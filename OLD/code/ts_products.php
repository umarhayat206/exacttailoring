<?php

/**
 * Products Classes
 * Products are defined as a series of measurements and/or drop down options. They are put into order with
 * an ordernumber an can each have an image to help display to a user where/how to make the measurement.
 * Products can be arranged into categories and can be added to the shopping cart via the tsProductOrder 
 * index    
 **/ 
/**
 * ts_product_types class
 **/
class tsProductTypes extends tsProductCategory {
	public $ptId;
	public $ptName;
	public $ptAvailable;
	public $ptPrice;
	public $ptImagePath;
	
	//Public functions
	
	/** Get a single property type object **/
	public static function productTypeGetOne($ptId){
		$sql = "SELECT * FROM ts_product_types ";
		$sql.= self::_join();
		$sql.= "WHERE pt_id=".smFunctions::checkInput($ptId)." ";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		return(self::_processRow($row));
	}
	
	/** Get products by category id **/
	public static function ptGetList($catId){
		$sql = "SELECT * FROM ts_product_types WHERE pt_pc_id=".smFunctions::checkInput($catId)." AND pt_available = 1";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			$collection[] = self::_processRow($row);
		}
		return($collection);
	}
	
	/** Get a list of property type objects **/
	public function productTypeList($keywords = "",$orderBy = ""){
		$sql = "SELECT * FROM ts_product_types ";
		$sql.= self::_join();
		if($keywords!=""){
			$sql.= self::_appendFilterElements($keywords);	
		}
		if($orderBy!=""){
			$sql.= "ORDER BY ".smFunctions::checkInput($orderBy)." ";	
		}else{
			$sql.= "ORDER BY pc_name, pt_name LIMIT 0,50";
		}
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			$list[]=self::_processRow($row);
		}
		return($list);
	}
	
	/** Save a product type **/
	public function productTypeSave($productType){
		if($productType->ptId>0){
			$id = $this->_update($productType);
		}else{
			$id = $this->_insert($productType);
		}
		return($id);
	}
	
	/** Delete a product type **/
	public static function productTypeDelete($ptId){
		/*
		self::_unlinkImage($ptId);
		$sql = "DELETE FROM ts_product_types WHERE pt_id=".smFunctions::checkInput($ptId)." LIMIT 1 ";
		mysql_query($sql);
		*/
	}
	
	//Private functions	
	
	/** Unlink images **/
	private function _unlinkImage($ptId){
		$sql = "SELECT pt_image_path FROM ts_product_types WHERE pt_id=".smFunctions::checkInput($ptId)." ";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		@unlink($row[0]); //Delete main image
		$thumbName = str_replace(".","_T.",$row[0]);
		@unlink($thumbName);//Delete thumb		
	}
	
	private function _appendFilterElements($keywords){
		//prep key words as arrayIns
		$keywords = str_replace(array(","," "),"~",$keywords);
		$aryKeywords = explode("~",$keywords);
		if(count($aryKeywords>0)){
			$sql="WHERE ";
			$firstRun = true;
			foreach($aryKeywords as $keyword){
				if(!$firstRun){//not first run through loop
					$sql.="OR ";
					$firstRun = false;
				}
				if(trim($keyword!="")){	
					$sql.= "(pt_name LIKE '%".smFunctions::checkInput($keywords,true)."%' OR ";
					$sql.= "pt_price LIKE '%".smFunctions::checkInput($keywords,true)."%' OR ";
					$sql.= "pc_name LIKE '%".smFunctions::checkInput($keywords,true)."%') ";
				}
			}
		}
		return($sql);
	}
	
	private function _join(){
		return("INNER JOIN ts_product_category ON pt_pc_id=pc_id ");
	}
	
	private function _insert($product){
		$sql = "INSERT INTO ts_product_types SET ";
		$sql.= $this->_processInsertUpdate($product);
		mysql_query($sql);
		return(mysql_insert_id());
	}
	
	private function _update($product){
		$sql = "UPDATE ts_product_types SET ";
		$sql.= $this->_processInsertUpdate($product);
		$sql.= "WHERE pt_id=".smFunctions::checkInput($product->ptId)."";
		mysql_query($sql);
		return($product->ptId);
	}
	
	private function _processInsertUpdate($productType){
		$sql = "pt_name=".smFunctions::checkInput($productType->ptName).",";
		$sql.= "pt_available=".smFunctions::checkInput($productType->ptAvailable).",";
		$sql.= "pt_price=".smFunctions::checkInput($productType->ptPrice).",";
		if($productType->ptImagePath!="")
			$sql.= "pt_image_path=".smFunctions::checkInput($productType->ptImagePath).",";
		$sql.= "pt_pc_id=".smFunctions::checkInput($productType->pcId)." ";
		return($sql);
	}
	
	private function _processRow($row){
		$pt = new tsProductTypes;
		$pt->ptId = $row['pt_id'];
		$pt->ptName = $row['pt_name'];
		$pt->ptAvailable = $row['pt_available'];
		$pt->ptPrice = $row['pt_price'];
		$pt->ptImagePath = $row['pt_image_path'];
		$pt->pcId = $row['pc_id'];
		$pt->pcName = $row['pc_name'];
		$pt->pcPmgId = $row['pc_pmg_id'];
		return($pt);
	}	
} 

