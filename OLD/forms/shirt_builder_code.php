<?php

//Create object, then store to sess
if($_POST['sSave']=="Save"){
	$shirtDesign = new tsShirtDesign;
	$shirtDesign->sFit = $_POST['sFit'];
	$shirtDesign->sColor = $_POST['sColor'];
	$shirtDesign->sCollar = $_POST['sCollar'];
	$shirtDesign->sCollarWhite = $_POST['sCollarWhite'];
	$shirtDesign->sSleeve = $_POST['sSleeve'];
	$shirtDesign->sCuff = $_POST['sCuff'];
	$shirtDesign->sCuffWhite = $_POST['sCuffWhite'];
	$shirtDesign->sPlacketButton = $_POST['sPlacketButton'];
	$shirtDesign->sFastening = $_POST['sFastening'];
	$shirtDesign->sPocket = $_POST['sPocket'];
	$shirtDesign->sPocketFlaps = $_POST['sPocketFlaps'];
	$shirtDesign->sEpaulettes = $_POST['sEpaulettes'];
	$shirtDesign->sEmbroideryText = $_POST['sEmbroideryText'];
	$shirtDesign->sEmbroideryColor = $_POST['sEmbroideryColor'];
	$shirtDesign->sBackPleats = $_POST['sBackPleats'];
	$shirtDesign->sBottomCut = $_POST['sBottomCut'];
	$_SESSION['shirtDesign'] = $shirtDesign;
	//header("location: order-a-shirt-step-3.php");
	//header("location: tailor-made-shirts-measurements.php");
	echo "<script language='javascript' type='text/javascript'>window.location='tailor-made-shirts-measurements.php';</script>";
}

?>