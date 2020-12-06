<?php
@session_start();
include_once('includes/globals.php');


?>
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

    fbq('track', 'AddToCart');
</script>
<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1069763303102834&ev=PageView&noscript=1" /></noscript>
<!-- End Facebook Pixel Code -->


<?php
/*
if(empty($_SESSION['chkmemberuser'])){ // member not login 
    echo "<script language='javascript' type='text/javascript'>
            alert('You are not login. Please login to your account.');
            history.go(-1);
        </script>";

}else{
*/

// Create order
if (empty($_SESSION['currentOrder'])) {
    $sqlOrder = "insert into ex_shoppingcart set ";
    $sqlOrder .= "shopCompleted='1', "; // await confirm payment
    $sqlOrder .= "shopDeliveryAddress='{$_SESSION['shippingaddress']}', ";
    $sqlOrder .= "shopConfirmOrder='0', ";
    $sqlOrder .= "shopUserId='{$_SESSION['chkmemberuser']}' ";
    mysql_query($sqlOrder);
    $_SESSION['currentOrder'] = mysql_insert_id();
    //echo $sqlOrder."---<br/><br/>";
}

if ($_POST['hiddenproductid']) {
    $product = smProduct::GetIndividual($_POST['hiddenproductid']);
    $checkProductOnPromotion = smPromotion::checkProductOnPromotion($product->productId);
    //echo $checkProductOnPromotion->promotionId;

    $promotiondetails = smPromotion::GetPromotion($checkProductOnPromotion->promotionId);
    if ($promotiondetails->promotionType == 1) {  // discount
        // EDIT 30/7/14
        //$productPrice = $product->productPrice - (($product->productPrice * $promotiondetails->promotionDiscount) / 100);
        $productPrice = $product->productPrice;
    } else if ($promotiondetails->promotionType == 2) {    // free item
        $productPrice = $product->productPrice;

        //print_r($_POST)."<br/>";
        $addfreeitems = smProduct::GetAllVisible();
        $specialfreeitem = "";
        foreach ($addfreeitems as $item) {
            $freeitem = "freeitem-" . $item->productId;
            // echo $freeitem . " - " . $_POST[$freeitem] ."<br/>"; 

            if ($_POST[$freeitem] == 1) {
                $specialfreeitem .= $item->productTitle . " (" . $item->productRefCode . "), ";
            }
        }
    } else {  // not on promotion 
        $productPrice = $product->productPrice;
    }

    $_SESSION['initials'] = $_POST['hiddeninitials'];

    if (!empty($_POST['hiddeninsidecollarcuff'])) {
        $_SESSION['insidecollarcuff'] = $_POST['hiddeninsidecollarcuff'];
    } else {
        $_SESSION['insidecollarcuff'] = "";
    }

    // echo $_SESSION['currentOrder']."-*-<br/>"; 
    // print_r($_POST)."<br/>"; 
    // echo $_POST['hiddencategoryid']."<br/>"; 
    // echo $_POST['hiddenproductid']."<br/>"; 
    $checkItemId = checkingProductIdExists($_SESSION['currentOrder'], $product->productId);
    if ($checkItemId <= 0) {
        // Add order item
        $sqlOrderItems = "insert into ex_shoppingcart_items set ";
        $sqlOrderItems .= "shopId='{$_SESSION['currentOrder']}', ";
        $sqlOrderItems .= "productId='{$product->productId}', ";
        $sqlOrderItems .= "itemPrice='$productPrice', ";
        $sqlOrderItems .= "itemInsideCollarCuff='{$_POST['hiddeninsidecollarcuff']}', ";

        /*
            if(!empty($specialfreeitem)){
                $sqlOrderItems .="itemSpecialDetails='Get free product: $specialfreeitem', ";
            }
            */

        $sqlOrderItems .= "itemQty='1' ";
        mysql_query($sqlOrderItems);
        $returnItemId = mysql_insert_id();
    } else {
        $returnItemId = $checkItemId; //
    }



    //echo $sqlOrderItems;

    if ($promotiondetails->promotionType == 2) {    // free item
        $addfreeitems = smProduct::GetAllVisible();
        foreach ($addfreeitems as $item) {
            $freeitem = "freeitem-" . $item->productId;
            if ($_POST[$freeitem] == 1) {
                $productId = explode("-", $freeitem);

                //PK100 Check Count the number of free ==============================
                $chkFreeItemId = checkingFreeProductIdExists($_SESSION['currentOrder'], $item->productId, $product->productId);
                if ($chkFreeItemId == 0) {
                    // Add order item
                    $sqlFreeItems = "insert into ex_shoppingcart_items set ";
                    $sqlFreeItems .= "shopId='{$_SESSION['currentOrder']}', ";
                    $sqlFreeItems .= "productId='{$productId[1]}', ";
                    //$sqlFreeItems .="itemComplete='1', ";
                    $sqlFreeItems .= "itemPrice='0', ";
                    $sqlFreeItems .= "itemQty='1', ";
                    $sqlFreeItems .= "itemOnPromotion='{$product->productId}' ";
                } else {
                    // Edit order item
                    $sqlFreeItems = "update ex_shoppingcart_items set ";
                    $sqlFreeItems .= "shopId='{$_SESSION['currentOrder']}', ";
                    $sqlFreeItems .= "productId='{$productId[1]}', ";
                    //$sqlFreeItems .="itemComplete='1', ";
                    $sqlFreeItems .= "itemPrice='0', ";
                    $sqlFreeItems .= "itemQty='1', ";
                    $sqlFreeItems .= "itemOnPromotion='{$product->productId}' ";
                    $sqlFreeItems .= "WHERE itemId = '$chkFreeItemId' ";
                }
                //PK100 End Check Count the number of free ==============================


                mysql_query($sqlFreeItems);
            }
        }
    }

    //echo $sqlOrderItems."---<br/><br/>";

    if ($_POST) {
        asort($_POST);
        $itemDetailsInex = checkingItemDetailsIndexExists($returnItemId);
        if ($itemDetailsInex) {
            $i = 0;
            foreach ($_POST as $k => $y) {
                //echo $k."=>".$y."<br/>";
                $optionKey = explode("-", $k);
                $optionValue = $y;
                //echo $optionKey[1]." => ".$optionValue."<br/>";

                if ($optionKey[1]) {
                    $optionKeyName = smFeature::getFeatures($optionKey[1]);
                    $optionValueName = smFeature::getFeatures($optionValue);

                    //if(!empty($optionKeyName->featuresName) && !empty($optionValueName->featuresName)){                        // Add item design

                    if (array_key_exists($i, $itemDetailsInex)) {
                        $sqlItemsDesign = "update ex_item_details_index set ";
                        $sqlItemsDesign .= "itemId='$returnItemId', ";
                        $sqlItemsDesign .= "optionId='{$optionKey[1]}', ";
                        $sqlItemsDesign .= "optionValue='$optionValue' ";
                        $sqlItemsDesign .= "WHERE id = '" . $itemDetailsInex[$i] . "' ";
                        mysql_query($sqlItemsDesign);
                    } else {
                        $sqlItemsDesign = "insert into ex_item_details_index set ";
                        $sqlItemsDesign .= "itemId='$returnItemId', ";
                        $sqlItemsDesign .= "optionId='{$optionKey[1]}', ";
                        $sqlItemsDesign .= "optionValue='$optionValue' ";
                        mysql_query($sqlItemsDesign);
                    }


                    //echo $sqlItemsDesign."<br/>";

                    $shirtsDesignDetails .= "<p>{$optionKeyName->featuresName}: {$optionValueName->featuresName}</p>";
                    //}
                    $i++;
                }
            } //foreach
        } else {
            foreach ($_POST as $k => $y) {
                //echo $k."=>".$y."<br/>";
                $optionKey = explode("-", $k);
                $optionValue = $y;
                //echo $optionKey[1]." => ".$optionValue."<br/>";

                if ($optionKey[1]) {
                    $optionKeyName = smFeature::getFeatures($optionKey[1]);
                    $optionValueName = smFeature::getFeatures($optionValue);

                    //if(!empty($optionKeyName->featuresName) && !empty($optionValueName->featuresName)){                        // Add item design
                    $sqlItemsDesign = "insert into ex_item_details_index set ";
                    $sqlItemsDesign .= "itemId='$returnItemId', ";
                    $sqlItemsDesign .= "optionId='{$optionKey[1]}', ";
                    $sqlItemsDesign .= "optionValue='$optionValue' ";
                    mysql_query($sqlItemsDesign);
                    //echo $sqlItemsDesign."<br/>";

                    $shirtsDesignDetails .= "<p>{$optionKeyName->featuresName}: {$optionValueName->featuresName}</p>";
                    //}
                }
            } //foreach
        }


        //echo $shirtsDesignDetails;

        // Update order item
        $sqlUpdateOrderItems = "UPDATE ex_shoppingcart_items set ";
        $sqlUpdateOrderItems .= "itemDetails='" . mysql_real_escape_string($shirtsDesignDetails) . "' ";
        $sqlUpdateOrderItems .= "WHERE itemId = '$returnItemId' ";
        mysql_query($sqlUpdateOrderItems);
        // echo $sqlUpdateOrderItems."---<br/><br/>";

        /* if($_POST['hiddennodesign']=="true"){
                echo "<script language='javascript' type='text/javascript'>
                    window.location='"._URL_."shoppingcart'
                </script>";
            }else{ */

        echo "<script language='javascript' type='text/javascript'>
                    window.location='" . _URL_ . "measurement?item=$returnItemId&product={$_POST['hiddenproductid']}'
                </script>";

        // }

    } else {  // no design option

        // nothing happen
        echo "<script language='javascript' type='text/javascript'>
                    window.location='" . _URL_ . "shoppingcart'
                </script>";
    }
} else if ($_POST['hiddenvouchers']) {

    // Add vouchers
    $sqlVouchers = "insert into ex_vouchers set ";
    $sqlVouchers .= "usId='{$_SESSION['chkmemberuser']}', ";
    $sqlVouchers .= "vouchersCode='" . mktime() . "', ";
    $sqlVouchers .= "vouchersOrderDate='" . date("Y-m-d") . "', ";
    $sqlVouchers .= "vouchersValue='{$_POST['vouchersValue']}', ";
    $sqlVouchers .= "vouchersStatus='0', ";  // not complete order
    $sqlVouchers .= "recipientName='{$_POST['recipientName']}', ";
    $sqlVouchers .= "recipientEmail='{$_POST['recipientEmail']}', ";
    $sqlVouchers .= "message='{$_POST['message']}' ";
    mysql_query($sqlVouchers);
    $returnVouchersId = mysql_insert_id();

    // Add vouchers to cart
    $sqlOrderItems = "insert into ex_shoppingcart_items set ";
    $sqlOrderItems .= "shopId='{$_SESSION['currentOrder']}', ";
    $sqlOrderItems .= "vouchersId='{$returnVouchersId}', ";
    $sqlOrderItems .= "itemPrice='{$_POST['vouchersValue']}', ";
    $sqlOrderItems .= "itemQty='1', ";
    $sqlOrderItems .= "itemComplete='1' ";
    mysql_query($sqlOrderItems);

    echo "<script language='javascript' type='text/javascript'>
                window.location='" . _URL_ . "shoppingcart'
            </script>";
}

