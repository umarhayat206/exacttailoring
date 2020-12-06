<?php

$errSmMeasurement = "";
$selectedSM = new tsShirtMeasurements;

if($_REQUEST['smId']!=""){
	$selectedSM = $selectedSM->smGetOne($_REQUEST['smId'],$_SESSION['auth']->mId);
}

if(isset($_POST['smSave'])){
	$selectedSM->smProfileName = $_POST['smProfileName'];
	$selectedSM->smMetric = $_POST['smMetric'];
	$selectedSM->smCollar = $_POST['smCollar'];
	$selectedSM->smChest = $_POST['smChest'];
	$selectedSM->smWaist = $_POST['smWaist'];
	$selectedSM->smBottom = $_POST['smBottom'];
	$selectedSM->smLength = $_POST['smLength'];
	$selectedSM->smSleeve = $_POST['smSleeve'];
	$selectedSM->smSleeveLower = $_POST['smSleeveLower'];
	$selectedSM->smSleeveShort = $_POST['smSleeveShort'];
	$selectedSM->smSleeveShortLower = $_POST['smSleeveShortLower'];
	$selectedSM->smBack = $_POST['smBack'];
	$selectedSM->smArmpit = $_POST['smArmpit'];
	$selectedSM->smCuff = $_POST['smCuff'];
	$selectedSM->smShortSleeveOpening = $_POST['smShortSleeveOpening'];
	$selectedSM->smBackType = $_POST['smBackType'];
	$selectedSM->smShoulderType = $_POST['smShoulderType'];
	$selectedSM->smAge = $_POST['smAge'];
	$selectedSM->smHeight = $_POST['smHeight'];
	$selectedSM->smWeight = $_POST['smWeight'];
	$selectedSM->smComments = $_POST['smComments'];
	$selectedSM->smMId = $_SESSION['auth']->mId;
	
	if(
		$selectedSM->smProfileName=="" ||
		$selectedSM->smMetric=="" ||
		$selectedSM->smCollar=="" ||
		$selectedSM->smHeight=="" ||
		$selectedSM->smWeight=="" 
		){
		$errSmMeasurement = "<p class='validationArea'>Please ensure all fields are completed.</p>";
	}else{ //Great. Store to session
		$_SESSION['shirtMeasurement'] = $selectedSM;
		//header("location:order-a-shirt-step-4");
		//header("location:tailor-made-shirts-review");
		echo "<script language='javascript' type='text/javascript'>window.location='tailor-made-shirts-review';</script>";
	}
}
?>