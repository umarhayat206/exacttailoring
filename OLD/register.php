<?php
$pageTitle = "Register with ";

include("code/application_code_includes_and_globals_file.php");
include($siteRoot."includes/html_head.php");
include($siteRoot."includes/page_header.php");

include($siteRoot."forms/member_signup_code.php");
?>
	<h3>Sign up</h3>	
	<p>
		By registering you can:
	</p>
	<ul class="points">
		<li>Create and save measurement profiles</li>
		<li>Make a purchase</li>
		<li>Access previous orders and order status information</li>	
	</ul>
	<p>
		Please fill out the form below to get your own membership account with Exact Tailoring. Thi will give you access to your measurements, previous orders and contact information.
	</p>
	<?php include($siteRoot."forms/member_signup_form.php");?>

<?php include($siteRoot."includes/page_footer.php");?>