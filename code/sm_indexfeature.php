<?php

class smIndexFeature{
	var $pfId;
	var $pfFeId;
	var $pfPdId;
	var $featNum;

	public function GetAll($id){
		$sqlSelectCutPages="select * from pt_feature_index where pfPdId ='".$id."' ";
		$rsSelectCutPages=mysql_query($sqlSelectCutPages);
		$listFeatureIndex = array();
		//$counter = 0;
		$test=array();
		//$featureIndexList = new smIndexFeature;
		while ($row = mysql_fetch_array($rsSelectCutPages)){
			$featureIndexList->pfFeId = $row['pfFeId'];
			$test[]= $row['pfFeId'];
			//$listFeatureIndex[$counter] = $featureIndexList;
			//$counter++;
		}
		return $test;	
	}
	
	public function GetIndividual($pfId){
		$sqlSelect = "SELECT * FROM pt_feature_index WHERE pfId='".$pfId."'";
		$query = mysql_query($sqlSelect);
		$theFeatureIndex = new smIndexFeature;
		
		while ($row = mysql_fetch_array($query)){
			$theFeatureIndex->pfId = $row['pfId'];
		 	$theFeatureIndex->pfFeId = $row['pfFeId'];
		 	$theFeatureIndex->pfPdId = $row['pfPdId'];
		}
		return $theFeatureIndex;
	}
	
	public function GetPropertyFeatureIndex($featureId){
		$sqlSelect = "SELECT pfPdId FROM pt_feature_index WHERE pfFeId='".$featureId."' ORDER BY RAND() LIMIT 5 ";
		$query = mysql_query($sqlSelect);
		$listproperty = array();
		while($row = mysql_fetch_array($query)){
			$listproperty[] = $row['pfPdId'];
		}
		return $listproperty;
	}
	
	public function Add($newFeatureIndex){	
		if(!empty($newFeatureIndex->pfPdId)){	
			$sqlInsert = "INSERT INTO pt_feature_index SET ";	
			$sqlInsert .= "pfFeId='".$newFeatureIndex->pfFeId."', ";	
			$sqlInsert .= "pfPdId='".$newFeatureIndex->pfPdId."' ";	
			mysql_query($sqlInsert);	
		}
	}
	
	public function Delete($pfId){
		$sqlDelete = "DELETE FROM pt_feature_index WHERE pfId='".$pfId."'";
		mysql_query($sqlDelete);
	}

}
?>
