<?php

class smFabric {

/* ***** PAGE ORDERING ***** */

	function GetNextOrderNumber(){
		$sql = "SELECT fabricOrdernumber FROM ex_fabric ORDER BY fabricOrdernumber DESC LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_row($query);	
		return($row[0] + 1);
	}
	
	function MoveUp($fabricId){
		//Loop through all the pages of the same root type 
		//compare the page above, if any, then swap numbers		
		$previousLinksOrderNumber = "";
		$previousLinkspageid = "";		
		$sql = "SELECT fabricId, fabricOrdernumber FROM ex_fabric ORDER BY fabricOrdernumber";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			//Check to see if this is the link to move
			if($row['fabricId']==$fabricId){
				if($previousLinkspageid!=""){ 		//Link is already at the top - "they built a better fabricIdiot"
					//Change me
					smFabric::SetOrderNumber($fabricId, $previousLinksOrderNumber);	
					
					//Change other
					smFabric::SetOrderNumber($previousLinkspageid, $row['fabricOrdernumber']);
				}	
			}			
			$previousLinkspageid = $row['fabricId'];
			$previousLinksOrderNumber = $row['fabricOrdernumber'];
		}		
	}
	
	function MoveDown($fabricId){
		//Loop through all the pages of the same root type 
		//compare the page above, if any, then swap numbers		
		$previousLinksOrderNumber = "";
		$previousLinkspageid = "";		
		$sql = "SELECT fabricId, fabricOrdernumber FROM ex_fabric ORDER BY fabricOrdernumber DESC";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			//Check to see if this is the link to move
			if($row['fabricId']==$fabricId){
				if($previousLinkspageid!=""){ 		//Link is already at the bottom - "they built a better fabricIdiot"
					//Change me
					smFabric::SetOrderNumber($fabricId, $previousLinksOrderNumber);	
					
					//Change other
					smFabric::SetOrderNumber($previousLinkspageid, $row['fabricOrdernumber']);
				}	
			}			
			$previousLinkspageid = $row['fabricId'];
			$previousLinksOrderNumber = $row['fabricOrdernumber'];
		}		
	}
	
	function SetOrderNumber($fabricId, $newNumber){
		$sql = "UPDATE ex_fabric SET ";
		$sql .="fabricOrdernumber='".$newNumber."' ";
		$sql .="WHERE fabricId='".$fabricId."'";
		mysql_query($sql);
	}
