<?php //TODO: Add a radio button to specify shirt or body measurement ?>
<form id="bodyMeasurementForm" method="post" action="<?php echo($_SERVER['PHP_SELF']);?>" class="hidden">
	<h3>Body/Shirt measurements</h3>
	<?php echo($errBmMeasurement);?>
	<fieldset>
		<legend>Profile</legend>
		<?php smControls::smTextBox("Profile name","bmProfileName",$selectedBM->bmProfileName);?><br />
		
		<fieldset>
			<legend>Metric</legend>	
			<?php smControls::smRadioButton("Centimeters <span class='smallText'>(Decimal)</span>","bmMetric","bmDecimal","0",$selectedBM->bmMetric==0?"Checked":"");?><br />
			<?php smControls::smRadioButton("Inches <span class='smallText'>(Imperial)</span>","bmMetric","bmImperial","1",$selectedBM->bmMetric==1?"Checked":"");?><br />
		</fieldset>
		<script  type="text/javascript">
			$(document).ready(function(){
				$('#Body').click(function(){
					$('#fit').slideToggle();
				});
				$('#Shirt').click(function(){
					$('#fit').slideToggle();
				});
			});
		</script> 
		<fieldset>
			<legend>Measurement taken from</legend>
			<?php smControls::smRadioButton("Shirt","bmType","Shirt","Shirt",$selectedBM->bmType=="Shirt" || $selectedBM->bmType==""?"Checked":""); ?><br />
			<?php smControls::smRadioButton("Body","bmType","Body","Body",$selectedBM->bmType=="Body"?"Checked":""); ?><br />
			<?php //smControls::smCheckBox("Shirt","bmType","Shirt","Shirt",$selectedBM->bmType=="Shirt" || $selectedBM->bmType==""?"Checked":""); ?><br />
			<?php //smControls::smCheckBox("Body","bmType","Body","Body",$selectedBM->bmType=="Body"?"Checked":""); ?>
			<?php /*smControls::smDropDownList("Fit","bmFit",
				array(
					'Slim Fit'=>'Slim Fit – close fit 2" will be added to the chest, stomach and hip measurements above',
					'Standard Fit'=>'Standard – Average fit 4" will be added to the chest, stomach and hip measurements above.',
					'Full Cut'=>'Full cut - Loose fit 6" will be added to the chest, stomach and hip measurements above',
				),
				$selectedBM->bmFit);*/
			?>
			
			<?php
			if($selectedBM->bmType=="Body"){
				$u="display:run-in;";
			}else{
				$u="display:none;";
			}
			echo "<div id='fit' style='$u'>";
				
				if($_SESSION['shirtDesign']->sFit==1){		// Normal Fit
					echo "<label>Fit</label><label style='width:85%; float:right;'>Standard – Average fit 4\" will be added to the chest, stomach and hip measurements above.</label><input type='hidden' id='bmFit' name='bmFit' value='Mens Standard Fit' />";
				}else if($_SESSION['shirtDesign']->sFit==2){	// Slim Fit
					echo "<label>Fit</label><label style='width:85%; float:right;'>Slim Fit – close fit 2\" will be added to the chest, stomach and hip measurements above.</label><input type='hidden' id='bmFit' name='bmFit' value='Mens Slim Fit' />";
				}else if($_SESSION['shirtDesign']->sFit==3){	// Loose Fit
					echo "<label>Fit</label><label style='width:85%; float:right;'>Loose fit 6\" will be added to the chest, stomach and hip measurements above.</label><input type='hidden' id='bmFit' name='bmFit' value='Mens Full Cut' />";
				// edit 01-11-11
				}else if($_SESSION['shirtDesign']->sFit==4){		// Normal Fit
					echo "<label>Fit</label><label style='width:85%; float:right;'>Standard – Average fit 4\" will be added to the chest, stomach and hip measurements above.</label><input type='hidden' id='bmFit' name='bmFit' value='Ladies Standard Fit' />";
				}else if($_SESSION['shirtDesign']->sFit==5){	// Slim Fit
					echo "<label>Fit</label><label style='width:85%; float:right;'>Slim Fit – close fit 2\" will be added to the chest, stomach and hip measurements above.</label><input type='hidden' id='bmFit' name='bmFit' value='Ladies Slim Fit' />";
				}else if($_SESSION['shirtDesign']->sFit==6){	// Loose Fit
					echo "<label>Fit</label><label style='width:85%; float:right;'>Loose fit 6\" will be added to the chest, stomach and hip measurements above.</label><input type='hidden' id='bmFit' name='bmFit' value='Ladies Full Cut' />";
				}

			echo "</div><br />";
			?><br />
			<?php smControls::smCheckBox("Soft collar option","bmSoftCollar","Yes",$selectedBM->bmSoftCollar);?><br />
		</fieldset>
		<fieldset>
			<legend>Measurments</legend>
			<?php smControls::smTextBox("<a href='styles/images/measurements7.jpg' style='text-decoration: none; color:#333;' rel='lyteshow[g1]'>Neck <span class='smallText'>(Measure Length required from button to centre of button hole)</span></a>","bmNeck",$selectedBM->bmNeck,"class='numeric'");?><br />
			<?php smControls::smTextBox("<a href='styles/images/measurements3.jpg' style='text-decoration: none; color:#333;' rel='lyteshow[g2]'>Chest <span class='smallText'>(Measure around body well up under arm holes )</span></a>","bmChest",$selectedBM->bmChest,"class='numeric'");?><br />
			<?php smControls::smTextBox("<a href='styles/images/measurements4.jpg' style='text-decoration: none; color:#333;' rel='lyteshow[g3]'>Stomach <span class='smallText'>(Measure around stomach line)</span></a>","bmWaist",$selectedBM->bmWaist,"class='numeric'");?><br />
			<?php smControls::smTextBox("<a href='styles/images/measurements6.jpg' style='text-decoration: none; color:#333;' rel='lyteshow[g4]'>Hips <span class='smallText'>(Measure around hips at widest point of seat but not tight. )</span></a>","bmSeat",$selectedBM->bmSeat,"class='numeric'");?><br />
			<?php smControls::smTextBox("<a href='styles/images/measurements5.jpg' style='text-decoration: none; color:#333;' rel='lyteshow[g5]'>Lenght <span class='smallText'>(Measure from small bone at back of neck to length required )</span></a>","bmBack",$selectedBM->bmBack,"class='numeric'");?><br />
			<?php smControls::smTextBox("<a href='styles/images/measurements2.jpg' style='text-decoration: none; color:#333;' rel='lyteshow[g6]'>Sleeve length <span class='smallText'>(Measure from shoulder to length desired - around elbow for long sleeve)</span></a>","bmArm",$selectedBM->bmArm,"class='numeric'");?><br />
			<?php smControls::smTextBox("<a href='styles/images/measurements2.jpg' style='text-decoration: none; color:#333;' rel='lyteshow[g7]'>Short sleeve <span class='smallText'>(Measure from shoulder to length required)</span></a>","bmArmShort",$selectedBM->bmArmShort,"class='numeric'");?><br />
			<?php smControls::smTextBox("<a href='styles/images/measurements8.jpg' style='text-decoration: none; color:#333;' rel='lyteshow[g8]'>Cuff <span class='smallText'>(Measure length required from button to centre button hole)</span></a>","bmCuff",$selectedBM->bmCuff,"class='numeric'");?><br />
			<?php smControls::smTextBox("<a href='styles/images/measurements8.jpg' style='text-decoration: none; color:#333;' rel='lyteshow[g9]'>Upper arm <span class='smallText'>(Measure around upper arm)</span></a>","bmBicep",$selectedBM->bmBicep,"class='numeric'");?><br />
			<?php //smControls::smTextBox("Lenght","bmLength",$selectedBM->bmLength,"class='numeric'"); ?>
			<?php smControls::smTextBox("<a href='styles/images/measurements1.jpg' style='text-decoration: none; color:#333;' rel='lyteshow[g10]'>Shoulder <span class='smallText'>(Measure back at end of shoulder)</span></a>","bmShoulder",$selectedBM->bmShoulder);?><br />
			<?php smControls::smTextArea("Special Details <span class='smallText'>(More design, Delivery address *if different address with default address on your account, etc.. )</span>","bmSpecial",$selectedBM->bmSpecial);?><br />
			<?php //smControls::smTextBox("Height <span class='smallText'>(Optional)</span>","bmHeight",$selectedBM->bmHeight,"class='numeric'");?><br />
			<?php //smControls::smTextBox("Weight <span class='smallText'>(Optional)</span>","bmWeight",$selectedBM->bmWeight,"class='numeric'");?><br />
		</fieldset>
		<!--<fieldset>
			<legend>Back type</legend>
			<?php //smControls::smRadioButton("Bent","bmBackType","bmBackBent","0",$selectedBM->bmBackType==0?"Checked":"");?><br />
			<?php //smControls::smRadioButton("Average","bmBackType","bmBackAverage","1",$selectedBM->bmBackType==1?"Checked":"");?><br />
			<?php //smControls::smRadioButton("Straight","bmBackType","bmBackStraight","2",$selectedBM->bmBackType==2?"Checked":"");?><br />
		</fieldset>
		<fieldset>
			<legend>Shoulder type</legend>
			<?php //smControls::smRadioButton("Sloping","bmShoulderType","bmshoulderBent","0",$selectedBM->bmShoulderType==0?"Checked":"");?><br />
			<?php //smControls::smRadioButton("Average","bmShoulderType","bmshoulderAverage","1",$selectedBM->bmShoulderType==1?"Checked":"");?><br />
			<?php //smControls::smRadioButton("Straight","bmShoulderType","bmshoulderStraight","2",$selectedBM->bmShoulderType==2?"Checked":"");?><br />
		</fieldset>-->
		<?php smcontrols::smHiddenText("bmId",$selectedBM->bmId); ?>
		<?php smControls::smButton("Save","bmSave");?>
	</fieldset>
</form>