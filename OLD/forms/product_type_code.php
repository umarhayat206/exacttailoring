<?php
//print_r($_POST);
$selectedProductType = new tsProductTypes;
if($_REQUEST['ptId']!=""){
	$selectedProductType = $selectedProductType->productTypeGetOne($_REQUEST['ptId']);
}

if($_POST['ptName']!=""){
	//Upload Image
	$selectedProductType->ptImagePath = smImages::Upload($_FILES["ptImage"]["name"],$_FILES["ptImage"]["tmp_name"]);
	if($selectedProductType->ptImagePath!=""){ //create ini thumb
		$thumb = smImages::prepThumbName($selectedProductType->ptImagePath);
		$newThumb = smImages::thumbnail($selectedProductType->ptImagePath,180);
		smImages::imageToFile($newThumb,$thumb);
	}
	$selectedProductType->ptName = $_POST['ptName'];
	$selectedProductType->ptAvailable = $_POST['ptAvailable'];
	$selectedProductType->ptPrice = $_POST['ptPrice'];
	$selectedProductType->pcId = $_POST['ptPcId'];
	$selectedProductType->ptId = $selectedProductType->productTypeSave($selectedProductType);
	$selectedProductType = null;
}
?>