<form id="editmembermeasurement" class="" method="post" action="<?=_URL_;?>my-account" enctype="multipart/form-data">
    <?php
    if($memberMeasurement->measurementMetric==1){
        $chkmatric1=" checked='checked' ";
    }else{
        $chkmatric2=" checked='checked' ";
    }
    ?>
      <div class="row">
        <div class="col-lg-6 col-md-6">
        <h1 id="account-h1" class="text-center">Metric</h1>
        <label class="radio">
            <input type="radio" name="membermeasurementMetric" id="metric1" value="1" <?php echo $chkmatric1; ?> />
           Centimeters (Decimal)
        </label>
        
        
        <label class="radio">
            <input type="radio" name="membermeasurementMetric" id="metric2" value="0" <?php echo $chkmatric2; ?> />
            Inches (Imperial)
        </label>
        </div>
    
    
    
    
    <?php
    if($memberMeasurement->measurementType=="SHIRT"){
        $checktype21 = " checked='checked' ";
    }else{
        $checktype22 = " checked='checked' ";
    }
    ?>
      <div class="col-lg-6 col-md-6">
        <h1 id="account-h1" class="text-center">Measurement Type</h1>
        <label class="radio">
            <input type="radio" name="membermeasurementType" id="type21" value="SHIRT" <?=$checktype21;?> />
            Taken from SHIRT
        </label>
        <label class="radio">
            <input type="radio" name="membermeasurementType" id="type22" value="BODY" <?=$checktype22;?> />
            Taken from BODY
        </label>
       </div>
    </div><br/>
    <div class="row">
    <div class="col-lg-6 col-md-6">
    <fieldset>
        <h1 id="account-h1" class="text-center">Shirt / Jacket Measurement</h1>
        
        <p class="textblue">* Measurement taken from BODY (Standard - Average fit 4" will be added to the chest, stomach and hip measurements above.)</p>
        
        <label>Neck (Measure Length required from button to centre of button hole)</label>
        <input type="text" id="membermeasurementShirtNeck" name="membermeasurementShirtNeck" value="<?=$memberMeasurement->measurementShirtNeck; ?>" placeholder="Neck" class="account-input form-control" /><br/>
        
        <label>Chest (Measure around body well up under arm holes)</label>
        <input type="text" id="membermeasurementShirtChest" name="membermeasurementShirtChest" value="<?=$memberMeasurement->measurementShirtChest; ?>" placeholder="Chest"class="account-input form-control" /><br/>
        
        <label>Stomach (Measure around stomach line)</label>
        <input type="text" id="membermeasurementShirtStomach" name="membermeasurementShirtStomach" value="<?=$memberMeasurement->measurementShirtStomach; ?>" placeholder="Stomach" class="account-input form-control"/><br/>
        
        <label>Hips (Measure around hips at widest point of seat but not tight.)</label>
        <input type="text" id="membermeasurementShirtHips" name="membermeasurementShirtHips" value="<?=$memberMeasurement->measurementShirtHips; ?>" placeholder="Hips" class="account-input form-control" /><br/>
        
        <label>Length (Measure from small bone at back of neck to length required)</label>
        <input type="text" id="membermeasurementShirtLenght" name="membermeasurementShirtLenght" value="<?=$memberMeasurement->measurementShirtLenght; ?>" placeholder="Lenght" class="account-input form-control"/><br/>
        
        <label>Sleeve length (Measure from shoulder to length desired - around elbow for long sleeve)</label>
        <input type="text" id="membermeasurementShirtSleeveLength" name="membermeasurementShirtSleeveLength" value="<?=$memberMeasurement->measurementShirtSleeveLength; ?>" placeholder="Sleeve length" class="account-input form-control"/><br/>
        
        <label>Short sleeve (Measure from shoulder to length required)</label>
        <input type="text" id="membermeasurementShirtShortSleeve" name="membermeasurementShirtShortSleeve" value="<?=$memberMeasurement->measurementShirtShortSleeve; ?>" placeholder="Short sleeve" class="account-input form-control"  /><br/>
        
        <label>Cuff (Measure length required from button to centre button hole)</label>
        <input type="text" id="membermeasurementShirtCuff" name="membermeasurementShirtCuff" value="<?=$memberMeasurement->measurementShirtCuff; ?>" placeholder="Cuff" class="account-input form-control" /><br/>
        
        <label>Upper arm (Measure around upper arm)</label>
        <input type="text" id="membermeasurementShirtUpperarm" name="membermeasurementShirtUpperarm" value="<?=$memberMeasurement->measurementShirtUpperarm; ?>" placeholder="Upper arm"  class="account-input form-control"/><br/>
        
        <label>Shoulder (Measure back at end of shoulder)</label>
        <input type="text" id="membermeasurementShirtShoulder" name="membermeasurementShirtShoulder" value="<?=$memberMeasurement->measurementShirtShoulder; ?>" placeholder="Shoulder" class="account-input form-control"/><br/>
    </fieldset>
    </div>
     <div class="col-lg-6 col-md-6">
    <fieldset>
        <h1 id="account-h1" class="text-center">Trousers Measurement</h1>
        <label>(A) Outside Leg - Along Side Seam</label>
        <input type="text" id="membermeasurementTrousersA" name="membermeasurementTrousersA" value="<?=$memberMeasurement->measurementTrousersA; ?>" placeholder="Outside Leg" class="account-input form-control" /><br/>
        
        <label>(B) Inside Leg - Along Inside Seam</label>
        <input type="text" id="membermeasurementTrousersB" name="membermeasurementTrousersB" value="<?=$memberMeasurement->measurementTrousersB; ?>" placeholder="Inside Leg" class="account-input form-control"/><br/>
        
        <label>(C) Thigh - 3” below top of inside Leg</label>
        <input type="text" id="membermeasurementTrousersC" name="membermeasurementTrousersC" value="<?=$memberMeasurement->measurementTrousersC; ?>" placeholder="Thigh" class="account-input form-control" /><br/>
        
        <label>(D) Width Of Knee</label>
        <input type="text" id="membermeasurementTrousersD" name="membermeasurementTrousersD" value="<?=$memberMeasurement->measurementTrousersD; ?>" placeholder="Width Of Knee" 
        class="account-input form-control"/><br/>
        
        <label>(E) Width of Bottom</label>
        <input type="text" id="membermeasurementTrousersE" name="membermeasurementTrousersE" value="<?=$memberMeasurement->measurementTrousersE; ?>" placeholder="Width of Bottom"
        class="account-input form-control" /><br/>
        
        <label>(F) Waist - At waistband Level</label>
        <input type="text" id="membermeasurementTrousersF" name="membermeasurementTrousersF" value="<?=$memberMeasurement->measurementTrousersF; ?>" placeholder="Waist Measurements"class="account-input form-control" /><br/>
        
        <label>(G) Seat - At fullest part of hips</label>
        <input type="text" id="membermeasurementTrousersG" name="membermeasurementTrousersG" value="<?=$memberMeasurement->measurementTrousersG; ?>" placeholder="Seat Measurements" class="account-input form-control" /><br/>
    </fieldset>
    </div>
    </div><br>
    <?php //if($_SESSION['memberDetails']->usGender == 1){ ?>
    <div class="row"> 
    <div class="col-lg-6 col-md-6">   
    <fieldset>
        <h1 id="account-h1" class="text-center">Boxers Measurement</h1><br>
        <label>Waist - Measure around waist or enter known waist size</label>
        <input type="text" id="membermeasurementBoxersWaist" name="membermeasurementBoxersWaist" value="<?=$memberMeasurement->measurementBoxersWaist; ?>" placeholder="Waist" class="account-input form-control" /><br/>
        
        <label>Top of Leg - Measure around the thickest part of the leg</label>
        <input type="text" id="membermeasurementBoxersTopofLeg" name="membermeasurementBoxersTopofLeg" value="<?=$memberMeasurement->measurementBoxersTopofLeg; ?>" placeholder="Top of Leg" class="account-input form-control"/><br/>
        
        <label>Length - Measure from waist to length required</label>
        <input type="text" id="membermeasurementBoxersLength" name="membermeasurementBoxersLength" value="<?=$memberMeasurement->measurementBoxersLength; ?>" placeholder="Length" class="account-input form-control" /><br/>
        
        <label>Hip - Measure around the widest part of the hips</label>
        <input type="text" id="membermeasurementBoxersHip" name="membermeasurementBoxersHip" value="<?=$memberMeasurement->measurementBoxersHip; ?>" placeholder="Hip" class="account-input form-control" /><br/>
        
        <label>Inside Leg - Measure from crotch to length required</label>
        <input type="text" id="membermeasurementBoxersInsideLeg" name="membermeasurementBoxersInsideLeg" value="<?=$memberMeasurement->measurementBoxersInsideLeg; ?>" placeholder="Inside Leg" class="account-input form-control" /><br/>
    </fieldset>
     </div>
    <?php //} ?>
    <div class="col-lg-6 col-md-6">
    <fieldset>
        <h1 id="account-h1" class="text-center">Special Details</h1><br><br>
	<textarea id="measurementSpecialDetails" class="account-input form-control" name="measurementSpecialDetails" style="height:100px;"><?=stripcslashes($memberMeasurement->measurementSpecialDetails); ?></textarea>
    </fieldset>
     </div>
    </div>
    <br style="clear:both;"/>
    <input type="hidden" id="measurementId" name="measurementId" value="<?=$memberMeasurement->measurementId?>" />
    <input type="hidden" id="submitmeasurement" name="submitmeasurement" value="true" />
    <br/>
    <center>
        <button type="submit" class="btn btn-default-shop">Save</button>
    </center>
</form>