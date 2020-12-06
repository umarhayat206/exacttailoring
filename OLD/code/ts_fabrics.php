<?php
/**
 * All fabric classes contained here and encapsulated into tsFabrics
 * tsFabrics | tsFabricType | tsFabricSimilarFabrics 
 **/
/**
 * Main fabric class. Other fabric classes should not be required outside of this file
 * ts_fabrics | ts_fabric_type 
 **/ 
class tsFabrics extends tsFabricType {
	public $fId;
	public $fCode;
	public $fName;
	public $fImage;
	public $fPricePerShirt;
	
	// Public functions
	
	/** Get fabric price **/
	public static function fGetPrice($fId){
		$sql = "SELECT f_price_per_shirt FROM ts_fabrics WHERE f_id=".smFunctions::checkInput($fId)." LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		return($row['f_price_per_shirt']);
	}
	
	/** 
 	 * Return fabric collections for fabric chooser
 	 * Id can be specified to return a single fabric	
	 **/
	public static function fabricGetCompleteCollection($fId = ""){
		$sql = "
			SELECT * FROM ts_fabrics
			INNER JOIN ts_fabric_type ON f_ft_id=ft_id ";
		if($fId!=""){
			$sql.= "WHERE f_id=".smFunctions::checkInput($fId)." ";
		}
		$sql.= "ORDER BY f_ft_id, f_code";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			$collection[] = self::_processRow($row);
		}
		return($collection);
	}
	
	/**
	 * Return a fabric type filtered list of fabrics
	 */
	public static function fabricGetFilteredCollection($ftId=null){
		$sql = "
			SELECT * FROM ts_fabrics
			INNER JOIN ts_fabric_type ON f_ft_id=ft_id ";
		if($ftId!=null && $ftId!=""){
			$sql.= "WHERE f_ft_id=".smFunctions::checkInput($ftId)." ";
		}
		$sql.= "ORDER BY f_ft_id, f_code";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			$collection[] =  self::_processRow($row);
		}
		return($collection);
	}
	
	/** Return count of fabrics in a fabric type group **/
	public static function ftGetCollectionCount($ftId){
		$sql = "SELECT count(*) FROM ts_fabrics	WHERE f_ft_id=".smFunctions::checkInput($ftId)." ";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		if($row[0]>0){ //If the count is greater than zero, minus 1... Fixes issue in the Admin Measurements section. 
			$row[0]--;
		}
		return($row[0]);
	}
	
	/** Return list of fabrics **/
	public static function fabricList($ftId){
		$sql = "
			SELECT * FROM ts_fabrics 
			INNER JOIN ts_fabric_type ON f_ft_id=ft_id
			WHERE f_ft_id=".smFunctions::checkInput($ftId)."  
			ORDER BY f_name
			"; //Statement has been corrected to WHERE f_id instead of ft_id - Hope no bugs crop up elsewhere
		//echo($sql);
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			$fabricList[]=self::_processRow($row);
		}
		return($fabricList);
	}
	
	/** get a single fabrics details **/
	public function fabricGetOne($fId){
		$sql = '
			SELECT * FROM ts_fabrics
			INNER JOIN ts_fabric_type ON f_ft_id=ft_id
			WHERE f_id='.smFunctions::checkInput($fId).'
		';
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		return self::_processRow($row);
	}
	
	/** Save fabrics **/
	public function fabricSave($fabric){
		if($fabric->fId>0){
			$id = $fabric->_fabricUpdate($fabric);	
		}else{
			$id = $fabric->_fabricInsert($fabric);
		}
		return($id);
	}
	
	/** Delete fabrics by collection id **/
	public static function fDeleteCollection($ftId){
		$sql = "SELECT f_id FROM ts_fabrics WHERE f_ft_id=".smFunctions::checkInput($ftId)." ";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			self::fDelete($row[0]);
		}
	}
	
	/** Delete fabric **/
	public static function fDelete($fId){
		/*
		self::_unlinkFabricImage($fId);
		$sql = "DELETE FROM ts_fabrics WHERE f_id=".smFunctions::checkInput($fId)." LIMIT 1";
		mysql_query($sql)or die(mysql_error());
		*/
	}
	
	// Private functions
	
	private function _unlinkFabricImage($fId){
		$sql = "SELECT f_image FROM ts_fabrics WHERE f_id=".smFunctions::checkInput($fId)." ";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		@unlink($row[0]);
		$thumbName = str_replace(".","_T.",$row[0]);
		@unlink($thumbName);//Delete thumb	
	}
	
	private function _fabricInsert($fabric){
		$sql = "INSERT INTO ts_fabrics SET ";
		$sql.= $fabric->_processInsertUpdate($fabric);
		mysql_query($sql);
		return(mysql_insert_id());
	} 	
	
	private function _fabricUpdate($fabric){
		$sql = "UPDATE ts_fabrics SET ";
		$sql.= $fabric->_processInsertUpdate($fabric);
		$sql.= "WHERE f_id=".smFunctions::checkInput($fabric->fId)."";
		mysql_query($sql);
		return($fabric->fId);
	}
	
	private function _processInsertUpdate($fabric){
		$sql = "f_code=".smFunctions::checkInput($fabric->fCode).","; 
		$sql.= "f_name=".smFunctions::checkInput($fabric->fName).",";
		if($fabric->fImage!="")
			$sql.= "f_image=".smFunctions::checkInput($fabric->fImage).",";
		$sql.= "f_price_per_shirt=".smFunctions::checkInput($fabric->fPricePerShirt).",";
		$sql.= "f_ft_id=".smFunctions::checkInput($fabric->ftId)." ";
		return($sql);
	}
	
	private function _processRow($row){
		$f = new tsFabrics;
		$f->fId = $row['f_id'];
		$f->fCode = $row['f_code'];
		$f->fName = $row['f_name'];
		$f->fImage = $row['f_image'];
		$f->fPricePerShirt = $row['f_price_per_shirt'];
		$f->ftId = $row['ft_id'];
		$f->ftName = $row['ft_name'];
		return($f);
	}
}


