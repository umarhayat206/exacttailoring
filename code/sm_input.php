<?php

/**
 * Title:-
 * Description:- 
 * @copyright 2007
 */

function smInput($label = "", $id = "", $value = "", $type = "text", $furtherAttributes = "", $required = "", $validation = ""){
	//Only need client side validation as badChars are stripped in code... (Alright, serverside would be better). Hence validation here is only for usability!
	
	$ofType = "input";
	$type = strtolower($type);
	
	if ($type == "textarea"){
		$ofType = "textarea";
		$type = "";
	}
		
	//Need to flesh this out
	if (!$required==""){
	 	$required = "<span class='required'><em>*</em></span>";
	}
	
	switch($validation){
	case "text":
		$validation = "valText";
	case "decimal":
		$validation = "valDecimal";
	}
	
	//Validation tag adds a class eg valText to the input... This can later be controled in page...
	if (!$required=="" Or !$validation==""){
		$classTag = "class='".(!$required==""?"valRequired ":"").(!$validation==""?$validation." ":"")."'";
	}
	if($ofType != "textarea"){	
		echo("<label for='$id' id='lbl$id'>$label $required</label>".
		 	"<$ofType id='$id' name='$id' type='$type' value='$value' $furtherAttributes $classTag />");
	//Append closing tags when necessary
	}else{
		echo("<label for='$id' id='lbl$id'>$label $required</label>".
		 "<$ofType id='$id' name='$id' type='$type' $furtherAttributes $classTag >");
	}
	echo($ofType == "textarea"? "$value</textarea>":"");	
}
?>