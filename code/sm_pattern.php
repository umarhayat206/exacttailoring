<?php

class smPattern {

/* ***** PAGE ORDERING ***** */

	function GetNextOrderNumber(){
		$sql = "SELECT patternOrdernumber FROM ex_pattern ORDER BY patternOrdernumber DESC LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_row($query);	
		return($row[0] + 1);
	}
	
	function MoveUp($patternId){
		//Loop through all the pages of the same root type 
		//compare the page above, if any, then swap numbers		
		$previousLinksOrderNumber = "";
		$previousLinkspageid = "";		
		$sql = "SELECT patternId, patternOrdernumber FROM ex_pattern ORDER BY patternOrdernumber";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			//Check to see if this is the link to move
			if($row['patternId']==$patternId){
				if($previousLinkspageid!=""){ 		//Link is already at the top - "they built a better patternIdiot"
					//Change me
					smPattern::SetOrderNumber($patternId, $previousLinksOrderNumber);	
					
					//Change other
					smPattern::SetOrderNumber($previousLinkspageid, $row['patternOrdernumber']);
				}	
			}			
			$previousLinkspageid = $row['patternId'];
			$previousLinksOrderNumber = $row['patternOrdernumber'];
		}		
	}
	
	function MoveDown($patternId){
		//Loop through all the pages of the same root type 
		//compare the page above, if any, then swap numbers		
		$previousLinksOrderNumber = "";
		$previousLinkspageid = "";		
		$sql = "SELECT patternId, patternOrdernumber FROM ex_pattern ORDER BY patternOrdernumber DESC";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			//Check to see if this is the link to move
			if($row['patternId']==$patternId){
				if($previousLinkspageid!=""){ 		//Link is already at the bottom - "they built a better patternIdiot"
					//Change me
					smPattern::SetOrderNumber($patternId, $previousLinksOrderNumber);	
					
					//Change other
					smPattern::SetOrderNumber($previousLinkspageid, $row['patternOrdernumber']);
				}	
			}			
			$previousLinkspageid = $row['patternId'];
			$previousLinksOrderNumber = $row['patternOrdernumber'];
		}		
	}
	
	function SetOrderNumber($patternId, $newNumber){
		$sql = "UPDATE ex_pattern SET ";
		$sql .="patternOrdernumber='".$newNumber."' ";
		$sql .="WHERE patternId='".$patternId."'";
		mysql_query($sql);
	}
/* ***** END PAGE ORDERING ***** */
	/*
	function GetParentNodes(){
		$sql = "SELECT * FROM ex_pattern ORDER BY patternOrdernumber";
		$query = mysql_query($sql);
		$listOfNodes = array();
		$counter =0;
		while($row = mysql_fetch_array($query)){
			$listOfNodes[$counter]=smPattern::_processRow($row);
			$counter++;				
		}
		return($listOfNodes);
	}
	*/
	
	function GetMenuAndPages($patternId = null, $showUnPublished = false){
		$sql = "SELECT * FROM ex_pattern ";
		if($patternId!=null){ 		
			$sql .="WHERE patternId='$patternId' ";
		}
		$sql .="ORDER BY patternOrdernumber";

		$query = mysql_query($sql);
		$counter = 0;
		$menuItems = array();
		while($row = mysql_fetch_array($query)){
			$menuItems[$counter]=smPattern::_processRow($row);
			//$item = $menuItems[$counter];
			$counter++;
		}
		return($menuItems);
	}
	
	public function getPattern($pattern){
		$sql = mysql_query("SELECT * FROM ex_pattern WHERE patternId = '$pattern' ");
		$row=mysql_fetch_array($sql);
		$counter = 0;
		$items = array();
		$items=smPattern::_processRow($row);
		return $items;	
	}
	
	public function getPatternByName($pattern){
		$sql = mysql_query("SELECT patternId FROM ex_pattern WHERE patternTitle = '$pattern' ");
		$row=mysql_fetch_array($sql);
		$patternId = $row['patternId'];
		return $patternId;	
	}

	function Update($pattern){		
		$sql = "UPDATE ex_pattern SET ";
		$sql .="patternTitle='".$pattern->patternTitle."',";
		//$sql .="patternImage='".$pattern->patternImage."', ";
		$sql .="patternOrdernumber='".$pattern->patternOrdernumber."' ";
		$sql .="WHERE patternId='".$pattern->patternId."'";
		mysql_query($sql);
		return $pattern->patternId;
	}

	function Insert($pattern){	
		$sql = "INSERT INTO ex_pattern SET ";
		$sql .="patternTitle='".$pattern->patternTitle."',";
		//$sql .="patternImage='".$pattern->patternImage."',";
		$sql .="patternOrdernumber='".smPattern::GetNextOrderNumber()."' ";
		mysql_query($sql);
		return mysql_insert_id();
	}

	function Delete($pattern){
		mysql_query("DELETE FROM ex_pattern WHERE patternId='$pattern' ");
	}

	function _convertSEFTitle($sefTitle){
		$aryOfChars = array("~"," ",",",".","_");
		return(str_replace($aryOfChars, "-", $sefTitle));
	}
	
/* ***** SQL ROW PRCESSING ***** */
	function _processRow($row){
		$item = new smPattern;
		$item->patternId = $row['patternId'];
		$item->patternTitle = $row['patternTitle'];
		$item->patternOrdernumber = $row['patternOrdernumber'];
		//$item->patternImage = $row['patternImage'];
		return($item);
	}
/* ***** END ROW PROCESSING ***** */


}

?>