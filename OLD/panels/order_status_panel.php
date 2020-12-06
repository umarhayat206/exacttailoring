<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
	$(".clicker").click(function(){
		$("#pane" + this.id).slideToggle();
	})
	
	$(".clicker2").click(function(){
		$("#pan" + this.id).slideToggle();
	})
})
//]]>
</script>
<table id="orderStatus" summary="Table showing previous shopping carts">
	<thead>
		<tr>
			<th>Options</th>
			<th>Order date</th>
			<th># items</th>
			<th>Total value</th>
			<th>Status</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>Options</th>
			<th>Order date</th>
			<th># items</th>
			<th>Total value</th>
			<th>Status</th>
		</tr>
	</tfoot>
	<tbody>
		<?php showPreviousOrders($_SESSION['auth']->mId);?>
		<?php //showPreviousOrders("3746");?>
	</tbody>
</table>