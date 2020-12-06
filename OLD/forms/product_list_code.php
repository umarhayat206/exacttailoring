<?php

if($_POST['sciQuantity']!=""){
	//Take product order. Store to po table and sci table
	//print_r($_POST);
	
	//Store the product order
	$po = new tsProductOrder;
	$po->poMeasurements = $_POST['poMeasurements'];
	$po->poOrderPrice = $_POST['poOrderPrice'];
	$po->poPtId = $_POST['poPtId'];
	$po->poId = $po->save($po);
	
	//Get the members cart and add the details
	$userCart = new tsShoppingCart;
	$userCart = $userCart->scGetInProgressMemberCart($_SESSION['auth']->mId);
	
	//print_r($userCart);
	
	$cartItem = new tsShoppingCartItems;
	$cartItem->sciScId = $userCart->scId;
	$cartItem->sciPoId = $po->poId;
	$cartItem->sciPrice = $_POST['poOrderPrice'];
	$cartItem->sciQty = $_POST['sciQty'];
	$cartItem->sciQty = $_POST['sciQuantity'];
	$userCart->scAddItem($cartItem);	

	if($_POST['smContinue']=="Continue"){
		//header("location:home");
		echo "<script language='javascript' type='text/javascript'>window.location='home';</script>";
	}else{
		//header("location:member-checkout");
		echo "<script language='javascript' type='text/javascript'>window.location='member-checkout';</script>";
	}
}
?>