<?php

if($_GET['delId']!="" && $_SESSION['auth']!="false"){
	tsShoppingCart::scRemoveItem($_GET['delId']);	
}

function putCartItems($memberId,$shippingHandlingCharge,$OpenPromotion,$promotionDiscount){
	$cart = tsShoppingCart::scGetInProgressMemberCart($memberId);
	$items = $cart->scListItems($cart->scId);
	$total = 0;
	$numShirts = 0;
	$numberShirtPromotion = 0;
	$discount = 0;
	$discountItem = 0;
	if(count($items)>0){
		foreach($items as $item){
			//Get item type and adjust description
			if($item->sciFId>0){ //SHIRT
				$numShirts += $item->sciQty;
				$fabric = tsFabrics::fabricGetOne($item->sciFId);
				//print_r($fabric);
				//$fabric = $fabric[0];
				
				if($item->sciSpecial2==1){
					$descText = "Custom tailored shirt with ".$fabric->ftName.", ".$fabric->fName." fabric (Special Offer - two silky ties)";
				}else{
					$descText = "Custom tailored shirt with ".$fabric->ftName.", ".$fabric->fName." fabric";
				}
				
				$detailsText = "";
				//$price = $fabric->fPricePerShirt;
			
			//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
			
				// TODO:: PROMOTION (check product from promotion set?) product id (localhost) = 169,170,171,172,173 , product id (lonline) = 174,175,176,177,178
				//if($item->sciFId==174 || $item->sciFId==175 || $item->sciFId==176 || $item->sciFId==177 || $item->sciFId==178){	// Online
				//if($item->sciFId==169 || $item->sciFId==170 || $item->sciFId==171 || $item->sciFId==172 || $item->sciFId==173){	// Localhost
				/*	$numberShirtPromotion += $item->sciQty;	// check howmany product to by from promotion set
					if($numberShirtPromotion %2 == 0){		// if buy product from promotion set >2 get discount
						$discountItem = $numberShirtPromotion/2;
						$discount = $promotionDiscount * $discountItem;
					}else{
						if($numberShirtPromotion > 2){
							$discountItem = $numberShirtPromotion/2;
							$discount = $promotionDiscount * (int)$discountItem;
						}else{
							$discount = $discount;		// no discount
						}
					}
				}else{
					$discount = $discount;
				}
				*/
			//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
			
			}else{ //OTHER PRODUCT
				$productOrder = tsProductOrder::poGetOne($item->sciPoId);
				$product = tsProductTypes::productTypeGetOne($productOrder->poPtId);
				$descText = $product->ptName." (".$product->pcName.")";
				$detailsText = "";
				//$price = $item->sciPrice;
			}
			
			/*if($_SESSION['affilate']){
				$price = $item->sciPrice/2;
				$total+=$price * $item->sciQty;
			}else{*/
				$price = $item->sciPrice;
				$total+=($price * $item->sciQty);
			//}
			
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
			$countboxerdiscound=0;
			if($boxeritems>2){
				for($j=1;$j<=$boxeritems;$j++){
					
					if($j%3==0){
						$countboxerdiscound++;
						$bprice+=$boxerprice/2;
					}else{
						$bprice+=$boxerprice;
					}
				}
				$bprice = number_format($bprice,2);
				$bprice2 = number_format($boxerprice * $boxeritems,2);
			}
			
			// --------------------------- edit 07-01-2012
	
			echo("
				<tr>
					<td>
						<a href='member-checkout?delId=".$item->sciId."' title='Delete item' onclick='javascript:return confirm(\"Are you sure you want to delete this item?\")' ><img src='styles/images/cross.png' alt='Delete item' /></a>
					");
			
			if($detailsText!="") // See if there are any details. If so, show the button
				//$payoutCode="";
				echo("<img src='styles/images/magnifier.png' alt='View details' id='".$item->sciId."' class='clicker' />");		
				//	".$descText."--".$item->sciPoId."--".$item->sciFId."
				echo("
					</td>
					<td>
						".$descText."
					</td>
					<td class='number'>&pound;".$price."</td>
					<td class='number'>".$item->sciQty."</td>
					<td class='number'>&pound;".($price * $item->sciQty)."</td>
				</tr>
				<tr>
					<td colspan='5'>
						<div class='hidden' id='pane".$item->sciId."'>
							".$detailsText." 
						</div>
					</td>
				</tr>
				");
			
			//$payoutCode .= $descText.",".($price * $item->sciQty).",";
		}
		//$_SESSION['orderPayoutCode'] = $payoutCode;
		
		// TODO:: PROMOTION
		//if($numShirts<2){
		if($OpenPromotion != "OPEN"){		//echo "-1-"; //
			//Put shipping plus totals
			$total += $shippingHandlingCharge;
			echo("
				<tr>
					<td></td>
					<td>Shipping &amp; Handling</td>
					<td class='number'>&pound;".$shippingHandlingCharge."</td>
					<td class='number'>1</td>
					<td class='number'>&pound;".$shippingHandlingCharge."</td>
				</tr>
				<tr>
					<td></td>
					<th>Total</th>
					<td class='number'></td>
					<td class='number'></td>
					<th class='number'>&pound;".$total."</th>
				</tr>");
		/*	
		}else if($numShirts >= 2 && $OpenPromotion=="OPEN"){	//echo "-2-"; //
			// totals - discount
			$promotionPrice=$total;
			if($promotionPrice >= 100 && $promotionPrice <= 200){
				$total -= 10;
				$discount = 10;
			}else if($promotionPrice > 200){
				$total -= 25;
				$discount = 25;
			}
			echo("
				<tr>
					<td></td>
					<td>Shipping &amp; Handling (Free on orders of 2 or more shirts)</td>
					<td class='number'>&pound;".$shippingHandlingCharge."</td>
					<td class='number'>0</td>
					<td class='number'>0</td>
				</tr>
				<tr>
					<td></td>
					<td>Discount (Promotion)</td>
					<td class='number'>&pound;".$discount."</td>
					<td class='number'>1</td>
					<td class='number'>&pound;".$discount."</td>
				</tr>
				<tr>
					<td></td>
					<th>Total</th>
					<td class='number'></td>
					<td class='number'></td>
					<th class='number'>&pound;".$total."</th>
				</tr>");
		*/	
		}else if($OpenPromotion=="OPEN"){		//echo "-3-"; //
			// totals + shipping , no discount
			
			// --------------------------- edit 07-01-2012
			
			if($boxeritems>2){ 
				$promotionPrice=$total-$bprice2;
			}else{ 
				$promotionPrice=$total;
			}
			
			if($promotionPrice <= 100){
				$discount = "10%";
				$total -= ($promotionPrice * 10) / 100;
				$discount2 = ($promotionPrice * 10) / 100;

			}else if($promotionPrice > 100 && $promotionPrice < 300){
				$discount = "15%";
				$total -= ($promotionPrice * 15) / 100;
				$discount2 = ($promotionPrice * 15) / 100;

			}else if($promotionPrice >=300){
				$discount = "25%";
				$total -= ($promotionPrice * 25) / 100;
				$discount2 = ($promotionPrice * 25) / 100;

			}else{
				$discount = 0;
			}
			
			if($boxeritems>2){
				$total -= $boxerprice / 2;
				
				$showboxerdiscound="<tr>
					<td></td>
					<td>Discount  (Buy two pairs of boxer shorts and get a third for half price)</td>
					<td class='number'>&pound;".(number_format($boxerprice / 2,2))."</td>
					<td class='number'>$countboxerdiscound</td>
					<td class='number'>&pound;".(number_format(($boxerprice / 2) * $countboxerdiscound,2))."</td>
				</tr>";
			}
			
			// --------------------------- edit 07-01-2012
			
			$total += $shippingHandlingCharge;
			$total=number_format($total,2);
			$discount2=number_format($discount2,2);
			
			echo("
				<tr>
					<td></td>
					<td>Discount  (Promotion not include Shipping)</td>
					<td class='number'>".$discount."</td>
					<td class='number'>1</td>
					<td class='number'>&pound;".$discount2."</td>
				</tr>
				$showboxerdiscound
				<tr>
					<td></td>
					<td>Shipping &amp; Handling</td>
					<td class='number'>&pound;".$shippingHandlingCharge."</td>
					<td class='number'>1</td>
					<td class='number'>&pound;".$shippingHandlingCharge."</td>
				</tr>
				<tr>
					<td></td>
					<th>Total</th>
					<td class='number'></td>
					<td class='number'></td>
					<th class='number'>&pound;".$total."</th>
				</tr>");
			
		}else{			//echo "-4-";
			echo("
				<tr>
					<td></td>
					<td>Shipping &amp; Handling (Free on orders of 2 or more shirts)</td>
					<td class='number'>&pound;".$shippingHandlingCharge."</td>
					<td class='number'>0</td>
					<td class='number'>0</td>
				</tr>
				<tr>
					<td></td>
					<th>Total</th>
					<td class='number'></td>
					<td class='number'></td>
					<th class='number'>&pound;".$total."</th>
				</tr>");			
		}
		
		/*echo("
			<tr>
				<td></td>
				<th>Total</th>
				<td class='number'></td>
				<td class='number'></td>
				<th class='number'>&pound; ".$total."</th>
			</tr>");*/
	}else{
		echo("<h3>You currently have no items in your shopping cart</h3>");
	}
	return($total);
	
}

?>