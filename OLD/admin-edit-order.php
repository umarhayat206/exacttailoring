<?php
include("code/application_code_includes_and_globals_file.php");
include($siteRoot."includes/html_head.php");
include($siteRoot."includes/admin_page_header.php");
include($siteRoot."panels/admin_orders_code.php");

if($_POST['editOrderSubmitted']){
    $updateid = $_POST['editOrderId'];
    for($i=1;$i<=$_POST['countItem'];$i++){
        
        $updateitemid = $_POST['editItemId'.$i];
        $updateqty = $_POST['editItemOty'.$i];
        $updatedetail = $_POST['editItemsDetail'.$i];
        $updatespecial = $_POST['bmSpecial'.$i];

        $sqlUpdataItem = "UPDATE ts_shopping_cart_items SET ";
        //$sqlUpdataItem.= "sci_special = '$updatespecial', ";
        $sqlUpdataItem.= "sci_qty = '$updateqty' ";
        $sqlUpdataItem.= "WHERE sci_sc_id='$updateid' AND sci_id='$updateitemid' ";
        mysql_query($sqlUpdataItem);
        //echo $sqlUpdataItem;
        
        $sql="SELECT sci_po_id FROM ts_shopping_cart_items WHERE sci_id = '$updateitemid' ";
        $query=mysql_query($sql);
        $row=mysql_fetch_array($query);
        
        $sqlUpdataItem2 = "UPDATE ts_product_order SET ";
        $sqlUpdataItem2.= "po_measurements = '$updatedetail' ";
        $sqlUpdataItem2.= "WHERE po_id='".$row['sci_po_id']."' ";
        mysql_query($sqlUpdataItem2);
        //echo $sqlUpdataItem2."--*--<br/>";
    }
    
    for($g=1;$g<=$_POST['cntnum'];$g++):
        $bmmetric = $_POST['bm_metric'.$g];
        $bmtype = $_POST['bm_type'.$g];
        $bmneck = $_POST['bm_neck'.$g];
        $bmchest = $_POST['bm_chest'.$g];
        $bmwaist = $_POST['bm_waist'.$g];
        $bmseat = $_POST['bm_seat'.$g];
        $bmback = $_POST['bm_back'.$g];
        $bmarm = $_POST['bm_arm'.$g];
        $bmarmshort = $_POST['bm_arm_short'.$g];
        $bmcuff = $_POST['bm_cuff'.$g];
        $bmbicep = $_POST['bm_bicep'.$g];
        $bmShoulder =$_POST['bmShoulder'.$g];
        $bmFit = $_POST['bmFit'.$g];
        $bmSpecial = $_POST['bmSpecial'.$g];
        $bmSoftCollar = $_POST['bmSoftCollar'.$g];
        $bmheight = $_POST['bm_height'.$g];
        $bmweight = $_POST['bm_weight'.$g];
        $measurementsId = $_POST['measurementsId'.$g];
        
        $sqlUpdateMeasurements = "UPDATE ts_body_measurements SET ";
        $sqlUpdateMeasurements.= "bm_metric = '".$bmmetric."', ";
        $sqlUpdateMeasurements.= "bm_type = '".$bmtype."', ";
        $sqlUpdateMeasurements.= "bm_neck = '".$bmneck."', ";
        $sqlUpdateMeasurements.= "bm_chest = '".$bmchest."', ";
        $sqlUpdateMeasurements.= "bm_waist = '".$bmwaist."', ";
        $sqlUpdateMeasurements.= "bm_seat = '".$bmseat."', ";
        $sqlUpdateMeasurements.= "bm_back = '".$bmback."', ";
        $sqlUpdateMeasurements.= "bm_arm = '".$bmarm."', ";
        $sqlUpdateMeasurements.= "bm_arm_short = '".$bmarmshort."', ";
        $sqlUpdateMeasurements.= "bm_cuff = '".$bmcuff."', ";
        $sqlUpdateMeasurements.= "bm_bicep = '".$bmbicep."', ";
        $sqlUpdateMeasurements.= "bmShoulder = '".$bmShoulder."', ";
        
        if($bmtype=="Body"){
            $sqlUpdateMeasurements.= "bmFit = '".$bmFit."', ";
        }
        $sqlUpdateMeasurements.= "bmSpecial = '".$bmSpecial."', ";
        $sqlUpdateMeasurements.= "bmSoftCollar = '".$bmSoftCollar."', ";
        $sqlUpdateMeasurements.= "bm_height = '".$bmheight."', ";
        $sqlUpdateMeasurements.= "bm_weight = '".$bmweight."' ";
        $sqlUpdateMeasurements.= "WHERE bm_id='".$measurementsId."' ";
        mysql_query($sqlUpdateMeasurements);
 //echo $sqlUpdateMeasurements."----<br/>";
        
        $designId = $_POST['designId'.$g];
        $bmcolor = $_POST['bm_color'.$g];
        $bmcollar = $_POST['bm_collar'.$g];
        $bmwhitecollar = $_POST['bm_whitecollar'.$g];
        $bmsleeves = $_POST['bm_sleeves'.$g];
        $bmcuffs = $_POST['bm_cuffs'.$g];
        $bmwhitecuffs = $_POST['bm_whitecuffs'.$g];
        $bmplacketbuttons = $_POST['bm_placketbuttons'.$g];
        $bmfastening = $_POST['bm_fastening'.$g];
        $bmpockets = $_POST['bm_pockets'.$g];
        $bmflaps = $_POST['bm_flaps'.$g];
        $bmepaulettes = $_POST['bm_epaulettes'.$g];
        $bmembroiderytext = $_POST['bm_embroiderytext'.$g];
        $bmembroiderycolour = $_POST['bm_embroiderycolour'.$g];
        $bmbackpleats = $_POST['bm_backpleats'.$g];
        $bmbottomcut = $_POST['bm_bottomcut'.$g];
        
        $sqlUpdateDesign = "UPDATE ts_shirt_design SET ";
        $sqlUpdateDesign.= "s_color = '".$bmcolor."', ";
        $sqlUpdateDesign.= "s_collar = '".$bmcollar."', ";
        $sqlUpdateDesign.= "s_collar_white = '".$bmwhitecollar."', ";
        $sqlUpdateDesign.= "s_sleeve = '".$bmsleeves."', ";
        $sqlUpdateDesign.= "s_cuff = '".$bmcuffs."', ";
        $sqlUpdateDesign.= "s_cuff_white = '".$bmwhitecuffs."', ";
        $sqlUpdateDesign.= "s_placket_button = '".$bmplacketbuttons."', ";
        $sqlUpdateDesign.= "s_fastening = '".$bmfastening."', ";
        $sqlUpdateDesign.= "s_pocket = '".$bmpockets."', ";
        $sqlUpdateDesign.= "s_pocket_flaps = '".$bmflaps."', ";
        $sqlUpdateDesign.= "s_epaulettes = '".$bmepaulettes."', ";
        $sqlUpdateDesign.= "s_embroidery_text = '".$bmembroiderytext."', ";
        $sqlUpdateDesign.= "s_embroidery_color = '".$bmembroiderycolour."', ";
        $sqlUpdateDesign.= "s_back_pleats = '".$bmbackpleats."', ";
        $sqlUpdateDesign.= "s_bottom_cut = '".$bmbottomcut."' ";
        $sqlUpdateDesign.= "WHERE s_id='".$designId."' ";
        mysql_query($sqlUpdateDesign);
        //echo $sqlUpdateDesign."------";
        
    endfor;
    
    $member=$_POST['memberId']; 
    echo "<script language='javascript1.4'  type='text/javascript'>
                    window.location='admin-edit-order?orderId=$updateid&memberId=$member';
            </script>";
}

