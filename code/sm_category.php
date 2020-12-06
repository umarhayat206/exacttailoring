<?php

class smCategory {

/* ***** PAGE ORDERING ***** */
	/*
	public function getSubMenu($mainmenu){
		$maincategoryId=smCategory::getContentcategoryId(str_replace(array("_","-")," ",$mainmenu));
		
		if($maincategoryId!='' || $maincategoryId!=0){
			$sqlsub=mysql_query("SELECT categoryId, categoryName FROM ex_category WHERE categoryRootId='$maincategoryId' ORDER BY categoryOrdernumber ASC");
			$countrow=mysql_num_rows($sqlsub);
			$htmlreturn="";
			if($countrow > 0){
				  
				$htmlreturn="<ul>";
				while($rowsub=mysql_fetch_array($sqlsub)){
					$categoryId=$rowsub['categoryId'];

					$title=$rowsub['categoryName'];

					$url=strtolower(str_replace(" ","-",$rowsub['categoryName']));
					//$htmlreturn.="<li><a href='"._URL_."content/$categoryId/{$url}.html'>$title</a></li>";
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
		$sql = "SELECT categoryOrdernumber FROM ex_category ORDER BY categoryOrdernumber DESC LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_row($query);	
		return($row[0] + 1);
	}
	
	function MoveUp($pageId, $pageLevel){
		//Loop through all the pages of the same root type 
		//compare the page above, if any, then swap numbers		
		$previousLinksOrderNumber = "";
		$previousLinkspageid = "";		
		$sql = "SELECT categoryId, categoryRootId, categoryOrdernumber FROM ex_category WHERE categoryRootId='".$pageLevel."' ORDER BY categoryOrdernumber";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			//Check to see if this is the link to move
			if($row['categoryId']==$pageId){
				if($previousLinkspageid!=""){ 		//Link is already at the top - "they built a better categoryIdiot"
					//Change me
					smCategory::SetOrderNumber($pageId, $previousLinksOrderNumber);	
					
					//Change other
					smCategory::SetOrderNumber($previousLinkspageid, $row['categoryOrdernumber']);
				}	
			}			
			$previousLinkspageid = $row['categoryId'];
			$previousLinksOrderNumber = $row['categoryOrdernumber'];
		}		
	}
	
	function MoveDown($pageId, $pageLevel){
		//Loop through all the pages of the same root type 
		//compare the page above, if any, then swap numbers		
		$previousLinksOrderNumber = "";
		$previousLinkspageid = "";		
		$sql = "SELECT categoryId, categoryRootId, categoryOrdernumber FROM ex_category WHERE categoryRootId='".$pageLevel."' ORDER BY categoryOrdernumber DESC";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			//Check to see if this is the link to move
			if($row['categoryId']==$pageId){
				if($previousLinkspageid!=""){ 		//Link is already at the bottom - "they built a better categoryIdiot"
					//Change me
					smCategory::SetOrderNumber($pageId, $previousLinksOrderNumber);	
					
					//Change other
					smCategory::SetOrderNumber($previousLinkspageid, $row['categoryOrdernumber']);
				}	
			}			
			$previousLinkspageid = $row['categoryId'];
			$previousLinksOrderNumber = $row['categoryOrdernumber'];
		}		
	}
	
	function SetOrderNumber($pageId, $newNumber){
		$sql = "UPDATE ex_category SET ";
		$sql .="categoryOrdernumber='".$newNumber."' ";
		$sql .="WHERE categoryId='".$pageId."'";
		mysql_query($sql);
	}
/* ***** END PAGE ORDERING ***** */
	
	/*
	function GetBySEFTitle($sefTitle){
		if($sefTitle!=''){ 
			$sql = "SELECT * FROM ex_category WHERE sef_title='".$sefTitle."'";
		}else{ 	//No title available so pass back the first the top level node
			$sql = "SELECT * FROM ex_category WHERE published='1' AND categoryRootId='0' ORDER BY categoryOrdernumber LIMIT 1";	
		}
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		return(smCategory::_processRow($row));		
	}

	static function recursiveTree($categoryId = "0", $tree = array(), $depth = 0){
		$sql = "SELECT * FROM ex_category WHERE categoryRootId=".$categoryId." ORDER BY categoryName ";
		$query = mysql_query($sql);
			if(mysql_num_rows($query)>0){
				$depth++;
				while($row = mysql_fetch_array($query)){
					$categoryToAddToList = new smLocal;
					$categoryToAddToList->categoryId = $row['categoryId'];
					$categoryToAddToList->categoryName = $row['categoryName'];
					$categoryToAddToList->categoryRootId = $row['categoryRootId'];
					
					$tree[] = array($categoryToAddToList,$depth);
					$tree = self::recursiveTree($row['categoryId'],$tree,$depth);
				}
			}
		$depth--;
		return($tree);
	}
	*/
	
