<?php

class smContent {

/* ***** PAGE ORDERING ***** */
	/*
	public function getSubMenu($mainmenu){
		$mainid=smContent::getContentId(str_replace(array("_","-")," ",$mainmenu));
		
		if($mainid!='' || $mainid!=0){
			$sqlsub=mysql_query("SELECT id, link_title FROM ex_content WHERE published='1' AND parent_node='$mainid' ORDER BY order_number ASC");
			$countrow=mysql_num_rows($sqlsub);
			$htmlreturn="";
			if($countrow > 0){
				  
				$htmlreturn="<ul>";
				while($rowsub=mysql_fetch_array($sqlsub)){
					$id=$rowsub['id'];

					$title=$rowsub['link_title'];

					$url=strtolower(str_replace(" ","-",$rowsub['link_title']));
					$htmlreturn.="<li><a href='"._URL_."content/$id/{$url}.html'>$title</a></li>";
				}
				$htmlreturn.="</ul>";
				  
			}else{
				$htmlreturn="";
			}
		}
		return $htmlreturn;
	}
	*/
	
	function GetNextOrderNumber(){
		$sql = "SELECT order_number FROM ex_content ORDER BY order_number DESC LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_row($query);	
		return($row[0] + 1);
	}
	
	function MoveUp($pageId, $pageLevel){
		//Loop through all the pages of the same root type 
		//compare the page above, if any, then swap numbers		
		$previousLinksOrderNumber = "";
		$previousLinksId = "";		
		$sql = "SELECT id, parent_node, order_number FROM ex_content WHERE parent_node='".$pageLevel."' ORDER BY order_number";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			//Check to see if this is the link to move
			if($row['id']==$pageId){
				if($previousLinksId!=""){ 		//Link is already at the top - "they built a better idiot"
					//Change me
					smContent::SetOrderNumber($pageId, $previousLinksOrderNumber);	
					
					//Change other
					smContent::SetOrderNumber($previousLinksId, $row['order_number']);
				}	
			}			
			$previousLinksId = $row['id'];
			$previousLinksOrderNumber = $row['order_number'];
		}		
	}
	
	function MoveDown($pageId, $pageLevel){
		//Loop through all the pages of the same root type 
		//compare the page above, if any, then swap numbers		
		$previousLinksOrderNumber = "";
		$previousLinksId = "";		
		$sql = "SELECT id, parent_node, order_number FROM ex_content WHERE parent_node='".$pageLevel."' ORDER BY order_number DESC";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			//Check to see if this is the link to move
			if($row['id']==$pageId){
				if($previousLinksId!=""){ 		//Link is already at the bottom - "they built a better idiot"
					//Change me
					smContent::SetOrderNumber($pageId, $previousLinksOrderNumber);	
					
					//Change other
					smContent::SetOrderNumber($previousLinksId, $row['order_number']);
				}	
			}			
			$previousLinksId = $row['id'];
			$previousLinksOrderNumber = $row['order_number'];
		}		
	}
	
	function SetOrderNumber($pageId, $newNumber){
		$sql = "UPDATE ex_content SET ";
		$sql .="order_number='".$newNumber."' ";
		$sql .="WHERE id='".$pageId."'";
		mysql_query($sql);
	}
	
