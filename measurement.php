
<?php
@session_start();
include_once('includes/globals.php');
include_once('includes/html_head.php');
include_once("forms/form_head.php");



function checkPrevPrice($price, $fabObj)
{
    $prevPrice = "";

    if ($fabObj->isShowPrevPrice == 1) {
        $percentage = $fabObj->PrevPricePercentage;
        $n = $price + (($price * $percentage) / 100);
        $prevPrice = ' <span style="text-decoration:line-through;color:#f00;padding:0;font-size:.9em;font-style: italic;" >' . number_format($n, 2) . '</span> ';
    }
    return $prevPrice;
}

/*
if(empty($_SESSION['chkmemberuser'])){ // member not login 
    echo "<script language='javascript' type='text/javascript'>
            alert('You are not login. Please login to your account.');
            history.go(-1);
        </script>";

}else{
*/
if ($_POST['hiddenconfirmitem']) { // submit confirm item

    $updateItemDesign = "UPDATE ex_shoppingcart_items set ";
    $updateItemDesign .= "itemmeasurementMetric='" . $_POST['itemmeasurementMetric'] . "', ";

    if ($_POST['itemmeasurementType2'] == "SHIRT") {
        $selectitemdetails = "select * from ex_item_details_index where itemId='{$_POST['hiddenitemid']}' ";
        $queryselectitemdetails = mysql_query($selectitemdetails);

        while ($rowselectitemdetails = mysql_fetch_array($queryselectitemdetails)) {
            $optionKeyName = smFeature::getFeatures($rowselectitemdetails['optionId']);
            $optionValueName = smFeature::getFeatures($rowselectitemdetails['optionValue']);
            if ($optionKeyName->featuresName != "Fit") {
                $shirtsDesignDetails .= "<p>{$optionKeyName->featuresName}: {$optionValueName->featuresName}</p>";
            }
        }
        $shirtsDesignDetails .= "<p>" . $_POST['itemFabric'] . "</p>";
        $shirtsDesignDetails .= "<p>" . $_POST['itemPattern'] . "</p>";
        $shirtsDesignDetails .= "<p>" . $_POST['itemColour'] . "</p>";

        $sqlUpdateOrderItems = "UPDATE ex_shoppingcart_items set ";
        $sqlUpdateOrderItems .= "itemDetails='" . mysql_real_escape_string($shirtsDesignDetails) . "' ";
        $sqlUpdateOrderItems .= "WHERE itemId = '{$_POST['hiddenitemid']}' ";
        mysql_query($sqlUpdateOrderItems);
        //echo $sqlUpdateOrderItems."";
    }

    if ($_POST['itemMeasurementType'] == 1) {
        $updateItemDesign .= "itemMeasurementType='1', ";
        $updateItemDesign .= "itemmeasurementShirtNeck='" . $_POST['membermeasurementShirtNeck'] . "', ";
        $updateItemDesign .= "itemmeasurementShirtChest='" . $_POST['membermeasurementShirtChest'] . "', ";
        $updateItemDesign .= "itemmeasurementShirtStomach='" . $_POST['membermeasurementShirtStomach'] . "', ";
        $updateItemDesign .= "itemmeasurementShirtHips='" . $_POST['membermeasurementShirtHips'] . "', ";
        $updateItemDesign .= "itemmeasurementShirtLenght='" . $_POST['membermeasurementShirtLenght'] . "', ";
        $updateItemDesign .= "itemmeasurementShirtSleeveLength='" . $_POST['membermeasurementShirtSleeveLength'] . "', ";
        $updateItemDesign .= "itemmeasurementShirtShortSleeve='" . $_POST['membermeasurementShirtShortSleeve'] . "', ";
        $updateItemDesign .= "itemmeasurementShirtCuff='" . $_POST['membermeasurementShirtCuff'] . "', ";
        $updateItemDesign .= "itemmeasurementShirtUpperarm='" . $_POST['membermeasurementShirtUpperarm'] . "', ";
        $updateItemDesign .= "itemmeasurementShirtShoulder='" . $_POST['membermeasurementShirtShoulder'] . "', ";
    } else if ($_POST['itemMeasurementType'] == 2) {
        $updateItemDesign .= "itemMeasurementType='2', ";
        $updateItemDesign .= "itemmeasurementTrousersA='" . $_POST['membermeasurementTrousersA'] . "', ";
        $updateItemDesign .= "itemmeasurementTrousersB='" . $_POST['membermeasurementTrousersB'] . "', ";
        $updateItemDesign .= "itemmeasurementTrousersC='" . $_POST['membermeasurementTrousersC'] . "', ";
        $updateItemDesign .= "itemmeasurementTrousersD='" . $_POST['membermeasurementTrousersD'] . "', ";
        $updateItemDesign .= "itemmeasurementTrousersE='" . $_POST['membermeasurementTrousersE'] . "', ";
        $updateItemDesign .= "itemmeasurementTrousersF='" . $_POST['membermeasurementTrousersF'] . "', ";
        $updateItemDesign .= "itemmeasurementTrousersG='" . $_POST['membermeasurementTrousersG'] . "', ";
    } else if ($_POST['itemMeasurementType'] == 3) {
        $updateItemDesign .= "itemMeasurementType='3', ";
        $updateItemDesign .= "itemmeasurementBoxersWaist='" . $_POST['membermeasurementBoxersWaist'] . "', ";
        $updateItemDesign .= "itemmeasurementBoxersTopofLeg='" . $_POST['membermeasurementBoxersTopofLeg'] . "', ";
        $updateItemDesign .= "itemmeasurementBoxersLength='" . $_POST['membermeasurementBoxersLength'] . "', ";
        $updateItemDesign .= "itemmeasurementBoxersHip='" . $_POST['membermeasurementBoxersHip'] . "', ";
        $updateItemDesign .= "itemmeasurementBoxersInsideLeg='" . $_POST['membermeasurementBoxersInsideLeg'] . "', ";
    }

    $updateItemDesign .= "itemMeasurementType2='" . $_POST['itemmeasurementType2'] . "', ";
    $updateItemDesign .= "itemSpecialDetails='" . mysql_real_escape_string($_POST['itemSpecialDetails']) . "', ";
    $updateItemDesign .= "itemInitials='" . $_POST['itemInitials'] . "', ";
    $updateItemDesign .= "itemComplete='1' ";
    $updateItemDesign .= "WHERE itemId = '" . $_POST['hiddenitemid'] . "' ";
    mysql_query($updateItemDesign);
    //echo $updateItemDesign;

    $updateFreeItem = "UPDATE ex_shoppingcart_items set ";
    $updateFreeItem .= "itemComplete='1' ";
    $updateFreeItem .= "WHERE itemOnPromotion = '" . $_REQUEST['hiddenproductid'] . "' AND shopId='" . $_SESSION['currentOrder'] . "' ";
    mysql_query($updateFreeItem);
    //echo $updateFreeItem;


    $measurementId = smMeasurement::GetIndividual($_SESSION['chkmemberuser']);

    $UPDATEMEASUREMENT = new smMeasurement;
    $UPDATEMEASUREMENT->usId = $_SESSION['chkmemberuser'];
    $UPDATEMEASUREMENT->measurementId = $measurementId->measurementId;
    $UPDATEMEASUREMENT->measurementMetric = $_POST['itemmeasurementMetric'];
    $UPDATEMEASUREMENT->measurementType = $_POST['itemmeasurementType2'];
    $UPDATEMEASUREMENT->measurementShirtNeck = str_replace(",", "", $_POST['membermeasurementShirtNeck']);
    $UPDATEMEASUREMENT->measurementShirtChest = str_replace(",", "", $_POST['membermeasurementShirtChest']);
    $UPDATEMEASUREMENT->measurementShirtStomach = str_replace(",", "", $_POST['membermeasurementShirtStomach']);
    $UPDATEMEASUREMENT->measurementShirtHips = str_replace(",", "", $_POST['membermeasurementShirtHips']);
    $UPDATEMEASUREMENT->measurementShirtLenght = str_replace(",", "", $_POST['membermeasurementShirtLenght']);
    $UPDATEMEASUREMENT->measurementShirtSleeveLength = str_replace(",", "", $_POST['membermeasurementShirtSleeveLength']);
    $UPDATEMEASUREMENT->measurementShirtShortSleeve = str_replace(",", "", $_POST['membermeasurementShirtShortSleeve']);
    $UPDATEMEASUREMENT->measurementShirtCuff = str_replace(",", "", $_POST['membermeasurementShirtCuff']);
    $UPDATEMEASUREMENT->measurementShirtUpperarm = str_replace(",", "", $_POST['membermeasurementShirtUpperarm']);
    $UPDATEMEASUREMENT->measurementShirtShoulder = str_replace(",", "", $_POST['membermeasurementShirtShoulder']);
    $UPDATEMEASUREMENT->measurementTrousersA = str_replace(",", "", $_POST['membermeasurementTrousersA']);
    $UPDATEMEASUREMENT->measurementTrousersB = str_replace(",", "", $_POST['membermeasurementTrousersB']);
    $UPDATEMEASUREMENT->measurementTrousersC = str_replace(",", "", $_POST['membermeasurementTrousersC']);
    $UPDATEMEASUREMENT->measurementTrousersD = str_replace(",", "", $_POST['membermeasurementTrousersD']);
    $UPDATEMEASUREMENT->measurementTrousersE = str_replace(",", "", $_POST['membermeasurementTrousersE']);
    $UPDATEMEASUREMENT->measurementTrousersF = str_replace(",", "", $_POST['membermeasurementTrousersF']);
    $UPDATEMEASUREMENT->measurementTrousersG = str_replace(",", "", $_POST['membermeasurementTrousersG']);
    $UPDATEMEASUREMENT->measurementBoxersWaist = str_replace(",", "", $_POST['membermeasurementBoxersWaist']);
    $UPDATEMEASUREMENT->measurementBoxersTopofLeg = str_replace(",", "", $_POST['membermeasurementBoxersTopofLeg']);
    $UPDATEMEASUREMENT->measurementBoxersLength = str_replace(",", "", $_POST['membermeasurementBoxersLength']);
    $UPDATEMEASUREMENT->measurementBoxersHip = str_replace(",", "", $_POST['membermeasurementBoxersHip']);
    $UPDATEMEASUREMENT->measurementBoxersInsideLeg = str_replace(",", "", $_POST['membermeasurementBoxersInsideLeg']);
    $UPDATEMEASUREMENT->measurementSpecialDetails = mysql_real_escape_string($_POST['itemSpecialDetails']);

    $checkmeasurement = smMeasurement::checkAddEdit($_SESSION['chkmemberuser']);
    if ($checkmeasurement == "update") { //echo "-2-";
        $_SESSION['measurementId'] = $UPDATEMEASUREMENT->Update($UPDATEMEASUREMENT);
    } else { //echo "-1-";
        $_SESSION['measurementId'] = $UPDATEMEASUREMENT->Add($UPDATEMEASUREMENT);
    }

    //print_r($UPDATEMEASUREMENT);

    echo ("<script>window.location='" . _URL_ . "shoppingcart';</script>");
}

