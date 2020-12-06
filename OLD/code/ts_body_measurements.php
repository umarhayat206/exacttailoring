<?php

/** ts_body_measurements **/
class tsBodyMeasurements {
	public $bmId;
	public $bmProfileName;
	public $bmMetric;
	public $bmType;
	public $bmNeck;
	public $bmChest;
	public $bmWaist;
	public $bmSeat;
	public $bmBack;
	public $bmArm;
	public $bmArmShort;
	
	public $bmShoulder, $bmSoftCollar, $bmFit; //Added
	
	public $bmCuff;
	public $bmBicep;
	public $bmLength;
	public $bmHeight;
	public $bmWeight;
	public $bmBackType;
	public $bmShoulderType;
	public $bmMId;
	
	// Public functions
	
	/** Get a single body measurement details, includes member id for security **/
	public static function bmGetOne($bmId, $mId, $admin="false"){
		$sql = "
				SELECT * FROM ts_body_measurements 
				WHERE bm_id=".smFunctions::checkInput($bmId);
		if($admin=="false") 
			$sql.=" AND bm_m_id=".smFunctions::checkInput($mId);
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		return(tsBodyMeasurements::_processRow($row));
	}
	
	/** Get a list of members body measurements **/
	public static function bmListByMemberId($mId){
		$sql = "
				SELECT * FROM ts_body_measurements 
				WHERE bm_m_id=".smFunctions::checkInput($mId)."
				ORDER BY bm_profile_name";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			$collection[]=tsBodyMeasurements::_processRow($row);
		}
		return($collection);
	}
	
	/** Delete by id and member id (for security) **/
	public static function bmDelete($bmId,$mId){
		/*
		$sql = 
			"DELETE FROM ts_body_measurements WHERE 
			bm_id=".smFunctions::checkInput($bmId)." AND 
			bm_m_id=".smFunctions::checkInput($mId);
		$query = mysql_query($sql);
		*/
	}
	
	public function bmSave($bodyMeasurement){
		if($bodyMeasurement->bmId>0){
			$id = $bodyMeasurement->_update($bodyMeasurement);
		}else{
			$id = $bodyMeasurement->_insert($bodyMeasurement);
		}
		return($id);
	}
	
	// Private functions
	
	private function _insert($bodyMeasurement){
		$sql = "INSERT INTO ts_body_measurements SET ";
		$sql.= $bodyMeasurement->_processInsertUpdate($bodyMeasurement);
		mysql_query($sql);
		return(mysql_insert_id());
	}
	
	private function _update($bodyMeasurement){
		$sql = "UPDATE ts_body_measurements SET ";
		$sql.= $bodyMeasurement->_processInsertUpdate($bodyMeasurement);
		$sql.= "WHERE bm_id=".smFunctions::checkInput($bodyMeasurement->bmId);
		mysql_query($sql)or die(mysql_error());
		return($bodyMeasurement->bmId);
	}
	
	private function _processInsertUpdate($bodyMeasurement){
		$sql = "bm_profile_name=".smFunctions::checkInput($bodyMeasurement->bmProfileName).",";
		$sql.= "bm_metric=".smFunctions::checkInput($bodyMeasurement->bmMetric).",";
		$sql.= "bm_type=".smFunctions::checkInput($bodyMeasurement->bmType).",";
		$sql.= "bm_neck=".smFunctions::checkInput($bodyMeasurement->bmNeck).",";
		$sql.= "bm_chest=".smFunctions::checkInput($bodyMeasurement->bmChest).",";
		$sql.= "bm_waist=".smFunctions::checkInput($bodyMeasurement->bmWaist).",";
		$sql.= "bm_seat=".smFunctions::checkInput($bodyMeasurement->bmSeat).",";
		$sql.= "bm_back=".smFunctions::checkInput($bodyMeasurement->bmBack).",";
		$sql.= "bm_arm=".smFunctions::checkInput($bodyMeasurement->bmArm).",";
		$sql.= "bm_arm_short=".smFunctions::checkInput($bodyMeasurement->bmArmShort).",";
		$sql.= "bmShoulder=".smFunctions::checkInput($bodyMeasurement->bmShoulder).",";
		$sql.= "bmSpecial=".smFunctions::checkInput($bodyMeasurement->bmSpecial).",";
		
		if($bodyMeasurement->bmType=="Body"){
			$sql.= "bmFit=".smFunctions::checkInput($bodyMeasurement->bmFit).",";
		}
		
		$sql.= "bmSoftCollar=".smFunctions::checkInput($bodyMeasurement->bmSoftCollar).",";
		$sql.= "bm_cuff=".smFunctions::checkInput($bodyMeasurement->bmCuff).",";
		$sql.= "bm_bicep=".smFunctions::checkInput($bodyMeasurement->bmBicep).",";
		$sql.= "bm_length=".smFunctions::checkInput($bodyMeasurement->bmLength).",";
		$sql.= "bm_height=".smFunctions::checkInput($bodyMeasurement->bmHeight).",";
		$sql.= "bm_weight=".smFunctions::checkInput($bodyMeasurement->bmWeight).",";
		$sql.= "bm_back_type=".smFunctions::checkInput($bodyMeasurement->bmBackType).",";
		$sql.= "bm_shoulder_type=".smFunctions::checkInput($bodyMeasurement->bmShoulderType).",";
		$sql.= "bm_m_id=".smFunctions::checkInput($bodyMeasurement->bmMId)." ";
		return($sql);
	}
	
	private static function _processRow($row){
		$bm = new tsBodyMeasurements;
		$bm->bmId = $row['bm_id'];
		$bm->bmProfileName = $row['bm_profile_name'];
		$bm->bmMetric = $row['bm_metric'];
		$bm->bmType = $row['bm_type'];
		$bm->bmNeck = $row['bm_neck'];
		$bm->bmChest = $row['bm_chest'];
		$bm->bmWaist = $row['bm_waist'];
		$bm->bmSeat = $row['bm_seat'];
		$bm->bmBack = $row['bm_back'];
		$bm->bmArm = $row['bm_arm'];
		$bm->bmArmShort = $row['bm_arm_short'];
		$bm->bmShoulder = $row['bmShoulder'];
		$bm->bmSpecial = $row['bmSpecial'];
		$bm->bmFit = $row['bmFit'];
		$bm->bmSoftCollar = $row['bmSoftCollar'];
		$bm->bmCuff = $row['bm_cuff'];
		$bm->bmBicep = $row['bm_bicep'];
		$bm->bmLength = $row['bm_length'];
		$bm->bmHeight = $row['bm_height'];
		$bm->bmWeight = $row['bm_weight'];
		$bm->bmBackType = $row['bm_back_type'];
		$bm->bmShoulderType = $row['bm_shoulder_type'];
		$bm->bmMId = $row['bm_m_id'];
		return($bm);
	}
}
?>