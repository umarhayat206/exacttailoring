<?php
include("code/application_code_includes_and_globals_file.php");

//if($_SESSION['auth']->mRole!=4)(header("location: admin-index.php"));
if($_SESSION['auth']->mRole!=4){
	echo "<script language='javascript' type='text/javascript'>window.location='admin-index.php';</script>";
}

include($siteRoot."includes/html_head.php");
include($siteRoot."includes/admin_page_header.php");

include($siteRoot."forms/product_category_code.php");
include($siteRoot."panels/product_category_list_code.php");
include($siteRoot."forms/product_type_code.php");
include($siteRoot."panels/product_type_list_code.php");

?>
	<div id="adminProducts">
		<div class="columnLeft">
			<?php include($siteRoot."forms/product_category_form.php");?>
			<?php include($siteRoot."panels/product_category_list_panel.php");?>
		</div>
		<div class="columnRight">
			<?php include($siteRoot."forms/product_type_form.php");?>
			<?php include($siteRoot."panels/product_type_list_panel.php");?>
		</div>
	</div>

<?php include($siteRoot."includes/admin_page_footer.php");?>