//echo $_SESSION['currentOrder']."----<br/>";
//echo $_GET['item']."-".$_REQUEST['item']."-".$item."--<br/>";

$productdetails = smProduct::GetIndividual($_REQUEST['product']);
$categoryname = smCategory::getCategory($productdetails->productCategoryId);
$fabric = smFabric::getFabric($productdetails->productFabricId);
$pattern = smPattern::getPattern($productdetails->productPatternId);
$color = smColor::getColor($productdetails->productColorId);

if (!empty($color)) {
    $stylecolor = str_replace(" ", "", strtolower($color->colorTitle));
    $showcolor = "<label style='width:15px; height:13px; background:$stylecolor; float:left; margin: 4px 5px 0 0;'>&nbsp;</label> " . $color->colorTitle;
}

$itemdesign = "";
$itemdesign = smOrder::getItemDesignDetails($_GET['item']);

$memberMeasurement = smMeasurement::GetIndividual($_SESSION['chkmemberuser']);
//print_r($_SESSION['memberDetails'])."<br/>";
//print_r($memberMeasurement)."<br/>";

$rootname = smCategory::getCategory($categoryname->categoryRootId);
if ($rootname->categoryName == "Accessories") {
    $updateAccessoriesItem = "UPDATE ex_shoppingcart_items set ";
    $updateAccessoriesItem .= "itemComplete='1' ";
    $updateAccessoriesItem .= "WHERE itemId = '" . $_REQUEST['item'] . "' ";
    mysql_query($updateAccessoriesItem);

    echo "<script language='javascript' type='text/javascript'>
                    window.location='" . _URL_ . "shoppingcart'
                </script>";
}
//echo $categoryname->categoryId." - ". $categoryname->categoryRootId." - ".$rootname->categoryName;

