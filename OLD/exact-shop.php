<?php
$pageTitle = "Shop at ";

include("code/application_code_includes_and_globals_file.php");

include($siteRoot."forms/product_list_code.php");

//Signup malarky only used if required
include($siteRoot."forms/member_signup_code.php");
if($mId != "" && is_numeric($mId)){
	$_SESSION['auth'] = $selectedUser->memberGet($mId); //Get new signup and store to session.
}

include($siteRoot."includes/html_head.php");
include($siteRoot."includes/page_header.php");


?>
<h2>Exact Tailor Store</h2>
<p>
	Our store offers a variety of products. <strong>For shirts please go directly to our </strong>
	<a href="<?php echo($siteLocalRoot);?>order-a-shirt-step-1" title="Order a shirt">shirt builder page</a>
</p>
<?php include($siteRoot."panels/products_menu.php");?>
<?php include($siteRoot."forms/product_list.php");?>

<?php include($siteRoot."includes/page_footer.php");?>