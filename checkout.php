<?php
@session_start();
include_once('includes/globals.php');

include_once('class.phpmailer.php');
//echo $_POST['payDirect']."-------";

/*
    echo '<pre>';
    print_r($_SESSION);
    echo '</pre>';
    echo '<hr>';
    echo '<pre>';
    print_r($u);
    echo '</pre>';    
    exit();

Array
(
    [chklevel] => 2
    [chkuser] => 1
    [username] => admin
    [shippingaddress] => 
 
    [auth] => 1
    [currentOrder] => 9052
    [initials] => 
    [insidecollarcuff] => Same as shirt
    [measurementId] => 1615
    [chkmemberuser] => 41528
    [membername] => Gavin
    [memberlastactivity] => 1476259118
    [memberDetails] => __PHP_Incomplete_Class Object
        (
            [__PHP_Incomplete_Class_Name] => smUser
            [usId] => 41528
            [usUsername] => 
            [usFirstname] => Gavin
            [usLastname] => Robertson
            [usPassword] => ss87db
            [usEmail] => Mo0511@aol.com
            [usCompany] => 
            [usAddress] => 42 Maynall Avenue
            [usAddress2] => 
            [usAddress3] => 
            [usCity] => Canvey, Island
            [usTelephone] => 123
            [usMobile] => 
            [usLastActivity] => 1476264644
            [usAuthorised] => 1
            [usRoLevel] => 2
            [usPasswordHashed] => 45038365c99e15739342079f83b7b487
            [usGender] => 1
            [usCountry] => 183
            [usPostcode] => SS8 7DB
            [usFax] => 
            [usSignupdate] => 2015-01-13 02:23:28
            [usLogins] => 3
            [usTotalSpend] => 61.94
            [usHowmanyOrder] => 1
            [usReceiveInfo] => 0
        )

    [applyvoucher] => 
)
------------------------------------------------------------------
smUser Object
(
    [usId] => 41528
    [usUsername] => 
    [usFirstname] => Gavin
    [usLastname] => Robertson
    [usPassword] => ss87db
    [usEmail] => Mo0511@aol.com
    [usCompany] => 
    [usAddress] => 42 Maynall Avenue
    [usAddress2] => 
    [usAddress3] => 
    [usCity] => Canvey, Island
    [usTelephone] => 123
    [usMobile] => 
    [usLastActivity] => 1476264644
    [usAuthorised] => 1
    [usRoLevel] => 2
    [usPasswordHashed] => 45038365c99e15739342079f83b7b487
    [usGender] => 1
    [usCountry] => 183
    [usPostcode] => SS8 7DB
    [usFax] => 
    [usSignupdate] => 2015-01-13 02:23:28
    [usLogins] => 3
    [usTotalSpend] => 61.94
    [usHowmanyOrder] => 1
    [usReceiveInfo] => 0
)


 */

