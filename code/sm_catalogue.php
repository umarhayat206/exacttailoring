<?php

class smCatalogue {

/* ***** PAGE ORDERING ***** */
	
	function GetNextOrderNumber(){
		$sql = "SELECT catalogueOrdernumber FROM ex_catalogue ORDER BY catalogueOrdernumber DESC LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_row($query);	
		return($row[0] + 1);
	}
	
	function MoveUp($catalogueId){
		//Loop through all the pages of the same root type 
		//compare the page above, if any, then swap numbers		
		$previousLinksOrderNumber = "";
		$previousLinkspageid = "";		
		$sql = "SELECT catalogueId, catalogueOrdernumber FROM ex_catalogue ORDER BY catalogueOrdernumber";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			//Check to see if this is the link to move
			if($row['catalogueId']==$catalogueId){
				if($previousLinkspageid!=""){ 		//Link is already at the top - "they built a better catalogueIdiot"
					//Change me
					smCatalogue::SetOrderNumber($catalogueId, $previousLinksOrderNumber);	
					
					//Change other
					smCatalogue::SetOrderNumber($previousLinkspageid, $row['catalogueOrdernumber']);
				}	
			}			
			$previousLinkspageid = $row['catalogueId'];
			$previousLinksOrderNumber = $row['catalogueOrdernumber'];
		}		
	}
	
	function MoveDown($catalogueId){
		//Loop through all the pages of the same root type 
		//compare the page above, if any, then swap numbers		
		$previousLinksOrderNumber = "";
		$previousLinkspageid = "";		
		$sql = "SELECT catalogueId, catalogueOrdernumber FROM ex_catalogue ORDER BY catalogueOrdernumber DESC";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			//Check to see if this is the link to move
			if($row['catalogueId']==$catalogueId){
				if($previousLinkspageid!=""){ 		//Link is already at the bottom - "they built a better catalogueIdiot"
					//Change me
					smCatalogue::SetOrderNumber($catalogueId, $previousLinksOrderNumber);	
					
					//Change other
					smCatalogue::SetOrderNumber($previousLinkspageid, $row['catalogueOrdernumber']);
				}	
			}			
			$previousLinkspageid = $row['catalogueId'];
			$previousLinksOrderNumber = $row['catalogueOrdernumber'];
		}		
	}
	
	function SetOrderNumber($catalogueId, $newNumber){
		$sql = "UPDATE ex_catalogue SET ";
		$sql .="catalogueOrdernumber='".$newNumber."' ";
		$sql .="WHERE catalogueId='".$catalogueId."'";
		mysql_query($sql);
	}
/* ***** END PAGE ORDERING ***** */
	/*
	function GetParentNodes(){
		$sql = "SELECT * FROM ex_catalogue ORDER BY catalogueOrdernumber";
		$query = mysql_query($sql);
		$listOfNodes = array();
		$counter =0;
		while($row = mysql_fetch_array($query)){
			$listOfNodes[$counter]=smCatalogue::_processRow($row);
			$counter++;				
		}
		return($listOfNodes);
	}
	*/
	
	function GetMenuAndPages($catalogueId = null, $showUnPublished = false){
		$sql = "SELECT * FROM ex_catalogue WHERE  ";
		
		if($catalogueId!=null){ 		
			$sql .="catalogueId = '$catalogueId' ";
		}else if($showUnPublished!=true){ 
			$sql .="catalogueVisible = '1' ";
		}else{
			$sql .="catalogueId != '' ";
		}
		
		$sql .="ORDER BY catalogueOrdernumber DESC";

		$query = mysql_query($sql);
		$counter = 0;
		$menuItems = array();
		while($row = mysql_fetch_array($query)){
			$menuItems[$counter]=smCatalogue::_processRow($row);
			//$item = $menuItems[$counter];
			$counter++;
		}
		return($menuItems);
	}

	public function getCatalogue($catalogueId){
		$sql = mysql_query("SELECT * FROM ex_catalogue WHERE catalogueId = '$catalogueId' ");
		$row=mysql_fetch_array($sql);
		$counter = 0;
		$items = array();
		$items=smCatalogue::_processRow($row);
		return $items;	
	}

	function Update($catalogue){		
		$sql = "UPDATE ex_catalogue SET ";
		$sql .="catalogueName='".$catalogue->catalogueName."',";
		$sql .="catalogueVisible='".$catalogue->catalogueVisible."',";
		$sql .="catalogueImage='".$catalogue->catalogueImage."', ";
		$sql .="cataloguePdf='".$catalogue->cataloguePdf."',";
		$sql .="catalogueDescriptions='".$catalogue->catalogueDescriptions."',";
		$sql .="catalogueOrdernumber='".$catalogue->catalogueOrdernumber."' ";
		$sql .="WHERE catalogueId='".$catalogue->catalogueId."'";
		mysql_query($sql);
		return $content->catalogueId;
	}

	function Insert($catalogue){	
		$sql = "INSERT INTO ex_catalogue SET ";
		$sql .="catalogueName='".$catalogue->catalogueName."',";
		$sql .="catalogueVisible='".$catalogue->catalogueVisible."',";
		$sql .="catalogueImage='".$catalogue->catalogueImage."',";
		$sql .="cataloguePdf='".$catalogue->cataloguePdf."',";
		$sql .="catalogueDescriptions='".$catalogue->catalogueDescriptions."',";
		$sql .="catalogueOrdernumber='".smCatalogue::GetNextOrderNumber()."' ";
		mysql_query($sql);
		return mysql_insert_id();
	}

	function Delete($catalogue){
		mysql_query("DELETE FROM ex_catalogue WHERE catalogueId='$catalogue' ");
	}

	function _convertSEFTitle($sefTitle){
		$aryOfChars = array("~"," ",",",".","_");
		return(str_replace($aryOfChars, "-", $sefTitle));
	}
	
/* ***** SQL ROW PRCESSING ***** */
	function _processRow($row){
		$item = new smCatalogue;
		$item->catalogueId = $row['catalogueId'];
		$item->catalogueName = $row['catalogueName'];
		$item->catalogueOrdernumber = $row['catalogueOrdernumber'];
		$item->catalogueImage = $row['catalogueImage'];
		$item->cataloguePdf = $row['cataloguePdf'];
		$item->catalogueVisible = $row['catalogueVisible'];
		$item->catalogueDescriptions = $row['catalogueDescriptions'];
		return($item);
	}
/* ***** END ROW PROCESSING ***** */


}

?>