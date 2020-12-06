<?php
include_once('includes/globals.php');
include_once('includes/check_admin_login.php');
include_once('class.phpmailer.php');

$ORDERS = new smOrder;
$shopId = intval($_GET['id']);

if ($shopId > 0) :

    /**
     * Update order status to 'Order now in production' (2)
     */
    $ORDERS->shopId = $shopId;
    $ORDERS->shopCompleted = 2;
    smOrder::statusUpdate($ORDERS);

    /**
     * Query order details
     */



    $orderItems = smOrder::GetAllItems($ORDERS->shopId);


    $listOrder = smOrder::GetIndividual($ORDERS->shopId);
    $memberDetails = smUser::GetIndividual($listOrder->shopUserId);
    $Y = substr($listOrder->shopDateadded, 0, 4);
    $M = substr($listOrder->shopDateadded, 5, 2);
    $MM = smSetting::changeMonth($M);
    $D = substr($listOrder->shopDateadded, 8, 2);

    //$orderDate = $D . ' ' . $MM . ' ' . $Y ;
    $orderDate = date('d-M-Y H:i:s', strtotime($listOrder->shopDateadded));
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

    //Send email order details to customer
    if (!empty($memberDetails->usEmail)) {

        $cartItems = $orderItems;
        if (!empty($cartItems)) {
            $productDetails = '<table class="columns" width="100%" border="1"><tr><th>Item</th><th>Unit price</th><th>QTY.</th><th>Total price</th></tr>';
            $subtotal = 0;
            foreach ($cartItems as $item) {
                //Get name/description of item
                $productitem = smProduct::GetIndividual($item->productId);
                $fabric = smFabric::getFabric($productitem->productFabricId);
                //print_r($productitem);

                $subtotal = $subtotal + ($item->itemPrice * $item->itemQty);
                $itemQty = "itemQty-" . $item->itemId;

                $productDetails .= '<tr><td>' . $productitem->productTitle . " (" . $fabric->fabricName . ") No." . $productitem->productRefCode . "</td><td>&nbsp; &pound;" . $item->itemPrice . "</td><td>" . $item->itemQty . "</td><td>&nbsp; &pound;" . number_format($item->itemQty * $item->itemPrice, 2) . "</td></tr>";
            }
            $productDetails .= '<tr><td colspan="3" align="right"><b>Sub total:</b></td><td align="right">&nbsp; &pound;' . $subtotal . '</td></tr>';
            $productDetails .= '<tr><td colspan="3" align="right"><b>Discount(' . $listOrder->shopPromotionCode . ')</b></td><td>&nbsp;</td></tr>';
            $productDetails .= '<tr><td colspan="3" align="right"><b>Shipping ( Included )</b></td><td>&nbsp;</td></tr>';
            $productDetails .= '<tr><td colspan="3" align="right"><b>Total paid:</b></td><td align="right">&nbsp; <b>&pound;' . $listOrder->shopPriceValue . '</b></td></tr>';
            $productDetails .= '</table>';
        }

        $shippingAddress = (trim(str_replace('<br/>', '', $listOrder->shopDeliveryAddress)) == '') ? $memberDetails->usAddress : $listOrder->shopDeliveryAddress;
        $billingAddress = $memberDetails->usAddress;
        $paymentGateway = $listOrder->shopGateway;

        $to = $memberDetails->usEmail;
        //$to = 'poppo@silvermover.com';
        $subject = "[EXACT TAILORING] Order confirmation";


        // $headers = 'MIME-Version: 1.0' . "\r\n";
        // $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        //@mail($to, $subject, $message, $headers);



        $output = '';
        /**
         * Get email template
         */
        $output = file_get_contents('email-template/emailOrderConfirmation.html');

        /**
         * Insert Custmer name & surname
         */
        $output = str_replace('{{customer.name}} {{customer.surnamename}}', ($memberDetails->usFirstname . " " . $memberDetails->usLastname), $output);


        /**
         * Insert Shopping ID & Shopping Date
         */
        $output = str_replace('{{orderId}} Place on {{orderDate}}', ($ORDERS->shopId . " Place on " . $orderDate), $output);


        /**
         * Insert Payment method
         */
        $output = str_replace('{{paymentMethod}}', $paymentGateway, $output);

        /**
         * Insert Product details
         */
        $output = str_replace('{{product.details}}', $productDetails, $output);

        /**
         * Insert Shipping address
         */
        $output = str_replace('{{shipping.address}}', $shippingAddress, $output);

        /**
         * Insert Billing address
         */
        $output = str_replace('{{billing.address}}', $billingAddress, $output);



        /**
         * Insert Shop email address
         */
        $output = str_replace('{{shop.email}}', 'info@exacttailoring.com', $output);






        //echo ($output);
        //exit();
        $mail = new PHPMailer();
        $mail->From = $smMainEmail;
        $mail->FromName = "EXACT TAILORING";
        $mail->AddAddress($to, $u->usFirstname);
        //$mail->AddAddress("poppo@silvermover.com", "[Exact Tailoring] Copied from order confirmation");
        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mail->AddEmbeddedImage('images/logo.png', 'ExactLogo', 'ExactLogo.png');
        $mail->Body = $output;

        //$mail->MsgHTML($output);


        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
        echo '<h2><a href="https://www.exacttailoring.com/admin_order">Back to Order</a></h2>';
    } // n send email to customer & admin



endif // if got Order ID

//@header("location:admin_order");
//exit;
?>.