//}

$checkProductOnPromotion = smPromotion::checkProductOnPromotion($productdetails->productId);
$promotiondetails = smPromotion::GetPromotion($checkProductOnPromotion->promotionId);

if ($promotiondetails->promotionType == 1) {  // discount
    $promotiontype = "";
    // EDIT 30/7/14
    //$price = $productdetails->productPrice - (($productdetails->productPrice * $promotiondetails->promotionDiscount) / 100);
    //$showprice = "<span><span class='strike-through'>&pound;".number_format($productdetails->productPrice,2)."</span>&pound;".number_format($price,2)."</span>";
    $price = $productdetails->productPrice;
    $showprice = checkPrevPrice($price, $fabric) . "<span>&pound;" . number_format($price, 2) . "</span>";
} else if ($promotiondetails->promotionType == 2) {    // free item
    $promotiontype = "<i class='right'><a>Buy 1 free " . $promotiondetails->promotionGetfreeItem . "</a></i>";
    $showprice = checkPrevPrice($productdetails->productPrice, $fabric) . "<span>&pound;" . number_format($productdetails->productPrice, 2) . "</span>";
} else {  // not on promotion
    $promotiontype = "";
    $showprice = checkPrevPrice($productdetails->productPrice, $fabric) . "<span>&pound;" . number_format($productdetails->productPrice, 2) . "</span>";
}