/**
 * ts_product_measurement_group
 **/ 
class tsProductMeasurmentGroup {
	public $pmgId;
	public $pmgName;
	public $pmgImage;
	
	//Public functions
	
	/** Get groups for DDL **/
	public static function pmgGetKeyValueArray(){
		$sql = "SELECT * FROM ts_product_measurement_group ORDER BY pmg_name";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			$ary[$row['pmg_id']] = $row['pmg_name'];
		}
		return($ary);		
	}
	
	/** Get group and measurements **/
	public static function pmgGetCollection(){
		$sql = "SELECT * FROM ts_product_measurement_group ORDER BY pmg_name";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			$collection[] = self::_processRow($row);
		}
		return($collection);
	}
	
	/** Get a product measurement group **/
	public function pmgGetOne($pmgId){
		$sql = "SELECT * FROM ts_product_measurement_group WHERE pmg_id=".smFunctions::checkInput($pmgId)." ";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		return(self::_processRow($row));
	}
	
	/** Save measurement group **/
	public function pmgSave($pmg){
		if($pmg->pmgId>0){
			$id = $this->_pmgUpdate($pmg);
		}else{
			$id = $this->_pmgInsert($pmg);
		}
		return($id);
	}
	
	/** Delete measurement group **/
	public static function pmgDelete($pmgId){
		$sql = "DELETE FROM ts_product_measurement_group WHERE pmg_id=".smFunctions::checkInput($pmgId)." ";
		mysql_query($sql);
		//Now delete any leftover measurements
		tsProductMeasurements::pmDeleteByGroupId($pmgId);
	}

	//Private functions
	
	private function _pmgInsert($pmg){
		$sql = "INSERT INTO ts_product_measurement_group SET ";
		$sql.= self::_processInsertUpdate($pmg);
		mysql_query($sql);
		return(mysql_insert_id());
	}
	
	private function _pmgUpdate($pmg){
		$sql = "UPDATE ts_product_measurement_group SET ";
		$sql.= self::_processInsertUpdate($pmg);
		$sql.= "WHERE pmg_id=".smFunctions::checkInput($pmg->pmgId)." ";
		mysql_query($sql);
		return($pmg->pmgId);
	}
	
	private function _processInsertUpdate($pmg){
		$sql = "pmg_name=".smFunctions::checkInput($pmg->pmgName).",";
		if($pmg->pmgImage!=""){
			$sql.= "pmg_image=".smFunctions::checkInput($pmg->pmgImage)." ";
		}
		return($sql);
	}
	
	private static function _processRow($row){
		$pmg = new tsProductMeasurmentGroup;
		$pmg->pmgId = $row['pmg_id'];
		$pmg->pmgName = $row['pmg_name'];
		$pmg->pmgImage = $row['pmg_image'];
		return($pmg);
	}	
}

