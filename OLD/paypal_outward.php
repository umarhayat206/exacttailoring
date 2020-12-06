<?
include("code/application_code_includes_and_globals_file.php");
//include($siteRoot."includes/html_head.php");
//include($siteRoot."includes/page_header.php");
?>

<style type="text/css">
h2 { text-align: center; margin-top:  100px; }
p { text-align: center; }
</style>

<?php
$pageTitle = "";

function simpleXor($InString, $Key) {
	// Initialise key array
	$KeyList = array();
	// Initialise out variable
	$output = "";
	
	// Convert $Key into array of ASCII values
	for($i = 0; $i < strlen($Key); $i++){
	  $KeyList[$i] = ord(substr($Key, $i, 1));
	}
      
	// Step through string a character at a time
	for($i = 0; $i < strlen($InString); $i++) {
	  // Get ASCII code from string, get ASCII code from key (loop through with MOD), XOR the two, get the character from the result
	  // % is MOD (modulus), ^ is XOR
	  $output.= chr(ord(substr($InString, $i, 1)) ^ ($KeyList[$i % strlen($Key)]));
	}
      
	// Return the result
	return $output;
}

//function payNowProtex($member,$companyName,$returnUrl,$confEmail,$strEncryptionPassword,$vendorCode){
function payNowProtex($member,$vendorCode){
	//Get the members cart
	$memberCart = cartGetItemList($member->mId);
	
	//Create unique VendorTxCode for the transaction (ShoppingCart Id, Site url, Timestamp)
	$strVendorTxCode=$memberCart[0]->ciCartId."-".$vendorCode."-".time();
	//$strVendorTxCode=$vendorCode;
	//Recalculate cart totals (For security hidden fields, etc are not used)
	$cartTotal=0;

	//Format the final figure into a valid 2 decimal places (any more would cause an error)
	$cartTotal=number_format($cartTotal,2);

	//Finally append the Delivery
	$cart = $memberCart.":Delivery:---:---:---:---:4.95";
	//$cartTotal+=4.95; //Add delivery charge to cart total
	
	//Now, with above details, create the crypt
	/*$strPost.="&VendorTxCode='".$vendorTxCode."'";
	$strPost.="&Amount='".number_format($_POST['amount'],2)."' ";
	$strPost.="&Currency='GBP' ";
	$strPost.="&Description='Silver goods from $companyName' ";
	$strPost.="&CardHolder='".$_SESSION['auth']->mFirstname." ".$_SESSION['auth']->mLastname."' ";
	$strPost.="&CardNumber='' ";
	$strPost.="&CardType='VISA' ";
	$strPost.="&BillingSurname='".$_SESSION['auth']->mLastname."' ";
	$strPost.="&BillingFirstnames='".$_SESSION['auth']->mFirstname."' ";
	$strPost.="&BillingAddress1='".$_POST['deliveryAddress']."' ";
	$strPost.="&BillingCity='' ";
	$strPost.="&BillingPostCode='".$_SESSION['auth']->mPostcode."' ";
	$strPost.="&BillingCountry='' ";
	$strPost.="&DeliverySurname='".$_SESSION['auth']->mLastname."' ";
	$strPost.="&DeliveryFirstnames='".$_SESSION['auth']->mFirstname."' ";
	$strPost.="&DeliveryAddress1='".$_POST['deliveryAddress']."' ";
	$strPost.="&DeliveryCity='' ";
	$strPost.="&DeliveryPostCode='".$_SESSION['auth']->mPostcode;
	$strPost.="&DeliveryCountry='' ";
	$strPost.="&Basket=".$cart;*/
	//echo($strEncryptionPassword);

	//$strCrypt = base64_encode(simpleXor($cart,$strEncryptionPassword));
	//return($strCrypt);
	return($cart);	
}

