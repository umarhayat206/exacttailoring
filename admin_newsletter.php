<?php

include_once('includes/globals.php');
include_once('includes/check_admin_login.php');
include_once('includes/admin_html_head.php');
include_once('forms/admin_form_head.php');

include_once("includes/tiny_mce_script.php");
include_once("includes/script.php");

echo "<div class='content_res'>";

include('forms/admin_newsletter_current_pages.php');
include('forms/admin_newsletter_add_edit.php');

echo "</div>";
include_once('forms/admin_form_end.php');
?>