	function GetParentNodes(){
		$sql = "SELECT * FROM ex_category WHERE categoryRootId=0 ORDER BY categoryOrdernumber";
		$query = mysql_query($sql);
		$listOfNodes = array();
		$counter =0;
		while($row = mysql_fetch_array($query)){
			$listOfNodes[$counter]=smCategory::_processRow($row);
			$counter++;				
		}
		return($listOfNodes);
	}
	
	function GetMenuAndPages($categoryId = null, $showUnPublished = false){
		$sql = "SELECT * FROM ex_category ";
		$sql .="WHERE ";
		if($categoryId!=null){ 		//categoryId given - provcategoryIde details of a single page (i.e. a link has been clicked)
			$sql .="categoryId='$categoryId' ";
		}elseif($showUnPublished == false){
			$sql .="categoryRootId=0 "; 		//No categoryId - so we are building the menu
		}else{
			$sql .="categoryRootId=0 ";
		}
		$sql .="AND categoryVisible = '1' ORDER BY categoryOrdernumber";

		$query = mysql_query($sql);
		$counter = 0;
		$menuItems = array();
		
		while($row = mysql_fetch_array($query)){
			$menuItems[$counter]=smCategory::_processRow($row);
			$item = $menuItems[$counter];
			$counter++;
			//Get the sub menu items
			$sql2 = "SELECT * FROM ex_category ";
			//if($showUnPublished == true){
			//	$sql2 .="WHERE categoryRootId='".$item->categoryId."' ORDER BY categoryOrdernumber";
			//}else{
				$sql2 .="WHERE categoryRootId='".$item->categoryId."' ORDER BY categoryOrdernumber";
			//}

			$query2=mysql_query($sql2);
			while($row2 = mysql_fetch_array($query2)){
				$menuItems[$counter]=smCategory::_processRow($row2);
				$counter++;
			}
		}
		return($menuItems);
	}
	
	function GetMenu(){
		$sql = "SELECT * FROM ex_category ";
		$sql .="WHERE ";
		$sql .="categoryRootId=0 "; 		//No categoryId - so we are building the menu
		$sql .="ORDER BY categoryOrdernumber";
		$query = mysql_query($sql);
		$counter = 0;
		$menuItems = array();
		while($row=mysql_fetch_array($query)){
			$menuItems[$counter]=smCategory::_processRow($row);
			$item=$menuItems[$counter];
			$counter++;
			
			//Get the sub menu items
			$sql2 = "SELECT * FROM ex_category ";
			$sql2 .="WHERE categoryRootId='".$item->categoryId."' ORDER BY categoryOrdernumber";
			$query2=mysql_query($sql2);
			while($row2=mysql_fetch_array($query2)){
				$menuItems[$counter]=smCategory::_processRow($row2);
				$counter++;
			}
		}
		return($menuItems);
	}
	
	function getReducedMenu($contentcategoryId = null, $showUnPublished = false){
		$sql = "SELECT * FROM ex_category ";
		$sql .="WHERE ";
		if($contentcategoryId!=null){ 		//categoryId given - provcategoryIde details of a single page (i.e. a link has been clicked)
			$sql .="categoryId='".$contentcategoryId."' ";
		}elseif($showUnPublished == false){
			$sql .="categoryRootId=0 "; 	//No categoryId - so we are building the menu
		}else{
			$sql .="categoryRootId=0 ";
		}
		
		$sql .="ORDER BY categoryOrdernumber";
		$query = mysql_query($sql);
		$counter = 0;
		$items = array();
		while($row = mysql_fetch_array($query)){
			$items[$counter]=smCategory::_processRow($row);
			$item = $items[$counter];
			$counter++;
		}
		return $items;			
	}
	
	public function getCategory($category){
		$sql = mysql_query("SELECT * FROM ex_category WHERE categoryId = '$category' ");
		$row=mysql_fetch_array($sql);
		$counter = 0;
		$items = array();
		$items=smCategory::_processRow($row);
		
		return $items;	
	}
	
	public function getCategoryByName($category){
		$sql = mysql_query("SELECT categoryId FROM ex_category WHERE categoryName = '$category' ");
		$row=mysql_fetch_array($sql);
		//$counter = 0;
		//$items = array();
		//$items=smCategory::_processRow($row);
		
		$categoryId = $row['categoryId'];
		return $categoryId;	
	}
	
