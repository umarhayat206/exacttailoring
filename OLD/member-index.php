<?php
$pageTitle = "My account - ";

include("code/application_code_includes_and_globals_file.php");
include($siteRoot."includes/html_head.php");
include($siteRoot."includes/page_header.php");

include($siteRoot."forms/member_signup_code.php");

include($siteRoot."panels/body_measurement_profile_code.php");
include($siteRoot."panels/shirt_measurement_profile_code.php");
?>

<h3>Welcome to Exact Tailoring members area</h3>
<?php include($siteRoot."includes/member_navigation.php");?>
<p>
	Welcome to your personal page at Exact Tailoring. Here you can find all your personal information 
	such as addresses, previous orders and measurement profiles. You can amend this information to 
	make sure it is up to date.
</p>
<h5 id="showPanelPD">Personal details</h5>
<p>
	View or change your address and or login details here.
</p>
<div id="panelPD">
	<?php include($siteRoot."forms/member_signup_form.php");?>
</div>
 
<br />

<?php include($siteRoot."includes/page_footer.php");?>