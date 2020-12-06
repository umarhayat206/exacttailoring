<?php

include_once('includes/globals.php');
include_once('includes/check_admin_login.php');
include_once('includes/admin_html_head.php');
include_once('forms/admin_form_head.php');
include_once('includes/tiny_mce_script2.php');

echo "<div class='content_res'>";

include('forms/admin_customer_comment.php');

echo "</div><br/>";	// n leftblock vertsortable 

include_once('forms/admin_form_end.php');

?>