	public function getSubCategoryByName($root, $category){
		$sql = mysql_query("SELECT categoryId FROM ex_category WHERE categoryName = '$category' AND categoryRootId = '$root' ");
		$row=mysql_fetch_array($sql);
		//$counter = 0;
		//$items = array();
		//$items=smCategory::_processRow($row);
		
		$categoryId = $row['categoryId'];
		return $categoryId;	
	}

	function getSubCategory($category){
		$sql = "SELECT categoryId FROM ex_category WHERE categoryRootId = '$category' ";
		$query = mysql_query($sql);
		$counter = 0;
		$items = array();
		while($row = mysql_fetch_array($query)){
			$items[$counter]=smCategory::_processRow($row);
			$counter++;
		}
		return $items;			
	}
	
	public function getMainCategory($category){
		$sql="SELECT * FROM ex_category WHERE categoryId='$category' ";
		$query=mysql_query($sql);
		$row=mysql_fetch_array($query);
		
		$sqlMain="SELECT * FROM ex_category WHERE categoryId='".$row['categoryRootId']."' ";
		$queryMain=mysql_query($sqlMain);
		$rowMain=mysql_fetch_array($queryMain);
		
		$counter = 0;
		$items = array();
		while($row = mysql_fetch_array($queryMain)){
			$items[$counter]=smCategory::_processRow($row);
			$counter++;
		}
		return $items;	
	}
	
	function Update($category){		
		$sql = "UPDATE ex_category SET ";
		$sql .="categoryName='".$category->categoryName."',";
		$sql .="categoryRootId='".$category->categoryRootId."',";	// parentNode
		$sql .="categoryVisible='".$category->categoryVisible."',";
		$sql .="categoryImage='".$category->categoryImage."', ";
		$sql .="categoryDescriptions='".$category->categoryDescriptions."',";
		$sql .="categoryOrdernumber='".$category->categoryOrdernumber."' ";
		$sql .="WHERE categoryId='".$category->categoryId."'";
		mysql_query($sql);
		return $content->categoryId;
	}

	function Insert($category){	
		$sql = "INSERT INTO ex_category SET ";
		$sql .="categoryName='".$category->categoryName."',";
		$sql .="categoryRootId='".$category->categoryRootId."',";	// parentNode
		$sql .="categoryVisible='".$category->categoryVisible."',";
		$sql .="categoryImage='".$category->categoryImage."',";
		$sql .="categoryDescriptions='".$category->categoryDescriptions."',";
		$sql .="categoryOrdernumber='".smCategory::GetNextOrderNumber()."' ";
		mysql_query($sql);
		return mysql_insert_id();
	}

	function Delete($category){
		//mysql_query("DELETE FROM ex_category WHERE categoryId='$category' ");
		//mysql_query("DELETE FROM ex_category WHERE categoryRootId='$category' ");
	}

	function _convertSEFTitle($sefTitle){
		$aryOfChars = array("~"," ",",",".","_");
		return(str_replace($aryOfChars, "-", $sefTitle));
	}
	
/* ***** SQL ROW PRCESSING ***** */
	function _processRow($row){
		$item = new smCategory;
		$item->categoryId = $row['categoryId'];
		$item->categoryName = $row['categoryName'];
		$item->categoryRootId = $row['categoryRootId'];
		$item->categoryOrdernumber = $row['categoryOrdernumber'];
		$item->categoryImage = $row['categoryImage'];
		$item->categoryVisible = $row['categoryVisible'];
		$item->categoryDescriptions = $row['categoryDescriptions'];
		return($item);
	}
/* ***** END ROW PROCESSING ***** */

	public function exportsqlcount($cate){
		$maincate = explode("-", $cate);
		if($maincate[1] =="mens" || $maincate[1] =="womens" || $maincate[1] == "accessories"){
		    $mc = $maincate[1];  //echo "-/2-";
		}else{
		    $mc = "mens"; //echo "-/1-".$m;
		}
		
		$maincateId = smCategory::getCategoryByName($mc);
		//echo $maincate[1]." - ".$maincate[2];
		$loopsupcate = smCategory::getSubCategory($maincateId);
		
		$sqlreturn = "AND (";
		foreach($loopsupcate as $item){
		    $sqlreturn .= "productCategoryId = '{$item->categoryId}' OR ";
		    $lastcate = $item->categoryId;
		}
		$sqlreturn .= " productCategoryId = '$lastcate') ";
		
		return $sqlreturn;
	}


}

?>