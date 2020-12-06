<?php
if($_SESSION['auth']!="false"){
	//Get item count for member
	$memCart = tsShoppingCart::scGetInProgressMemberCart($_SESSION['auth']->mId);
	$vals = tsShoppingCart::scTotals($memCart->scId);
	$numShirts = $vals['numShirts'];
	
	// --------------------------- edit 07-01-2012
	/*
	if($vals['value'] <= 100){
		$vals['value'] -= ($vals['value'] * 10) / 100;
	}else if($vals['value'] > 100 && $vals['value'] < 300){
		$vals['value'] -= ($vals['value'] * 15) / 100;
	}else if($vals['value'] >= 300){
		$vals['value'] -= ($vals['value'] * 25) / 100;
	}
	*/
?>
<div id="shoppingCart">
	<table summary="Table displaying current value of your shopping cart">
		<caption>Your shopping cart</caption>
		<tr>
			<td><?php echo($vals['quantity']>0?$vals['quantity']:"0");?> item(s)</td>
			<td class="number">&pound;<?php echo($vals['value']>0?(number_format($vals['value'],2)):"0.00");?></td>
		</tr>
		<?php
		//if($numShirts<2 ){
		if($OpenPromotion != "OPEN"){
		?>
		<tr>
			<td>Shipping &amp; handling</td>
			<td class="number">&pound;<?php echo($vals['value']>0?$shippingHandlingCharge:"0.00");?></td>
		</tr>	
		<tr>
			<th>Total</th>
			<th class="number">&pound;<?php echo($vals['value']>0?(number_format($shippingHandlingCharge + $vals['value'],0)):"0.00");?></th>
		</tr>
		<?php
		// TODO:: PROMOTION
		//}else if($numShirts >= 2 && $OpenPromotion=="OPEN"){	//
		?>
		<!--<tr>
			<td>Shipping &amp; handling</td>
			<td class="number">&pound;0.00</td>
		</tr>	
		<tr>
			<th>Total</th>
			<th class="number">&pound;<?php //echo($vals['value']>0?($vals['value']):"0.00");?></th>
		</tr>-->
		<?php
		}else if($OpenPromotion=="OPEN"){		//
		?>
		<tr>
			<td>Shipping &amp; handling</td>
			<td class="number">&pound;<?php echo($vals['value']>0?$shippingHandlingCharge:"0.00");?></td>
		</tr>	
		<tr>
			<th>Total</th>
			<th class="number">&pound;<?php echo($vals['value']>0?(number_format($shippingHandlingCharge + $vals['value'],2)):"0.00");?></th>
		</tr>
		<? 
		}else{
		?>
		<tr>
			<td>Shipping &amp; handling</td>
			<td class="number">&pound;0.00</td>
		</tr>	
		<tr>
			<th>Total</th>
			<th class="number">&pound;<?php echo($vals['value']>0?(number_format($vals['value'],2)):"0.00");?></th>
		</tr>
		<?php
		}
		?>
	</table>
	<a href="<?php echo($siteLocalRoot);?>member-checkout" title="Check out items">Check out</a>
</div>
<?php
} // if auth
?>