function cartGetItemList($memberId){
	$cart2 = new tsShoppingCart;
	$sqlshoppingcart = "SELECT * FROM ts_shoppingcart WHERE sc_m_id=".smFunctions::checkInput($memberId)." AND sc_completed='InProgress'";
	$queryshoppingcart = mysql_query($sqlshoppingcart);
	if(mysql_num_rows($queryshoppingcart)==0){ 		//No cart available
		$cart2->scMId = $memberId;
		$cart2->scId = tsShoppingCart::scSave($cart2);
	}
	
	$cart = new tsShoppingCart;
	$sql = "SELECT * FROM ts_shoppingcart WHERE sc_m_id=".smFunctions::checkInput($memberId)." AND sc_completed='PendingConfirmation' ORDER BY sc_id DESC LIMIT 1";
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
        $cart->scId = $row['sc_id'];
        $cart->scDateAdded = $row['sc_dateadded'];
        $cart->scDateOrdered = $row['sc_dateordered'];
        $cart->scCompleted = $row['sc_completed'];
        $cart->scDateCompleted = $row['sc_datecompleted'];
        $cart->scSysRef = $row['sc_sys_ref'];
        $cart->scGateway = $row['sc_gateway'];
        $cart->scGatewayRef = $row['sc_gateway_ref'];
        $cart->scCalculatedValue = $row['sc_calculated_value'];
        $cart->scReturnedValue = $row['sc_returned_value'];
        $cart->scDeliveryAddress = $row['sc_delivery_address'];
	$cart->scSpecialDetails = $row['sc_special_details'];
        $cart->scAdminNotes = $row['sc_adminnotes'];
        $cart->scMId = $row['sc_m_id'];

	$productcart = "";
	$total = 0;
	$numShirts = 0;
	
	$sql = "SELECT * FROM ts_shopping_cart_items WHERE sci_sc_id=".smFunctions::checkInput($cart->scId)." ORDER BY sci_id ASC ";
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query)){
		$sciId = $row['sci_id'];
		$sciMeasurementType = $row['sci_measurement_type'];
		$sciPrice = $row['sci_price'];
		$sciQty = $row['sci_qty'];
		$sciSId = $row['sci_s_id'];
		$sciFId = $row['sci_f_id'];
		$sciSmId = $row['sci_sm_id'];
		$sciBmId = $row['sci_bm_id'];
		$sciScId = $row['sci_sc_id'];
		$sciPoId = $row['sci_po_id'];
		
		if($sciFId>0){ 		//SHIRT
			$numShirts += $sciQty;
			$sumPrice = $sciQty * $sciPrice;
			$fabric = tsFabrics::fabricGetOne($sciFId);
			$productcart.=":"."Custom tailored shirt with ".$fabric->ftName.":".$fabric->fName.":".$sciQty.":".$sciPrice.":0:".$sumPrice.":0";
			//$productcart.=":"."Custom tailored shirt with ".$fabric->ftName.", ".$fabric->fName." fabric Qty ".$sciQty." Price &pound;".$sumPrice."/n/n";
		}else{ 	//OTHER PRODUCT
			$numShirts += $sciQty;
			$sumPrice = $sciQty * $sciPrice;
			$productOrder = tsProductOrder::poGetOne($sciPoId);
			$product = tsProductTypes::productTypeGetOne($productOrder->poPtId);
			$productcart.=":".$product->ptName." (".$product->pcName."):".$sciQty.":".$sciPrice.":0".$sumPrice.":0";
			//$productcart.=":".$product->ptName." (".$product->pcName.") Qty ".$sciQty." Price &pound;".$sumPrice."/n/n";
		}
	}

	return($productcart);
}

