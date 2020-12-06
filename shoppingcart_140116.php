<?php
@session_start(); 
include_once('includes/globals.php');
include_once('includes/html_head.php');
include_once("forms/form_head.php");

//echo $_SESSION['measurementId']."--------";

if(empty($_SESSION['chkmemberuser'])){ // member not login 
    echo "<script language='javascript' type='text/javascript'>
            window.location='"._URL_."regisform';
        </script>";
        //alert('You are not login. Please login to your account.');
        // history.go(-1);

}else if(!empty($_SESSION['currentOrder'])){
    
    if(!empty($_POST['updateshoppingcart'])){
        $updateitems = smOrder::GetAllItems($_SESSION['currentOrder']);
        //print_r($_POST);
        foreach($updateitems as $item){
            $g = "itemQty-".$item->itemId;
            //echo $item->itemId."-".$g."-".$$g."<br/>";
            
            mysql_query("UPDATE ex_shoppingcart_items SET itemQty = '".$_POST[$g]."' WHERE shopId = '{$_SESSION['currentOrder']}' AND itemId = '{$item->itemId}' ");
            //echo "UPDATE ex_shoppingcart_items SET itemQty = '{$$g}' WHERE shopId = '{$_SESSION['currentOrder']}' AND itemId = '{$item->itemId}' <br/>";
        }
        
        echo ("<script>window.location='"._URL_."shoppingcart';</script>");
    }

    if(!empty($_GET['removeproduct']) && !empty($_GET['removeitem'])){
        smOrder::itemDelete($_SESSION['currentOrder'], $_GET['removeproduct'], $_GET['removeitem']);
        //echo $_GET['removeproduct']."-*-*-".$_SESSION['currentOrder']."-*-*-".$_GET['removeitem'];
        echo ("<script>window.location='"._URL_."shoppingcart';</script>");
    }
    
    if(!empty($_GET['removevoucher']) && !empty($_GET['removeitem'])){
        smOrder::voucherDelete($_GET['removevoucher'], $_GET['removeitem']);
        echo ("<script>window.location='"._URL_."shoppingcart';</script>");
    }
    
    if(!empty($_POST['applyVoucher'])){
        $checkVoucherCode = smVouchers::checkVoucherAvailable($_POST['inputVoucher']);
        
        if(!empty($checkVoucherCode->vouchersId)){           
            $VOUCHERDISCOUNT = $checkVoucherCode->vouchersValue;
            $hiddenvouchercode = $_POST['inputVoucher'];

            echo "<script language='javascript' type='text/javascript'>
                alert('Now you get discount from Gif Voucher £{$VOUCHERDISCOUNT}');
            </script>";

        }else{
            $hiddenvouchercode = "";
            echo "<script language='javascript' type='text/javascript'>
                alert('Your voucher code unavailable. Please try to use another code.');
            </script>";
        }
        
    }
    
    if(!empty($_POST['applyCoupon']) && !empty($_POST['inputDiscount'])){
        $checkCouponCode = smPromotion::checkCouponAvailable($_POST['inputDiscount']);
        //print_r($checkCouponCode);
        
        if(!empty($checkCouponCode->promotionId)){ //I have promotion
 
            mysql_query("UPDATE ex_shoppingcart SET shopPromotionCode = '".$_POST['inputDiscount']."' WHERE shopId = '{$_SESSION['currentOrder']}'");

            $hiddencouponcode = $_POST['inputDiscount'];

            if($checkCouponCode->promotionType == 1){   //Get Discount
 
                $PROMOTIONDISCOUND = $checkCouponCode->promotionDiscount;
                $FREESHIPPING = $checkCouponCode->promotionFreeShipping;
                
                $_SESSION['applyvoucher']=$PROMOTIONDISCOUND;
                // echo $checkCouponCode->promotionFreeShipping;

                echo "<script language='javascript' type='text/javascript'>
                    alert('Now you get discount from Promotion {$PROMOTIONDISCOUND}%');
                </script>";
            }

        }else{
            $hiddencouponcode = "";
            echo "<script language='javascript' type='text/javascript'>
                alert('Your voucher code unavailable. Please try to use another code.');
            </script>";
        }
        
    }
    
    //echo $_SESSION['currentOrder']."----<br/>";
    
    $shoppingcartdetails = smOrder::GetIndividual($_SESSION['currentOrder']);
    //print_r($shoppingcartdetails);
    
    $shoppingitems = smOrder::GetAllItems($_SESSION['currentOrder']);
    //print_r($shoppingitems);
    
}

