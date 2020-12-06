<?php
$pageTitle = "Review your order, sign up or register for ";

include("code/application_code_includes_and_globals_file.php");

include($siteRoot."forms/confirm_order_code.php");

include($siteRoot."forms/member_signup_code.php");
if($mId != "" && is_numeric($mId)){
	$_SESSION['auth'] = $selectedUser->memberGet($mId); //Get new signup and store to session.
}

include($siteRoot."includes/html_head.php");
include($siteRoot."includes/page_header.php");

if($_REQUEST['bmId']!=""){
	$_SESSION['bmId']=$_REQUEST['bmId'];
}
if($_REQUEST['smId']!=""){
	$_SESSION['smId']=$_REQUEST['smId'];
}


//REM: If a bmId or smId is available. USE IT!. If not look in SESSION for measurement object and use instead. 

?>
<h2>Order a bespoke shirt</h2>
<?php include($siteRoot."panels/shirt_steps.php");?>
<p>
	Please ensure that the information and options you have entered are correct.
</p>
<?php //Check to see if user logged in... If not show register form
if($_SESSION['auth']=="false"){
?>
<p>
	To complete your order, please log in on the left, or register below.
</p>
<?php include($siteRoot."forms/member_signup_form.php");?>
<?php
}else{ //if session auth != false
?>
<?php include($siteRoot."forms/confirm_order_form.php");?>
<?php
} //If Session Auth == false
?>
<?php include($siteRoot."includes/page_footer.php");?>