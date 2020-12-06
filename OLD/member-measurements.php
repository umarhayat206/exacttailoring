<?php
$pageTitle = "Measurement profiles - ";

include("code/application_code_includes_and_globals_file.php");
include($siteRoot."includes/html_head.php");
include($siteRoot."includes/page_header.php");

include($siteRoot."panels/body_measurement_profile_code.php");
include($siteRoot."panels/shirt_measurement_profile_code.php");

include($siteRoot."forms/body_measurement_code.php");
include($siteRoot."forms/shirt_measurement_code.php");
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
<h3>Measurment profiles</h3>
<?php include($siteRoot."includes/member_navigation.php");?>
<p>
	You can store any number of measurement profiles for future purchases. The profile name 
	is used to identify each profile (e.g. My measurements, Dads measurements). At least one
	profile is required to order a shirt. 
</p>
<h5>Measurment profiles</h5>
<p>
	Create or edit measurement profiles. All measurements are required unless stated otherwise.	
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