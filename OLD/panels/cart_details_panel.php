<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
	$(".clicker").click(function(){
		$("#pane" + this.id).slideToggle();
	})
})
//]]>
</script>
<table id="cartDetails" summary="Table of items currently in your shopping cart">
	<thead>
		<tr>
			<th>Options</th>
			<th>Description</th>
			<th class='number'>Price</th>
			<th class='number'>Qty</th>
			<th class='number'>Total</th>
		</tr>
	</thead>
	<tbody>
		<?php
		// TODO:: PROMPROTION
		$cartValue = putCartItems($_SESSION['auth']->mId,$shippingHandlingCharge,$OpenPromotion,$promotionDiscount);
		?>
	</tbody>
</table>