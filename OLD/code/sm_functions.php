<?php

class smFunctions {	
	
	/** Displays the date is a user friendly manner - or displays "N/A" if empty var given **/
	public static function displayDate($date){
		if($date!=""){
			return(date("d M Y H:m:s", strtotime($date)));
		}else{
			return("N/A");
		}		
	}
	
	/** Cleans user input against SQL Injection **/
	public static function checkInput($value,$dontQuote=false){
		// Stripslashes
		if (get_magic_quotes_gpc()){
			$value = stripslashes($value);
		}
		// Quote if not a number
		if (!is_numeric($value) && $dontQuote==false){
			$value = "'" . mysql_real_escape_string($value) . "'";
		}elseif(!is_numeric($value) && $dontQuote==true){
			$value = "" . mysql_real_escape_string($value) . "";
		}
		return $value;
	}
	
	public static function makeSef($string){
		$string = str_replace(" ","-",$string);
		return(strtolower($string));
	}
}
?>