if (!empty($_SESSION['currentOrder'])) {

	$u = smUser::GetIndividual($_SESSION['chkmemberuser']);

	//check Order ID and User ID in Table ex_shoppingcart
	$ChkOrderTable = smOrder::CheckOrderOfUser();
	if (!$ChkOrderTable) {
		echo '<script type="text/javascript">';
		echo 'alert("System error we will contact back to you soon!.");';
		echo 'window.location.href = "' . _URL_ . 'memberlogout";';
		echo '</script>';
		exit();
	}

	//Send thanks to customer
	if (!empty($u->usEmail)) {

		$cartItems = smOrder::GetAllItems($_SESSION['currentOrder']);
		if (!empty($cartItems)) {
			foreach ($cartItems as $item) {
				//Get name/description of item
				$productitem = smProduct::GetIndividual($item->productId);
				$fabric = smFabric::getFabric($productitem->productFabricId);
				//print_r($productitem);

				$subtotal = $subtotal + ($item->itemPrice * $item->itemQty);
				$itemQty = "itemQty-" . $item->itemId;

				$outputString .= $productitem->productTitle . " (" . $fabric->fabricName . ") No." . $productitem->productRefCode . " &pound;" . $item->itemPrice . " x " . $item->itemQty . "<br/><br/>";
			}
		}

		//Send thx to customer
		$to = $u->usEmail;
		$subject = "Thank you for shopping with " . $smCompanyName;
		$message = "
		    Dear " . $u->usFirstname . " " . $u->usLastname . "<br /><br />
		    Your order has been received and is now being processed. Please return to
		    <b><a href='http://exacttailoring.com'>exacttailoring.com</a></b> at any time to log in and view the progress of this order.<br /><br />
		    Below are the details of your order<br /><br />
		    $outputString <br/><br/>
		    Please telephone 01789 205612 if you wish to amend any details.<br /><br /><br /><br />
		    Kind regards,<br />
		    $smCompanyName";

		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		//@mail($to, $subject, $message, $headers);

		//$mail = new PHPMailer();
		//$mail->From = $smMainEmail;
		//$mail->FromName = "exacttailoring.com";
		//$mail->AddAddress($to, $u->usFirstname);
		//$mail->AddAddress("may@silvermover.com", "Test");
		//$mail->Subject = $subject;
		//$mail->MsgHTML($message);
		//$mail->Send();

		//Send mail to admins
		$subject1 = "New order received - Ref id: " . $_SESSION['currentOrder'];
		$message1 =
			"A new order has been recieved from " .
			$u->usFirstname . " " . $u->usLastname .
			" Please see below or login to view the details.<br/><br/>" .
			$outputString . "<br/><br/>
		    Contact details <br/>
		    Email: {$u->usEmail} <br/>
		    Telephone: {$u->usTelephone} / {$u->usMobile}<br/>";

		$mail1 = new PHPMailer();
		$mail1->From = $to;
		$mail1->FromName = $u->usFirstname . " " . $u->usLastname;
		$mail1->AddAddress("orders@exacttailoring.com", "orders@exacttailoring.com");
		$mail1->AddCC("may@silvermover.com", "Admin");
		$mail1->Subject = $subject1;
		$mail1->MsgHTML($message1);
		//$mail1->Send();
	} // n send email to customer & admin

	if (!empty($_POST['actiontotalprice']) && $_POST['payDirect'] != "") {

		if (!empty($_POST['actionvouchercode'])) {
			mysql_query("UPDATE ex_vouchers SET vouchersStatus = '3' WHERE vouchersCode ='{$_POST['actionvouchercode']}' ");
		}

		$checkVoucherOnCart = smVouchers::getVoucherOnCart($_SESSION['currentOrder']);
		if (!empty($checkVoucherOnCart)) {
			foreach ($checkVoucherOnCart as $item) {
				smVouchers::statusUpdate($item->vouchersId, 1); // Update vouchersStatus = Payment awaiting confirmation
			}
		}

		$shoppingcart = "UPDATE ex_shoppingcart set ";
		$shoppingcart .= "shopDatecompleted='" . mktime() . "', ";
		$shoppingcart .= "shopDateordered='" . date("Y-m-d H:i:s") . "', ";
		$shoppingcart .= "shopGateway='Pay Direct', ";
		$shoppingcart .= "shopPriceValue='" . $_POST['actiontotalprice'] . "', ";
		$shoppingcart .= "shopCompleted='1', ";
		$shoppingcart .= "shopConfirmOrder='1', ";
		$shoppingcart .= "shopUserId='" . $u->usId . "' ";
		$shoppingcart .= "WHERE shopId = '" . $_SESSION['currentOrder'] . "' ";
		mysql_query($shoppingcart);

		//echo $shoppingcart."--------";

		$updeteuser = "UPDATE ex_users set ";
		$updeteuser .= "usTotalSpend = usTotalSpend + {$_POST['actiontotalprice']} , ";
		$updeteuser .= "usHowmanyOrder = usHowmanyOrder + 1 ";
		$updeteuser .= "WHERE usId = '" . $_SESSION['chkmemberuser'] . "' ";
		mysql_query($updeteuser);

		$_SESSION['currentOrder'] = "";
		$_SESSION['applyvoucher'] = "";

		echo "<script language='javascript' type='text/javascript'>
			alert('Thankyou for shopping with Exact Personal Tailoring Services. Your order is now in process.');
			window.location='" . _URL_ . "';
			</script>";
		echo "
	<script>
	!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
	n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
	t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
	document,'script','https://connect.facebook.net/en_US/fbevents.js');

	fbq('init', '1069763303102834');
	fbq('track', 'PageView');

	fbq('track', 'InitiateCheckout');

	</script>
	";
?>


	<?php
		// Pay by PaymentSense
	} elseif (!empty($_POST['actiontotalprice']) && $_POST['payPaymentSense'] == 'y') {

		if (!empty($_POST['actionvouchercode'])) { // Update vouchersStatus = Already Used
			mysql_query("UPDATE ex_vouchers SET vouchersStatus = '3' WHERE vouchersCode ='{$_POST['actionvouchercode']}' ");
		}

		$checkVoucherOnCart = smVouchers::getVoucherOnCart($_SESSION['currentOrder']);
		if (!empty($checkVoucherOnCart)) {
			foreach ($checkVoucherOnCart as $item) {
				smVouchers::statusUpdate($item->vouchersId, 1); // Update vouchersStatus = Payment awaiting confirmation 
			}
		}

		$shoppingcart = "UPDATE ex_shoppingcart set ";
		$shoppingcart .= "shopDatecompleted='" . mktime() . "', ";
		$shoppingcart .= "shopDateordered='" . date("Y-m-d H:i:s") . "', ";
		$shoppingcart .= "shopGateway='PaymentSense', ";
		$shoppingcart .= "shopPriceValue='" . $_POST['actiontotalprice'] . "', ";
		$shoppingcart .= "shopCompleted='1', ";
		$shoppingcart .= "shopConfirmOrder='1', ";
		$shoppingcart .= "shopUserId='" . $u->usId . "' ";
		$shoppingcart .= "WHERE shopId = '" . $_SESSION['currentOrder'] . "' ";
		mysql_query($shoppingcart);

		$updeteuser = "UPDATE ex_users set ";
		$updeteuser .= "usTotalSpend = usTotalSpend + {$_POST['actiontotalprice']} , ";
		$updeteuser .= "usHowmanyOrder = usHowmanyOrder + 1 ";
		$updeteuser .= "WHERE usId = '" . $_SESSION['chkmemberuser'] . "' ";
		mysql_query($updeteuser);

		$SHOPPINGCARTID = $_SESSION['currentOrder'];

		$_SESSION['currentOrder'] = "";
		$_SESSION['applyvoucher'] = "";

		$Amount =  number_format($_POST['actiontotalprice'], 2);

		$CurrencyShort = "826";
		//$OrderID = $_SESSION['currentOrder'];
		$OrderDescription = "Exact Personal Tailoring Order (id-{$SHOPPINGCARTID})";
		$memberDetails = smUser::GetIndividual($_SESSION['chkmemberuser']);


	?>

		<body onload="document.forms[0].submit()">
			<h2>Redirecting to Payment Sense...</h2>
			<form name="paymentSenseForm" id="paymentSenseForm" action="<?= _URL_ ?>PMSSKIN/Process.php" method="post">
				<input type="hidden" name="amount" value="<?php echo $Amount ?>" />
				<input type="hidden" name="currency_code" value="<?php echo $CurrencyShort ?>" />
				<input type="hidden" name="order_id" value="<?php echo $SHOPPINGCARTID ?>" />
				<input type="hidden" name="order_description" value="<?php echo $OrderDescription ?>" />

				<input type="hidden" name="customer_name" value="<?php echo $memberDetails->usFirstname . '  ' . $memberDetails->usLastname ?>" />
				<input type="hidden" name="address_line_1" value="<?php echo $memberDetails->usAddress; ?>" />
				<input type="hidden" name="address_line_2" value="<?php echo $memberDetails->usAddress2; ?>" />
				<input type="hidden" name="address_line_3" value="<?php echo $memberDetails->usAddress3; ?>" />
				<input type="hidden" name="city" value="<?php echo $memberDetails->usCity; ?>" />
				<input type="hidden" name="state" value="" />
				<input type="hidden" name="post_code" value="<?php echo $memberDetails->usPostcode; ?>" />
				<input type="hidden" name="country_code" value="826" />
				<input type="hidden" name="email_address" value="<?php echo $memberDetails->usEmail; ?>" />
				<input type="hidden" name="phone_number" value="<?php echo $memberDetails->usTelephone; ?>" />





			</form>


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

				fbq('track', 'Purchase', {
					value: '<?= number_format($_POST['actiontotalprice'], 2); ?>',
					currency: 'GBP'
				});
			</script>
			<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1069763303102834&ev=PageView&noscript=1" /></noscript>
			<!-- End Facebook Pixel Code -->




		</body>




	<?php
		// Pay by PayPal
	} elseif (!empty($_POST['actiontotalprice']) && $_POST['payDirect'] == "" && $_POST['payCreditCard'] == "") {

		if (!empty($_POST['actionvouchercode'])) { // Update vouchersStatus = Already Used
			mysql_query("UPDATE ex_vouchers SET vouchersStatus = '3' WHERE vouchersCode ='{$_POST['actionvouchercode']}' ");
		}

		$checkVoucherOnCart = smVouchers::getVoucherOnCart($_SESSION['currentOrder']);
		if (!empty($checkVoucherOnCart)) {
			foreach ($checkVoucherOnCart as $item) {
				smVouchers::statusUpdate($item->vouchersId, 1); // Update vouchersStatus = Payment awaiting confirmation 
			}
		}

		$shoppingcart = "UPDATE ex_shoppingcart set ";
		$shoppingcart .= "shopDatecompleted='" . mktime() . "', ";
		$shoppingcart .= "shopDateordered='" . date("Y-m-d H:i:s") . "', ";
		$shoppingcart .= "shopGateway='PayPal', ";
		$shoppingcart .= "shopPriceValue='" . $_POST['actiontotalprice'] . "', ";
		$shoppingcart .= "shopCompleted='1', ";
		$shoppingcart .= "shopConfirmOrder='1', ";
		$shoppingcart .= "shopUserId='" . $u->usId . "' ";
		$shoppingcart .= "WHERE shopId = '" . $_SESSION['currentOrder'] . "' ";
		mysql_query($shoppingcart);

		$updeteuser = "UPDATE ex_users set ";
		$updeteuser .= "usTotalSpend = usTotalSpend + {$_POST['actiontotalprice']} , ";
		$updeteuser .= "usHowmanyOrder = usHowmanyOrder + 1 ";
		$updeteuser .= "WHERE usId = '" . $_SESSION['chkmemberuser'] . "' ";
		mysql_query($updeteuser);

		$SHOPPINGCARTID = $_SESSION['currentOrder'];

		$_SESSION['currentOrder'] = "";
		$_SESSION['applyvoucher'] = "";

	?>

		<body onload="document.forms[0].submit()">
			<h2>Redirecting to PayPal, please wait...</h2>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="frmP1">
				<input type="hidden" name="cmd" value="_xclick" />
				<input type="hidden" name="business" value="anand@anandsuitsupply.com" />
				<input type="hidden" name="item_name" value="Exact Personal Tailoring Order (id-<?= $SHOPPINGCARTID; ?>)" />
				<input type="hidden" name="item_number" value="<?= $SHOPPINGCARTID; ?>" />
				<input type="hidden" name="amount" value="<?= number_format($_POST['actiontotalprice'], 2); ?>" />
				<input type="hidden" name="no_shipping" value="0" />
				<input type="hidden" name="return" value="https://www.exacttailoring.com/" />
				<input type="hidden" name="cn" value="Optional Details" />
				<input type="hidden" name="currency_code" value="GBP" />
				<input type="hidden" name="quantity" value="1" />
				<input type="hidden" name="tax" value="" />
				<input type="hidden" name="lc" value="EN" />
				<input type="hidden" name="bn" value="PP-BuyNowBF" />
			</form>


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

				fbq('track', 'Purchase', {
					value: '<?= number_format($_POST['actiontotalprice'], 2); ?>',
					currency: 'GBP'
				});
			</script>
			<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1069763303102834&ev=PageView&noscript=1" /></noscript>
			<!-- End Facebook Pixel Code -->




		</body>





	<?php
	} else { ?>

		<h2>An error has occurred. We apologise for any inconvenience.</h2>
		<p>This error has been noted and will be dealt with shortly. In the mean time, please <a href="<?= _URL_; ?>" title="Continue shopping">click here</a> to continue shopping.</p>

	<?php
	} ?>


<?php
} else { ?>

	<h2>An error has occurred. We apologise for any inconvenience.</h2>
	<p>This error has been noted and will be dealt with shortly. In the mean time, please <a href="<?= _URL_; ?>" title="Continue shopping">click here</a> to continue shopping.</p>

<?php
} ?>