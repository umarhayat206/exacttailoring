<?php

//Take current session vars and put to database
//Add id measurement id and shirt design id and newly set quantity and add to members old/new cart.
//Forward to Checkout or shopping page dependant on button clicked

if(($_POST['smContinue']=="Continue" || $_POST['smCheckout']=="Checkout") && isset($_SESSION['shirtDesign'])){ //Confirmed
//	print_r($_SESSION['shirtDesign']);
	
	//Save shirt design, get id
	$shirt = new tsShirtDesign;
	$_SESSION['shirtDesign']->sMId = $_SESSION['auth']->mId;
	$shirt = $_SESSION['shirtDesign'];
	$shirtId = tsShirtDesign::sdSave($shirt);
	
	//if no id provided, save measurements and get id
	if(isset($_SESSION['bodyMeasurement'])){
		$bmNew = new tsBodyMeasurements;
		$_SESSION['bodyMeasurement']->bmMId = $_SESSION['auth']->mId;
		$bmId = $bmNew->bmSave($_SESSION['bodyMeasurement']);
	}else if(isset($_SESSION['shirtMeasurement'])){
		$smNew = new tsShirtMeasurements;
		$_SESSION['shirtMeasurement']->smMId = $_SESSION['auth']->mId;
		$smId = $smNew->smSave($_SESSION['shirtMeasurement']);
	}else if(isset($_SESSION['bmId'])){
		$bmId = $_SESSION['bmId'];
	}else if(isset($_SESSION['smId'])){
		$smId = $_SESSION['smId'];
	}else{
		//Aww shit... How'd that happen?
	}
	
	$userCart = new tsShoppingCart;
	$userCart = $userCart->scGetInProgressMemberCart($_SESSION['auth']->mId);
	
	//print_r($userCart);
	
	$cartItem = new tsShoppingCartItems;
	$cartItem->sciScId = $userCart->scId;
	$cartItem->sciSmId = $smId;
	$cartItem->sciBmId = $bmId;
	$cartItem->sciFId = $_SESSION['fId'];
	$cartItem->sciSId = $shirtId;
	$cartItem->sciQty = $_POST['sciQuantity'];
	$cartItem->sciSpecial2 = $_POST['sciSpecial2'];
	if($_POST['sciSpecial2']==1){
		$cartItem->sciPrice = 5+(tsFabrics::fGetPrice($_SESSION['fId']));
	}else{
		$cartItem->sciPrice = tsFabrics::fGetPrice($_SESSION['fId']);
	}
	
	$userCart->scAddItem($cartItem);
	
	//Send thx to customer
	$to = $_SESSION['auth']->mEmail;
	$subject = "Thank you for shopping with ".$siteBasicTitle;
	$message = "
		Dear ".$_SESSION['auth']->mFirstname." ".$_SESSION['auth']->mLastname."<br /><br />
		Your order has been received and is now being processed. Please return to
		".$siteUrl." at any time to log in and view the progress of this order.<br /><br />
		Below are the details of your order<br /><br />";
		
		$cartItems = tsShoppingCart::scListItems($userCart->scId);
		foreach($cartItems as $item){
			//Get name/description of item
			$outputString.= (tsShoppingCart::getItemNameDescription($item)."<br /><br />");
			$outputString.= ("&pound; ".$item->sciPrice." x ");
			$outputString.= ($item->sciQty." = ");
			$outputString.= ("&pound; ".($item->sciPrice * $item->sciQty)."<br />");
		}	
		
	$message.= "
		<br /><br />
		Kind regards,<br />
		".$siteBasicTitle."
	";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	//SEND MAIL MOVED TO THANKYOU PAGE! DOH. IF HERE IT SENDS MESSAGE EVEN IF USER NOT FINISHED SHOPPING
	//@mail($to,$subject,$message,$headers);
	
	
	
	//Send mail to admins
	$to = $siteGuvnerEmail.",".$siteSalesEmail;
	$subject = "New order received - Ref id: ".$userCart->scId;
	$message =
		"A new order has been recieved from ".
		$_SESSION['auth']->mFirstname." ".
		$_SESSION['auth']->mLastname.
		". Please see below or login to view the details.\r\n \r\n".
		$outputString;
	//SEND MAIL MOVED TO THANKYOU PAGE! DOH. IF HERE IT SENDS MESSAGE EVEN IF USER NOT FINISHED SHOPPING
	//@mail($to,$subject,$message);
	
	//All done, unset session vars and redirect as appropriate
	unset($_SESSION['bmId']);
	unset($_SESSION['smId']);
	unset($_SESSION['bodyMeasurement']);
	unset($_SESSION['shirtMeasurement']);	
	unset($_SESSION['shirtDesign']);
	unset($_SESSION['fId']);
	
	if($_POST['smContinue']=="Continue"){	echo "-1-";
		//header("location:home");
		echo "<script language='javascript' type='text/javascript'>window.location='home';</script>";
	}else{	echo "-2-";
		//header("location:member-checkout");
		echo "<script language='javascript' type='text/javascript'>window.location='member-checkout';</script>";
	}
}
?>