/**
 * ts_product_measurement_index
 * Private internal class for handling the relationship of measurements to group 
 **/ 
class tsProductMeasurmentIndex {
	public $pmiId;
	public $pmiPcId;
	public $pmiPmgId;
	
	//Public functions
	
	/** Save product measurement index **/
	public function pmiSave($pmi){
		if($pmi->pmiId>0){
			$id = $this->_pmiUpdate($pmi);
		}else{
			$id = $this->_pmiInsert($pmi);
		}
		return($id);
	}
	
	/** Delete index reference **/
	public function pmiDelete($pmiId){
		$sql = "DELETE FROM ts_product_measurement_index WHERE pmi_id=".smFunctions::checkInput($pmiId)." LIMIT 1";
		mysql_query($sql);
	}
	
	//Private functions
	
	private function _pmiInsert($pmi){
		$sql = "INSERT INTO ts_product_measurement_index SET ";
		$sql.= $this->_pmiInsert($pmi);
		mysql_query($pmi);
		return(mysql_insert_id());
	}
	
	private function _pmiUpdate($pmi){
		$sql = "UPDATE ts_product_measurement_index SET ";
		$sql.= $this->_pmiUpdate($pmi);
		$sql.= "WHERE pmi_id=".smFunctions::checkInput($pmi->pmiId);
		mysql_query($pmi);
		return($pmi->pmiId);
	}
	
	private static function _processInsertUpdate($pmi){
		$sql = "pmi_pc_id=".smFunctions::checkInput($pmi->pmiPcId).",";
		$sql.= "pmi_pmg_id=".smFunctions::checkInput($pmi->pmiPmgId).",";
		return($sql);
	}
	
	private static function _processRow($row){
		$pmi = new tsProductMeasurmentIndex;
		$pmi->pmiId = $row['pmi_id'];
		$pmi->pmiPcId = $row['pmi_pc_id'];
		$pmi->pmiPmgId = $row['pmi_pmg_id'];
		return($pmi);
	}
}

/**
 * ts_product_category
 **/ 
class tsProductCategory {
	public $pcId;
	public $pcName;
	public $pcDescription;
	public $pcImage;
	public $pcPmgId;
	public $pcPcId;
	
	//Public functions
	
	/** Returns count of products in this category **/
	public static function pcCountProducts($pcId){
		$sql = "SELECT COUNT(pt_id) FROM ts_product_types WHERE pt_pc_id=".smFunctions::checkInput($pcId)." AND pt_available =1 ";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		return($row[0]);
	}
	
	/** Returns a single product category object **/
	public static function productCategoryGetOne($pcId){
		$sql = "SELECT * FROM ts_product_category WHERE pc_id=".smFunctions::checkInput($pcId)." ";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		return(self::_processRow($row));
	}
	
	/** Save or update product category details **/
	public function productCategorySave($category){
		if($category->pcId>0){
			if(!$this->_checkIfHillbillys($category->pcId,$category->pcPcId)){
				$id = $this->_update($category);
			}
		}else{
			$id = $this->_insert($category);
		}
		return($id);
	}
	
	/** Returns categories for smDropDownList **/
	public static function getCategoriesForDDL(){
		$catList = tsProductCategory::productCategoryTree();
		if(count($catList)>0){
			foreach($catList as $cat){
				$depth = "";
				for($i=1;$i<=$cat[2];$i++){ //To increase the depth
					$depth.= ("&nbsp; &nbsp;");
				}
				$ary[$cat[0]] = $depth.$cat[1]; 
			}	
		}
		return($ary);
	}