function getCartList($memberId,$siteVendorTxCodePart,$calculatedVal){
	$cart = new tsShoppingCart;
	$sql = "SELECT * FROM ts_shoppingcart WHERE sc_m_id=".$memberId->mId." AND sc_completed='PendingConfirmation' ORDER BY sc_id DESC LIMIT 1";
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
        $cart->scId = $row['sc_id'];
        $cart->scDateAdded = $row['sc_dateadded'];
        $cart->scDateOrdered = $row['sc_dateordered'];
        $cart->scCompleted = $row['sc_completed'];
        $cart->scDateCompleted = $row['sc_datecompleted'];
        $cart->scSysRef = $row['sc_sys_ref'];
        $cart->scGateway = $row['sc_gateway'];
        $cart->scGatewayRef = $row['sc_gateway_ref'];
        $cart->scCalculatedValue = $row['sc_calculated_value'];
        $cart->scReturnedValue = $row['sc_returned_value'];
        $cart->scDeliveryAddress = $row['sc_delivery_address'];
	$cart->scSpecialDetails = $row['sc_special_details'];
        $cart->scAdminNotes = $row['sc_adminnotes'];
        $cart->scMId = $row['sc_m_id'];

	$productcart = "";
	$total = 0;
	$numShirts = 0;
	$i=0;
	$sql = "SELECT * FROM ts_shopping_cart_items WHERE sci_sc_id=".$cart->scId." ORDER BY sci_id ASC ";
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query)){
		$i++;
		$sciId = $row['sci_id'];
		$sciMeasurementType = $row['sci_measurement_type'];
		$sciPrice = $row['sci_price'];
		$sciQty = $row['sci_qty'];
		$sciSId = $row['sci_s_id'];
		$sciFId = $row['sci_f_id'];
		$sciSmId = $row['sci_sm_id'];
		$sciBmId = $row['sci_bm_id'];
		$sciScId = $row['sci_sc_id'];
		$sciPoId = $row['sci_po_id'];

		if($i==1){ $CartId=$sciScId; }
	}
	
	$txCode = $CartId."-".$siteVendorTxCodePart."-".time(); 		//Used as a transaction code
	$txCode = saveTxCodeAndValue($CartId,$txCode); 		//Only if the cart hasn't already got one
	return($txCode);
}

function saveTxCodeAndValue($cartId, $txCode){
	if($cartId != "" && $txCode != ""){
		$sql = "UPDATE ts_shoppingcart SET ";
		$sql .="sc_sys_ref='".$txCode."' ";
		//Note about using a dynamic sys ref. What happens if the customer goes to pay, but during the payment process the reference is regenerated!
		$sql .="WHERE sc_id='".$cartId."'";	// AND sc_sys_ref IS NULL;"; //MAYBE CHANGE THIS BACK TO BEING STATIC
		mysql_query($sql);
	
		$sql = "SELECT sc_sys_ref FROM ts_shoppingcart WHERE sc_id='".$cartId."' ";
		$query = mysql_query($sql)or die(mysql_error());
		$row = mysql_fetch_array($query);
	}
	return($row['sc_sys_ref']);
}

if($_POST['mHowhear']==""){
	$errSignUp = "Where did you hear about Exact? is required";
}

