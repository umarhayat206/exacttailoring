<?php

class smColor {

/* ***** PAGE ORDERING ***** */

	function GetNextOrderNumber(){
		$sql = "SELECT colorOrdernumber FROM ex_color ORDER BY colorOrdernumber DESC LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_row($query);	
		return($row[0] + 1);
	}
	
	function MoveUp($colorId){
		//Loop through all the pages of the same root type 
		//compare the page above, if any, then swap numbers		
		$previousLinksOrderNumber = "";
		$previousLinkspageid = "";		
		$sql = "SELECT colorId, colorOrdernumber FROM ex_color ORDER BY colorOrdernumber";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			//Check to see if this is the link to move
			if($row['colorId']==$colorId){
				if($previousLinkspageid!=""){ 		//Link is already at the top - "they built a better colorIdiot"
					//Change me
					smColor::SetOrderNumber($colorId, $previousLinksOrderNumber);	
					
					//Change other
					smColor::SetOrderNumber($previousLinkspageid, $row['colorOrdernumber']);
				}	
			}			
			$previousLinkspageid = $row['colorId'];
			$previousLinksOrderNumber = $row['colorOrdernumber'];
		}		
	}
	
	function MoveDown($colorId){
		//Loop through all the pages of the same root type 
		//compare the page above, if any, then swap numbers		
		$previousLinksOrderNumber = "";
		$previousLinkspageid = "";		
		$sql = "SELECT colorId, colorOrdernumber FROM ex_color ORDER BY colorOrdernumber DESC";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			//Check to see if this is the link to move
			if($row['colorId']==$colorId){
				if($previousLinkspageid!=""){ 		//Link is already at the bottom - "they built a better colorIdiot"
					//Change me
					smColor::SetOrderNumber($colorId, $previousLinksOrderNumber);	
					
					//Change other
					smColor::SetOrderNumber($previousLinkspageid, $row['colorOrdernumber']);
				}	
			}			
			$previousLinkspageid = $row['colorId'];
			$previousLinksOrderNumber = $row['colorOrdernumber'];
		}		
	}
	
	function SetOrderNumber($colorId, $newNumber){
		$sql = "UPDATE ex_color SET ";
		$sql .="colorOrdernumber='".$newNumber."' ";
		$sql .="WHERE colorId='".$colorId."'";
		mysql_query($sql);
	}
/* ***** END PAGE ORDERING ***** */
	/*
	function GetParentNodes(){
		$sql = "SELECT * FROM ex_color ORDER BY colorOrdernumber";
		$query = mysql_query($sql);
		$listOfNodes = array();
		$counter =0;
		while($row = mysql_fetch_array($query)){
			$listOfNodes[$counter]=smColor::_processRow($row);
			$counter++;				
		}
		return($listOfNodes);
	}
	*/
	
	function GetMenuAndPages($colorId = null, $showUnPublished = false){
		$sql = "SELECT * FROM ex_color ";
		if($colorId!=null){ 		
			$sql .="WHERE colorId='$colorId' ";
		}
		$sql .="ORDER BY colorOrdernumber";

		$query = mysql_query($sql);
		$counter = 0;
		$menuItems = array();
		while($row = mysql_fetch_array($query)){
			$menuItems[$counter]=smColor::_processRow($row);
			//$item = $menuItems[$counter];
			$counter++;
		}
		return($menuItems);
	}
	
	public function getColor($color){
		$sql = mysql_query("SELECT * FROM ex_color WHERE colorId = '$color' ");
		$row=mysql_fetch_array($sql);
		$counter = 0;
		$items = array();
		$items=smColor::_processRow($row);
		return $items;	
	}
	
	public function getColorByName($color){
		$sql = mysql_query("SELECT colorId FROM ex_color WHERE colorTitle = '$color' ");
		$row=mysql_fetch_array($sql);
		$colorId = $row['colorId'];
		return $colorId;	
	}

	function Update($color){		
		$sql = "UPDATE ex_color SET ";
		$sql .="colorTitle='".$color->colorTitle."',";
		//$sql .="colorImages='".$color->colorImages."', ";
		$sql .="colorOrdernumber='".$color->colorOrdernumber."' ";
		$sql .="WHERE colorId='".$color->colorId."' ";
		mysql_query($sql);
		return $color->colorId;
	}

	function Insert($color){	
		$sql = "INSERT INTO ex_color SET ";
		$sql .="colorTitle='".$color->colorTitle."',";
		//$sql .="colorImages='".$color->colorImages."',";
		$sql .="colorOrdernumber='".smColor::GetNextOrderNumber()."' ";
		mysql_query($sql);
		return mysql_insert_id();
	}

	function Delete($color){
		mysql_query("DELETE FROM ex_color WHERE colorId='$color' ");
	}

	function _convertSEFTitle($sefTitle){
		$aryOfChars = array("~"," ",",",".","_");
		return(str_replace($aryOfChars, "-", $sefTitle));
	}
	
	/* ***** SQL ROW PRCESSING ***** */
	function _processRow($row){
		$item = new smColor;
		$item->colorId = $row['colorId'];
		$item->colorTitle = $row['colorTitle'];
		$item->colorOrdernumber = $row['colorOrdernumber'];
		//$item->colorImages = $row['colorImages'];
		return($item);
	}
	/* ***** END ROW PROCESSING ***** */


}

?>