//}


function checkingProductIdExists($orderId = 0, $proId = 0)
{
    $sql = "SELECT * FROM ex_shoppingcart_items WHERE shopId = '" . $orderId . "' AND productId = '" . $proId . "' AND itemPrice > '0' ";
    $query = mysql_query($sql);
    if (mysql_num_rows($query)) {
        $row = mysql_fetch_assoc($query) or die(mysql_error());
        $itemId = $row['itemId'];
        return  $itemId;
    } else {
        return 0;
    }
}

function checkingFreeProductIdExists($orderId = 0, $proId = 0, $mainProId = 0)
{
    $sql = "SELECT * FROM ex_shoppingcart_items WHERE shopId = '" . $orderId . "' AND itemPrice <= '0' AND itemOnPromotion = '" . $mainProId . "' LIMIT 1 ";
    $query = mysql_query($sql);
    if (mysql_num_rows($query)) {
        $row = mysql_fetch_assoc($query) or die(mysql_error());
        $itemId = $row['itemId'];
        return  $itemId;
    } else {
        return 0;
    }
}


function checkingItemDetailsIndexExists($itemId = 0)
{

    $return = array();
    $sql = "SELECT * FROM ex_item_details_index WHERE itemId = '" . $itemId . "'  ";
    $query = mysql_query($sql);
    $listOrder = array();
    while ($row = mysql_fetch_array($query)) {
        $return[] = $row['id'];
    }
    if (count($return) > 0) {
        return $return;
    } else {
        return FALSE;
    }
}


?>