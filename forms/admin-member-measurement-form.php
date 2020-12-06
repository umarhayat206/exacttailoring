<?php

if($_POST['submitmeasurement']){
    $MEASUREMENT = new smMeasurement;
    $MEASUREMENT->measurementId = $_POST['measurementId'];
    $MEASUREMENT->usId = $_POST['memberId'];
    $MEASUREMENT->measurementMetric = $_POST['membermeasurementMetric'];
    $MEASUREMENT->measurementType = $_POST['membermeasurementType'];
    $MEASUREMENT->measurementShirtNeck = str_replace(",","",$_POST['membermeasurementShirtNeck']);
    $MEASUREMENT->measurementShirtChest = str_replace(",","",$_POST['membermeasurementShirtChest']);
    $MEASUREMENT->measurementShirtStomach = str_replace(",","",$_POST['membermeasurementShirtStomach']);
    $MEASUREMENT->measurementShirtHips = str_replace(",","",$_POST['membermeasurementShirtHips']);
    $MEASUREMENT->measurementShirtLenght = str_replace(",","",$_POST['membermeasurementShirtLenght']);
    $MEASUREMENT->measurementShirtSleeveLength = str_replace(",","",$_POST['membermeasurementShirtSleeveLength']);
    $MEASUREMENT->measurementShirtShortSleeve = str_replace(",","",$_POST['membermeasurementShirtShortSleeve']);
    $MEASUREMENT->measurementShirtCuff = str_replace(",","",$_POST['membermeasurementShirtCuff']);
    $MEASUREMENT->measurementShirtUpperarm = str_replace(",","",$_POST['membermeasurementShirtUpperarm']);
    $MEASUREMENT->measurementShirtShoulder = str_replace(",","",$_POST['membermeasurementShirtShoulder']);
    $MEASUREMENT->measurementTrousersA = str_replace(",","",$_POST['membermeasurementTrousersA']);
    $MEASUREMENT->measurementTrousersB = str_replace(",","",$_POST['membermeasurementTrousersB']);
    $MEASUREMENT->measurementTrousersC = str_replace(",","",$_POST['membermeasurementTrousersC']);
    $MEASUREMENT->measurementTrousersD = str_replace(",","",$_POST['membermeasurementTrousersD']);
    $MEASUREMENT->measurementTrousersE = str_replace(",","",$_POST['membermeasurementTrousersE']);
    $MEASUREMENT->measurementTrousersF = str_replace(",","",$_POST['membermeasurementTrousersF']);
    $MEASUREMENT->measurementTrousersG = str_replace(",","",$_POST['membermeasurementTrousersG']);
    $MEASUREMENT->measurementBoxersWaist = str_replace(",","",$_POST['membermeasurementBoxersWaist']);
    $MEASUREMENT->measurementBoxersTopofLeg = str_replace(",","",$_POST['membermeasurementBoxersTopofLeg']);
    $MEASUREMENT->measurementBoxersLength = str_replace(",","",$_POST['membermeasurementBoxersLength']);
    $MEASUREMENT->measurementBoxersHip = str_replace(",","",$_POST['membermeasurementBoxersHip']);
    $MEASUREMENT->measurementBoxersInsideLeg = str_replace(",","",$_POST['membermeasurementBoxersInsideLeg']);
    $MEASUREMENT->measurementSpecialDetails = mysql_real_escape_string($_POST['measurementSpecialDetails']);
    
    
    $checkmeasurement = smMeasurement::checkAddEdit($_POST['memberId']);
    
    if($checkmeasurement=="update"){
	$MEASUREMENTID=$MEASUREMENT->Update($MEASUREMENT);
    }else{
	$MEASUREMENTID=$MEASUREMENT->Add($MEASUREMENT);
    }
    
    
    
    echo ("<script>window.location='"._URL_."admin_body_measurements/?usId={$_POST['memberId']}';</script>");
    
}

$memberMeasurement = smMeasurement::GetIndividual($_GET['usId']);

$membername = smUser::GetIndividual($_GET['usId']);

if($memberMeasurement->measurementMetric==1){
    $chkmatric1=" checked='checked' ";
}else{
    $chkmatric2=" checked='checked' ";
}

if($memberMeasurement->measurementType=="SHIRT"){
    $checktype21 = " checked='checked' ";
}else{
    $checktype22 = " checked='checked' ";
}