if($errSignUp!=""){
	echo "<script language='javascript' type='text/javascript'>
		alert('$errSignUp');
		window.location='member-checkout';
	</script>";
	
}else{


	//Set cart status as PendingConfirmation
	$cart = tsShoppingCart::scGetInProgressMemberCart($_SESSION['auth']->mId);
	$items = $cart->scListItems($cart->scId);
	$calculatedVal = 0;
	$numShirts = 0;
	$numShirtsPromotion = 0;
	$discount = 0;
	$discountItem = 0;
	if(count($items)>0){
		foreach($items as $item){
			$calculatedVal += $item->sciPrice * $item->sciQty;
	
			if($item->sciFId>0){ //SHIRT
				$numShirts += $item->sciQty;
			}
			
			//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
			
			// --------------------------- edit 07-01-2012
			
			$boxeritems=0;
			$sql1="SELECT * FROM ts_shopping_cart_items WHERE sci_sc_id=".$item->sciScId;
			$query1=mysql_query($sql1);
			while($row1=mysql_fetch_array($query1)){
	
				$sql2="SELECT * FROM ts_product_order WHERE po_id=".$row1['sci_po_id'];
				$query2=mysql_query($sql2);
				while($row2=mysql_fetch_array($query2)){
					
					if($row2['po_pt_id']=="22"){	// localhost is 22 , online is 41
						$sql3="SELECT * FROM ts_shopping_cart_items WHERE sci_sc_id='".$item->sciScId."' AND sci_po_id='".$row2['po_id']."' ";
						$query3=mysql_query($sql3);
						while($row3=mysql_fetch_array($query3)){
							$boxeritems += $row3['sci_qty'];
							$boxerprice = $row3['sci_price'];
						}
					}
					
				}
				
			}
			
			$bprice=0;
			if($boxeritems>2){
				for($j=1;$j<=$boxeritems;$j++){
					if($j%3==0){
						$bprice+=$boxerprice/2;
					}else{
						$bprice+=$boxerprice;
					}
				}
				$bprice = number_format($bprice,2);
				$bprice2 = number_format($boxerprice * $boxeritems,2);
			}
			
			// --------------------------- edit 07-01-2012
			
		}
		
		//echo $numShirts."-*-";
		// edit 11-11-11 CODE FOR FRIEND
		/*
		if($_POST['sendCodetoFriend']==1){
			$body="<font face='Arial' size='2'><b>Exact Personal Tailoring Services,</b></font><br /><br />
				<font face='Arial' size='2'>Your friend sent special offer for your save 25% per order.<br />Details as follows
				<br /><br />--------------------------------------</font>
				<font face='Arial' size='2'>		
				<br /><br /><b>Code: FRIEND50</b>
				<br /><br /><b>Message:</b> $sendMessagetoFriend
				<br /><br /></font>";
			$mail = new PHPMailer();
			$mail->From = $_SESSION['auth']->mEmail;
			$mail->FromName = $_SESSION['auth']->mFirstname." ".$_SESSION['auth']->mLastname;
			$mail->AddAddress($_POST['yourFriendEmail'], $_POST['yourFriendEmail']);
			$mail->Subject = "Exact Tailoring - Your friend sent special offer for your save 25% per order";
			$mail->MsgHTML($body);
			//$mail->IsHTML(true);
			$mail->AddAttachment($_SERVER['DOCUMENT_ROOT']."/pictures/promotionforyourfriend.pdf","file name"); 
			//$mail->Send();
		}
		*/
		/*
		if($_POST['codeForFriend']=="FRIEND50"){
			//echo $calculatedVal."***<br/>";
			$friendfiftypercent = number_format(($calculatedVal-($calculatedVal*25/100))+$shippingHandlingCharge,2);
			$special="ORDER BY FRIEND CODE";
	
		}else{
			$special="";
		}
		*/
		// edit 4-12-12 voucher codes for first order
		
		if($_POST['codeForFirstOrder']=="S2013ORDER"){
			if($_SESSION['auth']->mVoucherCode != 1){
				echo "<script language='javascript' type='text/javascript'>alert('Order complete - Discount 50%');</script>";
			
				$voucherfiftypercent = number_format(($calculatedVal/2)+$shippingHandlingCharge,2);
				$special="Order voucher code - Discount 50%";
				
			}else{
				echo "<script language='javascript' type='text/javascript'>alert('Error!! - Voucher code already used');</script>";
				$special="";
			}
			
		}else{
			$special="";
		}
		
		
		/* ------- end edit 11-11-11 code for friend ------- */
		
		// TODO:: PROMOTION
	
		//if($numShirts<2){
		if($OpenPromotion != "OPEN"){		//echo "-1-";
			//Put shipping plus totals
			$calculatedVal += $shippingHandlingCharge;		// totals + shipping , no discount
		//}else if($OpenPromotion=="OPEN"){	//echo "-2-";//
		//	$calculatedVal -= $discount;		// totals - discount
		}else if($OpenPromotion=="OPEN"){		//echo "-3-";//
			
			// --------------------------- edit 07-01-2012
			
			if($boxeritems>2){ 
				$promotionPrice=$calculatedVal-$bprice2;
			}else{ 
				$promotionPrice=$calculatedVal;
			}
			
			if($promotionPrice <= 100){
				$calculatedVal -= ($promotionPrice * 10) / 100;
			}else if($promotionPrice > 100 && $promotionPrice < 300){
				$calculatedVal -= ($promotionPrice * 15) / 100;
			}else if($promotionPrice >= 300){
				$calculatedVal -= ($promotionPrice * 25) / 100;
			}
			
			if($boxeritems>2){
				$calculatedVal -= $boxerprice/2;
			}
	
			$calculatedVal += $shippingHandlingCharge;		// totals + shipping
			
			// --------------------------- edit 07-01-2012
			
		}else{	// $numShirts > 2 and $OpenPromotion = OPEN
			echo "-2-";
			//$calculatedVal += 0;
		}
		$calculatedVal=number_format($calculatedVal,2);
	}

} // n $errSignUp

