<?php //TODO: Change to Bio measurement form ?>
<form id="shirtMeasurementForm" method="post" action="<?php echo($_SERVER['REQUEST_URI']);?>" class="hidden">
	<h3>Bio measurements</h3>
	<fieldset>
		<legend>Profile</legend>
		<?php smControls::smTextBox("Profile name","smProfileName",$selectedSM->smProfileName);?><br />
		<fieldset>
			<legend>Metric</legend>	
			<?php smControls::smRadioButton("Centimeters <span class='smallText'>(Decimal)</span>","smMetric","smDecimal","0",$selectedSM->smMetric==0?"Checked":"");?><br />
			<?php smControls::smRadioButton("Inches <span class='smallText'>(Imperial)</span>","smMetric","smImperial","1",$selectedSM->smMetric==1?"Checked":"");?><br />
		</fieldset>
		<fieldset>
			<legend>Measurements</legend>
			<?php smControls::smTextBox("Collar size <span class='smallText'>(numeric)</span>","smCollar",$selectedSM->smCollar,"class='numeric'");?><br />
			<?php smControls::smTextBox("Age <span class='smallText'>(numeric)</span>","smAge",$selectedSM->smAge,"class='numeric'");?><br />
			<?php smControls::smTextBox("Chest <span class='smallText'>(numeric)</span>","smChest",$selectedSM->smChest,"class='numeric'");?><br />
			<?php smControls::smTextBox("Height <span class='smallText'>(numeric)</span>","smHeight",$selectedSM->smHeight,"class='numeric'");?><br />
			<?php smControls::smTextBox("Weight <span class='smallText'>(numeric)</span>","smWeight",$selectedSM->smWeight,"class='numeric'");?><br />
			<?php smControls::smTextArea("Comments","smComments",$selectedSM->smComments);?><br />
		</fieldset>
		<?php smcontrols::smHiddenText("smId",$selectedSM->smId);?>
		<?php smControls::smButton("Save","smSave");?>
	</fieldset>
</form><br />


<?php /* //Removed in favour of a Bio metric form


<?php smControls::smDropDownList("Length","smLength",array("Regular"=>"Regular","Long"=>"Long","Short"=>"Short"),$selectedSM->smLength);?><br />



<form id="shirtMeasurementForm" method="post" action="<?php echo($_SERVER['PHP_SELF']);?>" class="hidden">
	<h3>Shirt measurements</h3>
	<?php echo($errSmMeasurement);?>
	<fieldset>
		<legend>Profile</legend>
		<?php smControls::smTextBox("Profile name","smProfileName",$selectedSM->smProfileName);?><br />		
		<fieldset>
			<legend>Metric</legend>	
			<?php smControls::smRadioButton("Centimeters <span class='smallText'>(Decimal)</span>","smMetric","smDecimal","0",$selectedSM->smMetric==0?"Checked":"");?><br />
			<?php smControls::smRadioButton("Inches <span class='smallText'>(Imperial)</span>","smMetric","smImperial","1",$selectedSM->smMetric==1?"Checked":"");?><br />
		</fieldset>
		<fieldset>
			<legend>Measurments</legend>
			<?php smControls::smTextBox("Collar","smCollar",$selectedSM->smCollar,"class='numeric'");?><br />
			<?php smControls::smTextBox("Chest","smChest",$selectedSM->smChest,"class='numeric'");?><br />
			<?php smControls::smTextBox("Waist","smWaist",$selectedSM->smWaist,"class='numeric'");?><br />
			<?php smControls::smTextBox("Bottom","smBottom",$selectedSM->smBottom,"class='numeric'");?><br />
			<?php smControls::smTextBox("Length","smLength",$selectedSM->smLength,"class='numeric'");?><br />
			<?php smControls::smTextBox("Sleeve","smSleeve",$selectedSM->smSleeve,"class='numeric'");?><br />
			<?php smControls::smTextBox("Lower sleeve","smSleeveLower",$selectedSM->smSleeveLower,"class='numeric'");?><br />
			<?php smControls::smTextBox("Short sleeve","smSleeveShort",$selectedSM->smSleeveShort);?><br />
			<?php smControls::smTextBox("Lower short sleeve","smSleeveShortLower",$selectedSM->smSleeveShortLower,"class='numeric'");?><br />
			<?php smControls::smTextBox("Back","smBack",$selectedSM->smBack,"class='numeric'");?><br />
			<?php smControls::smTextBox("Armpit","smArmpit",$selectedSM->smArmpit,"class='numeric'");?><br />
			<?php smControls::smTextBox("Cuff","smCuff",$selectedSM->smCuff,"class='numeric'");?><br />
			<?php smControls::smTextBox("Short sleeve opening","smShortSleeveOpening",$selectedSM->smShortSleeveOpening,"class='numeric'");?><br />
		</fieldset>
		<fieldset>
			<legend>Back type</legend>
			<?php smControls::smRadioButton("Bent","smBackType","smBackBent","0",$selectedSM->smBackType==0?"Checked":"");?><br />
			<?php smControls::smRadioButton("Average","smBackType","smBackAverage","1",$selectedSM->smBackType==1?"Checked":"");?><br />
			<?php smControls::smRadioButton("Straight","smBackType","smBackStraight","2",$selectedSM->smBackType==2?"Checked":"");?><br />
		</fieldset>
		<fieldset>
			<legend>Shoulder type</legend>
			<?php smControls::smRadioButton("Sloping","smShoulderType","smShoulderBent","0",$selectedSM->smShoulderType==0?"Checked":"");?><br />
			<?php smControls::smRadioButton("Average","smShoulderType","smShoulderAverage","1",$selectedSM->smShoulderType==1?"Checked":"");?><br />
			<?php smControls::smRadioButton("Straight","smShoulderType","smShoulderStraight","2",$selectedSM->smShoulderType==2?"Checked":"");?><br />
		</fieldset>
		<?php smcontrols::smHiddenText("smId",$selectedSM->smId);?>
		<?php smControls::smButton("Save","smSave");?>
	</fieldset>
</form>
*/ ?>