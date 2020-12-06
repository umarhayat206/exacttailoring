<?php

class smFeature{
	/*
	public function getSubMenu($mainmenu){
		$mainfeaturesId=smFeature::getContentfeaturesId(str_replace(array("_","-")," ",$mainmenu));
		
		if($mainfeaturesId!='' || $mainfeaturesId!=0){
			$sqlsub=mysql_query("SELECT featuresId, featuresName FROM ex_features WHERE featuresRootId='$mainfeaturesId' ORDER BY featuresOrdernumber ASC");
			$countrow=mysql_num_rows($sqlsub);
			$htmlreturn="";
			if($countrow > 0){
				  
				$htmlreturn="<ul>";
				while($rowsub=mysql_fetch_array($sqlsub)){
					$featuresId=$rowsub['featuresId'];

					$title=$rowsub['featuresName'];

					$url=strtolower(str_replace(" ","-",$rowsub['featuresName']));
					$htmlreturn.="<li><a href='"._URL_."content/$featuresId/{$url}.html'>$title</a></li>";
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
		$sql = "SELECT featuresOrdernumber FROM ex_features ORDER BY featuresOrdernumber DESC LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_row($query);	
		return($row[0] + 1);
	}
	
	function MoveUp($pageId, $pageLevel){
		//Loop through all the pages of the same root type 
		//compare the page above, if any, then swap numbers		
		$previousLinksOrderNumber = "";
		$previousLinkspageid = "";		
		$sql = "SELECT featuresId, featuresRootId, featuresOrdernumber FROM ex_features WHERE featuresRootId='".$pageLevel."' ORDER BY featuresOrdernumber";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			//Check to see if this is the link to move
			if($row['featuresId']==$pageId){
				if($previousLinkspageid!=""){ 		//Link is already at the top - "they built a better featuresIdiot"
					//Change me
					smFeature::SetOrderNumber($pageId, $previousLinksOrderNumber);	
					
					//Change other
					smFeature::SetOrderNumber($previousLinkspageid, $row['featuresOrdernumber']);
				}	
			}			
			$previousLinkspageid = $row['featuresId'];
			$previousLinksOrderNumber = $row['featuresOrdernumber'];
		}		
	}
	
	function MoveDown($pageId, $pageLevel){
		//Loop through all the pages of the same root type 
		//compare the page above, if any, then swap numbers		
		$previousLinksOrderNumber = "";
		$previousLinkspageid = "";		
		$sql = "SELECT featuresId, featuresRootId, featuresOrdernumber FROM ex_features WHERE featuresRootId='".$pageLevel."' ORDER BY featuresOrdernumber DESC";
		$query = mysql_query($sql);
		//echo('adf');
		while($row = mysql_fetch_array($query)){
			//Check to see if this is the link to move
			if($row['featuresId']==$pageId){
				if($previousLinkspageid!=""){ 		//Link is already at the bottom - "they built a better featuresIdiot"
					//Change me
					smFeature::SetOrderNumber($pageId, $previousLinksOrderNumber);	
					
					//Change other
					smFeature::SetOrderNumber($previousLinkspageid, $row['featuresOrdernumber']);
				}	
			}			
			$previousLinkspageid = $row['featuresId'];
			$previousLinksOrderNumber = $row['featuresOrdernumber'];
		}		
	}
	
	function SetOrderNumber($pageId, $newNumber){
		$sql = "UPDATE ex_features SET ";
		$sql .="featuresOrdernumber='".$newNumber."' ";
		$sql .="WHERE featuresId='".$pageId."'";
		mysql_query($sql);
	}
/* ***** END PAGE ORDERING ***** */
	
	/*
	function GetBySEFTitle($sefTitle){
		if($sefTitle!=''){ 
			$sql = "SELECT * FROM ex_features WHERE sef_title='".$sefTitle."'";
		}else{ 	//No title available so pass back the first the top level node
			$sql = "SELECT * FROM ex_features WHERE published='1' AND featuresRootId='0' ORDER BY featuresOrdernumber LIMIT 1";	
		}
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		return(smFeature::_processRow($row));		
	}

	static function recursiveTree($featuresId = "0", $tree = array(), $depth = 0){
		$sql = "SELECT * FROM ex_features WHERE featuresRootId=".$featuresId." ORDER BY featuresName ";
		$query = mysql_query($sql);
			if(mysql_num_rows($query)>0){
				$depth++;
				while($row = mysql_fetch_array($query)){
					$featuresToAddToList = new smLocal;
					$featuresToAddToList->featuresId = $row['featuresId'];
					$featuresToAddToList->featuresName = $row['featuresName'];
					$featuresToAddToList->featuresSetHome = $row['featuresSetHome'];
					$featuresToAddToList->featuresRootId = $row['featuresRootId'];
					
					$tree[] = array($featuresToAddToList,$depth);
					$tree = self::recursiveTree($row['featuresId'],$tree,$depth);
				}
			}
		$depth--;
		return($tree);
	}
	*/
	
