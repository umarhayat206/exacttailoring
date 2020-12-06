<?php

//Display a filtered list of products

function showProductList($catId,$localRoot){
	global $siteLocalRoot;
	$products = tsProductTypes::ptGetList($catId);
	$cat = tsProductCategory::productCategoryGetOne($catId);

	if($cat->pcDescription!=""){
		//echo("<div id='description'><img src='".$siteLocalRoot.$cat->pcImage."' alt='Category Image' id='innerPic' />".$cat->pcDescription."</div>");
		echo("<div id='description'>".$cat->pcDescription."</div>");
	}
	if(count($products)>0){
		echo("<ul id='productList'>");
		foreach($products as $product){
			echo("<li><a href='".$localRoot."purchase/".$product->ptId."/".smFunctions::makeSef($product->ptName)."' title='".$product->ptName."'>");
				smImages::showThumb($localRoot.$product->ptImagePath,$product->ptName,170);
				echo("<strong>".$product->ptName."</strong><br />");
				echo("&pound; ".$product->ptPrice);
			echo("</a></li>");
		}
		echo("</ul>");
	}else{
		//echo("<h3>Please select a category to the left</h3>");
		if(count($_GET)==1){
			//$_SESSION['affilate']="affilate";
			//echo("<p class='spacialoffer'>Made to your Exact Measurements Special Offer 1/2 Price</p>");
		}
		//echo $_SESSION['affilate']."-*-";
	}
	
}
function showItemPurchased($itemId,$localRoot,$auth){
	//Need to show login if not already
	echo("<div id='productOrder'>");
	if($auth=='false'){
		echo("<p>To complete your order, please log in on the left, or register below.</p>");
		
		include($siteRoot."forms/member_signup_form.php");
	}else{ //member is logged in, take measurements
		$item = tsProductTypes::productTypeGetOne($itemId);
		$measurements = tsProductMeasurements::pmGetCollection($item->pcPmgId);
		echo("
			<img class='productLargeImage' src='".$localRoot.$item->ptImagePath."' alt='".$item->pmName."' title='".$item->pmName."'/>
			<strong>".$item->ptName."</strong> &pound;".$item->ptPrice."<br />
			<h3>Please enter your measurements</h3>
			<form id='formMeasurements' method='post' action='".$_SERVER['PHP_SELF']."'> 
			<fieldset>
			");
		
			// Edit for ties option 6/12/2012
			if($_GET['purchase']!=68){ // local 72
			?>
			<fieldset>
				<legend>Metric</legend>	
				<?php smControls::smRadioButton("Centimeters <span class='smallText'>(Decimal)</span>","smMetric","smDecimal","0",$selectedSM->smMetric==0?"Checked":"");?><br />
				<?php smControls::smRadioButton("Inches <span class='smallText'>(Imperial)</span>","smMetric","smImperial","1",$selectedSM->smMetric==1?"Checked":"");?><br />
			</fieldset>
		<?php
			}
			
			//Display measurement group image
			$measGroup = tsProductMeasurmentGroup::pmgGetOne($item->pcPmgId);
			$groupImage = $localRoot.$measGroup->pmgImage;
			if($measGroup->pmgImage!=""){
				echo("<img src='".$groupImage."' title='Measurement group image' alt='Measurement group image' /><br/>");
			}
		?>
		<?php
		foreach($measurements as $m){
			if(trim($m->pmImage)!=""){
			//	echo("<img src='".$localRoot.$m->pmImage."' title='".$m->pmName."' alt='Image showing ".$m->pmName."' />");
				smImages::showThumb($localRoot.$m->pmImage,$m->pmName,180);
			}
			if(!$m->pmCheckbox){
				if($m->pmName=="Additional Comments"){
					smControls::smTextArea($m->pmName,str_replace(" ","-",$m->pmName));
				}else{
					smControls::smTextBox($m->pmName,str_replace(" ","-",$m->pmName));
				}
				
			}else{
				smControls::smCheckBox($m->pmName,str_replace(" ","-",$m->pmName),"yes");
			}
			echo("<br />");			
		}
		smControls::smHiddenText("ptId",$itemId);
		smControls::smButton("Order now","measurementsSubmitted");
		echo("</fieldset></form>");
	}
	echo("</div>");
}

function showConfirmation($postVars,$localRoot,$auth){
	echo("<h3>Confirm your order</h3>");
	//print_r($postVars);

	echo("<form id='formConfirmOrder' method='post' action='".$_SERVER['PHP_SELF']."'>");
	$measurements = "";
	foreach($postVars as $key=>$value){
		if($key=="ptId"){	
			$ptId = $value;
		}elseif($key=="smMetric"){
			if($value=='0'){
				$metric = "cm";
			}else{
				$metric = "inches";
			}
		}elseif($key!="measurementsSubmitted"){	
			if($value!="yes"){
				if($key=="Additional-Comments" || $key=="Age" || $key=="Height" || $key=="Weight-(Kilos)"){	// clear cm
					$m="";
				}else{
					$m = $metric;
				}
				$measurements.= $key.": ".$value." ".$m."<br />";
			}else{
				// edit 07-03-2012
				//echo $_REQUEST['ptId']."-*-";
				if($_REQUEST['ptId']==21 || $_REQUEST['ptId']==22){ 	// localhost + online is 21 and 22 
					$countitem++;	// for boxer & jacket
				}else{
					$countitem=1;
				}
				
				$measurements.= $key.": ".$value."<br />";
			}
		}
	}
	$product = tsProductTypes::productTypeGetOne($ptId);
	smImages::showThumb($localRoot.$product->ptImagePath,$product->ptName,170);
	echo("<br /><strong>".$product->ptName."</strong><br />");
	//echo("&pound; ".$product->ptPrice."<br />");
	echo($measurements);
	smControls::smHiddenText("poMeasurements",$measurements);
	smControls::smHiddenText("poOrderPrice",$product->ptPrice);
	smControls::smHiddenText("poPtId",$ptId);
	?>
	<script type="text/javascript">
	//<![CDATA[
	$(document).ready(function(){
		function roundVal(val){
			var dec = 2;
			var result = Math.round(val*Math.pow(10,dec))/Math.pow(10,dec);
			return result;
		}
		$("#sciQuantity").change(function(){
			myVal = $("#sciQuantity").val() * <?php echo($product->ptPrice);?>;
			$("#totalPrice").val(roundVal(myVal));
		})
	})
	//]]>
	</script>
	<?php smControls::smTextBox("Quantity required","sciQuantity",$countitem,"class='numeric'");?><br />
	<?php smControls::smTextBox("Total price (&pound;):","totalPrice",$product->ptPrice*$countitem,"readonly='readonly' class='numeric'");?><br />
	<label id="lblConfirm">Confirm order and</label>
	<?php smControls::smButton("Checkout","smCheckout");?>
	<?php smControls::smButton("Continue","smContinue");?>	
	<?php
	echo("</form>");	
}
?>
<?php 
if($_REQUEST['purchase']!=""){ // show products in category
	showItemPurchased($_REQUEST['purchase'],$siteLocalRoot,$_SESSION['auth']);
}elseif($_POST['measurementsSubmitted']=="Order now"){ // confirm and add to cart
	showConfirmation($_POST,$siteLocalRoot,$_SESSION['auth']);
}else{ 
	showProductList($_GET['product'],$siteLocalRoot);
}
?>