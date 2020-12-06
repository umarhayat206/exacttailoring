<?php

include_once('includes/globals.php');
include_once('includes/check_admin_login.php');
include_once('includes/admin_html_head.php');
include_once('forms/admin_form_head.php');

echo "<div class='content_res'>";

include('forms/admin_order.php');

echo "</div><br/>";
include_once('forms/admin_form_end.php');
?>