/**
 * For use only within tsFabrics
 **/ 
class tsFabricSimilarFabrics {
	/*public $fsId;
	public $fsId1;
	public $fsId2;*/
	
	// Public functions
	
	/** Returns a list of fabrics ids that are similar to the specified fabric **/
	public function similarFabricList($fabricId){
		$sql = "
			SELECT * FROM ts_fabric_similar_fabric 
			WHERE fsf_f_id1=".smFunctions::checkInput($fabricId)." 
			OR fsf_f_id2=".smFunctions::checkInput($fabricId)."";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			//Make sure we only add the referenced id to the list, not the query id
			if($row['fsf_f_id1']!=$fabricId){
				$fIdList[]=$row['fsf_f_id1'];
			}else{
				$fIdList[]=$row['fsf_f_id2'];
			}
		}
		return($fIdList);
	}
	
	/** Checks that the associtation does not already exist... If not saves **/ 	
	public function similarFabricSave($fId1, $fId2){
		//Check if the association already exists
		if(!$this->_checkDuplicates($fId1,$fId2)){
			//if not insert
			$this->_similarFabricInsert($fId1,$fId2);
		}
	}
	
	public function deleteSimilarFabricAssociation($fId1,$fId2){
		$sql = "
			DELETE FROM ts_fabric_similar_fabric 
			WHERE 
				(fsf_f_id1=".smFunctions::checkInput($fId1)." AND fsf_f_id2=".smFunctions::checkInput($fId2).")
				 OR
				(fsf_f_id2=".smFunctions::checkInput($fId1)." AND fsf_f_id1=".smFunctions::checkInput($fId2).") 
			";
		mysql_query($sql);
	}
	
	// Private functions
	
	private function _similarFabricInsert($fId1,$fId2){
		$sql = "INSERT INTO ts_fabric_similar_fabric SET ";
		$sql.= "fsf_f_id1=".smFunctions::checkInput($fId1).",";	
		$sql.= "fsf_f_id2=".smFunctions::checkInput($fId2).",";	
		mysql_query($sql);
		return(mysql_insert_id());
	}
	
	private function _checkDuplicates($fId1,$fId2){
		$sql = "
			SELECT count(*) FROM ts_fabric_similar_fabric 
			WHERE (fsf_f_id1=".$fId1." AND fsf_f_id2=".$fId2.") 
			OR (fsf_f_id1=".$fId2." AND fsf_f_id2=".$fId1.")";
		$query = mysql_query($sql);
		$count = mysql_result($query,0,0);
		//$numRows = mysql_num_rows($query);
		if($count>0){
			return(true);
		}else{
			return(false);
		}
	}	 	
}

