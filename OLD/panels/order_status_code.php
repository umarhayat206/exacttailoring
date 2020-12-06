<?php

function showPreviousOrders($mId){

	//Get previous carts
	$carts = tsShoppingCart::scListInProgressCarts($mId);
	//print_r($carts);
	if(count($carts)>0){
		foreach($carts as $cart){
			//$cart = tsShoppingCart::scGetDetails($_GET['orderId']);
			$items = tsShoppingCart::scListItems($cart->scId);
			$member = tsMembers::memberGet($cart->scMId);
			
			$vals = tsShoppingCart::scTotals($cart->scId);
			$detailsText=tsShoppingCart::getDetails($cart->scId);
			echo("
				<tr>
					<td>");
			if($detailsText!="") // See if there are any details. If so, show the button
				echo("<img src='styles/images/magnifier.png' alt='View details icon' title='View order details' id='".$cart->scId."' class='clicker' />");
				echo("<img src='styles/images/basket.png' alt='Buy this order again' title='Buy this order again' id='".$cart->scId."' class='clicker2' style='margin:0 5px; cursor:pointer;' />");
				echo("id-".$cart->scId."</td>
					<td>".date("d M Y",strtotime($cart->scDateOrdered))."</td>
					<td>".$vals['quantity']."</td>
					<td>&pound; ".$cart->scCalculatedValue."</td>
					<td>
						".tsShoppingCart::scConvertStatusForMember($cart->scCompleted)."<br />
						<span class='smallText'>(Status last changed on ".date("d M Y",strtotime($cart->scDateCompleted)).")</span>
					</td>
				</tr>");
			// dropdown View details
			echo("
				<tr>
					<td colspan='5'>
						<div class='hidden' id='pane".$cart->scId."'>
							".$detailsText."<br />
							");
			if(trim($cart->scDeliveryAddress)!=""){
				echo("For delivery to: <br />".$cart->scDeliveryAddress);
			}
			echo("
						</div>
					</td>
				</tr>
				");
			// dropdown Buy this order again
			echo("
				<tr>
					<td colspan='5'>
						<div class='hidden' id='pan".$cart->scId."'>
							<p>----------------------------------------------------------------------------------------------</p>
							<p align='left'>
								<span>Order/Cust.No: ".$member->mId."-".$member->mFirstname." ".$member->mLastname."</span>
								<span style='margin-left:30px;'>Order Date: ".$cart->scDateOrdered."</span><br/>
								<span>".str_replace("\n"," ",$member->mAddress)." ".$member->mPostcode."</span><br/>
							</p>
							
							<a href='re-order.php?order=".$cart->scId."'>
								<img src='./styles/images/but_addtocart.gif' title='' alt='' style='float:right; margin:-50px 100px 0 0; cursor:pointer;' />
							</a>	
							
							<p>----------------------------------------------------------------------------------------------</p>
							<p align='left'>");
								$cartItems = new tsShoppingCart;
								$cartItems = tsShoppingCart::scListItems($cart->scId);
								$numShirts = 0;
								foreach($cartItems as $item){
									//Get name/description of item
									if($item->sciFId>0){ //SHIRT
										$numShirts += $item->sciQty;
									}
									
									$fabric = tsFabrics::fabricGetCompleteCollection($item->sciFId);
									$fabric = $fabric[0];
									//echo "<span class='description'>".$fabric->fCode."</span>";
									echo "<span class='description'>Qty ".$item->sciQty."</span>";
									echo "<span class='description' style='margin-left:30px;'>".tsShoppingCart::getItemNameDescription($item)." (".$fabric->fCode.")</span><br/>";
								}
							echo("</p><p>----------------------------------------------------------------------------------------------</p>
								".displayItemsReOrder($items)."<br />
							");
				//------------------
			echo("
						</div>
					</td>
				</tr>
				");
			
			//Display details of above cart
				
		}
	}
}

function displayItemsReOrder($items){
	//First check to see if shirt or not
	foreach($items as $item){
		if($item->sciPoId>0){	//Has product ID	
			doProductReOrder($item);
		}else{ 	//No product ID (is shirt)
			doShirtReOrder($item);
		}
	}
}

function doProductReOrder($item){
	$productOrder = tsProductOrder::poGetOne($item->sciPoId);
	$product = tsProductTypes::productTypeGetOne($productOrder->poPtId);
	//echo $product->ptName." (".$product->pcName.")";
	?>
		<table width="600px">
			<tr>
				<td valign="top" style="text-align:left;">
					Qty: <?=$item->sciQty;?><br />
					Price: <?=$item->sciPrice;?><br />
					Code: <?=$product->sciPrice;?><br />
					<img src="<?=$product->ptImagePath;?>" width="150px" />
				</td>
				<td valign="top" style="text-align:left;">
					<h4>Measurements</h4>
					<?=str_replace("-"," ",$productOrder->poMeasurements);?>
				</td>
			</tr>
		</table><br /><br />
	<?php
}

function doShirtReOrder($item){
	$fabric = tsFabrics::fabricGetCompleteCollection($item->sciFId);
	$fabric = $fabric[0];
	$design = tsShirtDesign::sdGetOne($item->sciSId);
	//echo "<h4>Shirt from {$fabric->ftName}, {$fabric->fName} fabric</h4>";
	?>
		<table width="600px">
			<tr>
				<td valign="top" style="text-align:left;">
					Qty: <?=$item->sciQty;?> <br />
					<!--Price: <?//=$fabric->sciPrice;?><br />-->
					Price: <?=$fabric->fPricePerShirt;?><br />
					CODE: <?=$fabric->fCode;?><br />
					<img src="<?=$fabric->fImage;?>" width="150px" />					
				</td>
				<td valign="top" style="text-align:left;">
					<!--<h4>Design details</h4>-->
					<?php tsShirtDesign::sdPutDesignDetails($design);?>
				</td>
				<td valign="top" style="text-align:left;">
					<!--<h4>Measurements</h4>-->
					<ul>
					<?php
					if($item->sciSmId>0){
						$mesType = "Shirt";
						$m = tsShirtMeasurements::smGetOne($item->sciSmId,$_SESSION['auth']->mId,"true");
					}else{
						$mesType = "Body";
						$m = tsBodyMeasurements::bmGetOne($item->sciBmId,$_SESSION['auth']->mId,"true");
					}
					?>
					<?php
						if($mesType=="Body"){ //BODY/SHIRT MEASUREMENTS
							//tsShirtDesign::sdPut("Profile name: ".$m->bmProfileName);
							if($m->bmMetric==0){
								$metric = " cm";
							}else{
								$metric = " inches";
							}
							
							tsShirtDesign::sdPut("Fit: ".$m->bmFit);
							tsShirtDesign::sdPut("Measurements take from: ".$m->bmType);
							tsShirtDesign::sdPut("Shoulder: ".$m->bmShoulder.$metric);
							tsShirtDesign::sdPut("Short sleeve: ".$m->bmArmShort.$metric);
							tsShirtDesign::sdPut("Sleeve Lenght: ".$m->bmArm.$metric);
							tsShirtDesign::sdPut("Chest: ".$m->bmChest.$metric);
							tsShirtDesign::sdPut("Waist: ".$m->bmWaist.$metric);
							tsShirtDesign::sdPut("Length: ".$m->bmBack.$metric);
							tsShirtDesign::sdPut("Hips: ".$m->bmSeat.$metric);
							tsShirtDesign::sdPut("Neck: ".$m->bmNeck.$metric);
							tsShirtDesign::sdPut("Cuff: ".$m->bmCuff.$metric);
							tsShirtDesign::sdPut("Upper Arm: ".$m->bmBicep.$metric);
							tsShirtDesign::sdPut("Special Details: ".$m->bmSpecial);
							
						}else{ //BIO MEASUREMENTS
							tsShirtDesign::sdPut("Profile name: ".$m->smProfileName);
							if($m->smMetric==0){
								$metric = " cm";
							}else{
								$metric = " inches";
							}
							tsShirtDesign::sdPut("Collar: ".$m->smCollar.$metric);
							tsShirtDesign::sdPut("Chest: ".$m->smChest.$metric);
							tsShirtDesign::sdPut("Age: ".$m->smAge);
							tsShirtDesign::sdPut("Height: ".$m->smHeight);
							tsShirtDesign::sdPut("Weight: ".$m->smWeight);
							tsShirtDesign::sdPut("Comments: ".$m->smComments);
						}
					?>
					</ul>					
				</td>				
			</tr>
		</table>
<?php
}	// n function doShirt
?>
