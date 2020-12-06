<?php
$errBmMeasurement = "";
$selectedBM = new tsBodyMeasurements;

if($_REQUEST['bmId']!=""){ //If available, retrieve the post/get bm details
	$selectedBM = $selectedBM->bmGetOne($_REQUEST['bmId'],$_SESSION['auth']->mId);
}

if(isset($_POST['bmSave'])){ //Saving a body measurement
	$selectedBM->bmProfileName = $_POST['bmProfileName'];
	$selectedBM->bmMetric = $_POST['bmMetric'];
	$selectedBM->bmType = $_POST['bmType'];
	$selectedBM->bmNeck = $_POST['bmNeck'];
	$selectedBM->bmChest = $_POST['bmChest'];
	$selectedBM->bmWaist = $_POST['bmWaist'];
	$selectedBM->bmSeat = $_POST['bmSeat'];
	$selectedBM->bmBack = $_POST['bmBack'];
	$selectedBM->bmArm = $_POST['bmArm'];
	$selectedBM->bmArmShort = $_POST['bmArmShort'];
	$selectedBM->bmCuff = $_POST['bmCuff'];
	$selectedBM->bmBicep = $_POST['bmBicep'];
	$selectedBM->bmShoulder = $_POST['bmShoulder'];
	$selectedBM->bmSpecial = $_POST['bmSpecial'];
	$selectedBM->bmFit = $_POST['bmFit'];
	$selectedBM->bmSoftCollar = $_POST['bmSoftCollar'];
	$selectedBM->bmLength = $_POST['bmLength'];
	$selectedBM->bmHeight = $_POST['bmHeight'];
	$selectedBM->bmWeight = $_POST['bmWeight'];
	$selectedBM->bmBackType = $_POST['bmBackType'];
	$selectedBM->bmShoulderType = $_POST['bmShoulderType'];
	$selectedBM->bmMId = $_SESSION['auth']->mId;

	if(
		$selectedBM->bmProfileName=="" ||
		$selectedBM->bmMId==""
		){
		$errBmMeasurement = "<p class='validationArea'>Please ensure all non-optional fields are completed.</p>";	
	}else{ //Alls good, proceed to save
		$bmId = $selectedBM->bmSave($selectedBM);
		$selectedBM = null;	
	}
}


?>