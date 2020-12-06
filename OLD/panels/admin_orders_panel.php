<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
	$(".clicker").click(function(){
		$("#pane" + this.id).slideToggle();
	})
})
//]]>
</script>
<div id="ordersList">
	<form id="orderListFilter" method="post" action="<?php echo($_SERVER['PHP_SELF']);?>">
		<fieldset>
			<legend>Filter list</legend>
			<?php smControls::smTextBox("Member text filter <span class='smallText'>(Name, username, address, email)</span>","filText",$_POST['filText']);?><br />
			<?php
				$arrayOfFilterStatuses = tsShoppingCart::getStatuses($_SESSION['auth']->mRole);
				array_unshift($arrayOfFilterStatuses,"Show all incomplete orders");
			?>
			<?php smControls::smDropDownList("Status","filStatus",$arrayOfFilterStatuses,$_POST['filStatus']);?><br />
			<?php smControls::smButton("Filter","filterList");?>
		</fieldset>
	</form>
	<p>
		The order page shows orders once they have been approved by the member. Please ensure that 
		a payment of the correct amount for the corresponding ID number has been made. Order status
		can be set to keep the customer informed via their member page of the current progress of 
		their order.
	</p>
	<form id="ordersListForm" method="post" action="<?php echo($_SERVER['PHP_SELF']);?>">
		<fieldset>
			<table summary="List of orders taken">
				<thead>
					<tr>
						<th>Order Id</th>
						<th>Member</th>
						<th>Order Date</th>
						<th>Value</th>
						<th>Method</th>
						<th>Status</th>
						<th>Options</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Order Id</th>
						<th>Member</th>
						<th>Order Date</th>
						<th>Value</th>
						<th>Method</th>
						<th>Status</th>
						<th>Options</th>
					</tr>		
				</tfoot>
				<tbody>
					<?php listOrders($_POST,$_SESSION['auth'],$siteLocalRoot);?>
				</tbody>
			</table>
			<?php smControls::smButton("Save changes","saveChanges");?>
		</fieldset>
	</form>
</div>