	function GetParentNodes(){
		$sql = "SELECT * FROM ex_features WHERE featuresRootId=0 ORDER BY featuresOrdernumber";
		$query = mysql_query($sql);
		$listOfNodes = array();
		$counter =0;
		while($row = mysql_fetch_array($query)){
			$listOfNodes[$counter]=smFeature::_processRow($row);
			$counter++;				
		}
		return($listOfNodes);
	}
	
	function GetMenuAndPages($contentfeaturesId = null, $showUnPublished = false){
		$sql = "SELECT * FROM ex_features WHERE ";
		if($contentfeaturesId!=null){ 		//featuresId given - provfeaturesIde details of a single page (i.e. a link has been clicked)
			$sql .="featuresId='".$contentfeaturesId."' ";
		}elseif($showUnPublished == false){
			$sql .="featuresRootId=0 "; 		//No featuresId - so we are building the menu
		}else{
			$sql .="featuresRootId=0 ";
		}
		$sql .="ORDER BY featuresOrdernumber";
		
		$query = mysql_query($sql);
		$counter = 0;
		$menuItems = array();
		while($row = mysql_fetch_array($query)){
			$menuItems[$counter]=smFeature::_processRow($row);
			$item = $menuItems[$counter];
			$counter++;
			//Get the sub menu items
			$sql2 = "SELECT * FROM ex_features ";
			//if($showUnPublished == true){
			//	$sql2 .="WHERE featuresRootId='".$item->featuresId."' ORDER BY featuresOrdernumber";
			//}else{
				$sql2 .="WHERE featuresRootId='".$item->featuresId."' ORDER BY featuresOrdernumber";
			//}
			$query2=mysql_query($sql2);
			while($row2 = mysql_fetch_array($query2)){
				$menuItems[$counter]=smFeature::_processRow($row2);
				$counter++;
			}
		}
		return($menuItems);
	}
	
	function GetMenu(){
		$sql = "SELECT * FROM ex_features WHERE ";
		$sql .="featuresRootId=0 "; 		//No featuresId - so we are building the menu
		$sql .="ORDER BY featuresOrdernumber";
		$query = mysql_query($sql);
		$counter = 0;
		$menuItems = array();
		while($row=mysql_fetch_array($query)){
			$menuItems[$counter]=smFeature::_processRow($row);
			$item=$menuItems[$counter];
			$counter++;
			
			//Get the sub menu items
			$sql2 = "SELECT * FROM ex_features ";
			$sql2 .="WHERE featuresRootId='".$item->featuresId."' ORDER BY featuresOrdernumber";
			$query2=mysql_query($sql2);
			while($row2=mysql_fetch_array($query2)){
				$menuItems[$counter]=smFeature::_processRow($row2);
				$counter++;
			}
		}
		return($menuItems);
	}
	
	function getReducedMenu($contentfeaturesId = null, $showUnPublished = false){
		$sql = "SELECT * FROM ex_features ";
		$sql .="WHERE ";
		if($contentfeaturesId!=null){ 		//featuresId given - provfeaturesIde details of a single page (i.e. a link has been clicked)
			$sql .="featuresId='".$contentfeaturesId."' ";
		}elseif($showUnPublished == false){
			$sql .="featuresRootId=0 "; 	//No featuresId - so we are building the menu
		}else{
			$sql .="featuresRootId=0 ";
		}
		
		$sql .="ORDER BY featuresOrdernumber";
		$query = mysql_query($sql);
		$counter = 0;
		$menuItems = array();
		while($row = mysql_fetch_array($query)){
			$menuItems[$counter]=smFeature::_processRow($row);
			$item = $menuItems[$counter];
			$counter++;
		}
		return($menuItems);			
	}
	
