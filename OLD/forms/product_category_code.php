<?php
$productCategoryError = "";
$selectedProductCategory = new tsProductCategory;

if($_REQUEST['pcId']!=""){
	$selectedProductCategory = $selectedProductCategory->productCategoryGetOne($_REQUEST['pcId']);
}

if($_POST['pcName']!=""){
	$selectedProductCategory->pcName = $_POST['pcName'];
	$selectedProductCategory->pcDescription = $_POST['pcDescription'];
	$selectedProductCategory->pcImage = smImages::Upload($_FILES['pcImage']['name'],$_FILES['pcImage']['tmp_name'],220);
	$selectedProductCategory->pcPcId = $_POST['pcPcId'];
	$selectedProductCategory->pcPmgId = $_POST['pcPmgId'];
	if($selectedProductCategory->pcId>0 && $selectedProductCategory->pcId==$selectedProductCategory->pcPcId){//mofo's
		$productCategoryError = "<p class='validationArea'>A category cannot reference itself!</p>";
	}else{
		$selectedProductCategory->productCategorySave($selectedProductCategory);
		$selectedProductCategory = null;	
	}
}

?>