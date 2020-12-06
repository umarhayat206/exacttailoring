<?php
include("code/application_code_includes_and_globals_file.php");

//if($_SESSION['auth']->mRole!=4)(header("location: admin-index.php"));
if($_SESSION['auth']->mRole!=4){
	echo "<script language='javascript' type='text/javascript'>window.location='admin-index.php';</script>";
}

include($siteRoot."includes/html_head.php");
include($siteRoot."includes/admin_page_header.php");


include($siteRoot."forms/fabric_code.php");
include($siteRoot."panels/fabric_collection_code.php");
?>
	<div id="adminFabrics">
		<?php include($siteRoot."forms/fabric_form.php");?>
	</div>
	<?php include($siteRoot."panels/fabric_collection_panel.php");?>

<?php include($siteRoot."includes/admin_page_footer.php");?>