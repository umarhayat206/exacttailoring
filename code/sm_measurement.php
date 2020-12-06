<?php

class smMeasurement{
    
	public function GetIndividual($usId){
		$query = mysql_query("SELECT * FROM ex_users_measurement WHERE usId='$usId' ");
		$row = mysql_fetch_array($query);
		$theMeasurement = array();
		$theMeasurement=smMeasurement::_processRow($row);
		return $theMeasurement;
	}
        
	public function checkAddEdit($usId){
		$query = mysql_query("SELECT * FROM ex_users_measurement WHERE usId='$usId' ");
		$row = mysql_num_rows($query);
		
		if($row>=1){ // update
			$check = "update";
		}else{	// new data
			$check = "new";
		}

		return $check;
	}
	
        
	public function Add($update){
		$sql = "INSERT INTO ex_users_measurement SET ";
		$sql .="usId='".$update->usId."', " ;
		$sql .="measurementMetric='".$update->measurementMetric."', ";
		$sql .="measurementType='".$update->measurementType."', ";
		$sql .="measurementShirtNeck='".$update->measurementShirtNeck."', " ;
		$sql .="measurementShirtChest='".$update->measurementShirtChest."', " ;
		$sql .="measurementShirtStomach='".$update->measurementShirtStomach."', " ;
		$sql .="measurementShirtHips='".$update->measurementShirtHips."', " ;
		$sql .="measurementShirtLenght='".$update->measurementShirtLenght."', " ;
		$sql .="measurementShirtSleeveLength='".$update->measurementShirtSleeveLength."', " ;
		$sql .="measurementShirtShortSleeve='".$update->measurementShirtShortSleeve."', " ;
		$sql .="measurementShirtCuff='".$update->measurementShirtCuff."', " ;
		$sql .="measurementShirtUpperarm='".$update->measurementShirtUpperarm."', " ;
		$sql .="measurementShirtShoulder='".$update->measurementShirtShoulder."', " ;
		$sql .="measurementTrousersA='".$update->measurementTrousersA."', " ;
		$sql .="measurementTrousersB='".$update->measurementTrousersB."', " ;
		$sql .="measurementTrousersC='".$update->measurementTrousersC."', " ;
		$sql .="measurementTrousersD='".$update->measurementTrousersD."', " ;
                $sql .="measurementTrousersE='".$update->measurementTrousersE."', " ;
                $sql .="measurementTrousersF='".$update->measurementTrousersF."', " ;
		$sql .="measurementTrousersG='".$update->measurementTrousersG."', " ;
                $sql .="measurementBoxersWaist='".$update->measurementBoxersWaist."', " ;
                $sql .="measurementBoxersTopofLeg='".$update->measurementBoxersTopofLeg."', " ;
                $sql .="measurementBoxersLength='".$update->measurementBoxersLength."', " ;
                $sql .="measurementBoxersHip='".$update->measurementBoxersHip."', " ;
                $sql .="measurementBoxersInsideLeg='".$update->measurementBoxersInsideLeg."', " ;
		$sql .="measurementSpecialDetails='".$update->measurementSpecialDetails."' " ;
		mysql_query($sql);
		return mysql_insert_id();
		
	}
        
	
	public function Update($update){		
		$sql = "UPDATE ex_users_measurement SET ";
		//$sql .="usId='".$update->usId."', " ;
		$sql .="measurementMetric='".$update->measurementMetric."', ";
		$sql .="measurementType='".$update->measurementType."', ";
		$sql .="measurementShirtNeck='".$update->measurementShirtNeck."', " ;
		$sql .="measurementShirtChest='".$update->measurementShirtChest."', " ;
		$sql .="measurementShirtStomach='".$update->measurementShirtStomach."', " ;
		$sql .="measurementShirtHips='".$update->measurementShirtHips."', " ;
		$sql .="measurementShirtLenght='".$update->measurementShirtLenght."', " ;
		$sql .="measurementShirtSleeveLength='".$update->measurementShirtSleeveLength."', " ;
		$sql .="measurementShirtShortSleeve='".$update->measurementShirtShortSleeve."', " ;
		$sql .="measurementShirtCuff='".$update->measurementShirtCuff."', " ;
		$sql .="measurementShirtUpperarm='".$update->measurementShirtUpperarm."', " ;
		$sql .="measurementShirtShoulder='".$update->measurementShirtShoulder."', " ;
		$sql .="measurementTrousersA='".$update->measurementTrousersA."', " ;
		$sql .="measurementTrousersB='".$update->measurementTrousersB."', " ;
		$sql .="measurementTrousersC='".$update->measurementTrousersC."', " ;
		$sql .="measurementTrousersD='".$update->measurementTrousersD."', " ;
                $sql .="measurementTrousersE='".$update->measurementTrousersE."', " ;
                $sql .="measurementTrousersF='".$update->measurementTrousersF."', " ;
		$sql .="measurementTrousersG='".$update->measurementTrousersG."', " ;
                $sql .="measurementBoxersWaist='".$update->measurementBoxersWaist."', " ;
                $sql .="measurementBoxersTopofLeg='".$update->measurementBoxersTopofLeg."', " ;
                $sql .="measurementBoxersLength='".$update->measurementBoxersLength."', " ;
                $sql .="measurementBoxersHip='".$update->measurementBoxersHip."', " ;
                $sql .="measurementBoxersInsideLeg='".$update->measurementBoxersInsideLeg."', " ;
		$sql .="measurementSpecialDetails='".$update->measurementSpecialDetails."' " ;
		$sql .="WHERE measurementId='".$update->measurementId."' ";
                mysql_query($sql) or die(mysql_error());
		return($update->measurementId);
	}
	
