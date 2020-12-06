<?php

class smCountries {
	public $rowId;
	public $countryId;
	public $locale;
	public $countryCode;
	public $countryName;
	public $phonePrefix;
	
	/* ***** PUBLIC BUSINESS LOGIC ***** */
	
	public static function coutriesForDDL(){
		$sql = mysql_query("SELECT countryName FROM iso_countries ORDER BY countryName");
		while($row = mysql_fetch_array($sql)){
			$countryArray[$row['countryName']] = $row['countryName'];
		}
		return($countryArray);
	}
	
	public static function countryById($id){
		$sql = "SELECT * FROM iso_countries WHERE rowId=".smFunctions::checkInput($id)." LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_row($query);
		return($row[4]);
	}
	
	public static function countriesKeyValueArray(){
		$countryList = smCountries::_getCountryList();
		$keyValArray = array();
		foreach($countryList as $country){
			$keyValArray[$country->rowId]=$country->countryName;
		}
		return($keyValArray);
	}
	
	/* ***** PRIVATE DATA ACCESS ***** */
	
	private function _getCountryList(){
		$sql = "SELECT * FROM iso_countries ORDER BY countryName";
		$query = mysql_query($sql);
		$listOfCountries = array();
		$counter=0;
		while($row = mysql_fetch_array($query)){
			$listOfCountries[$counter]=smCountries::_processRow($row);
			$counter++;
		}	
		return($listOfCountries);
	}
	
	private function _processRow($row){
		$country = new smCountries;
		$country->rowId = $row['rowId'];
		$country->countryId = $row['countryId'];
		$country->locale = $row['locale'];
		$country->countryCode = $row['countryCode'];
		$country->countryName = smCountries::_cleanUp($row['countryName']);
		$country->phonePrefix = $row['phonePrefix'];
		return($country);
	}
	
	private function _cleanUp($string){
		$string = str_replace("'","&apos;",$string);
		return($string);
	}
	
}

?>