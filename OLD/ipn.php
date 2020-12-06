<?php

include("code/application_code_includes_and_globals_file.php");

function email($scId){
	global $siteProductionEmail;
	global $siteSalesEmail;
	global $siteGuvnerEmail;

	$to = $siteProductionEmail.','.$siteGuvnerEmail;
	$subject = "Paypal order confirmed - ref number ".$scId;
	$message = "Please login to Exact tailoring to view the details of order id - ".$scId." (".$status.")";
	//@mail($to,$subject,$message);
	
	$mail = new PHPMailer();
	$mail->From = "no-reply@exacttailoring.com";
	$mail->FromName = "Exact Personal Tailoring Services";
	$mail->AddAddress($to, $to);
	$mail->Subject = $subject;
	$mail->MsgHTML($message);
	$mail->Send();
}

//if(0){ //comment-out entire block below
$postvars = array();
$req = 'cmd=_notify-validate';
$file = fopen("aFile.txt","w");
fwrite($file,"POSTED STRING :- \n\r ");
foreach($_REQUEST as $key=>$value){
	fwrite($file,$key . "=" . $value . "\n\r");
	$req .= "&" . $key . "=" . urlencode ($value);
}



//------------------------------------------------------------------
// Open log file (in append mode) and write the current time into it.
// Open the DB Connection. Open the actual database.
//-------------------------------------------------------------------
$time=time();


//------------------------------------------------
// Read post from PayPal system and create reply
// starting with: 'cmd=_notify-validate'...
// then repeating all values sent - VALIDATION.
//------------------------------------------------
//$postvars = array();
/**
while (list ($key, $value) = each ($HTTP_POST_VARS)) {
	$postvars[] = $key;
}
//$req = 'cmd=_notify-validate';
for ($var = 0; $var < count ($postvars); $var++) {
	$postvar_key = $postvars[$var];
	$postvar_value = $$postvars[$var];
	$req .= "&" . $postvar_key . "=" . urlencode ($postvar_value);
}
**/

//--------------------------------------------
// Create message to post back to PayPal...
// Open a socket to the PayPal server...
//--------------------------------------------
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen ($req) . "\r\n\r\n";
$fp = fsockopen ("www.paypal.com", 80, $errno, $errstr, 30);

//---------------------------------------------
/* fwrite($log, "Vals: ". $invoice." ". $receiver_email." ". $item_name." ". $item_ number." ". $quantity." ". $payment_status." ". $pending_reason." ".$payment_date." ". $payment_gross." ". $payment_fee." ". $txn_id." ". $txn_type." ". $first_ name." ". $last_name." ". $address_street." ". $address_city." ". $address_state . " ".$address_zip." ". $address_country." ". $address_status." ". $payer_email. " ". $payer_status." ". $payment_type." ". $notify_version." ". $verify_sign. "\ n");  */

//----------------------------------------------------------------------
// Check HTTP connection made to PayPal OK, If not, print an error msg
//----------------------------------------------------------------------
if (!$fp) {
	echo "$errstr ($errno)";
	fwrite($log, "Failed to open HTTP connection!");
	$res = "FAILED";
	fwrite($file,"\n\r\n\rFailed to open HTTP connection!");
}

//--------------------------------------------------------
// If connected OK, write the posted values back, then...
//--------------------------------------------------------
else {
	fwrite($file,"\n\r\n\rFurtherinfo:- n\r".$fp."\n\r".$header."\n\r".$req."\r\n".$_REQUEST['payment_status']);

	fputs ($fp, $header . $req);
	//-------------------------------------------
	// ...read the results of the verification...
	// If VERIFIED = continue to process the TX...
	//-------------------------------------------
	while (!feof($fp)) {
		$res = fgets ($fp, 1024);
		if (strcmp ($res, "VERIFIED") == 0) {
		//----------------------------------------------------------------------
		// If the payment_status=Completed... Get the password for the product
		// from the DB and email it to the customer.
		//----------------------------------------------------------------------
		if (strcmp ($_REQUEST['payment_status'], "Completed") == 0) {
		
			// need update link paid and email
			$itemNumber = trim(str_replace("id-","",$_REQUEST['item_number']));
			mysql_query("UPDATE ts_shoppingcart SET sc_completed='Processing', sc_gateway_ref=".$_REQUEST['txn_id']." WHERE sc_id=".$itemNumber." ");
			email($itemNumber);
			}
			
			//----------------------------------------------------------------------
			// If the payment_status is NOT Completed... You'll have to send the 
			// password later, by hand, when the funds clear...
			//----------------------------------------------------------------------
			elseif (strcmp ($pending_reason, "echeck") == 0) {}
			//----------------------------------------------------------------------
			// If the payment_status is NOT Completed... You'll have to send the 
			// password later, by hand, when the funds clear...
			//----------------------------------------------------------------------
			else {}
		
		}
	}
}
//--------------------------------------
// Insert Transaction details into DB.
//--------------------------------------
//$sql = "INSERT INTO `ts_shoppingcart` (`invoice`, `receiver_email`, `item_name`, `item_number`, `credit_amount`, `payment_status`, `pending_reason`, `payment_date`, `mc_gross`, `mc_fee`, `tax`, `mc_currency`, `txn_id`, `txn_type`, `first_name`, `last_name`, `address_street`, `address_city`, `address_state`, `address_zip`, `address_country`, `address_status`, `payer_email`, `payer_status`, `payment_type`, `notify_version`, `verify_sign`, `referrer_id`, `date`) VALUES ('null', '$receiver_email', '$item_name', '$item_number', '$payment_credit', '$payment_status', '$pending_reason', '$payment_date', '$mc_gross', '$mc_fee', '$tax', '$mc_currency', '$txn_id', '$txn_type', '$first_name', '$last_name', '$address_street', '$address_city', '$address_state', '$address_zip', '$address_country', '$address_status', '$payer_email', '$payer_status', '$payment_type', '$notify_version', '$verify_sign', '$referrer_id', '$time');";

//mysql_query($sql, $db);
//-------------------------------------------
// Close PayPal Connection, Log File and DB.
//-------------------------------------------
fclose ($fp);
fclose ($file);
//mysql_close($db);

//} //end comment-out entire block
?>