//echo $user->mRole."-----";
?>
<h2>Edit Orders <? echo $_GET['orderId']; ?></h2>

<form id="editOrdersForm" method="post" action="<?php echo($_SERVER['PHP_SELF']);?>" style="border:none;" enctype="multipart/form-data">
    <fieldset>
            <table summary="List of orders taken" style="width:100%;">
                    <thead>
                        <tr>
                                <th style="width:10%;">Order Id</th>
                                <th style="width:23%;">Member</th>
                                <th style="width:12%;">Order Date</th>
                                <th style="width:10%;">Value</th>
                                <th style="width:10%;">Method</th>
                                <th style="width:35%;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php listEditOrders($_GET['orderId'],$sessionAuth->mRole);?>
                    </tbody>
            </table>
            
            <?
            
         //--------------------------------------------------------------
            
            // out
            if(0){
            $measurements=measurementsOrder($_GET['memberId']);
            foreach($measurements as $measurements2){
            ?>
            <div id="measurementsorder">
                <p>Measurements order</p>
                <label>Metric</label>
                    <?
                    if($measurements2->bm_metric==0){$metric1=" checked='checked' ";}
                    if($measurements2->bm_metric==1){$metric2=" checked='checked' ";}
                    ?>
                    <span style="float:right;">Centimeters (Decimal)</span><input type="radio" id="bm_metric1" name="bm_metric" <?=$metric1;?> />
                    <span style="float:right;">Inches (Imperial)</span><input type="radio" id="bm_metric2" name="bm_metric" <?=$metric2;?> /><br/>
                <label>Measurement taken from</label>
                    <?
                    if($measurements2->bm_type=="Shirt"){$ty1=" checked='checked' ";}                 
                    if($measurements2->bm_type=="Body"){$ty2=" checked='checked' ";}
                    ?>
                    <span style="float:right;">Shirt</span><input type="radio" id="bm_type1" name="bm_type" value="Shirst" <?=$ty1;?> />
                    <span style="float:right;">Body</span><input type="radio" id="bm_type2" name="bm_type" value="Body" <?=$ty2;?> /><br/>

                <label>Neck (Measure Length required from button to centre of button hole)</label><input type="text" id="bm_neck" name="bm_neck" value="<?=$measurements2->bm_neck;?>" /><br/>
                <label>Chest (Measure around body well up under arm holes )</label><input type="text" id="bm_chest" name="bm_chest" value="<?=$measurements2->bm_chest;?>" /><br/>
                <label>Stomach (Measure around stomach line)</label><input type="text" id="bm_waist" name="bm_waist" value="<?=$measurements2->bm_waist;?>" /><br/>
                <label>Hips (Measure around hips at widest point of seat but not tight. )</label><input type="text" id="bm_seat" name="bm_seat" value="<?=$measurements2->bm_seat;?>" /><br/>
                <label>Back (Measure from small bone at back of neck to length required )</label><input type="text" id="bm_back" name="bm_back" value="<?=$measurements2->bm_back;?>" /><br/>
                <label>Sleeve length (Measure from shoulder to length desired - around elbow for long sleeve)</label><input type="" id="bm_arm" name="bm_arm" value="<?=$measurements2->bm_arm;?>" /><br/>
                <label>Short sleeve (Measure from shoulder to length required)</label><input type="text" id="bm_arm_short" name="bm_arm_short" value="<?=$measurements2->bm_arm_short;?>" /><br/>
                <label>Cuff (Measure length required from button to centre button hole)</label><input type="text" id="bm_cuff" name="bm_cuff" value="<?=$measurements2->bm_cuff;?>" /><br/>
                <label>Upper arm (Measure around upper arm)</label><input type="text" id="bm_bicep" name="bm_bicep" value="<?=$measurements2->bm_bicep;?>" /><br/>
                <label>Shoulder (Measure back at end of shoulder)</label><input type="text" id="bmShoulder" name="bmShoulder" value="<?=$measurements2->bmShoulder;?>" /><br/>
                
                <?
                    // edit 01-11-11
                    if($measurements2->bmFit=="Standard Fit" || $measurements2->bmFit=="Mens Standard Fit"){$fit1=" selected='selected' "; }                 
                    if($measurements2->bmFit=="Slim Fit" || $measurements2->bmFit=="Mens Slim Fit"){$fit2=" selected='selected' "; }
                    if($measurements2->bmFit=="Full Cut" || $measurements2->bmFit=="Mens Full Fit"){$fit3=" selected='selected' "; }
                    if($measurements2->bmFit=="Ladies Standard Fit"){$fit4=" selected='selected' "; }                 
                    if($measurements2->bmFit=="Ladies Slim Fit"){$fit5=" selected='selected' "; }
                    if($measurements2->bmFit=="Ladies Full Cut"){$fit6=" selected='selected' "; }
                ?>
                <label>Fit</label>
                    <select id="bmFit" name="bmFit">
                        <option value="Mens Standard Fit" <?=$fit1;?>>Mens Standard Fit</option>
                        <option value="Mens Slim Fit" <?=$fit2;?>>Mens Slim Fit</option>
                        <option value="Mens Full Cut" <?=$fit3;?>>Mens Full Cut</option>
                        <option value="Ladies Standard Fit" <?=$fit4;?>>Ladies Standard Fit</option>
                        <option value="Ladies Slim Fit" <?=$fit5;?>>Ladies Slim Fit</option>
                        <option value="Ladies Full Cut" <?=$fit6;?>>Ladies Full Cut</option>
                    </select><br/>
                    
                <label>Collar size</label><input type="text" id="bmSoftCollar" name="bmSoftCollar" value="<?=$measurements2->bmSoftCollar;?>" /><br/>
                <!--<label>Age</label><input type="text" id="" name="" /><br/>
                <label>Chest</label><input type="text" id="" name="" /><br/>-->
                <label>Height</label><input type="text" id="bm_height" name="bm_height" value="<?=$measurements2->bm_height;?>" /><br/>
                <label>Weight</label><input type="text" id="bm_weight" name="bm_weight" value="<?=$measurements2->bm_weight;?>" /><br/>
            </div>
            <input type="hidden" name="measurementsId" id="measurementsId" value="<?=$measurements2->bm_id;?>" />
            <? } //n foreach
            }   // n if(0)
            
        //--------------------------------------------------------------
            
            ?>
            <input type="hidden" name="memberId" id="memberId" value="<?=$_GET['memberId'];?>" />
            <input type="hidden" name="editOrderId" id="editOrderId" value="<?=$_GET['orderId'];?>" />
            <input type="hidden" name="editOrderSubmitted" id="editOrderSubmitted" value="true" />
            <?php smControls::smButton("Save changes","saveChanges");?>
    </fieldset>
</form>

<?php include($siteRoot."includes/admin_page_footer.php");?>