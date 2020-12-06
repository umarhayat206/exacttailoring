<?php
$pageTitle = "Order a catalogue from ";

include("code/application_code_includes_and_globals_file.php");
include($siteRoot."includes/html_head.php");
include($siteRoot."includes/page_header.php");

$mailSent = false;
$errMessage = "";
/*
if($_POST['msgSend']=="Send"){
	$yourName = trim($_POST['yourName']);
	$yourEmail = trim($_POST['yourEmail']);
	$msgAddress = trim($_POST['msgAddress']);
	$msgContent = trim($_POST['msgContent']);
	$orderOption = trim($_POST['orderOption']);
	
	if($yourName!="" || $yourEmail!="" || $msgSubject!="" || $msgContent!=""){
		//All good, send mail. TODO: validation email address
		$subject = "Order Tenner for Two - sent via ".$siteBasicTitle;
		$message = $msgContent."<br/><br/>
			Order: $orderOption
			<br/><br/> From ".$yourName." [".$yourEmail."]".
			"<br/><br/> Heard about us from: ".$_POST['howHear'].
			"<br/><br/> Telephone number: ".$_POST['yourTel'].
			"<br/><br/> Address: ".$msgAddress.
			"<br/><br/> Postcode: ".$_POST['yourPostcode'].
			"<br/><br/> Country: ".smCountries::countryById($_POST['country']);
		
		$mail = new PHPMailer();
		$mail->From = $yourEmail;
		$mail->FromName = $yourName;
		$mail->AddAddress($siteEmail, $siteEmail);
		$mail->AddAddress($siteSalesEmail, $siteSalesEmail);
		$mail->Subject = $subject;
		$mail->MsgHTML($message);
		//$mail->SetLanguage('en','language/'); 
		if($mail->Send()){
			$mailSent = true;
			
			echo "<script language='javascript' type='text/javascript'>
				alert('Thank you for your order. We will contact you as soon as possible.');
			</script>";
			
		}else{
			echo "<script language='javascript' type='text/javascript'>
				alert('" .$mail->ErrorInfo. "');
			</script>";
		}

	}else{
		$errMessage="<p class='validationArea'>Please ensure all fields are completed</p>";
	}
}
*/

if(!empty($_POST['payDirect']) && empty($_POST['payCreditCard'])){
	$cart = tsShoppingCart::scGetInProgressMemberCart($_SESSION['auth']->mId);
	$cart->scCompleted = "PendingConfirmation";
	$cart->scDeliveryAddress = $_POST['msgAddress'];
	$cart->scSpecialDetails = $_POST['msgContent'];
	$cart->scCalculatedValue = $_POST['totalPrice'];
	$cart->scDateOrdered = date("Y-m-d H:i:s");
	$cart->scDateCompleted = date("Y-m-d H:i:s");
	$cart->scGateway = "Pay Direct";
	$cart->scSave($cart);
	
	//print_r($cart);
	
	$po = new tsProductOrder;
	$po->poMeasurements = $_POST['orderOption']." = Yes";
	$po->poOrderPrice = 10;
	$po->poPtId = 68; // localhost 72 / online 68
	$po->poId = $po->save($po);
	
	$userCart = new tsShoppingCart;
	$userCart = $userCart->scGetInProgressMemberCart($_SESSION['auth']->mId);
	
	$cartItem = new tsShoppingCartItems;
	$cartItem->sciScId = $cart->scId;
	$cartItem->sciPoId = $po->poId;
	$cartItem->sciPrice = 10;
	$cartItem->sciQty = $_POST['sciQuantity'];
	//print_r($cartItem);
	$userCart->scAddItem($cartItem);	

	echo "<script language='javascript' type='text/javascript'>window.location='thankyou.php';</script>";
	
}else if(empty($_POST['payDirect']) && !empty($_POST['payCreditCard'])){	// paypal
	$cart = tsShoppingCart::scGetInProgressMemberCart($_SESSION['auth']->mId);
	$cart->scCompleted = "PendingConfirmation";
	$cart->scDeliveryAddress = $_POST['msgAddress'];
	$cart->scSpecialDetails =$_POST['msgContent'];
	$cart->scCalculatedValue = $_POST['totalPrice'];
	$cart->scDateOrdered = date("Y-m-d H:i:s");
	$cart->scDateCompleted = date("Y-m-d H:i:s");
	$cart->scGateway = "PAYPAL";
	$cart->scSave($cart);
	
	$po = new tsProductOrder;
	$po->poMeasurements = $_POST['orderOption']." = Yes";
	$po->poOrderPrice = 10;
	$po->poPtId = 68; // localhost 72 / online 68
	$po->poId = $po->save($po);
	
	$cartItem = new tsShoppingCartItems;
	$cartItem->sciScId = $cart->scId;
	$cartItem->sciPoId = $po->poId;
	$cartItem->sciPrice = 10;
	$cartItem->sciQty = $_POST['sciQuantity'];
	$userCart->scAddItem($cartItem);	
	
	echo "<script language='javascript' type='text/javascript'>window.location='thankyou.php';</script>";
?>
	<body onload="document.forms[0].submit()">
	<h2>Redirecting to PayPal, please wait...</h2>
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="frmP1">
		<input type="hidden" name="cmd" value="_xclick" />
		<input type="hidden" name="business" value="<?php echo($siteEmail); ?>" />
		<input type="hidden" name="item_name" value="Exact Personal Tailoring Order (id-<?php echo($cart->scId); ?>)" />
		<input type="hidden" name="item_number" value="<?php echo($cart->scId); ?>" />
		<input type="hidden" name="amount" value="<?php echo($_POST['totalPrice']); ?>" />
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
}