?>

<div class="row">

    <div class="span12">
        
        <form id="" name="" method="post" action="<?=_URL_; ?>shoppingcart" enctype="multipart/form-data">
        
        <h4 style="text-align:center; font-size:15px; text-transform:uppercase;">"Click <b>Re-Calculate</b> to up date if ordering more than one of the same item" </h4><br/>
        
        <table class="table">
            <thead>
                <tr>
                    <th><span>Image</span></th>
                    <th class="desc" style="width:286px;"><span>Description</span></th>
                    <th><span>Quantity</span></th>
                    <th><span>Unit Price</span></th>
                    <th><span>Sub Price</span></th>
                    <th><span>&nbsp;</span></th>
                </tr>
            </thead>
            
            <tbody>
<?php

if(!empty($shoppingitems)){

    $a=1;  // for count item on promotion buy2get1free
        
    foreach($shoppingitems as $item){

        $productitem = smProduct::GetIndividual($item->productId);
        $fabric = smFabric::getFabric($productitem->productFabricId);
        //print_r($productitem);
        
        $subtotal = $subtotal+($item->itemPrice * $item->itemQty);
        $itemQty = "itemQty-".$item->itemId;

        if($checkCouponCode->promotionType == 1){
            $checkProductOnPromotion = smPromotion::checkProductOnPromotion1($item->productId);
            $promotiondetails = smPromotion::GetPromotion($checkProductOnPromotion->promotionId);
            //print_r($promotiondetails);

            if(!empty($_SESSION['applyvoucher'])){

                $discountpromotion = smPromotion::checkDiscountPromotion($_POST['inputDiscount']);
                //echo $discountpromotion->promotionDiscount;
                $listproductonpromotion = smPromotion::checkProductOnPromotion2($discountpromotion->promotionId, $item->productId, 1);
                
                //print_r($listproductonpromotion);
                //echo $listproductonpromotion->productId ." - ". $item->productId."<br/>";
                
                if(!empty($listproductonpromotion->productId)){
                    // price with discount
                    $discountprice = $item->itemPrice - ($item->itemPrice * $_SESSION['applyvoucher'] / 100); 
                    $showprice = "<span><span class='strike-through'>&pound;".number_format($productitem->productPrice,2)."</span><br/>&pound;".number_format($discountprice,2)."</span>";
                    
                    $discountprice2 = $discountprice2+($item->itemPrice * $item->itemQty);  
                }else{
                    $showprice = "<span>&pound;".number_format($item->itemPrice,2)."</span>";
                }

                $subtotalprice = $discountprice;
                // subtotal real price

           }else{
                $showprice = "<span>&pound;".number_format($item->itemPrice,2)."</span>";
                $subtotalprice = $item->itemPrice;
           }


        }else if($checkCouponCode->promotionType == 2){
            $showprice = "<span>&pound;".number_format($item->itemPrice,2)."</span>";
            $subtotalprice = $item->itemPrice;

        }else if($checkCouponCode->promotionType == 3){

            //$pro3buyitem = smOrder::GetAllItems($_SESSION['currentOrder']);

            $pro3freeitem = smPromotion::GetAllIndex($checkCouponCode->promotionId,2);
  
            //echo $item->productId."<br/>"; 

            foreach ($pro3freeitem as $free3) {
                
                //echo $free3."<br>";

                if($item->productId == $free3){
                
                    //echo $item->productId."-".$free3."-".$a."<br>";
                    
                    //echo $a."-".$item->productId."<br>";

                    if($a % 3 == 0){
                        //echo $item->productId."-".$free3."-".$a."<br>";

                        $freediscount += $item->itemPrice;
                        $showprice = "<span>Free</span>";
                        $subtotalprice = 0;

                    }else{

                        //echo $item->productId."-".$free3."-".$a."<br>";
                         
                        $showprice = "<span>&pound;".number_format($item->itemPrice,2)."</span>";

                        $subtotalprice = $item->itemPrice;
                    }

                    $a++;
                    
                }else{

                    $sql = mysql_query("SELECT * FROM ex_promotion_index WHERE promotionId = '$checkCouponCode->promotionId' AND productId = '$item->productId' ");
                    $cntsql = mysql_num_rows($sql);

                    if($cntsql<1){
                        $showprice = "<span>&pound;".number_format($item->itemPrice,2)."</span>";

                        $subtotalprice = $item->itemPrice;
                    }else{

                    }

                }

            }


        }else{  // not on promotion

            $showprice = "<span>&pound;".number_format($item->itemPrice,2)."</span>";
            $subtotalprice = $item->itemPrice;
        }

    
        if($productitem->productCategoryId==8){
            $forLadies = "<span style='color:#B88AB4;'>(for LADIES)</span>";
        }else{
            $forLadies = "";
        }
    
        if(empty($item->itemOnPromotion) || $item->itemOnPromotion==0){ // main item
            
            $h=1;


            //if($checkCouponCode->promotionType == 1 || empty($checkCouponCode->promotionType)){

        ?>

            <tr>
                <td>
                    <?php
                    if(!empty($productitem->productMainPicture)){ 
                        $showPic = $productitem->productMainPicture;
                        
                    }else if(!empty($productitem->productFabricPicture)){
                        $showPic = $productitem->productFabricPicture;
                    }
                    ?>
                    
                    <img src="<?=_URL_; ?>upload_pictures/<?=$showPic;?>" alt="<?=$productitem->productTitle;?>" title="<?=$productitem->productTitle;?>" width="108" />
                </td>
                <td class="desc">
                    <h4><a class="invarseColor"><?=$productitem->productTitle." ".$forLadies;?></a></h4>
                    <ul class="unstyled">
                        <li><span class="textblue"><?=$fabric->fabricName;?></span></li>
                        <li>No. <?=$productitem->productRefCode;?></li>
                        <?php
                        if(!empty($item->itemSpecialDetails)){
                            echo "<li><span class='txtred'>*</span> {$item->itemSpecialDetails}</li>";
                        }
                        ?>
                    </ul>
                </td>
                <td class="quantity">
                    <input type="text" name="<?php echo $itemQty; ?>" id="<?php echo $itemQty; ?>" value="<?php echo $item->itemQty; ?>" readonly='readonly' />
                </td>
                <td class="sub-price"><h2><?php echo $showprice;?></h2></td>
                <td class="total-price">
                    <h2>&pound;<?=number_format($subtotalprice * $item->itemQty, 2);?></h2>
                </td>
                <td>
                    <!--<button type="submit" class="btn btn-small" data-title="Re-calculate" data-placement="top" data-tip="tooltip" data-original-title=""><i class="icon-refresh"></i></button>-->
                    <label onclick="window.location='<?=_URL_;?>shoppingcart?removeproduct=<?=$productitem->productId;?>&amp;removeitem=<?=$item->itemId;?>'" class="btn btn-small btn-danger" data-title="Remove" data-placement="top" data-tip="tooltip" data-original-title=""><i class="icon-trash"></i></label>
                </td>
            </tr>

        <?php

            //}else if($checkCouponCode->promotionType == 3){

            //}

        }else{  // for product on promotion get free item
            
            if($h==1){
            ?>
            <tr>
                <td>
                    <?php
                    if(!empty($productitem->productMainPicture)){ 
                        $showPic = $productitem->productMainPicture;
                        
                    }else if(!empty($productitem->productFabricPicture)){
                        $showPic = $productitem->productFabricPicture;
                    }
                    ?>
                    <img src="<?=_URL_; ?>upload_pictures/<?=$showPic; ?>" alt="<?=$productitem->productTitle;?>" title="<?=$productitem->productTitle;?>" width="108" />
                </td>
                <td class="desc">
                    <h4><a class="invarseColor"><?=$productitem->productTitle;?></a></h4>
                    <ul class="unstyled">
                        <li><span class="textblue"><?=$fabric->fabricName;?></span></li>
                        <li>No. <?=$productitem->productRefCode;?></li>
                    </ul>
                </td>
                <td class="quantity"><a class="invarseColor">1</a></td>
                <td class="sub-price"><h2>Free</h2></td>
                <td class="total-price"><h2>Free</h2></td>
                <td>&nbsp;</td>
            </tr>
            <?php
                $h=0;
            } // chech h
        }

    }   // n foreach items
} // n if !empty $shoppingitems

