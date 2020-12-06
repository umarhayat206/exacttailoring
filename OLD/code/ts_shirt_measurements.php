<?php

/** ts_shirt_measurment **/
class tsShirtMeasurements {
	public $smId, $smProfileName, $smMetric, $smCollar, $smChest, $smWaist,
		$smBottom, $smLength, $smSleeve, $smSleeveLower, $smSleeveShort,
		$smSleeveShortLower, $smBack, $smArmpit, $smCuff, $smShortSleeveOpening,
		$smBackType, $smShoulderType, $smAge, $smHeight, $smWeight,
		$smComments, $smMId;
	
	// Public functions
	
	/** Return a single measurement object, include member id for security **/
	public static function smGetOne($smId,$smMId,$admin="false"){
		$sql = "
			SELECT * FROM ts_shirt_measurement 
			WHERE sm_id=".smFunctions::checkInput($smId);
		if($admin=="false")
			$sql.= " AND sm_m_id=".smFunctions::checkInput($smMId);
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		return(tsShirtMeasurements::_processRow($row));
	}
	
	/** Return a collection of measurement objects by member Id **/
	public static function smGetCollection($mId){
		$sql = "
			SELECT * FROM ts_shirt_measurement 
			WHERE sm_m_id=".smFunctions::checkInput($mId);
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			$collection[] = tsShirtMeasurements::_processRow($row);
		}
		return($collection);
	}
	
	/** Delete by id and member id (for security) **/
	public static function smDelete($smId,$mId){
		/*
		$sql = 
			"DELETE FROM ts_shirt_measurement WHERE 
			sm_id=".smFunctions::checkInput($smId)." AND 
			sm_m_id=".smFunctions::checkInput($mId);
		$query = mysql_query($sql);
		*/
	}
	
	public function smSave($shirtMeasurement){
		if($shirtMeasurement->smId>0){
			$id = $shirtMeasurement->_update($shirtMeasurement);
		}else{
			$id = $shirtMeasurement->_insert($shirtMeasurement);
		}
		return($id);
	}
	
	// Private functions
	
	private function _update($sm){
		$sql = "UPDATE ts_shirt_measurement SET ";
		$sql.= $sm->_processInsertUpdate($sm);
		$sql.= "WHERE sm_id=".smFunctions::checkInput($sm->smId);
		mysql_query($sql);
		return($sm->smId);	
	}
	
	private function _insert($sm){
		$sql = "INSERT INTO ts_shirt_measurement SET ";
		$sql.= $sm->_processInsertUpdate($sm);
		mysql_query($sql);
		return(mysql_insert_id());
	}
	
	private function _processInsertUpdate($sm){
		$sql = "sm_profile_name=".smFunctions::checkInput($sm->smProfileName).",";
		$sql.= "sm_metric=".smFunctions::checkInput($sm->smMetric).",";
		$sql.= "sm_collar=".smFunctions::checkInput($sm->smCollar).",";
		$sql.= "sm_chest=".smFunctions::checkInput($sm->smChest).",";
		$sql.= "sm_waist=".smFunctions::checkInput($sm->smWaist).",";
		$sql.= "sm_bottom=".smFunctions::checkInput($sm->smBottom).",";
		$sql.= "sm_length=".smFunctions::checkInput($sm->smLength).",";
		$sql.= "sm_sleeve=".smFunctions::checkInput($sm->smSleeve).",";
		$sql.= "sm_sleeve_lower=".smFunctions::checkInput($sm->smSleeveLower).",";
		$sql.= "sm_sleeve_short=".smFunctions::checkInput($sm->smSleeveShort).",";
		$sql.= "sm_sleeve_short_lower=".smFunctions::checkInput($sm->smSleeveShortLower).",";
		$sql.= "sm_back=".smFunctions::checkInput($sm->smBack).",";
		$sql.= "sm_armpit=".smFunctions::checkInput($sm->smArmpit).",";
		$sql.= "sm_cuff=".smFunctions::checkInput($sm->smCuff).",";
		$sql.= "sm_short_sleeve_opening=".smFunctions::checkInput($sm->smShortSleeveOpening).",";
		$sql.= "sm_back_type=".smFunctions::checkInput($sm->smBackType).",";
		$sql.= "sm_shoulder_type=".smFunctions::checkInput($sm->smShoulderType).",";
		$sql.= "sm_age=".smFunctions::checkInput($sm->smAge).",";
		$sql.= "sm_height=".smFunctions::checkInput(str_replace("'",".",$sm->smHeight)).",";
		$sql.= "sm_weight=".smFunctions::checkInput($sm->smWeight).",";
		$sql.= "sm_comments=".smFunctions::checkInput($sm->smComments).",";
		$sql.= "sm_m_id=".smFunctions::checkInput($sm->smMId)." ";
		return($sql);
	}
	
	private static function _processRow($row){
		$sm = new tsShirtMeasurements;
		$sm->smId = $row['sm_id'];
		$sm->smProfileName = $row['sm_profile_name'];
		$sm->smMetric = $row['sm_metric'];
		$sm->smCollar = $row['sm_collar'];
		$sm->smChest = $row['sm_chest'];
		$sm->smWaist = $row['sm_waist'];
		$sm->smBottom = $row['sm_bottom'];
		$sm->smLength = $row['sm_length'];
		$sm->smSleeve = $row['sm_sleeve'];
		$sm->smSleeveLower = $row['sm_sleeve_lower'];
		$sm->smSleeveShort = $row['sm_sleeve_short'];
		$sm->smSleeveShortLower = $row['sm_sleeve_short_lower'];
		$sm->smBack = $row['sm_back'];
		$sm->smArmpit = $row['sm_armpit'];
		$sm->smCuff = $row['sm_cuff'];
		$sm->smShortSleeveOpening = $row['sm_short_sleeve_opening'];
		$sm->smBackType = $row['sm_back_type'];
		$sm->smShoulderType = $row['sm_shoulder_type'];
		$sm->smAge = $row['sm_age'];
		$sm->smHeight = $row['sm_height'];
		$sm->smWeight = $row['sm_weight'];
		$sm->smComments = $row['sm_comments'];
		$sm->smMId = $row['sm_m_id'];
		return($sm);
	}
}

?>