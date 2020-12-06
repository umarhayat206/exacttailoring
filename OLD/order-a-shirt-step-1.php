<?php
$pageTitle = "Order a bespoke shirt from ";

include("code/application_code_includes_and_globals_file.php");

include($siteRoot."includes/html_head.php");
include($siteRoot."includes/page_header.php");

include($siteRoot."forms/fabric_chooser_code.php");
?>
<img src="styles/images/shirt.gif" title="Order a bespoke shirt" alt="Picture of a custom shirt" id="innerPic" />
<h2>Order a shirt step 1</h2>
<?php include($siteRoot."panels/shirt_steps.php");?>
<p>
	
	Exact Personal Tailoring offers the comfort benefits of made to measure for
	less than the price you could pay for off the peg. Whatever your size,
	whatever your shape, Exact can provide you with a fine quality shirt that
	fits as it should do, offering excellent comfort at a price that will enable
	you to discard the old and stock up your wardrobe regularly. Remember, our
	personalization service is free when ordering two shirts or more.
</p><br />
<h5>
	Select your desired fabric from our selection below.
</h5>

<?php include($siteRoot."forms/fabric_chooser_form.php");?>

<?php include($siteRoot."includes/page_footer.php");?>