?>
<div class="container">

   <h1 class="text-center" id="contactus-h1">MEASUREMENT</h1>

<div class="row">
  
  <div class="col-lg-8">

    <form action="<?= _URL_; ?>measurement.php" method="post">

        <!-- <aside class="span4"> -->
              

        <!-- <aside class="span13"> -->
            <!-- <div class="user-comments"> -->
                <!-- <div class="titleHeader clearfix">
                    <h3><?php echo $categoryname->categoryName; ?> Measurement</h3>
                </div> -->
                <?php if ($categoryname->categoryName == "Trousers") {
                    $chkop1 = ""; // check setting measurment
                    $chkdiv1 = "display:none;";
                    $chkop2 = "checked='checked' "; // check setting measurment
                    $chkdiv2 = "display:run-in;";
                } else if ($categoryname->categoryName == "Shirts" || $categoryname->categoryName == "Dress Shirts" || $categoryname->categoryName == "Jackets") {
                    $chkop1 = "checked='checked' "; // check setting measurment
                    $chkdiv1 = "display:run-in;";
                    $chkop2 = "'"; // check setting measurment
                    $chkdiv2 = "display:none;";
                }
                ?>

                <!-- <div class="media-list hProductItems">
                    <label class="radio">
                        <input type="radio" name="itemMeasurementType" id="shirtmeasurement" value="1" <?= $chkop1; ?> />
                        Shirt / Jacket Measurement
                    </label>

                    <label class="radio">
                        <input type="radio" name="itemMeasurementType" id="trousersmeasurement" value="2" <?= $chkop2; ?> />
                        Trousers Measurement
                    </label>

                    <label class="radio">
                        <input type="radio" name="itemMeasurementType" id="boxersmeasurement" value="3" />
                        Boxers Measurement
                    </label><br />
                </div> -->

               <!--  <div class="titleHeader clearfix">
                    <h3><?php echo $categoryname->categoryName; ?> Design Details</h3>
                </div> -->
                <!-- <div class="media-list hProductItems">

                    <?php
                    
                    foreach ($itemdesign as $design) {
                        $designlabel = smFeature::getFeatures($design->optionId);
                        $designvalue = smFeature::getFeatures($design->optionValue);
                        echo "<p>{$designlabel->featuresName}: <span class='textblue'>{$designvalue->featuresName}</span></p>";
                    }

                    $sqlSpecialitem = "SELECT * FROM ex_shoppingcart_items WHERE shopId='" . $_SESSION['currentOrder'] . "' AND productId = '" . $productdetails->productId . "' AND vouchersId='0' ORDER BY itemId DESC";
                    $querySpecialitem = mysql_query($sqlSpecialitem);
                    $rowSpecialitem = mysql_fetch_array($querySpecialitem);
                    $specialItems4 = smOrder::_itemProcessRow($rowSpecialitem);

                    if (!empty($_SESSION['insidecollarcuff'])) {
                        echo "<p>Inside Collar &amp; Cuff: <span class='textblue'>{$_SESSION['insidecollarcuff']}</span></p>";
                    }
                    ?>

                    <label>Initials</label>
                    <input type="text" id="itemInitials" name="itemInitials" value="<?= $_SESSION['initials']; ?>" placeholder="Initials" readonly="readonly" /><br />

                    <label>Special Details</label>
                    <textarea id="itemSpecialDetails" name="itemSpecialDetails"><?php echo $specialItems4->itemSpecialDetails . " " . $memberMeasurement->measurementSpecialDetails; ?></textarea>
                </div> -->
            <!-- </div> -->
        <!-- </aside> -->

        
            
                

                    <h3 id="contactus-h1">Metric</h3>
                
                
                    <?php
                    if ($memberMeasurement->measurementMetric == 1) {
                        $checkmetric1 = " checked='checked' ";
                    } else {
                        $checkmetric2 = " checked='checked' ";
                    }
                    ?>
                    <label class="radio"  style="margin-left:25px;">
                        <input type="radio" name="itemmeasurementMetric" id="metric1" value="1" <?= $checkmetric1; ?>/>
                        Centimeters (Decimal)
                    </label>
                    <label class="radio" style="margin-left:25px;">
                        <input type="radio" name="itemmeasurementMetric" id="metric2" value="0" <?= $checkmetric2; ?> />
                        Inches (Imperial)
                    </label>
                

                
                
                
                
                    <div id="divshirtmeasurement" style="<?= $chkdiv1; ?>">
                        <h3 id="contactus-h1">Measurement Type</h3>
                        <?php
                        if ($memberMeasurement->measurementType == "SHIRT") {
                            $checktype21 = " checked='checked' ";
                        } else {
                            $checktype22 = " checked='checked' ";
                        }
                        ?>
                        <label class="radio" style="margin-left:25px;">
                            <input type="radio" name="itemmeasurementType2" id="type21" value="SHIRT" <?= $checktype21; ?>/>
                            Taken from SHIRT
                        </label>
                        <label class="radio" style="margin-left:25px;">
                            <input type="radio" name="itemmeasurementType2" id="type22" value="BODY" <?= $checktype22; ?> />
                            Taken from BODY
                        </label><br />
                        <p class="textblue">Download measuring guide <a href="https://www.exacttailoring.com/tapemeasureoffer" target="_blank" style="text-decoration: underline;">click here</a>.</p>

                        <p class="textblue">* Measurement taken from BODY <br />
                            Slim fit 2" / Standard fit 4" / Loost fit 6" will be added to the chest, stomach and hip measurements above.<br />
                        </p>

                        <label>Neck (Measure Length required from button to centre of button hole)</label>
                        <input type="text" id="membermeasurementShirtNeck" name="membermeasurementShirtNeck" value="<?= $memberMeasurement->measurementShirtNeck; ?>" class="form-control account-input" placeholder="Neck" /><br />

                        <label>Chest (Measure around body well up under arm holes)</label>
                        <input type="text" id="membermeasurementShirtChest" name="membermeasurementShirtChest" value="<?= $memberMeasurement->measurementShirtChest; ?>" class="form-control account-input" placeholder="Chest" /><br />

                        <label>Stomach (Measure around stomach line)</label>
                        <input type="text" id="membermeasurementShirtStomach" name="membermeasurementShirtStomach" value="<?= $memberMeasurement->measurementShirtStomach; ?>"class="form-control account-input" placeholder="Stomach" /><br />

                        <label>Hips (Measure around hips at widest point of seat but not tight.)</label>
                        <input type="text" id="membermeasurementShirtHips" name="membermeasurementShirtHips" value="<?= $memberMeasurement->measurementShirtHips; ?>"class="form-control account-input" placeholder="Hips" /><br />

                        <label>Length (Measure from small bone at back of neck to length required)</label>
                        <input type="text" id="membermeasurementShirtLenght" name="membermeasurementShirtLenght" value="<?= $memberMeasurement->measurementShirtLenght; ?>"class="form-control account-input" placeholder="Lenght" /><br />

                        <label>Sleeve length (Measure from shoulder to length desired - around elbow for long sleeve)</label>
                        <input type="text" id="membermeasurementShirtSleeveLength" name="membermeasurementShirtSleeveLength" value="<?= $memberMeasurement->measurementShirtSleeveLength; ?>"class="form-control account-input" placeholder="Sleeve length" /><br />

                        <label>Short sleeve (Measure from shoulder to length required)</label>
                        <input type="text" id="membermeasurementShirtShortSleeve" name="membermeasurementShirtShortSleeve" value="<?= $memberMeasurement->measurementShirtShortSleeve; ?>"class="form-control account-input" placeholder="Short sleeve" /><br />

                        <label>Cuff (Measure length required from button to centre button hole)</label>
                        <input type="text" id="membermeasurementShirtCuff" name="membermeasurementShirtCuff" value="<?= $memberMeasurement->measurementShirtCuff; ?>"class="form-control account-input" placeholder="Cuff" /><br />

                        <label>Upper arm (Measure around upper arm)</label>
                        <input type="text" id="membermeasurementShirtUpperarm" name="membermeasurementShirtUpperarm" value="<?= $memberMeasurement->measurementShirtUpperarm; ?>"class="form-control account-input" placeholder="Upper arm" /><br />

                        <label>Shoulder (Measure back at end of shoulder)</label>
                        <input type="text" id="membermeasurementShirtShoulder" name="membermeasurementShirtShoulder" value="<?= $memberMeasurement->measurementShirtShoulder; ?>"class="form-control account-input" placeholder="Shoulder" /><br />
                    </div>

                    <div id="divtrousersmeasurement" style="<?= $chkdiv2; ?>">
                        <p class="textblue">Download measuring guide <a href="https://www.exacttailoring.com/tapemeasureoffer" target="_blank" style="text-decoration: underline;">click here</a>.</p><br />
                        <label>(A) Outside Leg - Along Side Seam</label>
                        <input type="text" id="membermeasurementTrousersA" name="membermeasurementTrousersA" value="<?= $memberMeasurement->measurementTrousersA; ?>"class="form-control account-input" placeholder="Outside Leg" /><br />

                        <label>(B) Inside Leg - Along Inside Seam</label>
                        <input type="text" id="membermeasurementTrousersB" name="membermeasurementTrousersB" value="<?= $memberMeasurement->measurementTrousersB; ?>"class="form-control account-input" placeholder="Inside Leg" /><br />

                        <label>(C) Thigh - 3” below top of inside Leg</label>
                        <input type="text" id="membermeasurementTrousersC" name="membermeasurementTrousersC" value="<?= $memberMeasurement->measurementTrousersC; ?>"class="form-control account-input" placeholder="Thigh" /><br />

                        <label>(D) Width Of Knee</label>
                        <input type="text" id="membermeasurementTrousersD" name="membermeasurementTrousersD" value="<?= $memberMeasurement->measurementTrousersD; ?>"class="form-control account-input" placeholder="Width Of Knee" /><br />

                        <label>(E) Width of Bottom</label>
                        <input type="text" id="membermeasurementTrousersE" name="membermeasurementTrousersE" value="<?= $memberMeasurement->measurementTrousersE; ?>"class="form-control account-input" placeholder="Width of Bottom" /><br />

                        <label>(F) Waist - At waistband Level</label>
                        <input type="text" id="membermeasurementTrousersF" name="membermeasurementTrousersF" value="<?= $memberMeasurement->measurementTrousersF; ?>"class="form-control account-input" placeholder="Waist Measurements" /><br />

                        <label>(G) Seat - At fullest part of hips</label>
                        <input type="text" id="membermeasurementTrousersG" name="membermeasurementTrousersG" value="<?= $memberMeasurement->measurementTrousersG; ?>"class="form-control account-input" placeholder="Seat Measurements" /><br />
                    </div>

                    <div id="divboxersmeasurement" style="display:none;">
                        <label>Waist - Measure around waist or enter known waist size</label>
                        <input type="text" id="membermeasurementBoxersWaist" name="membermeasurementBoxersWaist" value="<?= $memberMeasurement->measurementBoxersWaist; ?>"class="form-control account-input" placeholder="Waist" /><br />

                        <label>Top of Leg - Measure around the thickest part of the leg</label>
                        <input type="text" id="membermeasurementBoxersTopofLeg" name="membermeasurementBoxersTopofLeg" value="<?= $memberMeasurement->measurementBoxersTopofLeg; ?>"class="form-control account-input" placeholder="Top of Leg" /><br />

                        <label>Length - Measure from waist to length required</label>
                        <input type="text" id="membermeasurementBoxersLength" name="membermeasurementBoxersLength" value="<?= $memberMeasurement->measurementBoxersLength; ?>"class="form-control account-input" placeholder="Length" /><br />

                        <label>Hip - Measure around the widest part of the hips</label>
                        <input type="text" id="membermeasurementBoxersHip" name="membermeasurementBoxersHip" value="<?= $memberMeasurement->measurementBoxersHip; ?>"class="form-control account-input" placeholder="Hip" /><br />

                        <label>Inside Leg - Measure from crotch to length required</label>
                        <input type="text" id="membermeasurementBoxersInsideLeg" name="membermeasurementBoxersInsideLeg" value="<?= $memberMeasurement->measurementBoxersInsideLeg; ?>"class="form-control account-input" placeholder="Inside Leg" /><br />
                    </div>



               
            
        

        <br style="clear:both" />
        <input type="hidden" id="hiddenitemid" name="hiddenitemid" value="<?= $_REQUEST['item']; ?>" />
        <input type="hidden" id="hiddenproductid" name="hiddenproductid" value="<?= $_REQUEST['product']; ?>" />
        <input type="hidden" id="hiddenconfirmitem" name="hiddenconfirmitem" value="true" />

        
            <center><button class="btn btn-default-shop">
                ORDER THIS PRODUCT
            </button></center>
        

    </form>
  </div>


    <div class="col-lg-4">
                
    <h3 id="contactus-h1"><?php echo $categoryname->categoryName; ?> REF #<?= $productdetails->productRefCode; ?></h3>
               
               
                    
                        <center>
                            <?php
                            if (!empty($productdetails->productMainPicture)) {
                                $showPic = $productdetails->productMainPicture;
                            } else if (!empty($productdetails->productFabricPicture)) {
                                $showPic = $productdetails->productFabricPicture;
                            }
                            ?>
                            <a href="<?= _URL_; ?>upload_pictures/<?= $showPic; ?>" title="" rel="prettyPhoto">
                                <img src="<?= _URL_; ?>upload_pictures/<?= $showPic; ?>" alt="<?= $productdetails->productTitle; ?>" title="<?= $productdetails->productTitle; ?>" class="mainpicture"style="height:250px;width:100%;" />
                            </a>
                        </center>
                    

                    
                        
            <p class="text-center price">Product Price:<?php echo $showprice; ?></p>
                        

                <h3 id="account-h1"><?= $productdetails->productTitle; ?></h3>

                        <dl style="margin-left:30px;">
                        <dt>Fabric:</dt>
                        <dd><?= $fabric->fabricName; ?> </dd>

                        <dt>Pattern:</dt>
                        <dd><?= $pattern->patternTitle; ?> </dd>

                        <dt>Colour:</dt>
                        <dd><?= $showcolor; ?> </dd>
                    </dl>
                
                    

                   <!--  <?php
                    if ($categoryname->categoryName == "Shirts" || $categoryname->categoryName == "Dress Shirts") :
                    ?>
                        <iframe width="100%" height="220" src="https://www.youtube.com/embed/Gk10_ZRlKcA" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    <?php
                    elseif ($categoryname->categoryName == "Trousers") :
                    ?>

                        <iframe width="100%" height="220" src="https://www.youtube.com/embed/iW4Z5N3knso" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    <?php endif; ?> -->
                
            
    </div>
</div>
</div><br><br><br><br>
<!-- Facebook Pixel Code -->
<script>
    ! function(f, b, e, v, n, t, s) {
        if (f.fbq) return;
        n = f.fbq = function() {
            n.callMethod ?
                n.callMethod.apply(n, arguments) : n.queue.push(arguments)
        };
        if (!f._fbq) f._fbq = n;
        n.push = n;
        n.loaded = !0;
        n.version = '2.0';
        n.queue = [];
        t = b.createElement(e);
        t.async = !0;
        t.src = v;
        s = b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t, s)
    }(window,
        document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');

    fbq('init', '1069763303102834');
    fbq('track', "PageView");

    fbq('track', 'AddPaymentInfo');
</script>
<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1069763303102834&ev=PageView&noscript=1" /></noscript>
<!-- End Facebook Pixel Code -->
<?php include_once('forms/form_end.php'); ?>