/*
if(!empty($_SESSION['currentOrder'])){
    
    $getVoucherOnCart = smVouchers::getVoucherOnCart($_SESSION['currentOrder']);
    
    if(!empty($getVoucherOnCart)){
        // print_r($getVoucherOnCart);
        
        foreach($getVoucherOnCart as $item){
            $voucherdetails = smVouchers::GetIndividual($item->vouchersId);
            //print_r($voucherDetails);
            $VOUCHERPRICE = $VOUCHERPRICE+$voucherdetails->vouchersValue
            ?>
            <tr>
                <td>&nbsp;</td>
                <td class="desc">
                    <h4><a class="invarseColor">
                        Gif Voucher &pound;<?=number_format($voucherdetails->vouchersValue, 2);?>
                    </a></h4>
                </td>
                <td class="quantity">
                    <span>1</span>
                </td>
                <td class="sub-price">
                    <h2>&pound;<?=number_format($voucherdetails->vouchersValue, 2);?></h2>
                </td>
                <td class="total-price">
                    <h2>&pound;<?=number_format($voucherdetails->vouchersValue, 2);?></h2>
                </td>
                <td>
                    <button onclick="window.location='<?=_URL_;?>shoppingcart?removevoucher=<?=$voucherdetails->vouchersId;?>&amp;removeitem=<?=$item->itemId;?>'" class="btn btn-small btn-danger" data-title="Remove" data-placement="top" data-tip="tooltip" data-original-title=""><i class="icon-trash"></i></button>
                </td>
            </tr>
            
        <?php    
        }   // n foreach

    }else{
        $VOUCHERPRICE = 0;
    }

}
*/

