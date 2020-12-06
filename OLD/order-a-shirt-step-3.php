<?php
$pageTitle = "Select or create a measurement profile - ";

include("code/application_code_includes_and_globals_file.php");

//Unset any previous measurement sessions if user navigates back to this page (presumably because they clicked the wrong profile)
unset($_SESSION['bmId']);
unset($_SESSION['smId']);
unset($_SESSION['bodyMeasurement']);
unset($_SESSION['shirtMeasurement']);

include($siteRoot."panels/body_measurement_profile_code.php");
include($siteRoot."panels/shirt_measurement_profile_code.php");
include($siteRoot."forms/body_measurement_code_non_member.php");
include($siteRoot."forms/shirt_measurement_code_non_member.php");

include($siteRoot."includes/html_head.php");
include($siteRoot."includes/page_header.php");

?>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
	$('#addNewBM').click(function(){
		$("#shirtMeasurementForm").slideUp();
		$("#bodyMeasurementForm").slideToggle();	
	})
	$('#addNewSM').click(function(){
		$("#bodyMeasurementForm").slideUp();
		$("#shirtMeasurementForm").slideToggle();
	})
})
//]]>
</script>
<?php if($_REQUEST['smId']!="" || $errSmMeasurement!=""){ ?>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
	$("#shirtMeasurementForm").show();
})
//]]>
</script>
<?php } ?>
<?php if($_REQUEST['bmId']!="" || $errBmMeasurement!=""){ ?>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
	$("#bodyMeasurementForm").show();
})
//]]>
</script>
<?php } ?>
<h2>Order a shirt step </h2>
<?php include($siteRoot."panels/shirt_steps.php");?>
<p>
	You can create either a body or a shirt measurement below, or login on the left 
	to access your previously saved measurments.  
</p>
<h3>Standard Shirt Service</h3>
<p>
	For those with a regular size requirement, we require minimal measurements.
	Simply provide age, height, weight and collar size enabling an order to be
	placed quickly and easily online, telephone or by post using the post paid
	reply envelope provided.
</p>
<div class="columnLeft">
	<?php include($siteRoot."panels/body_measurement_profile.php");?>
</div>
<div class="columnRight">
	<?php include($siteRoot."panels/shirt_measurement_profile.php");?>
</div><br />

<?php include($siteRoot."forms/body_measurement_form.php");?>
<?php include($siteRoot."forms/shirt_measurement_form.php");?>



<?php include($siteRoot."includes/page_footer.php");?>