	/** Returns an array of category names and depth **/
	public static function productCategoryTree($id = "0", $tree = array(), $depth = 0){
		//TODO: Check whether recursion is best solution. Aparently shouldn't use where 
		//		there are more than 100/200 recursions or the stack can crash - crappy php limitation
		$sql = "SELECT * FROM ts_product_category WHERE pc_pc_id=".$id." ORDER BY pc_name ";
		$query = mysql_query($sql);
		if(mysql_num_rows($query)>0){
			$depth++;
			while($row = mysql_fetch_array($query)){
				$tree[] = array($row['pc_id'],$row['pc_name'],$depth);
				$tree = self::productCategoryTree($row['pc_id'],$tree,$depth);
			}
		}
		//$depth--;  Not necessary... But I've kept it for clarity (i.e. when returning to the previous recurrance the depth will be one less than the current of course)
		return($tree);
	}
	
	/** Delete category **/
	public static function productCategoryDelete($pcId){
		$sql = "DELETE FROM ts_product_category WHERE pc_id=".smFunctions::checkInput($pcId)." LIMIT 1";
		mysql_query($sql);
	}

	//Private functions	
	
	/** 
 	 * Checks to see if an update will create a circular reference
	 * i.e item a has item b as parent and we are now trying to set item b's parent as item a
	 * causing a circular reference (The mother is her daughters daughter...).
	 * Without this it could cause both categories to disappear Oozlum style 
	 **/  	
	private function _checkIfHillbillys($pcId, $proposedPcPcId){
		$sql = "SELECT count(*) FROM ts_product_category ";
		$sql.= "WHERE pc_id=".smFunctions::checkInput($proposedPcPcId)." ";
		$sql.= "AND pc_pc_id=".smFunctions::checkInput($pcId)." ";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		if($row[0]>0){
			return(true); //Mother and Sister... Possibly cousin aswell
		}else{
			return(false); //Not circular
		}
	}
	
	private function _insert($category){
		$sql = "INSERT INTO ts_product_category SET ";
		$sql.= self::_processInsertUpdate($category);
		mysql_query($sql);
		return(mysql_insert_id());
	}
	
	private function _update($category){
		$sql = "UPDATE ts_product_category SET ";
		$sql.= self::_processInsertUpdate($category);
		$sql.= "WHERE pc_id=".smFunctions::checkInput($category->pcId)."";
		mysql_query($sql);
		return($category->pcId);
	}
	
	private function _processInsertUpdate($category){
		$sql = "pc_name=".smFunctions::checkInput($category->pcName).",";
		$sql.= "pc_description=".smFunctions::checkInput($category->pcDescription).",";
		if(!empty($category->pcImage)){
			$sql.= "pc_image=".smFunctions::checkInput($category->pcImage).",";
		}
		$sql.= "pc_pmg_id=".smFunctions::checkInput($category->pcPmgId).",";
		$sql.= "pc_pc_id=".smFunctions::checkInput($category->pcPcId)." ";
		return($sql);
	}
	
	private function _processRow($row){
		$pc = new tsProductCategory;
		$pc->pcId = $row['pc_id'];
		$pc->pcName = $row['pc_name'];
		$pc->pcDescription = $row['pc_description'];
		$pc->pcImage = $row['pc_image'];
		$pc->pcPmgId = $row['pc_pmg_id'];
		$pc->pcPcId = $row['pc_pc_id'];
		return($pc);
	}
}

/**
 * ts_product_measurements
 **/ 
class tsProductMeasurements {
	public $pmId;
	public $pmName;
	public $pmOrderNumber;
	public $pmCheckbox;
	public $pmOptionGroup;
	public $pmOptionGroupValue;
	public $pmImage;
	public $pmPmgId;
	
	//Public functions
	
	/** Get count of measurments by group id - NOTE: abused to fix an issue in the the Admin Measurements section. Create new function for this **/
	public static function pmGetCollectionCount($pmPmgId){
		$sql = "SELECT count(*) FROM ts_product_measurements WHERE pm_pmg_id=".smFunctions::checkInput($pmPmgId)." ";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		if($row[0]>0){ //If the count is greater than zero, minus 1... Fixes issue in the Admin Measurements section. 
			$row[0]--;
		}
		return($row[0]);
	} 
	
