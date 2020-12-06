<?php
@session_start();
include_once('includes/globals.php');
include_once('includes/html_head.php');
include_once("forms/form_head.php");


$is_promotion_free = false;
//echo $_SESSION['measurementId']."--------";

if (empty($_SESSION['chkmemberuser'])) { // member not login 
    echo "<script language='javascript' type='text/javascript'>
            window.location='" . _URL_ . "regisform';
        </script>";
    //alert('You are not login. Please login to your account.');
    // history.go(-1);
} else if (!empty($_SESSION['currentOrder'])) {

    if (!empty($_POST['updateshoppingcart'])) {
        $updateitems = smOrder::GetAllItems($_SESSION['currentOrder']);
        //print_r($updateitems);exit();
        foreach ($updateitems as $item) {
            $g = "itemQty-" . $item->itemId;
            //echo $item->itemId."-".$g."-".$$g."<br/>";

            if ($_POST[$g] > 0) {
                mysql_query("UPDATE ex_shoppingcart_items SET itemQty = '" . $_POST[$g] . "' WHERE shopId = '{$_SESSION['currentOrder']}' AND itemId = '{$item->itemId}' ");
                //echo "UPDATE ex_shoppingcart_items SET itemQty = '{$$g}' WHERE shopId = '{$_SESSION['currentOrder']}' AND itemId = '{$item->itemId}' <br/>";
                //check number qty for free item
                checkUpdateFreeItem($item->shopId, $item->productId, $item->itemQty);
            }
        }

        echo ("<script>window.location='" . _URL_ . "shoppingcart';</script>");
    }

    if (!empty($_GET['removeproduct']) && !empty($_GET['removeitem'])) {
        smOrder::itemDelete($_SESSION['currentOrder'], $_GET['removeproduct'], $_GET['removeitem']);
        //echo $_GET['removeproduct']."-*-*-".$_SESSION['currentOrder']."-*-*-".$_GET['removeitem'];
        echo ("<script>window.location='" . _URL_ . "shoppingcart';</script>");
    }

    if (!empty($_GET['removevoucher']) && !empty($_GET['removeitem'])) {
        smOrder::voucherDelete($_GET['removevoucher'], $_GET['removeitem']);
        echo ("<script>window.location='" . _URL_ . "shoppingcart';</script>");
    }

    if (!empty($_POST['applyVoucher'])) {
        $checkVoucherCode = smVouchers::checkVoucherAvailable($_POST['inputVoucher']);

        if (!empty($checkVoucherCode->vouchersId)) {
            $VOUCHERDISCOUNT = $checkVoucherCode->vouchersValue;
            $hiddenvouchercode = $_POST['inputVoucher'];

            echo "<script language='javascript' type='text/javascript'>
                alert('Now you get discount from Gif Voucher £{$VOUCHERDISCOUNT}');
            </script>";
        } else {
            $hiddenvouchercode = "";
            echo "<script language='javascript' type='text/javascript'>
                alert('Your voucher code unavailable. Please try to use another code.');
            </script>";
        }
    }

    if (!empty($_POST['applyCoupon']) && !empty($_POST['inputDiscount'])) {
        $checkCouponCode = smPromotion::checkCouponAvailable($_POST['inputDiscount']);
        //print_r($checkCouponCode);

        if (!empty($checkCouponCode->promotionId)) { //I have promotion

            mysql_query("UPDATE ex_shoppingcart SET shopPromotionCode = '" . $_POST['inputDiscount'] . "' WHERE shopId = '{$_SESSION['currentOrder']}'");

            $hiddencouponcode = $_POST['inputDiscount'];

            if ($checkCouponCode->promotionType == 1) {   //Get Discount

                if ($checkCouponCode->promotionType2 == 1) {
                    $PROMOTIONDISCOUND = $checkCouponCode->promotionDiscount;
                    $FREESHIPPING = $checkCouponCode->promotionFreeShipping;
                    //$FREESHIPPING = 1;

                    $_SESSION['applyvoucher'] = $PROMOTIONDISCOUND;
                    // echo $checkCouponCode->promotionFreeShipping;

                    if ($FREESHIPPING == 1) {
                        echo "<script language='javascript' type='text/javascript'>
                        alert('Now you get free delivery  promotion ');
                    </script>";
                    } else {
                        echo "<script language='javascript' type='text/javascript'>
                        alert('Now you get discount from Promotion {$PROMOTIONDISCOUND}%');
                    </script>";
                    }
                } else {
                    $PROMOTIONDISCOUND = $checkCouponCode->promotionDiscount;
                    $FREESHIPPING = $checkCouponCode->promotionFreeShipping;
                    //$FREESHIPPING = 0;

                    $_SESSION['applyvoucher'] = $PROMOTIONDISCOUND;
                    // echo $checkCouponCode->promotionFreeShipping;

                    echo "<script language='javascript' type='text/javascript'>
                        alert('Now you get discount from Promotion {$PROMOTIONDISCOUND}%');
                    </script>";
                }
            }
        } else {
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
<div class="container">
<div class="row">

    <div class="span12">

        <form id="" name="" method="post" action="<?= _URL_; ?>shoppingcart" enctype="multipart/form-data">

            <h4 style="text-align:center; font-size:px; text-transform:uppercase;">"Click <b>Re-Calculate</b> to up date if ordering more than one of the same item" </h4><br />
            <div class="table-responsive">
            <table class="table table-bordered ">
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

                    if (!empty($shoppingitems)) {

                        $a = 1;  // for count item on promotion buy2get1free
                        $qtyCountCheck2free1 = 0;

                        foreach ($shoppingitems as $item) {
                            $realPriceOfItem = 0;
                            $check2free1 = false;
                            $productitem = smProduct::GetIndividual($item->productId);
                            $fabric = smFabric::getFabric($productitem->productFabricId);
                            //print_r($productitem);

                            $subtotal = $subtotal + ($item->itemPrice * $item->itemQty);
                            $itemQty = "itemQty-" . $item->itemId;

                            if ($checkCouponCode->promotionType == 1) {
                                $checkProductOnPromotion = smPromotion::checkProductOnPromotion1($item->productId);
                                $promotiondetails = smPromotion::GetPromotion($checkProductOnPromotion->promotionId);
                                //print_r($promotiondetails);

                                if (!empty($_SESSION['applyvoucher'])) {

                                    $discountpromotion = smPromotion::checkDiscountPromotion($_POST['inputDiscount']);
                                    //echo $discountpromotion->promotionDiscount;
                                    $listproductonpromotion = smPromotion::checkProductOnPromotion2($discountpromotion->promotionId, $item->productId, 1);

                                    //print_r($listproductonpromotion);
                                    //echo $listproductonpromotion->productId ." - ". $item->productId."<br/>";

                                    if (!empty($listproductonpromotion->productId)) {
                                        // price with discount
                                        $discountprice = $item->itemPrice - ($item->itemPrice * $_SESSION['applyvoucher'] / 100);
                                        $showprice = "<span><span class='strike-through'>&pound;" . number_format($productitem->productPrice, 2) . "</span><br/>&pound;" . number_format($discountprice, 2) . "</span>";

                                        $discountprice2 = $discountprice2 + ($item->itemPrice * $item->itemQty);
                                    } else {
                                        $showprice = "<span>&pound;" . number_format($item->itemPrice, 2) . "</span>";
                                    }

                                    $subtotalprice = ($discountprice2 * (1 - ($_SESSION['applyvoucher'] / 100)));
                                    // subtotal real price
                                } else {
                                    $showprice = "<span>&pound;" . number_format($item->itemPrice, 2) . "</span>";
                                    $subtotalprice = $item->itemPrice;
                                }
                            } else if ($checkCouponCode->promotionType == 2) {
                                $showprice = "<span>&pound;" . number_format($item->itemPrice, 2) . "</span>";
                                $subtotalprice = $item->itemPrice;
                            } else if ($checkCouponCode->promotionType == 3) {
                                $check2free1 = true;
                                //$pro3buyitem = smOrder::GetAllItems($_SESSION['currentOrder']);

                                $pro3freeitem = smPromotion::GetAllIndex($checkCouponCode->promotionId, 2);

                                //echo $item->productId."<br/>"; 

                                foreach ($pro3freeitem as $free3) {

                                    //echo $free3."=============<br>";

                                    if ($item->productId == $free3) {

                                        //echo $item->productId."-".$free3."-".$a."<br>";

                                        //echo $a."-".$item->productId."<br>";

                                        if ($item->itemQty >= 3) {
                                            $realPriceOfItem = $item->itemPrice * $item->itemQty;
                                            $minusItem = floor($item->itemQty / 3);
                                            $subtotalprice = $item->itemPrice * ($item->itemQty - $minusItem);
                                            $freediscount = $freediscount + ($item->itemPrice * $minusItem);

                                            $itemBalance = $item->itemQty - (3 * $minusItem);
                                            $qtyCountCheck2free1 = $itemBalance;
                                        } else {

                                            $qtyCountCheck2free1 += $item->itemQty;
                                            //echo $qtyCountCheck2free1.'+';
                                            if ($qtyCountCheck2free1 >= 3) {
                                                $realPriceOfItem = $item->itemPrice * $item->itemQty;
                                                $minusItem = floor($item->itemQty / 3);

                                                $minusItem = ($minusItem <= 0) ? 1 : $minusItem;
                                                //echo $minusItem.'=';                            
                                                $subtotalprice = $item->itemPrice * ($item->itemQty - $minusItem);
                                                $freediscount = $freediscount + ($item->itemPrice * $minusItem);

                                                $num1 = $item->itemQty;
                                                $num2 = 3 * $minusItem;
                                                if ($num1 > $num2) {
                                                    $itemBalance = $num1 - $num2;
                                                } else {
                                                    $itemBalance = $num2 - $num1;
                                                }
                                                //$itemBalance = $item->itemQty - ( 3 * $minusItem );
                                                $qtyCountCheck2free1 = ($qtyCountCheck2free1 == 3) ? 0 : $itemBalance;
                                                //echo $itemBalance.'*';
                                            } else {
                                                $realPriceOfItem = 0;
                                                $subtotalprice = $item->itemPrice * $item->itemQty;
                                            }
                                        }

                                        /*
                    if($a % 3 == 0){
                        $freediscount += $item->itemPrice;
                        //$showprice = "<span>Free</span>";
                        $subtotalprice = 0;
                    }else{
                        //$showprice = "<span>&pound;".number_format($item->itemPrice,2)."</span>";
                        $subtotalprice = $item->itemPrice;
                    }
                    $a++;
                     */

                                        $showprice = "<span>&pound;" . number_format($item->itemPrice, 2) . "</span>";
                                    } else {

                                        $sql = mysql_query("SELECT * FROM ex_promotion_index WHERE promotionId = '$checkCouponCode->promotionId' AND productId = '$item->productId' ");
                                        $cntsql = mysql_num_rows($sql);

                                        if ($cntsql < 1) {
                                            $showprice = "<span>&pound;" . number_format($item->itemPrice, 2) . "</span>";

                                            $subtotalprice = $item->itemPrice * $item->itemQty;
                                        } else {
                                        }
                                    }
                                } //foreach
                            } else {  // not on promotion

                                $showprice = "<span>&pound;" . number_format($item->itemPrice, 2) . "</span>";
                                $subtotalprice = $item->itemPrice * $item->itemQty;
                            }


                            if ($productitem->productCategoryId == 8) {
                                $forLadies = "<span style='color:#B88AB4;'>(for LADIES)</span>";
                            } else {
                                $forLadies = "";
                            }

                            if (empty($item->itemOnPromotion) || $item->itemOnPromotion == 0) { // main item

                                $h = 1;


                                //if($checkCouponCode->promotionType == 1 || empty($checkCouponCode->promotionType)){

                    ?>

                                <tr>
                                    <td>
                                        <?php
                                        if (!empty($productitem->productMainPicture)) {
                                            $showPic = $productitem->productMainPicture;
                                        } else if (!empty($productitem->productFabricPicture)) {
                                            $showPic = $productitem->productFabricPicture;
                                        }
                                        ?>

                                        <img src="<?= _URL_; ?>upload_pictures/<?= $showPic; ?>" alt="<?= $productitem->productTitle; ?>" title="<?= $productitem->productTitle; ?>" width="108" />
                                    </td>
                                    <td class="desc">
                                        <h4><a class="invarseColor"><?= $productitem->productTitle . " " . $forLadies; ?></a></h4>
                                        <ul class="unstyled">
                                            <li><span class="textblue"><?= $fabric->fabricName; ?></span></li>
                                            <li>No. <?= $productitem->productRefCode; ?></li>
                                            <?php
                                            if (!empty($item->itemSpecialDetails)) {
                                                echo "<li><span class='txtred'>*</span> {$item->itemSpecialDetails}</li>";
                                            }
                                            ?>
                                        </ul>
                                    </td>
                                    <td class="quantity">
                                        <input type="text"class="contactus-input form-control" name="<?php echo $itemQty; ?>" id="<?php echo $itemQty; ?>" value="<?php echo $item->itemQty; ?>" <?php  /* readonly style="background: none;border: none;color: #004990;" */ ?>  />
                                    </td>
                                    <td class="sub-price">
                                        <h3><?php echo $showprice; ?></h3>
                                    </td>
                                    <td class="total-price">
                                        <h3>
                                            <?php
                                            if ($realPriceOfItem > 0) {
                                                echo '<s style="color:red;">&pound; ' . $realPriceOfItem . '</s><br>';
                                            }
                                            //echo '&pound;'.number_format($subtotalprice * $item->itemQty, 2);
                                            echo '&pound;' . number_format($subtotalprice, 2);
                                            ?>
                                        </h3>
                                    </td>
                                    <td>
                                        <!--<button type="submit" class="btn btn-small" data-title="Re-calculate" data-placement="top" data-tip="tooltip" data-original-title=""><i class="icon-refresh"></i></button>-->
                                        <label onclick="window.location='<?= _URL_; ?>shoppingcart?removeproduct=<?= $productitem->productId; ?>&amp;removeitem=<?= $item->itemId; ?>'" class="btn btn-small btn-danger" data-title="Remove" data-placement="top" data-tip="tooltip" data-original-title=""><i class="icon-trash"></i></label>
                                    </td>
                                </tr>

                                <?php

                                //}else if($checkCouponCode->promotionType == 3){

                                //}
                            } else {  // for product on promotion get free item
                                $is_promotion_free = true;
                                if ($h == 1) {
                                ?>
                                    <tr>
                                        <td>
                                            <?php
                                            if (!empty($productitem->productMainPicture)) {
                                                $showPic = $productitem->productMainPicture;
                                            } else if (!empty($productitem->productFabricPicture)) {
                                                $showPic = $productitem->productFabricPicture;
                                            }
                                            ?>
                                            <img src="<?= _URL_; ?>upload_pictures/<?= $showPic; ?>" alt="<?= $productitem->productTitle; ?>" title="<?= $productitem->productTitle; ?>" width="108" />
                                        </td>
                                        <td class="desc">
                                            <h4><a class="invarseColor"><?= $productitem->productTitle; ?></a></h4>
                                            <ul class="unstyled">
                                                <li><span class="textblue"><?= $fabric->fabricName; ?></span></li>
                                                <li>No. <?= $productitem->productRefCode; ?></li>
                                            </ul>
                                        </td>
                                        <td class="quantity"><a class="invarseColor"><?= $item->itemQty; ?></a></td>
                                        <td class="sub-price">
                                            <h2>Free</h2>
                                        </td>
                                        <td class="total-price">
                                            <h2>Free</h2>
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                    <?php
                                    $h = 0;
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
        </div>

            <br />
            <input type="hidden" id="updateshoppingcart" name="updateshoppingcart" value="true" />

            <center><button type="submit" class="btn btn-default-shop" data-title="Re-calculate" data-placement="top" data-tip="tooltip" data-original-title=""><i class="icon-refresh"></i> Re-Calculate</button></center>

        </form>


    </div><br><br>
    <!--end span12-->
    <div class="row">
    <div class="span7">
        <?php if ($is_promotion_free == false) : ?>

            <div id="cart-tab">

                <!-- <ul class="nav nav-tabs">
                    <li class="">
                        <a href="#dis-code" data-toggle="tab">Apply Promotion Code</a>
                    </li> -->
                    
                <!-- </ul> -->

             <div class="col-lg-6 col-md-6 col-sm-6 sol-xs-6" style="margin-bottom:15px;">
                <div class="tab-content">

                    <div class="tab-pane active" id="dis-code">
                        <form method="post" id="applyCouponForm" name="applyCouponForm" action="<?= _URL_; ?>shoppingcart" class="form-horizontal">
                            
                            <!-- <div class="form-group">
                           <label  for="email">Email:</label>
                           <div class="col-sm-10 col-xs-10">
                          <input type="email" class="form-control" id="email" placeholder="Enter email">
                         </div>
                          </div> -->
                            <div class="control-group">
                                <h4 style="text-align:center; font-size:px; text-transform:uppercase;">If you have a promotion code please enter at here. (ONLY ONE PROMOTION CODE PER ORDER)</h4><br />

                                <label class="control-label col-sm-2 col-xs-2" for="inputDiscount">
                                    <strong>Promotion Code</strong>
                                </label>
                                <div class="controls col-sm-10 col-xs-10">
                                    <input type="text" id="inputDiscount" name="inputDiscount" placeholder="Enter Promotion Code..." class="form-control
                                    contactus-input">
                                </div>
                            </div>

                            <div class="control-group">
                                <div class="controls">
                                    <input type="hidden" id="applyCoupon" name="applyCoupon" value="true" /><br><br>
                                    <center><button type="submit" class="btn btn-default-shop">Apply Coupon</button></center>
                                </div>
                            </div>

                        </form>
                    </div>

                    <!--
                <div class="tab-pane active" id="gift-vouc">
                    <form method="post" id="applyVoucherForm" name="applyVoucherForm" action="<? ?>shoppingcart" class="form-horizontal">
                        
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

                </div>
            </div>

                <!--end tab-content-->

            </div>
            <!--end cart-tab-->
        <?php endif; ?>
    </div>
    <!--end span7-->
     
    <div class="col-lg-6 col-md-6 col-sm-6 sol-xs-6">
    <form method="post" id="checkoutForm" name="checkoutForm" action="<?= _URL_; ?>checkout" enctype="multipart/form-data">
        <div class="span5">
            <div class="cart-receipt">
                <table class="table table-receipt">
                    <?php
                    // $VOUCHERPRICE for order voucher
                    // $VOUCHERDISCOUNT for enter voucher code

                    if (!empty($_SESSION['applyvoucher'])) {

                        //$subtotal1 = $subtotal - ($subtotal * $_SESSION['applyvoucher'] /100) +$VOUCHERPRICE;
                        $subtotal1 = $subtotal;

                        $PROMOTIONDISCOUND1 = number_format($discountprice2 * $_SESSION['applyvoucher'] / 100, 2);

                        if ($FREESHIPPING == 1) { //echo "--1----";
                            $SHIPPING = 0;
                            $SHIPPINGTEXT = "FREE";
                        } else { //echo "--2----";
                            $SHIPPING = 6.95;
                            $SHIPPINGTEXT = "&pound;6.95";
                        }
                    } else {

                        if ($checkCouponCode->promotionType == 3) {
                            $subtotal1 = $subtotal;
                            $PROMOTIONDISCOUND1 = number_format($freediscount, 2);
                        } else {
                            $subtotal1 = $subtotal + $VOUCHERPRICE;
                            $PROMOTIONDISCOUND1 = 0;
                        }

                        /* Edited by POP / 29 Nov 2017 */
                        if ($FREESHIPPING == 1 || $subtotal1 == 0) {
                            $SHIPPING = 0;
                            $SHIPPINGTEXT = "FREE";
                        } else {

                            $SHIPPING = 6.95;
                            $SHIPPINGTEXT = "&pound;6.95";
                        }
                    }

                    $subtotal1 = $subtotal + $VOUCHERPRICE;
                    //$VAT=0;

                    // EDIT 30/7/14
                    // $TOTAL=$subtotal+$SHIPPING+$VOUCHERPRICE-$PROMOTIONDISCOUND1-$VOUCHERDISCOUNT;
                    $TOTAL = $subtotal + $SHIPPING - $PROMOTIONDISCOUND1;
                    ?>
                    <tbody>
                        <tr>
                            <td class="alignRight">Subtotal</td>
                            <td class="alignLeft">&pound;<?= number_format($subtotal1, 2); ?></td>
                        </tr>
                        <tr>
                            <td class="alignRight">Promotion Discount</td>
                            <td class="alignLeft">&pound;<?= number_format($PROMOTIONDISCOUND1, 2); ?></td>
                        </tr>
                        <!--<tr>
                            <td class="alignRight">Voucher Discound</td>
                            <td class="alignLeft">&pound;<? ?></td>
                        </tr>-->
                        <!--<tr>
                            <td class="alignRight">VAT</td>
                            <td class="alignLeft">&pound;12.00</td>
                        </tr>-->
                        <tr>
                            <td class="alignRight">Shipping</td>
                            <td class="alignLeft"><?= $SHIPPINGTEXT; ?></td>
                        </tr>
                        <tr>
                            <td class="alignRight">
                                <h2>Total</h2>
                            </td>
                            <td class="alignLeft">
                                <h2>&pound;<?= number_format($TOTAL, 2); ?></h2>
                            </td>
                        </tr>
                        <tr>
                            <td class="alignCenter" colspan="2">
                                <input type="image" src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-large.png" alt="Make payments with PayPal - it's fast, free and secure!" style="cursor:pointer;" />
                                <?php /*
                                <h6 style="">OR</h6>

                                <input class="btn btn-primary" type="submit" id="payDirect" name="payDirect" value="Pay via telephone" />
                                
                                <h6 style="">OR</h6>


                                <input type="button" class="btn btn-primary" id="payPaymentSenseButton" value="To pay securely by" />
                                <img src="<?= _URL_ ?>styles/all-major-cards-accepted.jpg" alt="All major cards accepted">

                                */ ?>
                            </td>

                        </tr>
                        <?php /*
                        <tr>
                            <td colspan="2">Pay via the telephone by calling <span class="textblue"><?= $siteContactNumber; ?></span> and talking with one of our representatives. Or pay online by <span class="textblue">PayPal.</span></td>
                        </tr>
                        */ ?>
                        <tr>
                            <td colspan="2">
                                <label class="btn btn-default-shop" onclick="window.location='<?= _URL_; ?>collection'">Continue Shopping</label>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!--end span5-->

        <input id="actionvouchercode" name="actionvouchercode" type="hidden" value="<?= $hiddenvouchercode; ?>" />
        <input id="actiontotalprice" name="actiontotalprice" type="hidden" value="<?= $TOTAL; ?>" />
        <input id="payPaymentSense" name="payPaymentSense" type="hidden" value="n" />

    </form>
     </div>
    </div>

    <?php
    /*
    // Sut up PaymentSense Form


    $BodyAttributes = "";
    $FormAttributes = "";
    $FormAction = "PaymentForm.php";



    $Amount =  number_format($TOTAL, 2);

    $CurrencyShort = "826";
    $OrderID = $_SESSION['currentOrder'];
    $OrderDescription = "Exact Personal Tailoring Order (id-{$_SESSION['currentOrder']})";
    $_SESSION['memberDetails'] = smUser::GetIndividual($_SESSION['chkmemberuser']);

    ?>
    <form name="paymentSenseForm" id="paymentSenseForm" action="<?= _URL_ ?>PMSSKIN/Process.php" method="post">
        <input type="hidden" name="amount" value="<?php echo $Amount ?>" />
        <input type="hidden" name="currency_code" value="<?php echo $CurrencyShort ?>" />
        <input type="hidden" name="order_id" value="<?php echo $OrderID ?>" />
        <input type="hidden" name="order_description" value="<?php echo $OrderDescription ?>" />

        <input type="hidden" name="customer_name" value="<?php echo $_SESSION['memberDetails']->usFirstname . '  ' . $_SESSION['memberDetails']->usLastname ?>" />
        <input type="hidden" name="address_line_1" value="<?php echo $_SESSION['memberDetails']->usAddress; ?>" />
        <input type="hidden" name="address_line_2" value="<?php echo $_SESSION['memberDetails']->usAddress2; ?>" />
        <input type="hidden" name="address_line_3" value="<?php echo $_SESSION['memberDetails']->usAddress3; ?>" />
        <input type="hidden" name="city" value="<?php echo $_SESSION['memberDetails']->usCity; ?>" />
        <input type="hidden" name="state" value="" />
        <input type="hidden" name="post_code" value="<?php echo $_SESSION['memberDetails']->usPostcode; ?>" />
        <input type="hidden" name="country_code" value="826" />
        <input type="hidden" name="email_address" value="<?php echo $_SESSION['memberDetails']->usEmail; ?>" />
        <input type="hidden" name="phone_number" value="<?php echo $_SESSION['memberDetails']->usTelephone; ?>" />
        <input type="hidden" name="actionvouchercode" id="vcCodePMS" value="" />




    </form>

    <?php */    ?>
    <script type="text/javascript">
        $(function() {
            $('#payPaymentSenseButton').click(function() {
                $('#payPaymentSense').val('y');
                $('#checkoutForm').submit();
            });

        });
    </script>
</div>
</div>
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

    fbq('track', 'InitiateCheckout');
</script>
<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1069763303102834&ev=PageView&noscript=1" /></noscript>
<!-- End Facebook Pixel Code -->

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

function checkUpdateFreeItem($shopId = 0, $mainProId = 0, $qty = 0)
{
    $sql = "SELECT * FROM ex_shoppingcart_items WHERE shopId = '" . $shopId . "' AND itemPrice <= '0' AND itemOnPromotion = '" . $mainProId . "' AND itemOnPromotion > 0 LIMIT 1 ";
    //echo $sql;exit();
    $query = mysql_query($sql);
    if (mysql_num_rows($query)) {
        //$row = mysql_fetch_assoc($query) or die(mysql_error());
        //$itemQty = $row['itemQty']; 

        $sql2 = "UPDATE ex_shoppingcart_items SET itemQty = '" . $qty . "' WHERE shopId = '{$shopId}' AND itemOnPromotion = '{$mainProId}' ";
        mysql_query($sql2);
    }
}

?>