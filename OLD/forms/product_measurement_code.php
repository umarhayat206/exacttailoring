<?php
//print_r($_POST);

if($_GET['delPmId']!="" && $_SESSION['auth']!='false'){
	tsProductMeasurements::pmDelete($_GET['delPmId']);
}

$currentGroup = new tsProductMeasurmentGroup;
if($_REQUEST['pmgId']!=""){ //See if a measurement group has been posted back
	$currentGroup = $currentGroup->pmgGetOne($_REQUEST['pmgId']);
}

$measurements = new tsProductMeasurements;
if($currentGroup->pmgId!=""){ //Group selected. Get relevent measurements
	$measurements = $measurements->pmGetCollection($currentGroup->pmgId);
}
if($_POST['pmgGroupName']!=""){ //Save measurements
	//$numMeasurements = (count($_POST) - 3) / 5; //Deduct 3 from the total count, then divide by 5
	$numMeasurements=0;
	foreach($_POST as $key=>$value){
		if(stristr($key,"pmId")){
			$numMeasurements++;
		}
	}
	$currentGroup->pmgName = $_POST['pmgGroupName'];
	$currentGroup->pmgImage = smImages::Upload($_FILES['pmgGroupImage']['name'],$_FILES['pmgGroupImage']['tmp_name'],570);
	$currentGroup->pmgId = $currentGroup->pmgSave($currentGroup); //Save the group name and use the group id to save the measurements
	for($i=1;$i<=$numMeasurements;$i++){ //loop through the groups of measurements
		if($_POST['pmName'.$i]!=""){
			$measurements = new tsProductMeasurements;
			//Upload image and get filename
			$measurements->pmImage = smImages::Upload($_FILES['pmImage'.$i]['name'],$_FILES['pmImage'.$i]['tmp_name']);			
			$measurements->pmId = $_POST['pmId'.$i];
			$measurements->pmName = $_POST['pmName'.$i];
			$measurements->pmOrderNumber = $_POST['pmOrderNumber'.$i];
			$measurements->pmCheckbox = $_POST['pmCheckbox'.$i];
			//$measurements->pmOptionGroup = $_POST['pmOptionGroup'.$i];
			//$measurements->pmOptionGroupValue = $_POST['pmOptionGroupValue'.$i];
			$measurements->pmPmgId = $currentGroup->pmgId;
			$measurements->pmSave($measurements);	
		}
	}
	$currentGroup = null;
	$measurements = null;
}

function addCurrentMeasurements($pmgId){
	$measurement = tsProductMeasurements::pmGetCollection($pmgId);
	if(count($measurement)>0){
		$countTo = count($measurement)-1;
	}else{
		$countTo = 0;
	}
	for($i=0;$i<=$countTo;$i++){
		if($measurement[$i]->pmId>0){
			$delButton = "<a title='Delete single measurement' href='".($_SERVER['PHP_SELF']."?pmgId=".$_GET['pmgId']."&amp;delPmId=".$measurement[$i]->pmId)."' class='measurementDelete' onclick='javascript:return confirm(\"Are you sure you want to delete this measurement?\")'>X</a>";
		}else{
			$delButton = "";
		}
		?>
			<fieldset>
				<legend>Measurement <?php echo($i+1);?> <?php echo($delButton);?></legend>
				<?php smControls::smHiddenText("pmId".($i+1),$measurement[$i]->pmId);?>
				<?php smControls::smTextBox("Measurement name","pmName".($i+1),$measurement[$i]->pmName);?><br />
				<?php smControls::smTextBox("Order number","pmOrderNumber".($i+1),$measurement[$i]->pmOrderNumber);?><br />
				<?php smControls::smCheckBox("Checkbox option","pmCheckbox".($i+1),"1",$measurement[$i]->pmCheckbox=="1"?"checked='checked'":"");?><br />
				<?php smImages::showThumb($measurement[$i]->pmImage,$measurement[$i]->pmName,180);?>
				<?php smControls::smFileUpload("Descriptive image","pmImage".($i+1),$measurement[$i]->pmImage);?><br />
				<!--<h4>Optional drop down menu details</h4>-->
				<?php //smControls::smTextBox("Option group name","pmOptionGroup".($i+1),$measurement[$i]->pmOptionGroup);?><br />
				<?php //smControls::smTextBox("Option value","pmOptionGroupValue".($i+1),$measurement[$i]->pmOptionGroupValue);?><br />
			</fieldset>		
		<?php
	}
	return($i);
}
?>