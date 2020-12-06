<?php
include_once('includes/globals.php');

if (empty($_SESSION['chkmemberuser'])) { // member not login 
	echo "<script language='javascript' type='text/javascript'>
            alert('You are not login. Please login to your account.');
            window.close();
        </script>";
}

$listOrder = smOrder::GetIndividual($_GET['orderId']);
$memberDetails = smUser::GetIndividual($listOrder->shopUserId);

$Y = substr($listOrder->shopDateadded, 0, 4);
$M = substr($listOrder->shopDateadded, 5, 2);
$MM = smSetting::changeMonth($M);
$D = substr($listOrder->shopDateadded, 8, 2);

if (!empty($memberDetails->usCountry)) {
	$mcountry = smSetting::getCountry($memberDetails->usCountry);
	$shocountry = $mcountry->countryName;
}

if ($memberDetails->usGender == 1) {
	$gender = "Male";
} else if ($memberDetails->usGender == 2) {
	$gender = "Female";
} else {
	$gender = "";
}

?>

<div style="width:620px; margin:0 auto;">
	<p>
		<b>Exact Personal Tailoring Services Limited</b><br />
		<?php /* P O Box 3370, Stratford on Avon CV37 7XR.<br/>
	<span style="font-size:21px;">Please telephone <b>01789 205612</b> if you wish to amend any details</span> */ ?>
	</p>
	<p>------------------------------------------------------------------------------------------------------</p>
	<p>
		<span>Order No: <?php echo $_GET['orderId']; ?> - <?php echo $memberDetails->usFirstname . " " . $memberDetails->usLastname . " ($gender)"; ?></span>
		<span style="margin-left:30px;">Order Date: <?php echo $D . " " . $MM . " " . $Y; ?></span><br />
		<span><?php echo $memberDetails->usAddress . " " . $memberDetails->usPostcode . " " . $shocountry; ?></span><br />
		<label>Tel: <span style="color:#FF0000;"><?php echo $memberDetails->usTelephone; ?></span></label>
		<label style="margin-left:30px;">Mobile Phone: <span style="color:#FF0000;"><?php echo $memberDetails->usMobile; ?></span></label>
		<label style="margin-left:30px;">Email: <span style="color:#FF0000;"><?php echo $memberDetails->usEmail; ?></span></label>
	</p>

	<p>--------------------------------------- Start Of Personalisation --------------------------------------</p>
	<?php
	$listItems = smOrder::GetAllItems($listOrder->shopId);

	foreach ($listItems as $item) {
		$productitem = smProduct::GetIndividual($item->productId);
		$categoryname = smCategory::getCategory($productitem->productCategoryId);
		$designmenu = smFeature::getIndexFeatures($productitem->productCategoryId);

		if ($productitem->productCategoryId == 8) {
			$forLadies = "<span style='color:#B88AB4;' class='right'>(for LADIES)</span>";
		} else {
			$forLadies = "";
		}

		if (empty($item->itemOnPromotion) || $item->itemOnPromotion == 0) {

			echo "<span>" . $productitem->productRefCode . ":: " . $productitem->productTitle . " $forLadies :: Quantity " . $item->itemQty . "</span><br/>";

			if ($item->itemmeasurementMetric == 1) {
				$MeasurementMetric = "cm";
			} else {
				$MeasurementMetric = "inc";
			}

			echo "<div style='width:49%; float:left;'>";

			if (!empty($designmenu)) { // no option for design
				$itemDetails = str_replace("p>", "span>", $item->itemDetails);
				$itemDetails = str_replace("</span>", "</span><br/>", $itemDetails);

				echo "<p><b>" . strtoupper($categoryname->categoryName) . " DESIGN</b></p>
			" . $itemDetails;
			}

			if (!empty($item->itemInitials)) {
				echo "<span>Initials - " . stripcslashes($item->itemInitials) . "</span>";
			}

			echo "</div><div style='width:49%; float:right;'>";

			$rootname = smCategory::getCategory($categoryname->categoryRootId);
			if ($rootname->categoryName !== "Accessories") {

				if ($item->productId != "470") {

					if ($item->itemMeasurementType == 1) {  // Shirt

						if ($item->itemmeasurementType2 == "SHIRT") {
							$MeasurementType = "SIZE TAKEN FROM SHIRT";
						} else {
							$MeasurementType = "BODY MEASUREMENT";
						}

						echo "<p><b>$MeasurementType</b></p>";

						echo "<span>Neck - {$item->itemmeasurementShirtNeck} $MeasurementMetric</span><br/>
			    <span>Chest - {$item->itemmeasurementShirtChest} $MeasurementMetric</span><br/>
			    <span>Stomach - {$item->itemmeasurementShirtStomach} $MeasurementMetric</span><br/>
			    <span>Hips - {$item->itemmeasurementShirtHips} $MeasurementMetric</span><br/>
			    <span>Length - {$item->itemmeasurementShirtLenght} $MeasurementMetric</span><br/>
			    <span>Sleeve length - {$item->itemmeasurementShirtSleeveLength} $MeasurementMetric</span><br/>
			    <span>Short sleeve - {$item->itemmeasurementShirtShortSleeve} $MeasurementMetric</span><br/>
			    <span>Cuff - {$item->itemmeasurementShirtCuff} $MeasurementMetric</span><br/>
			    <span>Upper arm - {$item->itemmeasurementShirtUpperarm} $MeasurementMetric</span><br/>
			    <span>Shoulder - {$item->itemmeasurementShirtShoulder} $MeasurementMetric</span><br/>";
					} else if ($item->itemMeasurementType == 2) {    // Trousers
						echo "<p><b>MEASUREMENT</b></p>";

						echo "<span>(A) Outside Leg - Along Side Seam - {$item->itemmeasurementTrousersA} $MeasurementMetric</span><br/>
			    <span>(B) Inside Leg - Along Inside Seam - {$item->itemmeasurementTrousersB} $MeasurementMetric</span><br/>
			    <span>(C) Thigh - 3\" below top of inside Leg - {$item->itemmeasurementTrousersC} $MeasurementMetric</span><br/>
			    <span>(D) Width Of Knee - {$item->itemmeasurementTrousersD} $MeasurementMetric</span><br/>
			    <span>(E) Width of Bottom - {$item->itemmeasurementTrousersE} $MeasurementMetric</span><br/>
			    <span>(F) Waist - At waistband Level - {$item->itemmeasurementTrousersF} $MeasurementMetric</span><br/>
			    <span>(G) Seat - At fullest part of hips- {$item->itemmeasurementTrousersG} $MeasurementMetric</span><br/>";
					} else if ($item->itemMeasurementType == 3) {    // Boxers
						echo "<p><b>MEASUREMENT</b></p>";

						echo "<span>Waist - {$item->itemmeasurementBoxersWaist} $MeasurementMetric</span><br/>
			    <span>Top of Leg - {$item->itemmeasurementBoxersTopofLeg} $MeasurementMetric</span><br/>
			    <span>Length - {$item->itemmeasurementBoxersLength} $MeasurementMetric</span><br/>
			    <span>Hip - {$item->itemmeasurementBoxersHip} $MeasurementMetric</span><br/>
			    <span>Inside Leg - {$item->itemmeasurementBoxersInsideLeg} $MeasurementMetric</span><br/>";
					}


					echo "<br/>Special Details - " . stripcslashes($item->itemSpecialDetails);
				} // if ! 470

			}
			echo "</div><br style='clear:both;'/><br style='clear:both;'/><hr/>";
		} else {

			if ($productitem->productId == "470") {
				echo "<p>" . $productitem->productRefCode . ":: " . $productitem->productTitle . " $forLadies :: Quantity " . $item->itemQty . "<span style='color:#FF0000;'>(this item get FREE)</span></p><hr/>";
			} else {
				echo "<p>" . $productitem->productRefCode . ":: " . $productitem->productTitle . " $forLadies :: Quantity " . $item->itemQty . "<span style='color:#FF0000;'>(this item get FREE - Design same main shirt)</span></p><hr/>";
			}
		} // n check not free item
	}

	?>

</div>