	/** Get collection of measurements with group id **/
	public static function pmGetCollection($pmPmgId){
		$sql = "SELECT * FROM ts_product_measurements WHERE pm_pmg_id=".smFunctions::checkInput($pmPmgId)." ORDER BY pm_ordernumber ";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			$collection[] = self::_processRow($row);
		}
		return($collection);
	}
	
	/** Save Product Measurement details **/
	public function pmSave($measurement){
		if($measurement->pmId>0){
			$id = $this->_update($measurement);
		}else{
			$id = $this->_insert($measurement);
		}
		return($id);
	}
	
	/** Delete by on GROUP id **/
	public static function pmDeleteByGroupId($pmgId){
		self::_unlinkGroupImages($pmgId);
		$sql = "DELETE FROM ts_product_measurements WHERE pm_pmg_id=".smFunctions::checkInput($pmgId)." ";
		mysql_query($sql);
	}
	
	/** Delete by measurement Id **/
	public static function pmDelete($pmId){
		self::_unlinkImage($pmId);
		$sql = "DELETE FROM ts_product_measurements WHERE pm_id=".smFunctions::checkInput($pmId)." LIMIT 1";
		mysql_query($sql)or die(mysql_error());
	}
	
	//Private functions
	
	/** Unlink image by id **/
	private static function _unlinkImage($pmId){
		$sql = "SELECT pm_image FROM ts_product_measurements WHERE pm_id=".smFunctions::checkInput($pmId)." LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		@unlink($row[0]); //Delete main image
		$thumbName = str_replace(".","_T.",$row[0]);
		@unlink($thumbName);//Delete thumb
	}
	
	/** Unlink images by group Id **/
	private function _unlinkGroupImages($pmgId){
		$sql = "SELECT pm_id FROM ts_product_measurements WHERE pm_pmg_id=".smFunctions::checkInput($pmgId)." ";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			self::_unlinkImage($row[0]);
		}
	}
	
	private function _update($measurement){
		$sql = "UPDATE ts_product_measurements SET ";
		$sql.= $this->_processInsertUpdate($measurement);
		$sql.= "WHERE pm_id=".smFunctions::checkInput($measurement->pmId)."";
		mysql_query($sql)or die(mysql_error());
		return($measurement->pmId);
	}
	
	private function _insert($measurement){
		$sql = "INSERT INTO ts_product_measurements SET ";
		$sql.= $this->_processInsertUpdate($measurement);
		mysql_query($sql);
		return(mysql_insert_id());
	}
	
	private function _processInsertUpdate($measurement){
		$sql = "pm_name=".smFunctions::checkInput($measurement->pmName).",";
		$sql.= "pm_ordernumber=".smFunctions::checkInput($measurement->pmOrderNumber).",";
		$sql.= "pm_checkbox=".smFunctions::checkInput($measurement->pmCheckbox).",";
		$sql.= "pm_option_group=".smFunctions::checkInput($measurement->pmOptionGroup).",";
		$sql.= "pm_option_group_value=".smFunctions::checkInput($measurement->pmOptionGroupValue).",";
		if($measurement->pmImage!="")
			$sql.= "pm_image=".smFunctions::checkInput($measurement->pmImage).",";
		$sql.= "pm_pmg_id=".smFunctions::checkInput($measurement->pmPmgId)." ";
		return($sql);
	}
	
	private function _processRow($row){
		$pc = new tsProductMeasurements;
		$pc->pmId = $row['pm_id'];
		$pc->pmName = $row['pm_name'];
		$pc->pmCheckbox = $row['pm_checkbox'];
		$pc->pmOrderNumber = $row['pm_ordernumber'];
		$pc->pmOptionGroup = $row['pm_option_group'];
		$pc->pmOptionGroupValue = $row['pm_option_group_value'];
		$pc->pmImage = $row['pm_image'];
		$pc->pmPmgId = $row['pm_pmg_id'];
		return($pc);
	}
}

?>