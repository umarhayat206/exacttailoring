<?php
$pageTitle = "Thank you for shopping with ";

include("code/application_code_includes_and_globals_file.php");
include($siteRoot."includes/html_head.php");
include($siteRoot."includes/page_header.php");
include_once('class.phpmailer.php');

//Send thanks to customer
if($_SESSION['auth']->mEmail != ""){
	//print_r($_SESSION['auth'])."<br/><br/>";
	
	$userCart = new tsShoppingCart;
	$userCart = $userCart->scGetInProgressMemberCart($_SESSION['auth']->mId);
	
	//print_r($userCart);
	//Send thx to customer
	$to = $_SESSION['auth']->mEmail;
	$subject = "Thank you for shopping with ".$siteBasicTitle;
	$message = "
		Dear ".$_SESSION['auth']->mFirstname." ".$_SESSION['auth']->mLastname."<br /><br />
		Your order has been received and is now being processed. Please return to
		".$siteUrl." at any time to log in and view the progress of this order.<br /><br />
		Below are the details of your order<br /><br />";
		
	//echo $userCart->scId;	
	$cartItems = tsShoppingCart::scListItems($userCart->scId);
	if(!empty($cartItems)){
		foreach($cartItems as $item){
			//Get name/description of item
			$outputString.= (tsShoppingCart::getItemNameDescription($item)."<br /><br />");
			$outputString.= ("&pound; ".$item->sciPrice." x ");
			$outputString.= ($item->sciQty." = ");
			$outputString.= ("&pound; ".($item->sciPrice * $item->sciQty)."<br />");
		}	
	}	
	$message.= "
		<br /><br />
		Kind regards,<br />
		".$siteBasicTitle."
	";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	//@mail($to,$subject,$message,$headers);
		
	$mail = new PHPMailer();
	$mail->From = $siteEmail;
	$mail->FromName = "exacttailoring.com";
	$mail->AddAddress($to, $to);
	$mail->Subject = $subject;
	$mail->MsgHTML($message);
	$mail->Send();
	
	//Send mail to admins
	//$to = $siteGuvnerEmail.",".$siteSalesEmail;
	$subject1 = "New order received - Ref id: ".$userCart->scId;
	$message1 =
		"A new order has been recieved from ".
		$_SESSION['auth']->mFirstname." ".
		$_SESSION['auth']->mLastname.
		". Please see below or login to view the details.<br/><br/>".
		$outputString;
	//@mail($to,$subject,$message);
	
	$mail1 = new PHPMailer();
	$mail1->From = $to;
	$mail1->FromName = $_SESSION['auth']->mFirstname." ".$_SESSION['auth']->mLastname;
	$mail1->AddAddress($siteGuvnerEmail, $siteGuvnerEmail);
	$mail1->AddAddress($siteSalesEmail, $siteSalesEmail);
	$mail1->Subject = $subject1;
	$mail1->MsgHTML($message1);
	$mail1->Send();

}

?>

<h2>Thankyou for shopping with Exact Personal Tailoring Services</h2>
<p>Your order is now in process. You can keep track of your orders in your <a href="member-order-status" title="Order status">account order status page</a></p>
<p>If you have any questions please do not hesitate to <a href="contact-us" title="Contact Exact">contact us.</a></p>

<script language="javascript" src="https://scripts.affiliatefuture.com/AFFunctions.js"></script>
<script language="javascript">

                var merchantID = 5858;

                var orderValue = '<?=$_SESSION['orderValue'];?>';

                var orderRef = '<?=$_SESSION['orderRef'];?>';

                var payoutCodes = '';

                var offlineCode = '';

                AFProcessSaleV2(merchantID, orderValue, orderRef,payoutCodes,offlineCode);

</script>
<?php include($siteRoot."includes/page_footer.php");?>