/**
 * ts_fabric_type
 **/ 
class tsFabricType {
	public $ftId;
	public $ftName;
	public $ftImagepath;
	public $ftDescription;
	
	// Public functions
	
	/** Return an array of fabric types for ddl */
	public function ftArray(){
		$collection = self::ftList();
		foreach($collection as $fabricType){
			$fabricArray[$fabricType->ftId] = $fabricType->ftName;
		}
		return($fabricArray);
	}
	
	/** Return list of fabric types **/
	public function ftList(){
		$sql = "SELECT * FROM ts_fabric_type ORDER BY ft_name";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			$list[] = self::_processRow($row);
		}
		return($list);
	}
	
	/** Get fabric type details **/
	public static function ftDetails($ftId){
		$sql = "SELECT * FROM ts_fabric_type WHERE ft_id=".smFunctions::checkInput($ftId)." ";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		return(self::_processRow($row));
	}
	
	/** Save collection of fabrics **/
	public function fabricTypeSave($fabricType){
		if($fabricType->ftId>0){
			$id = $fabricType->_fabricTypeUpdate($fabricType);
		}else{
			$id = $fabricType->_fabricTypeInsert($fabricType);
		}
		return($id);
	}
	
	/** Delete collection of fabrics **/
	public static function ftDelete($ftId){
		tsFabrics::fDeleteCollection($ftId); //Delete underlying fabrics
		$sql = "DELETE FROM ts_fabric_type WHERE ft_id=".smFunctions::checkInput($ftId);
		mysql_query($sql);
	}
	
	// Private functions 
	
	private function _fabricTypeInsert($fabricType){
		$sql = "INSERT INTO ts_fabric_type SET ";
		$sql.= $fabricType->_processInsertUpdate($fabricType);
		mysql_query($sql);
		return(mysql_insert_id());
	}
	
	private function _fabricTypeUpdate($fabricType){
		$sql = "UPDATE ts_fabric_type SET ";
		$sql.= $fabricType->_processInsertUpdate($fabricType);
		$sql.= "WHERE ft_id=".smFunctions::checkInput($fabricType->ftId)."";
		mysql_query($sql);
		return($fabricType->ftId);
	}
	
	private function _processInsertUpdate($fabricType){
		$sql = "ft_name=".smFunctions::checkInput($fabricType->ftName).",";
		$sql.= "ft_description=".smFunctions::checkInput($fabricType->ftDescription);
		if(!empty($fabricType->ftImagepath)){
			$sql.= ", ft_imagepath=".smFunctions::checkInput($fabricType->ftImagepath);
		}
		return($sql);
	}
	
	private function _processRow($row){
		$ft = new tsFabricType;
		$ft->ftId = $row['ft_id'];
		$ft->ftName = $row['ft_name'];
		$ft->ftImagepath = $row['ft_imagepath'];
		$ft->ftDescription = $row['ft_description'];
		return($ft);
	}
}

?>