/* ***** END PAGE ORDERING ***** */
	/*
	function GetParentNodes(){
		$sql = "SELECT * FROM ex_fabric ORDER BY fabricOrdernumber";
		$query = mysql_query($sql);
		$listOfNodes = array();
		$counter =0;
		while($row = mysql_fetch_array($query)){
			$listOfNodes[$counter]=smFabric::_processRow($row);
			$counter++;				
		}
		return($listOfNodes);
	}
	*/
	
	function GetMenuAndPages($fabricId = null, $showUnPublished = false){
		$sql = "SELECT * FROM ex_fabric ";
		if($fabricId!=null){ 		
			$sql .="WHERE fabricId='$fabricId' ";
		}
		$sql .="ORDER BY fabricOrdernumber";

		$query = mysql_query($sql);
		$counter = 0;
		$menuItems = array();
		while($row = mysql_fetch_array($query)){
			$menuItems[$counter]=smFabric::_processRow($row);
			//$item = $menuItems[$counter];
			$counter++;
		}
		return($menuItems);
	}
	
	public function getFabricByName($fabric){
		$sql = mysql_query("SELECT fabricId FROM ex_fabric WHERE fabricName = '$fabric' ");
		$row=mysql_fetch_array($sql);
		$fabricId = $row['fabricId'];
		return $fabricId;	
	}
	
	/*
	function GetMenu(){
		$sql = "SELECT * FROM ex_fabric ";
		$sql .="WHERE ";
		$sql .="categoryRootId=0 "; 		//No fabricId - so we are building the menu
		$sql .="ORDER BY fabricOrdernumber";
		$query = mysql_query($sql);
		$counter = 0;
		$menuItems = array();
		while($row=mysql_fetch_array($query)){
			$menuItems[$counter]=smFabric::_processRow($row);
			$item=$menuItems[$counter];
			$counter++;
			
			//Get the sub menu items
			$sql2 = "SELECT * FROM ex_fabric ";
			$sql2 .="WHERE categoryRootId='".$item->fabricId."' ORDER BY fabricOrdernumber";
			$query2=mysql_query($sql2);
			while($row2=mysql_fetch_array($query2)){
				$menuItems[$counter]=smFabric::_processRow($row2);
				$counter++;
			}
		}
		return($menuItems);
	}
	*/
	
	public function getFabric($fabric){
		$sql = mysql_query("SELECT * FROM ex_fabric WHERE fabricId = '$fabric' ");
		$row=mysql_fetch_array($sql);
		$counter = 0;
		$items = array();
		$items=smFabric::_processRow($row);
		return $items;	
	}

	function Update($fabric){		
		$sql = "UPDATE ex_fabric SET ";
		$sql .="fabricName='".$fabric->fabricName."',";
		$sql .="fabricVisible='".$fabric->fabricVisible."',";
		$sql .="fabricImage='".$fabric->fabricImage."', ";
		$sql .="fabricDescriptions='".$fabric->fabricDescriptions."',";
		$sql .="fabricShortDescriptions='".$fabric->fabricShortDescriptions."',";
		$sql .="fabricOrdernumber='".$fabric->fabricOrdernumber."', ";
		$sql .="isShowPrevPrice='".$fabric->isShowPrevPrice."',";
		$sql .="PrevPricePercentage='".$fabric->PrevPricePercentage."' ";
		$sql .="WHERE fabricId='".$fabric->fabricId."' ";
		mysql_query($sql);
		//echo $sql; exit;
		return $fabric->fabricId;
	}

	function Insert($fabric){	
		$sql = "INSERT INTO ex_fabric SET ";
		$sql .="fabricName='".$fabric->fabricName."',";
		$sql .="fabricVisible='".$fabric->fabricVisible."',";
		$sql .="fabricImage='".$fabric->fabricImage."',";
		$sql .="fabricDescriptions='".$fabric->fabricDescriptions."',";
		$sql .="fabricShortDescriptions='".$fabric->fabricShortDescriptions."',";
		$sql .="fabricOrdernumber='".smFabric::GetNextOrderNumber()."', ";
		$sql .="isShowPrevPrice='".$fabric->isShowPrevPrice."',";
		$sql .="PrevPricePercentage='".$fabric->PrevPricePercentage."' ";

		mysql_query($sql);
		return mysql_insert_id();
	}

	function Delete($fabric){
		mysql_query("DELETE FROM ex_fabric WHERE fabricId='$fabric' ");
	}

	function _convertSEFTitle($sefTitle){
		$aryOfChars = array("~"," ",",",".","_");
		return(str_replace($aryOfChars, "-", $sefTitle));
	}
	
/* ***** SQL ROW PRCESSING ***** */
	function _processRow($row){
		$item = new smFabric;
		$item->fabricId = $row['fabricId'];
		$item->fabricName = $row['fabricName'];
		$item->fabricOrdernumber = $row['fabricOrdernumber'];
		$item->fabricImage = $row['fabricImage'];
		$item->fabricVisible = $row['fabricVisible'];
		$item->fabricDescriptions = $row['fabricDescriptions'];
		$item->fabricShortDescriptions = $row['fabricShortDescriptions'];

		$item->isShowPrevPrice = $row['isShowPrevPrice'];
		$item->PrevPricePercentage = $row['PrevPricePercentage'];
		return($item);
	}
/* ***** END ROW PROCESSING ***** */


}

?>