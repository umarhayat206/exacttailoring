<?php
$pageTitle = "";

include("code/application_code_includes_and_globals_file.php");
include($siteRoot."includes/html_head.php");
include($siteRoot."includes/page_header.php");


include($siteRoot."panels/order_status_code.php");
?>
<h3>Order status</h3>
<?php include($siteRoot."includes/member_navigation.php");?>
<p>You can review your all the orders you have placed with Exact</p>

<?php include($siteRoot."panels/order_status_panel.php");?>


<?php include($siteRoot."includes/page_footer.php");?>