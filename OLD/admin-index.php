<?php
include("code/application_code_includes_and_globals_file.php");
include($siteRoot."includes/html_head.php");
include($siteRoot."includes/admin_page_header.php");

include($siteRoot."panels/admin_orders_code.php");

//echo $user->mRole."-----";
?>
<h2>Orders</h2>
<p class='smallText centered'>
	<img src='styles/images/<?php echo(tsShoppingCart::scStatusImage(2));?>' title='Confirmation of Payment' alt='Confirmation of Payment icon' /> Confirmation of Payment -&gt; 
	<img src='styles/images/<?php echo(tsShoppingCart::scStatusImage(3));?>' title='Processing' alt='Processing icon' /> Processing (handed to factory) -&gt; 
	<img src='styles/images/<?php echo(tsShoppingCart::scStatusImage(4));?>' title='In Production' alt='In Production icon' /> In Production -&gt; 
	<img src='styles/images/<?php echo(tsShoppingCart::scStatusImage(5));?>' title='Order shipped' alt='Order shipped icon' /> Order shipped -&gt; 
	<img src='styles/images/<?php echo(tsShoppingCart::scStatusImage(6));?>' title='Completed' alt='Completed icon' /> Completed
</p>

<?php include($siteRoot."panels/admin_orders_panel.php");?>
<?php include($siteRoot."includes/admin_page_footer.php");?>