/* ***** END PAGE ORDERING ***** */

	static function recursiveTree($id = "0", $tree = array(), $depth = 0){
		$sql = "SELECT * FROM ex_content WHERE parent_node=".$id." ORDER BY link_title ";
		$query = mysql_query($sql);
			if(mysql_num_rows($query)>0){
				$depth++;
				while($row = mysql_fetch_array($query)){
					$linkToAddToList = new smLocal;
					$linkToAddToList->id = $row['id'];
					$linkToAddToList->link_title = $row['link_title'];
					$linkToAddToList->parent_node = $row['parent_node'];
					
					$tree[] = array($linkToAddToList,$depth);
					$tree = self::recursiveTree($row['id'],$tree,$depth);
				}
			}
		$depth--;
		return($tree);
	}
	
	function GetParentNodes(){
		$sql = "SELECT * FROM ex_content WHERE parent_node=0 ORDER BY order_number";
		$query = mysql_query($sql);
		$listOfNodes = array();
		$counter =0;
		while($row = mysql_fetch_array($query)){
			$listOfNodes[$counter]=smContent::_processRow($row);
			$counter++;				
		}
		return($listOfNodes);
	}
	
	function GetMenuAndPages($contentId = null, $showUnPublished = false){
		$sql = "SELECT * FROM ex_content";
		if($contentId!=null){ 		
			$sql .=" WHERE id='$contentId' ";
		}elseif($showUnPublished == false){
			$sql .=" WHERE published='1' ";
		}else{
			$sql .= " WHERE parent_node = '0' ";
		}
		$sql .="ORDER BY order_number";
//echo $sql;
		$query = mysql_query($sql);
		$counter = 0;
		$menuItems = array();
		
		while($row = mysql_fetch_array($query)){
			$menuItems[$counter]=smContent::_processRow($row);
			$item = $menuItems[$counter];
			$counter++;
			//Get the sub menu items
			$sql2 = "SELECT * FROM ex_content ";
			$sql2 .="WHERE parent_node='".$item->id."' ORDER BY order_number";

			$query2=mysql_query($sql2);
			while($row2 = mysql_fetch_array($query2)){
				$menuItems[$counter]=smContent::_processRow($row2);
				$counter++;
			}
		}
		
		return($menuItems);
	}
	
	public function GetIndividual($id){
		$sqlSelect = "SELECT * FROM ex_content WHERE id='".$id."' and published = '1' ";
		$query = mysql_query($sqlSelect);
		$row = mysql_fetch_array($query);
		$theArticles=self::_processRow($row);
		return $theArticles;
	}
	
	
	function GetContentMenu($root){
		$sql = "SELECT * FROM ex_content ";
		$sql .="WHERE parent_node='$root' AND published = '1' ORDER BY order_number";

		$query=mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			$menuItems[$counter]=smContent::_processRow($row);
			$counter++;
		}
		return($menuItems);
	}
	
	function GetContentLeftMenu($root){
		$sql = "SELECT * FROM ex_content ";
		$sql .="WHERE showleftmenu='1' AND published = '1' ORDER BY id";

		$query=mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			$menuItems[$counter]=smContent::_processRow($row);
			$counter++;
		}
		return($menuItems);
	}
	
	
	public function GetContentID($comtent){
		$sql = mysql_query("SELECT id FROM ex_content WHERE page_name LIKE '%$comtent%' ");
		$row=mysql_fetch_array($sql);
		$comtentId= $row['id'];
		return $comtentId;
	}
	
	/*
	public function getMainLocation($location){
		$sql = mysql_query("SELECT parent_node FROM ex_content WHERE id = '$location' ");
		$row=mysql_fetch_array($sql);
		$locationid= $row['parent_node'];
		return $locationid;
	}
	*/
	function Update($content){		
		$sql = "UPDATE ex_content SET ";
		$sql .="page_name='".$content->pageName."',";
		$sql .="link_title='".$content->linkTitle."',";
		$sql .="parent_node='".$content->parentCategory."',";	// parentNode
		$sql .="content='".$content->content."',";
		$sql .="showleftmenu='".$content->showleftmenu."',";
		$sql .="published='".$content->published."',";
		$sql .="order_number='".$content->orderNumber."' ";
		$sql .="WHERE id='".$content->id."'";
		mysql_query($sql);
		return $content->id;
	}

	function Insert($content){	
		$sql = "INSERT INTO ex_content SET ";
		$sql .="page_name='".$content->pageName."',";
		$sql .="link_title='".$content->linkTitle."',";
		$sql .="parent_node='".$content->parentCategory."',";	// parentNode
		$sql .="content='".$content->content."',";
		$sql .="showleftmenu='".$content->showleftmenu."',";
		$sql .="published='".$content->published."',";
		$sql .="order_number='".smContent::GetNextOrderNumber()."' ";

		mysql_query($sql);
		return mysql_insert_id();
	}

	function Delete($id){
		$sql = "DELETE FROM ex_content WHERE id='".$id."'";	
		mysql_query($sql);
	}

	function _convertSEFTitle($sefTitle){
		$aryOfChars = array("~"," ",",",".","_");
		return(str_replace($aryOfChars, "-", $sefTitle));
	}
	
/* ***** SQL ROW PRCESSING ***** */
	function _processRow($row){
		$item = new smContent;
		$item->id = $row['id'];
		$item->pageName = $row['page_name'];
		$item->linkTitle = $row['link_title'];
		$item->parentNode = $row['parent_node'];
		$item->orderNumber = $row['order_number'];
		$item->showleftmenu = $row['showleftmenu'];
		$item->published = $row['published'];
		$item->content = $row['content'];
		return($item);
	}
/* ***** END ROW PROCESSING ***** */

}

?>