//echo $calculatedVal." - ".$_POST['amount'];

// clear 50% for price
//session_unregister('affilate');
//unset($affilate);

//rudimentary check to see if the previous form wasn't tampered with... This form can still be doctored but at least it will all require manual rechecking by sales
if((int)$calculatedVal==(int)$_POST['amount'] && $_POST['payDirect']!=""){
	//echo $calculatedVal."-".$_POST['amount']."-".$friendfiftypercent;
	
	// edit 11-11-11 CODE FOR FRIEND
	// if($_POST['codeForFriend']=="FRIEND50"){ $calculatedVal=$friendfiftypercent; }
	
	// edit 4-12-12 voucher codes for first order
	if($_POST['codeForFirstOrder']=="S2013ORDER"){
		$calculatedVal=$voucherfiftypercent;
		
		// clear voucher code
		mysql_query("UPDATE ts_members SET m_vouchercode='1' WHERE m_id='{$_SESSION['auth']->mId}' ");
	}
	
	//It all adds up, save new status and calculated value
	$cart->scCompleted = "PendingConfirmation";
	$cart->scDeliveryAddress = $_POST['deliveryAddress'];
	$cart->scSpecialDetails = $_POST['specialDetails'].$special."<br/>Where did you hear about Exact? - ".$_POST['mHowhear'];
	$cart->scCalculatedValue = $calculatedVal;
	$cart->scDateOrdered = date("Y-m-d H:i:s");
	$cart->scDateCompleted = date("Y-m-d H:i:s");
	$cart->scGateway = "Pay Direct";
	$cart->scSave($cart);
	//header("location: thankyou.php");

	echo "<script language='javascript' type='text/javascript'>window.location='thankyou.php';</script>";
/*	
}elseif((int)$calculatedVal==(int)$_POST['amount'] && $_POST['payCreditCard']!=""){
	//echo "-1-";
	$cart->scCompleted = "PendingConfirmation";
	$cart->scDeliveryAddress = $_POST['deliveryAddress'];
	$cart->scSpecialDetails = $_POST['specialDetails'];
	$cart->scCalculatedValue = $calculatedVal;
	$cart->scDateOrdered = date("Y-m-d H:i:s");
	$cart->scDateCompleted = date("Y-m-d H:i:s");
	$cart->scGateway = "Pay Credit Card";
	$cart->scSave($cart);
	
	if($strConnectTo=="LIVE"){
		$strPurchaseURL="https://live.sagepay.com/gateway/service/vspdirect-register.vsp";
		//$strPurchaseURL="https://test.sagepay.com/showpost/showpost.asp";
		//$strPurchaseURL="https://live.sagepay.com/gateway/service/vspform-register.vsp";	// OLD
	}elseif ($strConnectTo=="TEST"){
		//$strPurchaseURL="https://live.sagepay.com/gateway/service/vspdirect-register.vsp";
		$strPurchaseURL="https://test.sagepay.com/gateway/service/vspdirect-register.vsp";
		//$strPurchaseURL="https://test.sagepay.com/gateway/service/vspform-register.vsp";
	}else{
		$strPurchaseURL="https://test.sagepay.com/Simulator/VSPDirectGateway.asp";
		//$strPurchaseURL="https://test.sagepay.com/Simulator/VSPDirectGateway.asp";
	}
	
	$vendorTxCode = getCartList($_SESSION['auth'], $siteVendorTxCodePart, $calculatedVal);
	//$payProtex = payNowProtex($_SESSION['auth'], $siteBasicTitle, $siteUrl, $siteProtxEmail, $siteProtxCryptPassword, $vendorTxCode);
	$basketDetails = payNowProtex($_SESSION['auth'], $vendorTxCode);
	//$strVendorTxCode=$vendorTxCode;
	
	if(!empty($_POST['deliveryAddress'])){
		$delivery=$_POST['deliveryAddress'];
	}else{
		$Countries=smCountries::countryById($_SESSION['auth']->mCountry);
		$delivery=$_SESSION['auth']->mAddress;
	}
*/
?>
<!--<body onload="document.forms[0].submit()">
<body>
	
<h2>Redirecting to SagePay, please wait...</h2>
<form action="<?//=$strPurchaseURL;?>" method="post" id="frmP2">
	<?php
	/*
	$sql="SELECT countryCode FROM iso_countries WHERE countryId='".$_SESSION['auth']->mCountry."' ";
	$query=mysql_query($sql);
	$row=mysql_fetch_array($query);
	$countryCode=$row['countryCode'];
	*/
	?><!--
	<input type="hidden" name="VPSProtocol" value="2.23" />
	<input type="hidden" name="TxType" value="PAYMENT" />
	<input type="hidden" name="Vendor" value="<?//=$siteProtxVendorName; ?>" />
	<input type="hidden" name="VendorTxCode" value="<?//=$vendorTxCode; ?>" />
	<input type="hidden" name="Amount" value="<?//=number_format($_POST['amount'],2); ?>" />
	<input type="hidden" name="Currency" value="GBP" />
	<input type="hidden" name="Description" value="Silver goods from <?//=$companyName; ?>" />
	<input type="hidden" name="CustomerEMail" value="<?//=$_SESSION['auth']->mEmail; ?>"/>
	<input type="hidden" name="3DSecureStatus" value="<?//=md5("password");?>" />
	<input type="hidden" name="CardType" value="<?//=$_POST['payCreditType'];?>" />
	<input type="hidden" name="CardHolder" value="<?//=$_POST['payCreditHolderName'];?>" />
	<input type="hidden" name="CardNumber" value="<?//=$_POST['payCreditNumber'];?>" />
	<input type="hidden" name="StartDate" value="<?//=$_POST['payCreditStartDate'];?>" />
	<input type="hidden" name="ExpiryDate" value="<?//=$_POST['payCreditExpiryDate'];?>" />
	<input type="hidden" name="IssueNumber" value="<?//=$_POST['payCreditIssueNumber'];?>" />
	<input type="hidden" name="CV2" value="<?//=$_POST['payCreditCV2'];?>" />
	<input type="hidden" name="BillingSurname" value="<?//=$_POST['billSurname']; ?>" />
	<input type="hidden" name="BillingFirstnames" value="<?//=$_POST['billFirstName']; ?>" />
	<input type="hidden" name="BillingAddress1" value="<?//=$_POST['billAddress1']; ?>" />
	<input type="hidden" name="BillingAddress2" value="<?//=$_POST['billAddress2']; ?>" />
	<input type="hidden" name="BillingCity" value="<?//=$_POST['billCity']; ?>"/>
	<input type="hidden" name="BillingPostCode" value="<?//=$_POST['billPostCode']; ?>" />
	<input type="hidden" name="BillingCountry" value="<?//=$_POST['billCountry']; ?>" />
	<input type="hidden" name="BillingState" value="<?//=$_POST['billStateCode']; ?>" />
	<input type="hidden" name="BillingPhone" value="<?//=$_POST['billPhone']; ?>" />
	<input type="hidden" name="DeliverySurname" value="<?//=$_POST['deliSurname']; ?>" />
	<input type="hidden" name="DeliveryFirstnames" value="<?//=$_POST['deliFirstName']; ?>" />
	<input type="hidden" name="DeliveryAddress1" value="<?//=$_POST['deliAddress1']; ?>" />
	<input type="hidden" name="DeliveryAddress2" value="<?//=$_POST['deliAddress2']; ?>" />
	<input type="hidden" name="DeliveryCity" value="<?//=$_POST['deliCity']; ?>" />
	<input type="hidden" name="DeliveryPostCode" value="<?//=$_POST['deliPostCode']; ?>" />
	<input type="hidden" name="DeliveryCountry" value="<?//=$_POST['deliCountry']; ?>" />
	<input type="hidden" name="DeliveryState" value="<?//=$_POST['deliStateCode']; ?>" />
	<input type="hidden" name="DeliveryPhone" value="<?//=$_POST['deliPhone']; ?>" />
	<input type="hidden" name="ClientIPAddress" value="<?//=$_SERVER['REMOTE_ADDR'];?>" />
</form>
</body>-->
	
<?php	
}elseif((int)$calculatedVal==(int)$_POST['amount'] && $_POST['payDirect']=="" && $_POST['payCreditCard']==""){
	//echo $calculatedVal."-".$_POST['amount']."-".$friendfiftypercent;
	
	// edit 11-11-11 CODE FOR FRIEND
	// if($_POST['codeForFriend']=="FRIEND50"){ $calculatedVal=$friendfiftypercent; }
	
	// edit 4-12-12 voucher codes for first order
	if($_POST['codeForFirstOrder']=="S2013ORDER"){
		$calculatedVal=$voucherfiftypercent;
		
		// clear voucher code
		mysql_query("UPDATE ts_members SET m_vouchercode='1' WHERE m_id='".$_SESSION['auth']->mId."' ");
	}
	
	//It all adds up, save new status and calculated value
	$cart->scCompleted = "PendingConfirmation";
	$cart->scDeliveryAddress = $_POST['deliveryAddress'];
	$cart->scSpecialDetails =$_POST['specialDetails'].$special."<br/>Where did you hear about Exact? - ".$_POST['mHowhear'];
	$cart->scCalculatedValue = $calculatedVal;
	$cart->scDateOrdered = date("Y-m-d H:i:s");
	$cart->scDateCompleted = date("Y-m-d H:i:s");
	$cart->scGateway = "PAYPAL";
	$cart->scSave($cart);
	
?>
<body onload="document.forms[0].submit()">
<h2>Redirecting to PayPal, please wait...</h2>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="frmP1">
	<input type="hidden" name="cmd" value="_xclick" />
	<input type="hidden" name="business" value="<?php echo($siteEmail); ?>" />
	<input type="hidden" name="item_name" value="Exact Personal Tailoring Order (id-<?php echo($cart->scId); ?>)" />
	<input type="hidden" name="item_number" value="<?php echo($cart->scId); ?>" />
	<input type="hidden" name="amount" value="<?php echo($calculatedVal); ?>" />
	<input type="hidden" name="no_shipping" value="0" />
	<input type="hidden" name="return" value="http://www.exacttailoring.com/thankyou.php" />
	<input type="hidden" name="cn" value="Optional Details" />
	<input type="hidden" name="currency_code" value="GBP" />
	<input type="hidden" name="quantity" value="1" />
	<input type="hidden" name="tax" value="" />
	<input type="hidden" name="lc" value="EN" />
	<input type="hidden" name="bn" value="PP-BuyNowBF" />
</form>
</body>

<?php
}else{ //Doctoring gone on
?>
<h2>An error has occurred. We apologise for any inconvenience.</h2>
<p>This error has been noted and will be dealt with shortly. In the mean time, please <a href="home" title="Continue shopping">click here</a> to continue shopping.</p>
<?php
}
?>
<?php //include($siteRoot."includes/page_footer.php"); ?>