?>
                
            </tbody>
        </table>
        
        <br />
        <input type="hidden" id="updateshoppingcart" name="updateshoppingcart" value="true" />
        
            <center><button type="submit" class="btn btn-primary" data-title="Re-calculate" data-placement="top" data-tip="tooltip" data-original-title=""><i class="icon-refresh"></i> Re-Calculate</button></center>
        
        </form>

        
    </div><!--end span12-->

    <div class="span7">
        <div id="cart-tab">
            
            <ul class="nav nav-tabs">
                <li class="">
                    <a href="#dis-code" data-toggle="tab">Apply Promotion Code</a>
                </li><!--
                <li class="active">
                    <a href="#gift-vouc" data-toggle="tab">Use Gift Voucher</a>
                </li>-->
            </ul>

            <div class="tab-content">
                
                <div class="tab-pane active" id="dis-code">
                    <form method="post" id="applyCouponForm" name="applyCouponForm" action="<?=_URL_; ?>shoppingcart" class="form-horizontal">
                        
                        <div class="control-group">
                            <h4 style="text-align:center; font-size:15px; text-transform:uppercase;">If you have a promotion code please enter at here.</h4><br/>
           
                            <label class="control-label" for="inputDiscount">
                                <strong>Promotion Code</strong>
                            </label>
                            <div class="controls">
                                <input type="text" id="inputDiscount" name="inputDiscount" placeholder="Enter Promotion Code...">
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <div class="controls">
                                <input type="hidden" id="applyCoupon" name="applyCoupon" value="true" />
                                <button type="submit" class="btn btn-primary">Apply Coupon</button>
                            </div>
                        </div>
                        
                    </form>
                </div>

                <!--
                <div class="tab-pane active" id="gift-vouc">
                    <form method="post" id="applyVoucherForm" name="applyVoucherForm" action="<?//=_URL_; ?>shoppingcart" class="form-horizontal">
                        
                        <div class="control-group">
                            <label class="control-label" for="inputVoucher">
                                <strong>Voucher Code</strong>
                                </label>
                            <div class="controls">
                                <input type="text" id="inputVoucher" name="inputVoucher" value="" placeholder="Enter Voucher Code..." />
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <div class="controls">
                                <input type="hidden" id="applyVoucher" name="applyVoucher" value="true" />
                                <button type="submit" class="btn btn-primary">Apply Voucher</button>
                            </div>
                        </div>
                        
                    </form>
                </div>
                -->

            </div><!--end tab-content-->

        </div><!--end cart-tab-->
    </div><!--end span7-->

    <form method="post" id="checkoutForm" name="checkoutForm" action="<?=_URL_; ?>checkout" enctype="multipart/form-data">
        <div class="span5">
            <div class="cart-receipt">
                <table class="table table-receipt">
                    <?php
                    // $VOUCHERPRICE for order voucher
                    // $VOUCHERDISCOUNT for enter voucher code
                    
                    if(!empty($_SESSION['applyvoucher'])){
                        
                        //$subtotal1 = $subtotal - ($subtotal * $_SESSION['applyvoucher'] /100) +$VOUCHERPRICE;
                        $subtotal1 = $subtotal;
                        
                        $PROMOTIONDISCOUND1 = number_format($discountprice2 * $_SESSION['applyvoucher'] /100,2);
                        
                        if($FREESHIPPING == 1){ //echo "--1----";
                            $SHIPPING=0;
                            $SHIPPINGTEXT="FREE";
                        }else{ //echo "--2----";
                            $SHIPPING=5;
                            $SHIPPINGTEXT="&pound;5";
                        }
                        
                        
                    }else{

                        if($checkCouponCode->promotionType == 3){
                            $subtotal1 = $subtotal;
                            $PROMOTIONDISCOUND1 = number_format($freediscount,2);

                        }else{
                            $subtotal1 = $subtotal+$VOUCHERPRICE;
                            $PROMOTIONDISCOUND1 = 0;
                        }
                        
                        if(!empty($showprice)){
                            $SHIPPING=5;
                            $SHIPPINGTEXT="&pound;5";
                        }else{
                            $SHIPPING=0;
                            $SHIPPINGTEXT="FREE";
                        }
                    }
                    
                    $subtotal1 = $subtotal+$VOUCHERPRICE;
                    //$VAT=0;
                    
                    // EDIT 30/7/14
                    // $TOTAL=$subtotal+$SHIPPING+$VOUCHERPRICE-$PROMOTIONDISCOUND1-$VOUCHERDISCOUNT;
                    $TOTAL=$subtotal+$SHIPPING-$PROMOTIONDISCOUND1;
                    ?>
                    <tbody>
                        <tr>
                            <td class="alignRight">Subtotal</td>
                            <td class="alignLeft">&pound;<?=number_format($subtotal1, 2); ?></td>
                        </tr>
                        <tr>
                            <td class="alignRight">Promotion Discount</td>
                            <td class="alignLeft">&pound;<?=number_format($PROMOTIONDISCOUND1, 2); ?></td>
                        </tr>
                        <!--<tr>
                            <td class="alignRight">Voucher Discound</td>
                            <td class="alignLeft">&pound;<?//=number_format($VOUCHERDISCOUNT, 2); ?></td>
                        </tr>-->
                        <!--<tr>
                            <td class="alignRight">VAT</td>
                            <td class="alignLeft">&pound;12.00</td>
                        </tr>-->
                        <tr>
                            <td class="alignRight">Shipping</td>
                            <td class="alignLeft"><?=$SHIPPINGTEXT; ?></td>
                        </tr>
                        <tr>
                            <td class="alignRight"><h2>Total</h2></td>
                            <td class="alignLeft"><h2>&pound;<?=number_format($TOTAL, 2); ?></h2></td>
                        </tr>
                        <tr>
                            <td class="alignRight">
                                <input type="image" src="https://www.paypal.com/en_GB/i/btn/btn_buynowCC_LG.gif" alt="Make payments with PayPal - it's fast, free and secure!" style="cursor:pointer;" />
                            </td>
                            <td class="alignLeft">
                                <input class="btn btn-primary" type="submit" id="payDirect" name="payDirect" value="Pay via telephone" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Pay via the telephone by calling <span class="textblue"><?=$siteContactNumber; ?></span> and talking with one of our representatives. Or pay online by <span class="textblue">PayPal.</span></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label class="btn" onclick="window.location='<?=_URL_; ?>collection'">Continue Shoping</label>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div><!--end span5-->
        
        <input id="actionvouchercode" name="actionvouchercode" type="hidden" value="<?=$hiddenvouchercode;?>" />
        <input id="actiontotalprice" name="actiontotalprice" type="hidden" value="<?=$TOTAL;?>" />
    </form>

</div>

<?php
/*
}else{
    echo "<script language='javascript'  type='text/javascript'>
            alert('This Email already used. Please try to use another email.');
           history.go(-1)
        </script>";
}
*/
include_once('forms/form_end.php');

?>