?>

<h2>Order ties</h2>
<img src="styles/images/nov_12.jpg" alt="Exact Tailoring Promotion Tenner for Two" title="Exact Tailoring Promotion Tenner for Two" />
	<?php if(!empty($_SESSION['auth']->mId)){ ?>
<form id="contactUsForm" method="post" action="<?php echo($_SERVER['PHP_SELF']); ?>">

	<fieldset>
		<legend>Order ties</legend>
		<?php echo($errMessage);?>
		<?php
		smControls::smDropDownList(
				"Ties",
				"orderOption",
				array(
					"Abstract"=>"Abstract",
					"Stripes"=>"Stripes",
					"One of Each"=>"One of Each",
					"Choose for me"=>"Choose for me",
				),
				$_POST['orderOption'],
				"",
				"",
				"true"
			);
		?><br/>

		<?php smControls::smTextArea("Delivery address: ","msgAddress",$_POST['msgSubject']);?><br />
		<?php smControls::smTextArea("Further details: ","msgContent",$_POST['msgContent']);?><br />

		<script type="text/javascript">
		//<![CDATA[
		$(document).ready(function(){
			function roundVal(val){
				var dec = 2;
				var result = Math.round(val*Math.pow(10,dec))/Math.pow(10,dec);
				return result;
			}
			$("#sciQuantity").change(function(){
				myVal = $("#sciQuantity").val() * 10;
				$("#totalPrice").val(roundVal(myVal));
			})
		})
		//]]>
		</script>
		
		<?php smControls::smTextBox("Quantity required","sciQuantity",$countitem,"class='numeric'");?><br />
		<?php smControls::smTextBox("Total price (&pound;):","totalPrice",10*$countitem,"readonly='readonly' class='numeric'");?><br />
	
		<?php //smControls::smButton("Send","msgSend"); ?><br/>
		
		<p>Pay via the telephone by calling 01 789 205612 and talking with one of our representatives. Or pay online<!--directly using your Credit Card (securely via Sage) or --> by Paypal.</p>
		<?php smControls::smButton("Pay via telephone","payDirect"); ?>
		<input type="image" src="https://www.paypal.com/en_GB/i/btn/btn_buynowCC_LG.gif" alt="Make payments with PayPal - it's fast, free and secure!" />
		
	</fieldset>
	
</form>
<?php }else{ ?>
	<center><br/><br/><br/>
	<h2>To complete your order, please log in on the left, or register below.</h2>
	</center>
<?php } ?>
<?php include($siteRoot."includes/page_footer.php"); ?>