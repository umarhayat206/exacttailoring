<?php

include_once('includes/globals.php');
include_once('includes/html_head.php');
include_once("forms/form_head.php");

$item = explode("-",$__get[1]);
//echo $item[0]." /* ".$item[1]; // item - product

if(empty($_SESSION['chkmemberuser'])){ // member not login 
    echo "<script language='javascript' type='text/javascript'>
            alert('You are not login. Please login to your account.');
            history.go(-1);
        </script>";

}else{
    
    if($_POST['hiddenconfirmitem']){ // submit confirm item
            
        // Create order
        if(empty($_SESSION['currentOrder'])){

            $sqlOrder="insert into ex_shoppingcart set ";
            $sqlOrder .="shopCompleted='1', "; // await confirm payment
            $sqlOrder .="shopDeliveryAddress='{$_SESSION['shippingaddress']}', ";
            $sqlOrder .="shopConfirmOrder='0', ";
            $sqlOrder .="shopUserId='{$_SESSION['chkmemberuser']}' ";
            mysql_query($sqlOrder);
            $_SESSION['currentOrder']=mysql_insert_id();
            //echo $sqlOrder."---<br/><br/>";
        }
        
        // Add order item
        $updateItemDesign="insert into ex_shoppingcart_items set ";
        $updateItemDesign .="shopId='{$_SESSION['currentOrder']}', ";
        $updateItemDesign .="productId='{$_POST['hiddenproductid']}', ";
        $updateItemDesign .="itemPrice='{$_POST['hiddenproductprice']}', ";
        $updateItemDesign .="itemQty='1', ";
        $updateItemDesign .="itemDetails='{$_POST['hiddenproductdesign']}', ";
        
        //$updateItemDesign="UPDATE ex_shoppingcart_items set ";
        $updateItemDesign .="itemmeasurementMetric='".$_POST['itemmeasurementMetric']."', ";
        
        if($_POST['itemMeasurementType'] == 1){
            $updateItemDesign .="itemMeasurementType='1', ";
            $updateItemDesign .="itemmeasurementShirtNeck='".$_POST['membermeasurementShirtNeck']."', ";
            $updateItemDesign .="itemmeasurementShirtChest='".$_POST['membermeasurementShirtChest']."', ";
            $updateItemDesign .="itemmeasurementShirtStomach='".$_POST['membermeasurementShirtStomach']."', ";
            $updateItemDesign .="itemmeasurementShirtHips='".$_POST['membermeasurementShirtHips']."', ";
            $updateItemDesign .="itemmeasurementShirtLenght='".$_POST['membermeasurementShirtLenght']."', ";
            $updateItemDesign .="itemmeasurementShirtSleeveLength='".$_POST['membermeasurementShirtSleeveLength']."', ";
            $updateItemDesign .="itemmeasurementShirtShortSleeve='".$_POST['membermeasurementShirtShortSleeve']."', ";
            $updateItemDesign .="itemmeasurementShirtCuff='".$_POST['membermeasurementShirtCuff']."', ";
            $updateItemDesign .="itemmeasurementShirtUpperarm='".$_POST['membermeasurementShirtUpperarm']."', ";
            $updateItemDesign .="itemmeasurementShirtShoulder='".$_POST['membermeasurementShirtShoulder']."', ";
    
        }else if($_POST['itemMeasurementType'] == 2){
            $updateItemDesign .="itemMeasurementType='2', ";
            $updateItemDesign .="itemmeasurementTrousersA='".$_POST['membermeasurementTrousersA']."', ";
            $updateItemDesign .="itemmeasurementTrousersB='".$_POST['membermeasurementTrousersB']."', ";
            $updateItemDesign .="itemmeasurementTrousersC='".$_POST['membermeasurementTrousersC']."', ";
            $updateItemDesign .="itemmeasurementTrousersD='".$_POST['membermeasurementTrousersD']."', ";
            $updateItemDesign .="itemmeasurementTrousersE='".$_POST['membermeasurementTrousersE']."', ";
            $updateItemDesign .="itemmeasurementTrousersF='".$_POST['membermeasurementTrousersF']."', ";
            $updateItemDesign .="itemmeasurementTrousersG='".$_POST['membermeasurementTrousersG']."', ";
            
        }else if($_POST['itemMeasurementType'] == 3){
            $updateItemDesign .="itemMeasurementType='3', ";
            $updateItemDesign .="itemmeasurementBoxersWaist='".$_POST['membermeasurementBoxersWaist']."', ";
            $updateItemDesign .="itemmeasurementBoxersTopofLeg='".$_POST['membermeasurementBoxersTopofLeg']."', ";
            $updateItemDesign .="itemmeasurementBoxersLength='".$_POST['membermeasurementBoxersLength']."', ";
            $updateItemDesign .="itemmeasurementBoxersHip='".$_POST['membermeasurementBoxersHip']."', ";
            $updateItemDesign .="itemmeasurementBoxersInsideLeg='".$_POST['membermeasurementBoxersInsideLeg']."', ";
            
        }
        
        $updateItemDesign .="itemSpecialDetails='".$_POST['itemSpecialDetails']."', ";
        $updateItemDesign .="itemComplete='1' ";
        //$updateItemDesign .="WHERE itemId = '".$_POST['hiddenitemid']."' ";
        mysql_query($updateItemDesign);
        $itemid=mysql_insert_id();
        //echo $updateItemDesign;
        
        $loopAddDesign = "SELECT * FROM ex_item_details_index WHERE itemId = '{$_POST['hiddenitemid']}' ";
        $queryAddDesign = mysql_query($loopAddDesign);
        while($rowAddDesign=mysql_fetch_array($queryAddDesign)){
            $sqlItemsDesign="insert into ex_item_details_index set " ;
            $sqlItemsDesign .="itemId='$itemid', ";
            $sqlItemsDesign .="optionId='{$rowAddDesign['optionId']}', ";
            $sqlItemsDesign .="optionValue='{$rowAddDesign['optionValue']}' ";
            mysql_query($sqlItemsDesign);
        }
    
        echo ("<script>window.location='"._URL_."shoppingcart';</script>");
        
    }
    
    //$getshoppingcartitems ="SELECT * FROM ex_shoppingcart_items WHERE itemId = '{$item[0]}' ";
    //$getitemdesigndetails ="SELECT * FROM ex_item_details_index WHERE itemId = '{$item[0]}' " ;
    
    $productdetails = smProduct::GetIndividual($item[1]);
    $categoryname = smCategory::getCategory($productdetails->productCategoryId);
    $fabric = smFabric::getFabric($productdetails->productFabricId);
    $pattern = smPattern::getPattern($productdetails->productPatternId);
    $color = smColor::getColor($productdetails->productColorId);
    
    if(!empty($color)){
        $stylecolor = str_replace(" ","", strtolower($color->colorTitle));
        $showcolor ="<label style='width:15px; height:13px; background:$stylecolor; float:left; margin: 4px 5px 0 0;'>&nbsp;</label> ".$color->colorTitle;
    }
    
    $itemdesign = smOrder::getItemDesignDetails($item[0]);
    $itemMeasurement = smOrder::GetItemsIndividual($item[0]);
    //print_r($_SESSION['memberDetails'])."<br/>";
    //print_r($memberMeasurement)."<br/>";
    
    //echo $categoryname->categoryId." - ". $categoryname->categoryRootId." - ".$rootname->categoryName;
    
    $checkProductOnPromotion = smPromotion::checkProductOnPromotion($productdetails->productId);
    $promotiondetails = smPromotion::GetPromotion($checkProductOnPromotion->promotionId);
    
    if($promotiondetails->promotionType == 1){  // discount
        $promotiontype = "";
        // EDIT 30/7/14
        //$price = $productdetails->productPrice - (($productdetails->productPrice * $promotiondetails->promotionDiscount) / 100);
        //$showprice = "<span><span class='strike-through'>&pound;".number_format($productdetails->productPrice,2)."</span>&pound;".number_format($price,2)."</span>";
        $price = $productdetails->productPrice;
        $showprice = "<span>&pound;".number_format($price,2)."</span>";
    
    }else if($promotiondetails->promotionType == 2){    // free item
        $promotiontype = "<i class='right'><a>Buy 1 free ".$promotiondetails->promotionGetfreeItem."</a></i>";
        $showprice = "<span>&pound;".number_format($productdetails->productPrice,2)."</span>";
        $price = $productdetails->productPrice;
    
    }else{  // not on promotion
        $promotiontype = "";
        $showprice = "<span>&pound;".number_format($productdetails->productPrice,2)."</span>";
        $price = $productdetails->productPrice;
    }

?>

<div class="row">
    <form action="<?=_URL_;?>view-design.php" method="post">
        
        <aside class="span4">
            <div class="user-comments">
                <div class="titleHeader clearfix">
                    <h3><?php echo $categoryname->categoryName; ?> REF #<?=$productdetails->productRefCode; ?></h3>
                </div>
                <div class="media-list hProductItems">
                    
                    <div class="thumbnail">
                        <center>
                            <?php
                            if(!empty($productdetails->productMainPicture)){ 
                                $showPic = $productdetails->productMainPicture;
                                
                            }else if(!empty($productdetails->productFabricPicture)){
                                $showPic = $productdetails->productFabricPicture;
                            }
                            ?>
                            <a href="<?=_URL_;?>upload_pictures/<?=$showPic;?>" title="" rel="prettyPhoto">
                                <img src="<?=_URL_;?>upload_pictures/<?=$showPic;?>" alt="<?=$productdetails->productTitle;?>" title="<?=$productdetails->productTitle;?>" class="mainpicture">
                            </a>
                        </center>
                    </div>
                    
                    <div class="thumbSetting product-set">
                        <div class="thumbPrice">
                            <span><?php echo $showprice; ?></span>
                        </div>
                        
                        <h3><?=$productdetails->productTitle; ?></h3>
                        
                        <div class="product-info">
                            <dl class="dl-horizontal">
                                <dt>Fabric:</dt>
                                <dd><?=$fabric->fabricName; ?> </dd>
        
                                <dt>Pattern:</dt>
                                <dd><?=$pattern->patternTitle; ?> </dd>
        
                                <dt>Colour:</dt>
                                <dd><?=$showcolor; ?> </dd>
                            </dl>
                        </div>
                    </div>
        
                </div>
            </div>
        </aside><!--end span4-->
        
        <aside class="span13">
            <div class="user-comments">
                <div class="titleHeader clearfix">
                    <h3><?php echo $categoryname->categoryName; ?> Measurement</h3>
                </div>
                <div class="media-list hProductItems">
                    <?php
                    if($itemMeasurement->itemMeasurementType==1){
                        echo "<label class='radio'>
                        <input type='radio' name='itemMeasurementType' id='shirtmeasurement' value='1' checked='checked' />
                        Shirt / Jacket Measurement
                    </label>";
                    $measurementform1 = " style='display:run-in;' ";
                    $measurementform2 = " style='display:none;' ";
                    $measurementform3 = " style='display:none;' ";
                    
                    }else if($itemMeasurement->itemMeasurementType==2){
                        echo "<label class='radio'>
                        <input type='radio' name='itemMeasurementType' id='shirtmeasurement' value='2' checked='checked' />
                        Trousers Measurement
                    </label>";
                    $measurementform1 = " style='display:none;' ";
                    $measurementform2 = " style='display:run-in;' ";
                    $measurementform3 = " style='display:none;' ";
                    
                    }else if($itemMeasurement->itemMeasurementType==3){
                        echo "<label class='radio'>
                        <input type='radio' name='itemMeasurementType' id='shirtmeasurement' value='3' checked='checked' />
                        Boxers Measurement
                    </label>";
                    $measurementform1 = " style='display:none;' ";
                    $measurementform2 = " style='display:none;' ";
                    $measurementform3 = " style='display:run-in;' ";
                    
                    }
                    ?><br/>
                </div>
                
                <div class="titleHeader clearfix">
                    <h3><?php echo $categoryname->categoryName; ?> Design Details</h3>
                </div>
                <div class="media-list hProductItems">
                    <?php
                    //print_r($itemdesign);
                    
                    foreach($itemdesign as $design){
                        $designlabel = smFeature::getFeatures($design->optionId);
                        $designvalue = smFeature::getFeatures($design->optionValue);
                        echo "<p>{$designlabel->featuresName}: <span class='textblue'>{$designvalue->featuresName}</span></p>";
                    }

                    //echo stripcslashes($itemMeasurement->itemDetails);
                    ?>

                    <label>Special Details (initials etc..)</label>
                    <textarea id="itemSpecialDetails" name="itemSpecialDetails"><?php //echo $itemMeasurement->itemSpecialDetails; ?></textarea>
                </div>
                
            </div>
        </aside>
        
        <aside class="span4">
            <div class="user-comments">
                
                <div class="titleHeader clearfix">
                    <h3>Metric</h3>
                </div>
                <div class="media-list hProductItems">
                    <?php
                    if($itemMeasurement->itemmeasurementMetric==1){
                        $checkmetric1 = " checked='checked' ";
                    }else{
                        $checkmetric2 = " checked='checked' ";
                    }
                    ?>
                    <label class="radio">
                        <input type="radio" name="itemmeasurementMetric" id="metric1" value="1" <?=$checkmetric1;?> />
                       Centimeters (Decimal)
                    </label>
                    <label class="radio">
                        <input type="radio" name="itemmeasurementMetric" id="metric2" value="0" <?=$checkmetric2;?> />
                        Inches (Imperial)
                    </label><br/>
                    
                    <div id="divshirtmeasurement" <?=$measurementform1;?>>
                        <p class="textblue">* Measurement taken from BODY (Standard - Average fit 4" will be added to the chest, stomach and hip measurements above.)</p>
        
                        <label>Neck (Measure Length required from button to centre of button hole)</label>
                        <input type="text" id="membermeasurementShirtNeck" name="membermeasurementShirtNeck" value="<?=$itemMeasurement->itemmeasurementShirtNeck; ?>" placeholder="Neck" /><br/>
                        
                        <label>Chest (Measure around body well up under arm holes)</label>
                        <input type="text" id="membermeasurementShirtChest" name="membermeasurementShirtChest" value="<?=$itemMeasurement->itemmeasurementShirtChest; ?>" placeholder="Chest" /><br/>
                        
                        <label>Stomach (Measure around stomach line)</label>
                        <input type="text" id="membermeasurementShirtStomach" name="membermeasurementShirtStomach" value="<?=$itemMeasurement->itemmeasurementShirtStomach; ?>" placeholder="Stomach" /><br/>
                        
                        <label>Hips (Measure around hips at widest point of seat but not tight.)</label>
                        <input type="text" id="membermeasurementShirtHips" name="membermeasurementShirtHips" value="<?=$itemMeasurement->itemmeasurementShirtHips; ?>" placeholder="Hips" /><br/>
                        
                        <label>Length (Measure from small bone at back of neck to length required)</label>
                        <input type="text" id="membermeasurementShirtLenght" name="membermeasurementShirtLenght" value="<?=$itemMeasurement->itemmeasurementShirtLenght; ?>" placeholder="Lenght" /><br/>
                        
                        <label>Sleeve length (Measure from shoulder to length desired - around elbow for long sleeve)</label>
                        <input type="text" id="membermeasurementShirtSleeveLength" name="membermeasurementShirtSleeveLength" value="<?=$itemMeasurement->itemmeasurementShirtSleeveLength; ?>" placeholder="Sleeve length" /><br/>
                        
                        <label>Short sleeve (Measure from shoulder to length required)</label>
                        <input type="text" id="membermeasurementShirtShortSleeve" name="membermeasurementShirtShortSleeve" value="<?=$itemMeasurement->itemmeasurementShirtShortSleeve; ?>" placeholder="Short sleeve"  /><br/>
                        
                        <label>Cuff (Measure length required from button to centre button hole)</label>
                        <input type="text" id="membermeasurementShirtCuff" name="membermeasurementShirtCuff" value="<?=$itemMeasurement->itemmeasurementShirtCuff; ?>" placeholder="Cuff" /><br/>
                        
                        <label>Upper arm (Measure around upper arm)</label>
                        <input type="text" id="membermeasurementShirtUpperarm" name="membermeasurementShirtUpperarm" value="<?=$itemMeasurement->itemmeasurementShirtUpperarm; ?>" placeholder="Upper arm" /><br/>
                        
                        <label>Shoulder (Measure back at end of shoulder)</label>
                        <input type="text" id="membermeasurementShirtShoulder" name="membermeasurementShirtShoulder" value="<?=$itemMeasurement->itemmeasurementShirtShoulder; ?>" placeholder="Shoulder" /><br/>
                    </div>
                    
                    <div id="divtrousersmeasurement" <?=$measurementform2;?>>
                        <label>(A) Outside Leg - Along Side Seam</label>
                        <input type="text" id="membermeasurementTrousersA" name="membermeasurementTrousersA" value="<?=$itemMeasurement->itemmeasurementTrousersA; ?>" placeholder="Outside Leg" /><br/>
                        
                        <label>(B) Inside Leg - Along Inside Seam</label>
                        <input type="text" id="membermeasurementTrousersB" name="membermeasurementTrousersB" value="<?=$itemMeasurement->itemmeasurementTrousersB; ?>" placeholder="Inside Leg" /><br/>
                        
                        <label>(C) Thigh - 3” below top of inside Leg</label>
                        <input type="text" id="membermeasurementTrousersC" name="membermeasurementTrousersC" value="<?=$itemMeasurement->itemmeasurementTrousersC; ?>" placeholder="Thigh" /><br/>
                        
                        <label>(D) Width Of Knee</label>
                        <input type="text" id="membermeasurementTrousersD" name="membermeasurementTrousersD" value="<?=$itemMeasurement->itemmeasurementTrousersD; ?>" placeholder="Width Of Knee" /><br/>
                        
                        <label>(E) Width of Bottom</label>
                        <input type="text" id="membermeasurementTrousersE" name="membermeasurementTrousersE" value="<?=$itemMeasurement->itemmeasurementTrousersE; ?>" placeholder="Width of Bottom" /><br/>
                        
                        <label>(F) Waist - At waistband Level</label>
                        <input type="text" id="membermeasurementTrousersF" name="membermeasurementTrousersF" value="<?=$itemMeasurement->itemmeasurementTrousersF; ?>" placeholder="Waist Measurements" /><br/>
                        
                        <label>(G) Seat - At fullest part of hips</label>
                        <input type="text" id="membermeasurementTrousersG" name="membermeasurementTrousersG" value="<?=$itemMeasurement->itemmeasurementTrousersG; ?>" placeholder="Seat Measurements" /><br/>
                    </div>
                    
                    <div id="divboxersmeasurement" <?=$measurementform3;?>>
                        <label>Waist - Measure around waist or enter known waist size</label>
                        <input type="text" id="membermeasurementBoxersWaist" name="membermeasurementBoxersWaist" value="<?=$itemMeasurement->itemmeasurementBoxersWaist; ?>" placeholder="Waist" /><br/>
                        
                        <label>Top of Leg - Measure around the thickest part of the leg</label>
                        <input type="text" id="membermeasurementBoxersTopofLeg" name="membermeasurementBoxersTopofLeg" value="<?=$itemMeasurement->itemmeasurementBoxersTopofLeg; ?>" placeholder="Top of Leg" /><br/>
                        
                        <label>Length - Measure from waist to length required</label>
                        <input type="text" id="membermeasurementBoxersLength" name="membermeasurementBoxersLength" value="<?=$itemMeasurement->itemmeasurementBoxersLength; ?>" placeholder="Length" /><br/>
                        
                        <label>Hip - Measure around the widest part of the hips</label>
                        <input type="text" id="membermeasurementBoxersHip" name="membermeasurementBoxersHip" value="<?=$itemMeasurement->itemmeasurementBoxersHip; ?>" placeholder="Hip" /><br/>
                        
                        <label>Inside Leg - Measure from crotch to length required</label>
                        <input type="text" id="membermeasurementBoxersInsideLeg" name="membermeasurementBoxersInsideLeg" value="<?=$itemMeasurement->itemmeasurementBoxersInsideLeg; ?>" placeholder="Inside Leg" /><br/>
                    </div>

                </div>
            </div>
        </aside>
        
        <br style="clear:both"/>
        <input type="hidden" id="hiddenitemid" name="hiddenitemid" value="<?=$item[0]; ?>" />
        <input type="hidden" id="hiddenproductid" name="hiddenproductid" value="<?=$item[1]; ?>" />
        <input type="hidden" id="hiddenproductprice" name="hiddenproductprice" value="<?=$price ?>" />
        <input type="hidden" id="hiddenproductdesign" name="hiddenproductdesign" value="<?=htmlspecialchars($itemMeasurement->itemDetails); ?>" />
        <input type="hidden" id="hiddenconfirmitem" name="hiddenconfirmitem" value="true" />
        <div style="width:280px; margin:15px auto 0;">
            <button class="btn btn-primary btn-small btn-block">
                ORDER THIS PRODUCT
            </button>
        </div>
        
    </form>
</div>

<?php } ?>
<?php include_once('forms/form_end.php'); ?>