	public function Delete($usId){
		$sqlDelete = "DELETE FROM ex_users_measurement WHERE usId='$usId' ";
		mysql_query($sqlDelete);
	}
	
	function _processRow($row){
		$item = new smMeasurement;
		$item->measurementId = $row['measurementId'];
		$item->usId = $row['usId'];
		$item->measurementMetric = $row['measurementMetric'];
		$item->measurementType = $row['measurementType'];
		$item->measurementShirtNeck = $row['measurementShirtNeck'];
		$item->measurementShirtChest = $row['measurementShirtChest'];
		$item->measurementShirtStomach = $row['measurementShirtStomach'];
		$item->measurementShirtHips = $row['measurementShirtHips'];
		$item->measurementShirtLenght = $row['measurementShirtLenght'];
		$item->measurementShirtSleeveLength = $row['measurementShirtSleeveLength'];
		$item->measurementShirtShortSleeve = $row['measurementShirtShortSleeve'];
		$item->measurementShirtCuff = $row['measurementShirtCuff'];
		$item->measurementShirtUpperarm = $row['measurementShirtUpperarm'];
		$item->measurementShirtShoulder = $row['measurementShirtShoulder'];
		$item->measurementTrousersA = $row['measurementTrousersA'];
		$item->measurementTrousersB = $row['measurementTrousersB'];
		$item->measurementTrousersC = $row['measurementTrousersC'];
		$item->measurementTrousersD = $row['measurementTrousersD'];
		$item->measurementTrousersE = $row['measurementTrousersE'];
		$item->measurementTrousersF = $row['measurementTrousersF'];
		$item->measurementTrousersG = $row['measurementTrousersG'];
                $item->measurementBoxersWaist = $row['measurementBoxersWaist'];
                $item->measurementBoxersTopofLeg = $row['measurementBoxersTopofLeg'];
                $item->measurementBoxersLength = $row['measurementBoxersLength'];
                $item->measurementBoxersHip = $row['measurementBoxersHip'];
                $item->measurementBoxersInsideLeg = $row['measurementBoxersInsideLeg'];
		$item->measurementSpecialDetails = $row['measurementSpecialDetails'];
		return($item);
	}
	
}
?>
