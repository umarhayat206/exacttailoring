<?php

include_once('includes/globals.php');
include_once('includes/check_admin_login.php');
include_once('includes/admin_html_head.php');
include_once('forms/admin_form_head.php');
include_once('includes/tiny_mce_script2.php');
    
if($_POST['editOrderSubmitted']){
    $cart = $_POST['editOrderId'];
    $member=$_POST['memberId'];
    
    $updateDesignItems = smOrder::GetAllItems($cart);
    foreach ($updateDesignItems as $item){
        $sqlupdateItemDetails = "";
        
        $DESIGNUPDATE="itemEdit-".$item->itemId;
        
        $SHIRTNECK="ShirtNeck-".$item->itemId;
        $SHIRTCHEST="ShirtChest-".$item->itemId;
        $SHIRTSTOMACH="ShirtStomach-".$item->itemId;
        $SHIRTHIPS="ShirtHips-".$item->itemId;
        $SHIRTLENGHT="ShirtLenght-".$item->itemId;
        $SHIRTSLEEVELENGHT="ShirtSleeveLength-".$item->itemId;
        $SHIRTSHORTSLEEVE="ShirtShortSleeve-".$item->itemId;
        $SHIRTCUFF="ShirtCuff-".$item->itemId;
        $SHIRTUPPERARM="ShirtUpperarm-".$item->itemId;
        $SHIRTSHOULDER="ShirtShoulder-".$item->itemId;
        
        $TROUSERSA="TrousersA-".$item->itemId;
        $TROUSERSB="TrousersB-".$item->itemId;
        $TROUSERSC="TrousersC-".$item->itemId;
        $TROUSERSD="TrousersD-".$item->itemId;
        $TROUSERSE="TrousersE-".$item->itemId;
        $TROUSERSF="TrousersF-".$item->itemId;
        $TROUSERSG="TrousersG-".$item->itemId;
        
        $BOXERSWAIST="BoxersWaist-".$item->itemId;
        $BOXERSTOPOFLEG="BoxersTopofLeg-".$item->itemId;
        $BOXERSLENGTH="BoxersLength-".$item->itemId;
        $BOXERSHIP="BoxersHip-".$item->itemId;
        $BOXERSINSIDELEG="BoxersInsideLeg-".$item->itemId;
        
        $INITIALS="Initials-".$item->itemId;
        $INSIDECOLLAR="InsideCollarCuff-".$item->itemId;
        
        $SPECIALDETIALS="SpecialDetails-".$item->itemId;
        
        $MEASUREMENT = "Measurement-".$item->itemId;
        $METRIC = "Metric-".$item->itemId;
        
        $sqlupdateItemDetails = "UPDATE ex_shoppingcart_items SET itemDetails='".mysql_real_escape_string($_POST[$DESIGNUPDATE])."', ";
        
        $sqlupdateItemDetails .= "itemmeasurementType2='". $_POST[$MEASUREMENT] ."',
        itemmeasurementMetric='". $_POST[$METRIC] ."', ";
        
        if($item->itemMeasurementType==1){
            $sqlupdateItemDetails .= "itemmeasurementShirtNeck='". $_POST[$SHIRTNECK] ."',
                itemmeasurementShirtChest='". $_POST[$SHIRTCHEST] ."',
                itemmeasurementShirtStomach='". $_POST[$SHIRTSTOMACH] ."',
                itemmeasurementShirtHips='". $_POST[$SHIRTHIPS] ."',
                itemmeasurementShirtLenght='". $_POST[$SHIRTLENGHT] ."',
                itemmeasurementShirtSleeveLength='". $_POST[$SHIRTSLEEVELENGHT] ."',
                itemmeasurementShirtShortSleeve='". $_POST[$SHIRTSHORTSLEEVE] ."',
                itemmeasurementShirtCuff='". $_POST[$SHIRTCUFF] ."',
                itemmeasurementShirtUpperarm='". $_POST[$SHIRTUPPERARM] ."',
                itemmeasurementShirtShoulder='". $_POST[$SHIRTSHOULDER] ."',
                itemInsideCollarCuff='". mysql_real_escape_string($_POST[$INSIDECOLLAR]) ."',
                ";
                    
        }else if($item->itemMeasurementType==2){        
            $sqlupdateItemDetails .= "itemmeasurementTrousersA='". $_POST[$TROUSERSA] ."',
                itemmeasurementTrousersB='". $_POST[$TROUSERSB] ."',
                itemmeasurementTrousersC='". $_POST[$TROUSERSC] ."',
                itemmeasurementTrousersD='". $_POST[$TROUSERSD] ."',
                itemmeasurementTrousersE='". $_POST[$TROUSERSE] ."',
                itemmeasurementTrousersF='". $_POST[$TROUSERSF] ."',
                itemmeasurementTrousersG='". $_POST[$TROUSERSG] ."',
                ";
                    
        }else if($item->itemMeasurementType==3){
            $sqlupdateItemDetails .= "itemmeasurementBoxersWaist='". $_POST[$BOXERSWAIST] ."',
                itemmeasurementBoxersTopofLeg='". $_POST[$BOXERSTOPOFLEG] ."',
                itemmeasurementBoxersLength='". $_POST[$BOXERSLENGTH] ."',
                itemmeasurementBoxersHip='". $_POST[$BOXERSHIP] ."',
                itemmeasurementBoxersInsideLeg='". $_POST[$BOXERSINSIDELEG] ."',
                ";
        }
        
        $sqlupdateItemDetails .= "itemInitials='". mysql_real_escape_string($_POST[$INITIALS]) ."', ";
        $sqlupdateItemDetails .= "itemSpecialDetails='". mysql_real_escape_string($_POST[$SPECIALDETIALS]) ."' 
                WHERE itemId='{$item->itemId}' ";
        
        mysql_query($sqlupdateItemDetails);        
        //echo $sqlupdateItemDetails."<br><br>";
        
    }
    
    echo "<script language='javascript1.4'  type='text/javascript'>
                window.location='"._URL_."admin-edit-order?orderId=$cart&usId=$member';
        </script>";
    
}