?>
<div class="vertsortable" style="width:50%; margin: 0 auto;">
	<!-- gadget left 1 -->
	<div class="gadget">
		<div class="titlebar vertsortable_head">
			<!--<a href="#" class="hidegadget" rel="hide_block"><img src="<?//=_URL_;?>styles/images/spacer.gif" alt="picture" width="19" height="33" /></a>-->
			<h3><?php echo $membername->usFirstname ." ". $membername->usLastname; ?> - Edit measurements profile</h3>
		</div>
		<div class="gadgetblock">
                    
<form id="contentAddEdit" class="" method="post" action="<?=_URL_;?>admin_body_measurements" enctype="multipart/form-data">
    <fieldset>
        <legend>Metric</legend>
        <label class="radio">
            <input type="radio" name="membermeasurementMetric" id="metric1" value="1"  <?php echo $chkmatric1; ?> style="width:50px;"  />
           Centimeters (Decimal)
        </label>
        <label class="radio">
            <input type="radio" name="membermeasurementMetric" id="metric2" value="0" <?php echo $chkmatric2; ?> style="width:50px;" />
            Inches (Imperial)
        </label>
    </fieldset>
    
    <fieldset>
        <legend>Measurement Type</legend>
        <label class="radio">
            <input type="radio" name="membermeasurementType" id="type21" value="SHIRT"  <?php echo $checktype21; ?> style="width:50px;"  />
           Taken from SHIRT
        </label>
        <label class="radio">
            <input type="radio" name="membermeasurementType" id="type22" value="BODY" <?php echo $checktype22; ?> style="width:50px;" />
           Taken from BODY
        </label>
    </fieldset>
        
    <fieldset>
        <legend>Shirt / Jacket Measurement</legend>
        
        <p class="textblue">* Measurement taken from BODY <br/>(Standard - Average fit 4" will be added to the chest, stomach and hip measurements above.)</p>
        
        <label>Neck (Measure Length required from button to centre of button hole)</label>
        <input type="text" id="membermeasurementShirtNeck" name="membermeasurementShirtNeck" value="<?=$memberMeasurement->measurementShirtNeck; ?>" placeholder="Neck" /><br/>
        
        <label>Chest (Measure around body well up under arm holes)</label>
        <input type="text" id="membermeasurementShirtChest" name="membermeasurementShirtChest" value="<?=$memberMeasurement->measurementShirtChest; ?>" placeholder="Chest" /><br/>
        
        <label>Stomach (Measure around stomach line)</label>
        <input type="text" id="membermeasurementShirtStomach" name="membermeasurementShirtStomach" value="<?=$memberMeasurement->measurementShirtStomach; ?>" placeholder="Stomach" /><br/>
        
        <label>Hips (Measure around hips at widest point of seat but not tight.)</label>
        <input type="text" id="membermeasurementShirtHips" name="membermeasurementShirtHips" value="<?=$memberMeasurement->measurementShirtHips; ?>" placeholder="Hips" /><br/>
        
        <label>Lenght (Measure from small bone at back of neck to length required)</label>
        <input type="text" id="membermeasurementShirtLenght" name="membermeasurementShirtLenght" value="<?=$memberMeasurement->measurementShirtLenght; ?>" placeholder="Lenght" /><br/>
        
        <label>Sleeve length (Measure from shoulder to length desired - around elbow for long sleeve)</label>
        <input type="text" id="membermeasurementShirtSleeveLength" name="membermeasurementShirtSleeveLength" value="<?=$memberMeasurement->measurementShirtSleeveLength; ?>" placeholder="Sleeve length" /><br/>
        
        <label>Short sleeve (Measure from shoulder to length required)</label>
        <input type="text" id="membermeasurementShirtShortSleeve" name="membermeasurementShirtShortSleeve" value="<?=$memberMeasurement->measurementShirtShortSleeve; ?>" placeholder="Short sleeve"  /><br/>
        
        <label>Cuff (Measure length required from button to centre button hole)</label>
        <input type="text" id="membermeasurementShirtCuff" name="membermeasurementShirtCuff" value="<?=$memberMeasurement->measurementShirtCuff; ?>" placeholder="Cuff" /><br/>
        
        <label>Upper arm (Measure around upper arm)</label>
        <input type="text" id="membermeasurementShirtUpperarm" name="membermeasurementShirtUpperarm" value="<?=$memberMeasurement->measurementShirtUpperarm; ?>" placeholder="Upper arm" /><br/>
        
        <label>Shoulder (Measure back at end of shoulder)</label>
        <input type="text" id="membermeasurementShirtShoulder" name="membermeasurementShirtShoulder" value="<?=$memberMeasurement->measurementShirtShoulder; ?>" placeholder="Shoulder" /><br/>
    </fieldset>
    
    <fieldset>
        <legend>Trousers Measurement</legend>
        <label>(A) Outside Leg - Along Side Seam</label>
        <input type="text" id="membermeasurementTrousersA" name="membermeasurementTrousersA" value="<?=$memberMeasurement->measurementTrousersA; ?>" placeholder="Outside Leg" /><br/>
        
        <label>(B) Inside Leg - Along Inside Seam</label>
        <input type="text" id="membermeasurementTrousersB" name="membermeasurementTrousersB" value="<?=$memberMeasurement->measurementTrousersB; ?>" placeholder="Inside Leg" /><br/>
        
        <label>(C) Thigh - 3” below top of inside Leg</label>
        <input type="text" id="membermeasurementTrousersC" name="membermeasurementTrousersC" value="<?=$memberMeasurement->measurementTrousersC; ?>" placeholder="Thigh" /><br/>
        
        <label>(D) Width Of Knee</label>
        <input type="text" id="membermeasurementTrousersD" name="membermeasurementTrousersD" value="<?=$memberMeasurement->measurementTrousersD; ?>" placeholder="Width Of Knee" /><br/>
        
        <label>(E) Width of Bottom</label>
        <input type="text" id="membermeasurementTrousersE" name="membermeasurementTrousersE" value="<?=$memberMeasurement->measurementTrousersE; ?>" placeholder="Width of Bottom" /><br/>
        
        <label>(F) Waist - At waistband Level</label>
        <input type="text" id="membermeasurementTrousersF" name="membermeasurementTrousersF" value="<?=$memberMeasurement->measurementTrousersF; ?>" placeholder="Waist Measurements" /><br/>
        
        <label>(G) Seat - At fullest part of hips</label>
        <input type="text" id="membermeasurementTrousersG" name="membermeasurementTrousersG" value="<?=$memberMeasurement->measurementTrousersG; ?>" placeholder="Seat Measurements" /><br/>
    </fieldset>
    
    <?php //if($_SESSION['memberDetails']->usGender == 1){ ?>
    <fieldset>
        <legend>Boxers Measurement</legend>
        <label>Waist - Measure around waist or enter known waist size</label>
        <input type="text" id="membermeasurementBoxersWaist" name="membermeasurementBoxersWaist" value="<?=$memberMeasurement->measurementBoxersWaist; ?>" placeholder="Waist" /><br/>
        
        <label>Top of Leg - Measure around the thickest part of the leg</label>
        <input type="text" id="membermeasurementBoxersTopofLeg" name="membermeasurementBoxersTopofLeg" value="<?=$memberMeasurement->measurementBoxersTopofLeg; ?>" placeholder="Top of Leg" /><br/>
        
        <label>Length - Measure from waist to length required</label>
        <input type="text" id="membermeasurementBoxersLength" name="membermeasurementBoxersLength" value="<?=$memberMeasurement->measurementBoxersLength; ?>" placeholder="Length" /><br/>
        
        <label>Hip - Measure around the widest part of the hips</label>
        <input type="text" id="membermeasurementBoxersHip" name="membermeasurementBoxersHip" value="<?=$memberMeasurement->measurementBoxersHip; ?>" placeholder="Hip" /><br/>
        
        <label>Inside Leg - Measure from crotch to length required</label>
        <input type="text" id="membermeasurementBoxersInsideLeg" name="membermeasurementBoxersInsideLeg" value="<?=$memberMeasurement->measurementBoxersInsideLeg; ?>" placeholder="Inside Leg" /><br/>
    </fieldset>
    <?php //} ?>
    
    <fieldset>
        <legend>Special Details</legend>
	<textarea id="measurementSpecialDetails" name="measurementSpecialDetails" style="height:100px;"><?=stripcslashes($memberMeasurement->measurementSpecialDetails); ?></textarea>
    </fieldset>
    
    <input type="hidden" id="measurementId" name="measurementId" value="<?=$memberMeasurement->measurementId; ?>" />
    <input type="hidden" id="memberId" name="memberId" value="<?=$_GET['usId'];?>" />
    <input type="hidden" id="submitmeasurement" name="submitmeasurement" value="true" />
    <center>
    <button type="submit" class="btn btn-primary" style="cursor:pointer;">Save</button>
    </center>
</form>

                </div>	<!-- n gadgetblock -->
        </div>	<!-- n gadget -->
</div>	<!-- n leftblock vertsortabl -->
<br/>