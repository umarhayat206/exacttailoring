<?php

class smControls{
	public static function smTextBox($label="sm Text Box", $id="", $value="", $furtherAttributes="", $suppressLabel=false, $newlineBetweenLabelAndInput = false){
		if($suppressLabel==false){
			echo("<label for='".$id."'>".$label."</label>");
		}
		if($newlineBetweenLabelAndInput==true){
			echo("<br />");
		}
		echo("<input id='".$id."' name='".$id."' value='".$value."' type='text' ".$furtherAttributes." />");
	}
	
	public static function smPasswordBox($label="sm Password Box", $id="", $value="", $furtherAttributes="", $suppressLabel=false, $newlineBetweenLabelAndInput = false){
		if($suppressLabel==false){
			echo("<label for='".$id."'>".$label."</label>");
		}
		if($newlineBetweenLabelAndInput==true){
			echo("<br />");
		}
		echo("<input id='".$id."' name='".$id."' value='".$value."' type='password' ".$furtherAttributes." />");
	}
	
	public static function smTextArea($label="sm Text Area", $id="", $value="", $furtherAttributes="", $suppressLabel=false, $newlineBetweenLabelAndInput = false, $rows = 8, $cols = 25){
		if($suppressLabel==false){
			echo("<label for='".$id."'>".$label."</label>");
		}
		if($newlineBetweenLabelAndInput==true){
			echo("<br />");
		}
		echo("<textarea id='".$id."' name='".$id."' ".$furtherAttributes." rows='".$rows."' cols='".$cols."' >".$value."</textarea>");	
	}
	
	public static function smCheckBox($label="sm Check Box", $id="", $value="", $checked="0", $futherAttributes=""){
		if($checked!=false And $checked!="N" And $checked!="No" And $checked!="NO" And $checked!="" And $checked!="false" and $checked!="0"){
			$checked = "checked='checked'";
		}else{
			$checked = "";
		}
		echo("<label for='".$id."'>".$label."</label>");
		echo("<input id='".$id."' name='".$id."' value='".$value."' type='checkbox' ".$checked." ".$furtherAttributes." />");	
	}
	
	public static function smRadioButton($label="sm Radio Button", $groupName="", $id="", $value="", $checked=false, $furtherAttributes=""){
		if($checked==true){
			$checked = "checked='checked'";
		}else{
			$checked = "";
		}
		echo("<label for='".$id."'>".$label."</label>");
		echo("<input id='".$id."' name='".$groupName."' value='".$value."' type='radio' ".$checked." ".$furtherAttributes." />");
	}
	
	public static function smHiddenText($id="sm Hidden Text", $value="", $furtherAttributes=""){
		echo("<input id='".$id."' name='".$id."' value='".$value."' ".$furtherAttributes." type='hidden' />");
	}
	
	public static function smButton($label="sm Button", $id="" , $furtherAttributes="class='button'"){
		echo("<input id='".$id."' name='".$id."' type='submit' value='".$label."' ".$furtherAttributes." />");
	}
	
	public static function smImageLink($src, $title, $navigateUrl, $returnConfirm="", $aFurtherAttributes="", $imgFurtherAttributes=""){
		if($returnConfirm!=""){
			$confirm = "onclick='javascript:return confirm(\"".$returnConfirm."\")'";
		}else{
			$confirm="";
		}
		echo("<a href='".$navigateUrl."' title='".$title."' ".$confirm." ".$aFurtherAttributes." ><img src='".$src."'  title='".$title."' alt='".$title."' ".$imgFurtherAttributes." /></a>");
	}
	
	public static function smFileUpload($label="sm File Upload", $id="", $value="", $furtherAttributes="", $suppressLabel=false, $newlineBetweenLabelAndInput = false){
		if($suppressLabel==false){
			echo("<label for='".$id."'>".$label."</label>");
		}
		if($newlineBetweenLabelAndInput==true){
			echo("<br />");
		}
		echo("<input id='".$id."' name='".$id."' value='".$value."' type='file' ".$furtherAttributes." />");
	}
	
	public static function smDropDownList($label="sm Drop Down List", $id="", $itemArray=array("key"=>"value"), $valueToSelect="" , $furtherAttributes="", $suppressLabel=false, $addSelectOption=false){
		if($suppressLabel==false){
			echo("<label  for='".$id."'>".$label."</label>");
		}
		echo("<select class='form-control account-input' id='".$id."' name='".$id."' ".$furtherAttributes." >");
		if($addSelectOption==true){
			echo("<option value=''>Select</option>");
		}
		if(!empty($itemArray)){
			foreach($itemArray as $key=>$value){
				if($key==$valueToSelect){
					$selected="selected='selected'";
				}else{
					$selected="";
				}
				echo("<option value='".$key."' ".$selected.">".$value."</option>");
			}
		}else{
			echo("<option value=''></option>");
		}
		echo("</select>");		
	}
	
	public static function smImageOptional($src="", $alt="", $title="", $furtherAttributes=""){
		if($src!=""){
			if(is_file($src)){
				echo("<img src='".$src."' alt='".$alt."' title='".$title."' ".$furtherAttributes." />");	
			}
		}
	}
	
	public static function smTrueFalseImage($srcTrueImage, $srcFalseImage, $switch, $textTrue="", $textFalse="", $furtherAttributes=""){
		if(($switch==true Or $switch==1 Or $switch=="true" Or $switch=="1" Or $switch=="Yes") And is_file($srcTrueImage)){
			echo("<img src='".$srcTrueImage."' alt='".$textTrue."' title='".$textTrue."' ".$furtherAttributes." />");
		}elseif(is_file($srcFalseImage)){
			echo("<img src='".$srcFalseImage."' alt='".$textFalse."' title='".$textFalse."' ".$furtherAttributes." />");
		}
	}
}
?>