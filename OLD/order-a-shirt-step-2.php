<?php
$pageTitle = "Create your shirt design - ";

include("code/application_code_includes_and_globals_file.php");

include($siteRoot."forms/shirt_builder_code.php"); // Put above HTML to allow header location changes

include($siteRoot."includes/html_head.php");
include($siteRoot."includes/page_header.php");



if($_REQUEST['fId']!=""){
	$_SESSION['fId']=$_REQUEST['fId'];
}elseif($_REQUEST['fId']=="" && $_SESSION['fId']==""){
	$pageError = "<p class='validationArea'>Please ensure you have selected a fabric first. <a href='order-a-shirt' title='Choose a fabric'>Click here to go back</a></p>";
}

?>
<h2>Order a bespoke shirt</h2>
<?php include($siteRoot."panels/shirt_steps.php");?>
<h5>
	Customise you shirt using the options below.
</h5>


<?php echo($pageError);?>

<?php include($siteRoot."forms/shirt_builder_form.php");?>
<?php include($siteRoot."panels/selected_fabric.php");?>

<?php include($siteRoot."includes/page_footer.php");?>