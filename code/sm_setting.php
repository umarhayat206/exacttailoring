<?php

class smSetting{
	
	public static function checkInput($value){
		// Stripslashes
		if (get_magic_quotes_gpc()){
			$value = stripslashes($value);
		}
		// Quote if not a number
		if (!is_numeric($value)){
			$value = "'" . mysql_real_escape_string($value) . "'";
		}
		return $value;
	}
	
	public function countProduct($sql){
		$query = mysql_query("SELECT * FROM ex_product_details WHERE productVisibleFlag = '1' $sql ");
		$countproduct = mysql_num_rows($query);
		return $countproduct;
	}
	
	public function getSearchCategoryId($g1, $g2, $g3){
		$catename = explode("categories-", $g2);
		$catename1 = explode($g1."-", $catename[1]);
		$cate = smCategory::getSubCategoryByName($g3, str_replace("-"," ",$catename1[1]));
		return $cate;
	}
	    
	public function getSearchFabricId($g1){
		$fabricname = explode("fabric-", $g1);
		$fabric = smFabric::getFabricByName(str_replace("-"," ",$fabricname[1]));
		return $fabric;
	}
	    
	public function getSearchColorId($g1){
		$colorname = explode("color-", $g1);
		$color = smColor::getColorByName(str_replace("-"," ",$colorname[1]));
		return $color;
	}
	    
	public function getSearchPatternId($g1){
		$patternname = explode("pattern-", $g1);
		$color = smPattern::getPatternByName(str_replace("-"," ",$patternname[1]));
		return $color;
	}

	public function changeMonth($m){
		switch ($m) {
			case "01":
				$mm="January";
				break;
			case "02":
				$mm="February";
				break;
			case "03":
				$mm="March";
				break;
			case "04":
				$mm="April";
				break;
			case "05":
				$mm="May";
				break;
			case "06":
				$mm="June";
				break;
			case "07":
				$mm="July";
				break;
			case "08":
				$mm="August";
				break;
			case "09":
				$mm="September";
				break;
			case "10":
				$mm="October";
				break;
			case "11":
				$mm="November";
				break;
			case "12":
				$mm="December";
				break;
			default:
				$mm="";
				break;
		}
		return $mm;
	}
	
	public function getCountry($id){
		$query = mysql_query("SELECT * FROM iso_countries WHERE rowId='$id' ");
		$row = mysql_fetch_array($query);
		$theCountry = array();
		$theCountry=smSetting::_processCountry($row);
		return $theCountry;
	}
	
	function getAllCountry(){
		$sql="select * from iso_countries order by countryName asc";
		$query=mysql_query($sql);
		$listCountry = array();
		$counter = 0;
		while ($row = mysql_fetch_array($query)){
		 	$listCountry[$counter]=smSetting::_processCountry($row);
			$counter++;
		}
		return $listCountry;			
	}
	
	function _processCountry($row){
		$item = new smSetting;
		$item->rowId = $row['rowId'];
		$item->countryId = $row['countryId'];
		$item->locale = $row['locale'];
		$item->countryCode = $row['countryCode'];
		$item->countryName = $row['countryName'];
		$item->phonePrefix = $row['phonePrefix'];
		return($item);
	}

	public function getHowhearDropdowm(){
		$htmlToReturn ="<option value=''>Select</option>
			<option value='Avery'>Avery</option>
			<option value='Cricket'>Cricket</option>
			<option value='Nauticalia'>Nauticalia</option>
			<option value='Virgin'>Virgin</option>
			<option value='AA Magazine'>AA Magazine</option>
			<option value='Daily Telegraph'>Daily Telegraph</option>
			<option value='Sunday Telegraph'>Sunday Telegraph</option>
			<option value='Daily Express'>Daily Express</option>
			<option value='Daily Mail'>Daily Mail</option>
			<option value='Mail On Sunday'>Mail On Sunday</option>
			<option value='The Times'>The Times</option>
			<option value='Sunday People'>Sunday People</option>
			<option value='Daily Mirror'>Daily Mirror</option>
			<option value='Sunday Mirror'>Sunday Mirror</option>
			<option value='Saga Magazine'>Saga Magazine</option>
			<option value='MSN'>MSN</option>
			<option value='Altavista'>Altavista</option>
			<option value='AOL'>AOL</option>
			<option value='Freeserve'>Freeserve</option>
			<option value='BT Internet'>BT Internet</option>
			<option value='Ask Jeeves'>Ask Jeeves</option>
			<option value='Google'>Google</option>
			<option value='Yahoo'>Yahoo</option>
			<option value='Other'>Other</option>";
		
		return $htmlToReturn;
	}
	
	/*
	function youtubeThumbs($ved_path,$w,$h,$att='') {
		return preg_replace('/http:\/\/(www.)?(youtu.be\/|youtube.com\/watch\?v=)([a-zA-Z0-9?%.;:\\/=+_-]+)([&]*([a-zA-Z0-9?&%.;:\\/=+_-]*))/i', '<a href="'.$ved_path.'" '.$att.'><img src="http://img.youtube.com/vi/$3/0.jpg" width="'.$w.'" height="'.$h.'" /></a>', $ved_path);
	}
	*/
}
?>