	public function getFeatures($features){
		$sql = mysql_query("SELECT * FROM ex_features WHERE featuresId = '$features' ");
		$row=mysql_fetch_array($sql);
		$items = array();
		$items=smFeature::_processRow($row);
		return $items;	
	}
	
	function getSubfeatures($features){
		$sql = "SELECT featuresId FROM ex_features WHERE featuresRootId = '$features' ";
		$query = mysql_query($sql);
		$counter = 0;
		$items = array();
		while($row = mysql_fetch_array($query)){
			$items[$counter]=$row['featuresId'];
			$counter++;
		}
		return $items;			
	}
	
	
	function getIndexFeatures($category){
		$sql = "SELECT * FROM ex_features WHERE featuresCategory = '$category' ORDER BY featuresOrdernumber";
		$query = mysql_query($sql);
		$counter = 0;
		$items = array();
		while($row = mysql_fetch_array($query)){
			$menuItems[$counter]=smFeature::_processRow($row);
			$item=$menuItems[$counter];
			$counter++;
			
			//Get the sub menu items
			$sql2 = "SELECT * FROM ex_features ";
			$sql2 .="WHERE featuresRootId='".$item->featuresId."' ORDER BY featuresOrdernumber";
			$query2=mysql_query($sql2);
			while($row2=mysql_fetch_array($query2)){
				$menuItems[$counter]=smFeature::_processRow($row2);
				$counter++;
			}
			
		}
		return $menuItems;			
	}
	/*
	function getRootIndexFeatures($category){
		$sql = "SELECT * FROM ex_features WHERE featuresCategory = '$category' AND featuresRootId = '0' ORDER BY featuresId";
		$query = mysql_query($sql);
		$counter = 0;
		//$item = array();
		while($row = mysql_fetch_array($query)){
			$menuItems = new smFeature;
			$menuItems->featuresId = $row['featuresId'];
			$menuItems->featuresName = $row['featuresName'];
			$item[$counter] = $menuItems;
			$counter++;
		}
		return $item;			
	}
	*/
	
	function Update($content){		
		$sql = "UPDATE ex_features SET ";
		$sql .="featuresCategory='".$content->featuresCategory."', ";
		$sql .="featuresName='".$content->featuresName."', ";
		$sql .="featuresSetHome='".$content->featuresSetHome."', ";
		$sql .="featuresRootId='".$content->featuresRootId."', ";	// parentNode
		$sql .="featuresOrdernumber='".$content->featuresOrdernumber."', ";
		$sql .="featuresImages='".$content->featuresImages."', ";
		$sql .="featuresDescriptions='".$content->featuresDescriptions."' ";
		$sql .="WHERE featuresId='".$content->featuresId."' ";
		mysql_query($sql);
		return $content->featuresId;
	}

	function Insert($content){	
		$sql = "INSERT INTO ex_features SET ";
		$sql .="featuresCategory='".$content->featuresCategory."', ";
		$sql .="featuresName='".$content->featuresName."', ";
		$sql .="featuresSetHome='".$content->featuresSetHome."', ";
		$sql .="featuresRootId='".$content->featuresRootId."', ";	// parentNode
		$sql .="featuresOrdernumber='".smFeature::GetNextOrderNumber()."', ";
		$sql .="featuresDescriptions='".$content->featuresDescriptions."', ";
		$sql .="featuresImages='".$content->featuresImages."' ";
		mysql_query($sql);
		return mysql_insert_id();
	}

	function Delete($featuresId){
		mysql_query("DELETE FROM ex_features WHERE featuresId='$featuresId' ");
		
		mysql_query("DELETE FROM ex_features WHERE featuresRootId='$featuresId' ");	
	}

	function _convertSEFTitle($sefTitle){
		$aryOfChars = array("~"," ",",",".","_");
		return(str_replace($aryOfChars, "-", $sefTitle));
	}
	
/* ***** SQL ROW PRCESSING ***** */
	function _processRow($row){
		$item = new smFeature;
		$item->featuresId = $row['featuresId'];
		$item->featuresCategory = $row['featuresCategory'];
		$item->featuresName = $row['featuresName'];
		$item->featuresSetHome = $row['featuresSetHome'];
		$item->featuresRootId = $row['featuresRootId'];
		$item->featuresOrdernumber = $row['featuresOrdernumber'];
		$item->featuresImages = $row['featuresImages'];
		$item->featuresDescriptions = $row['featuresDescriptions'];
		return($item);
	}
/* ***** END ROW PROCESSING ***** */

}
?>