?>
<div class="content_res">
    
    <div class="leftblock vertsortable" style="width:100%;">
        <!-- gadget left 1 -->
        <div class="gadget" id="orders">
            <div class="titlebar vertsortable_head">
                    <h3>Edit Orders <?php echo $_GET['orderId']; ?></h3>
            </div>
            <div class="gadgetblock">
    
    <form id="editOrdersForm" method="post" action="<?php echo($_SERVER['PHP_SELF']);?>" style="border:none;" enctype="multipart/form-data">
    
            <table summary="List of orders taken" width="100%" border="0" cellspacing="0" cellpadding="0" class="gwlines">
                <tr>
                    <th style="width:10%;">Order Id</th>
                    <th style="width:15%; text-align:center;">Order Date</th>
                    <th style="width:20%; text-align:center;">Member</th>
                    <th style="width:15%; text-align:right;">Value</th>
                    <th style="width:15%; text-align:center;">Payment Method</th>
                    <th style="width:15%; text-align:center;">Status</th>
                </tr>
                <?php
                $listOrder = smOrder::GetIndividual($_GET['orderId']);
                $memberDetails=smUser::GetIndividual($listOrder->shopUserId);
                
                $Y=substr($listOrder->shopDateadded,0,4);
                $M=substr($listOrder->shopDateadded,5,2);
                $MM=smSetting::changeMonth($M);
                $D=substr($listOrder->shopDateadded,8,2);
                
                echo "<tr>
                    <td style='border:none;'>".smOrder::GetBulletStatus($listOrder->shopCompleted)."ID{$listOrder->shopId}</td>
                    <td style='text-align:center; border:none;'>".$D." ".$MM." ".$Y."</td>
                    <td style='text-align:center; border:none;'>".$memberDetails->usFirstname." ".$memberDetails->usLastname."</td>
                    <td style='text-align:right; border:none; font-size:15px; color:#355F94;'>&pound;".number_format($listOrder->shopPriceValue,2)."</td>
                    <td style='text-align:center; border:none;'>{$listOrder->shopGateway}</td>
                    <td style='text-align:center; border:none;'>".smOrder::GetStatusTitle($listOrder->shopCompleted)."</td>
                </tr>
                <tr>
                    <td colspan='7' style='border:none;'>
                        <fieldset style='width:50%; margin:10px auto; border:solid 1px #CCC; padding:10px;'>
                            <legend>Items</legend>";
        
                $listItems = smOrder::GetAllItems($listOrder->shopId);
                
                foreach ($listItems as $item){
                    
                    if(empty($item->itemOnPromotion) || $item->itemOnPromotion==0){

                        $productitem = smProduct::GetIndividual($item->productId);
                        $categoryname = smCategory::getCategory($productitem->productCategoryId);
                        $designmenu = smFeature::getIndexFeatures($productitem->productCategoryId);
                        
                        echo "<p>".$productitem->productRefCode.":: ".$productitem->productTitle."</p>";
                        
                        $ITEMUPDATE = "itemEdit-".$item->itemId;
                        $ShirtNeck = "ShirtNeck-".$item->itemId;
                        $ShirtChest = "ShirtChest-".$item->itemId;
                        $ShirtStomach = "ShirtStomach-".$item->itemId;
                        $ShirtHips = "ShirtHips-".$item->itemId;
                        $ShirtLenght = "ShirtLenght-".$item->itemId;
                        $ShirtSleeveLength = "ShirtSleeveLength-".$item->itemId;
                        $ShirtShortSleeve = "ShirtShortSleeve-".$item->itemId;
                        $ShirtCuff = "ShirtCuff-".$item->itemId;
                        $ShirtUpperarm = "ShirtUpperarm-".$item->itemId;
                        $ShirtShoulder = "ShirtShoulder-".$item->itemId;
                        $TrousersA = "TrousersA-".$item->itemId;
                        $TrousersB = "TrousersB-".$item->itemId;
                        $TrousersC = "TrousersC-".$item->itemId;
                        $TrousersD = "TrousersD-".$item->itemId;
                        $TrousersE = "TrousersE-".$item->itemId;
                        $TrousersF = "TrousersF-".$item->itemId;
                        $TrousersG = "TrousersG-".$item->itemId;
                        $BoxersWaist = "BoxersWaist-".$item->itemId;
                        $BoxersTopofLeg = "BoxersTopofLeg-".$item->itemId;
                        $BoxersLength = "BoxersLength-".$item->itemId;
                        $BoxersHip = "BoxersHip-".$item->itemId;
                        $BoxersInsideLeg = "BoxersInsideLeg-".$item->itemId;
                        $Initials = "Initials-".$item->itemId;
                        $InsideCollarCuff = "InsideCollarCuff-".$item->itemId;
                        $SpecialDetails = "SpecialDetails-".$item->itemId;
                        
                        $Measurement = "Measurement-".$item->itemId;
                        $Measurement1 = "Measurement-".$item->itemId."-1";
                        $Measurement2 = "Measurement-".$item->itemId."-2";
                        $Metric = "Metric-".$item->itemId;
                        $Metric1 = "Metric-".$item->itemId."-1";
                        $Metric2 = "Metric-".$item->itemId."-2";
                        
                        if($item->itemmeasurementMetric==1){
                            $checkmetric1 = " checked='checked' ";
                        }else{
                            $checkmetric2 = " checked='checked' ";
                        }
                        
                        if($item->itemmeasurementType2=="SHIRT"){
                            $checktype21 = " checked='checked' ";
                        }else{
                            $checktype22 = " checked='checked' ";
                        }
                        
                        echo "<div class='admineditdesign'>";
                        
                        if(!empty($designmenu)){ // no option for design
                            echo "<span>Edit ".$categoryname->categoryName." design</span><br/>
                                <textarea id='$ITEMUPDATE' name='$ITEMUPDATE' class='tinymce' style='height:150px;'>
                                    ". stripcslashes($item->itemDetails) ."
                                </textarea>";
                        }
                        
                        echo "</div>
                        <div class='admineditdesign'>";
                        
                        if($item->itemMeasurementType==1){  // Shirt 
                            echo "Edit measurment taken from 
                            <input type='radio' name='$Measurement' id='$Measurement1' value='SHIRT' $checktype21 /> SHIRT

                            <input type='radio' name='$Measurement' id='$Measurement2' value='BODY' $checktype22 /> BODY <br/>
    
                            Metric <input type='radio' name='$Metric' id='$Metric1' value='1' $checkmetric1 /> Centimeters
                            <input type='radio' name='$Metric' id='$Metric2' value='0' $checkmetric2 /> Inches<br/>
                        
                            <br/><span>Neck</span>
                            <input type='text' id='$ShirtNeck' name='$ShirtNeck' value='{$item->itemmeasurementShirtNeck}' />
                            <br/><span>Chest</span>
                            <input type='text' id='$ShirtChest' name='$ShirtChest' value='{$item->itemmeasurementShirtChest}' />
                            <br/><span>Stomach</span>
                            <input type='text' id='$ShirtStomach' name='$ShirtStomach' value='{$item->itemmeasurementShirtStomach}' />
                            <br/><span>Hips</span>
                            <input type='text' id='$ShirtHips' name='$ShirtHips' value='{$item->itemmeasurementShirtHips}' />
                            <br/><span>Lenght</span>
                            <input type='text' id='$ShirtLenght' name='$ShirtLenght' value='{$item->itemmeasurementShirtLenght}' />
                            <br/><span>Sleeve length</span>
                            <input type='text' id='$ShirtSleeveLength' name='$ShirtSleeveLength' value='{$item->itemmeasurementShirtSleeveLength}' />
                            <br/><span>Short sleeve</span>
                            <input type='text' id='$ShirtShortSleeve' name='$ShirtShortSleeve' value='{$item->itemmeasurementShirtShortSleeve}' />
                            <br/><span>Cuff</span>
                            <input type='text' id='$ShirtCuff' name='$ShirtCuff' value='{$item->itemmeasurementShirtCuff}' />
                            <br/><span>Upper arm</span>
                            <input type='text' id='$ShirtUpperarm' name='$ShirtUpperarm' value='{$item->itemmeasurementShirtUpperarm}' />
                            <br/><span>Shoulder</span>
                            <input type='text' id='$ShirtShoulder' name='$ShirtShoulder' value='{$item->itemmeasurementShirtShoulder}' />
                            <br/><span>Inside Collar &amp; Cuff</span>
                            <input type='text' id='$InsideCollarCuff' name='$InsideCollarCuff' value='{$item->itemInsideCollarCuff}' /><br/>";
                            
                        }else if($item->itemMeasurementType==2){    // Trousers 
                            echo "<span>Edit ".$categoryname->categoryName." measurment</span>
                            Metric <input type='radio' name='$Metric' id='$Metric1' value='1' $checkmetric1 /> Centimeters
                            <input type='radio' name='$Metric' id='$Metric2' value='0' $checkmetric2 /> Inches<br/>
                            
                            <br/><span>(A) Outside Leg - Along Side Seam</span>
                            <input type='text' id='$TrousersA' name='$TrousersA' value='{$item->itemmeasurementTrousersA}' />
                            <br/><span>(B) Inside Leg - Along Inside Seam</span>
                            <input type='text' id='$TrousersB' name='$TrousersB' value='{$item->itemmeasurementTrousersB}' />
                            <br/><span>(C) Thigh - 3” below top of inside Leg</span>
                            <input type='text' id='$TrousersC' name='$TrousersC' value='{$item->itemmeasurementTrousersC}' />
                            <br/><span>(D) Width Of Knee</span>
                            <input type='text' id='$TrousersD' name='$TrousersD' value='{$item->itemmeasurementTrousersD}' />
                            <br/><span>(E) Width of Bottom</span>
                            <input type='text' id='$TrousersE' name='$TrousersE' value='{$item->itemmeasurementTrousersE}' />
                            <br/><span>(F) Waist - At waistband Level</span>
                            <input type='text' id='$TrousersF' name='$TrousersF' value='{$item->itemmeasurementTrousersF}' />
                            <br/><span>(G) Seat - At fullest part of hips</span>
                            <input type='text' id='$TrousersG' name='$TrousersG' value='{$item->itemmeasurementTrousersG}' />
                            <br/>";
                        
                        }else if($item->itemMeasurementType==3){    // Boxers 
                            echo "<span>Edit ".$categoryname->categoryName." measurment</span>
                            Metric <input type='radio' name='$Metric' id='$Metric1' value='1' $checkmetric1 /> Centimeters
                            <input type='radio' name='$Metric' id='$Metric2' value='0' $checkmetric2 /> Inches<br/>
                            
                            <br/><span>Waist</span>
                            <input type='text' id='$BoxersWaist' name='$BoxersWaist' value='{$item->itemmeasurementBoxersWaist}>' />
                            <br/><span>Top of Leg</span>
                            <input type='text' id='$BoxersTopofLeg' name='$BoxersTopofLeg' value='{$item->itemmeasurementBoxersTopofLeg}' />
                            <br/><span>Length</span>
                            <input type='text' id='$BoxersLength' name='$BoxersLength' value='{$item->itemmeasurementBoxersLength}>' />
                            <br/><span>Hip</span>
                            <input type='text' id='$BoxersHip' name='$BoxersHip' value='{$item->itemmeasurementBoxersHip}' />
                            <br/><span>Inside Leg</span>
                            <input type='text' id='$BoxersInsideLeg' name='$BoxersInsideLeg' value='{$item->itemmeasurementBoxersInsideLeg}' /><br/>";
                            
                        }
                        
                        echo "<span>Initials</span>
                            <input type='text' id='$Initials' name='$Initials' value='{$item->itemInitials}' /><br/>";

                        echo "<span>Special Details</span><br/>
                            <textarea id='$SpecialDetails' name='$SpecialDetails' style='width:60%; height:80px;'>{$item->itemSpecialDetails}</textarea>";
                        
                        echo "</div><br/><hr/>";
                        
                    }else{
                        echo "<p>".$productitem->productRefCode.":: ".$productitem->productTitle." <span style='color:#FF0000;'>(this item get FREE - Design same same main shirt)</span></p><hr/>";   
                    }// n check not free item
                    
                    
                } 
                echo "</fieldset></td></tr>";
                ?>
            </table>
                
            <input type="hidden" name="memberId" id="memberId" value="<?=$_GET['usId'];?>" />
            <input type="hidden" name="editOrderId" id="editOrderId" value="<?=$_GET['orderId'];?>" />
            <input type="hidden" name="editOrderSubmitted" id="editOrderSubmitted" value="true" />
            <div style="margin:0 auto; width:100px;"><?php smControls::smButton("Save changes","saveChanges");?></div>
            
    </form>
    
            </div>	<!-- n gadgetblock -->
        </div>	<!-- n gadget -->
    </div><br/>	<!-- n leftblock vertsortabl -->

</div><!-- n lcontent_res -->

<?php include_once('forms/admin_form_end.php'); ?>
