<?php

//Check to see if member has a cart with any items in it that is not completed or in progress (status Open).
//The form should display the carts delivery address, plus items, values and totals.
//print_r($_SESSION);
?>
<form id="shoppingCartForm" method="post" action="<?php echo($_SERVER['PHP_SELF']); ?>">
	<fieldset>
		<legend>Confirm order</legend>
		<div class="columnLeft">
			<h5>Shirt design</h5>
			<?php $sd = $_SESSION['shirtDesign']; ?>
			<?php tsShirtDesign::sdPutDesignDetails($sd); ?>
			<?php include($siteRoot."panels/selected_fabric.php"); ?>
		</div>
		<div class="columnRight">
		<?php
		if(isset($_SESSION['bodyMeasurement'])){
			$mesType = "Body/Shirt";
			$m = $_SESSION['bodyMeasurement'];
		}else if(isset($_SESSION['shirtMeasurement'])){
			$mesType = "Bio";
			$m = $_SESSION['shirtMeasurement'];
		}else if(isset($_SESSION['bmId'])){
			$mesType = "Body/Shirt";
			$m = tsBodyMeasurements::bmGetOne($_SESSION['bmId'],$_SESSION['auth']->mId);
		}else if(isset($_SESSION['smId'])){
			$mesType = "Bio";
			$m = tsShirtMeasurements::smGetOne($_SESSION['smId'],$_SESSION['auth']->mId);
		}else{
			//Aww shit... How'd that happen?
		}
		?>
			<h5><?php echo($mesType);?> Measurements</h5>
			<ul>
			<?php
			//print_r($_SESSION);
				if($mesType=="Body/Shirt"){//BODY MEASUREMENTS
					tsShirtDesign::sdPut("Profile name: ".$m->bmProfileName);
					if($m->bmMetric==0){
						$metric = " cm";
					}else{
						$metric = " inches";
					}
					tsShirtDesign::sdPut("Measurements take from: ".$m->bmType);
					tsShirtDesign::sdPut("Neck: ".$m->bmNeck.$metric);
					tsShirtDesign::sdPut("Chest: ".$m->bmChest.$metric);
					tsShirtDesign::sdPut("Waist: ".$m->bmWaist.$metric);
					tsShirtDesign::sdPut("Seat: ".$m->bmSeat.$metric);
					tsShirtDesign::sdPut("Back: ".$m->bmBack.$metric);
					tsShirtDesign::sdPut("Arm: ".$m->bmArm.$metric);
					tsShirtDesign::sdPut("Short sleeve: ".$m->bmArmShort.$metric);
					tsShirtDesign::sdPut("Cuff: ".$m->bmCuff.$metric);
					tsShirtDesign::sdPut("Bicep: ".$m->bmBicep.$metric);
					tsShirtDesign::sdPut("Shoulder: ".$m->bmShoulder.$metric);
					tsShirtDesign::sdPut("Special Details: ".$m->bmSpecial);
					
					if($m->bmType=="Body"){
						tsShirtDesign::sdPut("Fit: ".$m->bmFit);
					}
					
					if($m->bmSoftCollar=="Yes"){
						tsShirtDesign::sdPut("Soft Collar: ".$m->bmSoftCollar);
					}
					/*
					tsShirtDesign::sdPut("Length: ".$m->bmLength.$metric);
					tsShirtDesign::sdPut("Height: ".$m->bmHeight.$metric);
					tsShirtDesign::sdPut("Weight: ".$m->bmWeight.$metric);
					*/
				}else{//SHIRT MEASUREMENTS
					tsShirtDesign::sdPut("Profile name: ".$m->smProfileName);
					if($m->smMetric==0){
						$metric = " cm";
					}else{
						$metric = " inches";
					}
					tsShirtDesign::sdPut("Collar: ".$m->smCollar.$metric);
					tsShirtDesign::sdPut("Chest: ".$m->smChest.$metric);
					tsShirtDesign::sdPut("Age: ".$m->smAge);
					tsShirtDesign::sdPut("Height: ".$m->smHeight);
					tsShirtDesign::sdPut("Weight: ".$m->smWeight);
					tsShirtDesign::sdPut("Comments: ".$m->smComments);
				}
			?>
			</ul>
			<br /><br />
			
			<script type="text/javascript">
				//<![CDATA[
				$(document).ready(function(){
					function roundVal(val){
						var dec = 2;
						var result = Math.round(val*Math.pow(10,dec))/Math.pow(10,dec);
						return result;
					}
					$("#sciQuantity").change(function(){
						myVal = $("#sciQuantity").val() * <?php echo($selectedFabric[0]->fPricePerShirt);?>;
						$("#totalPrice").val(roundVal(myVal));
					})
				})
				//]]>
			</script>
			
			<?php smControls::smCheckBox("Pack of two silky ties to complement your shirt just &pound;5 (originally sold at up to &pound;19.99 each)","sciSpecial2","1",""); ?><br />
			<?php smControls::smTextBox("Quantity required","sciQuantity","1","class='numeric'"); ?><br />
			<?php smControls::smTextBox("Total price (&pound;):","totalPrice",$selectedFabric[0]->fPricePerShirt,"readonly='readonly' class='numeric'");?><br />
			
			<label id="lblConfirm">Confirm order and</label>
			<?php smControls::smButton("Checkout","smCheckout"); ?>
			<?php smControls::smButton("Continue","smContinue"); ?>
		</div><br />
	</fieldset>
</form>