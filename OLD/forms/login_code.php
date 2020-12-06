<?php
$loginError="";

if($_POST['mLogin']=="Login" && $_POST['mUsername']!="" && $_POST['mPassword']!=""){
	$user = tsMembers::memberValidate($_POST['mUsername'],$_POST['mPassword']);
	if($user==false){
		$loginError = "<p class='validationArea'>Username and/or password is incorrect. Please try again</p>";
	}elseif($user->mLockedOut==1){
		$loginError = "<p class='validationArea'>This account has been locked. Please <a href='mailto:".$siteEmail."' title='Contact Exact Administration'>contact administration</a>.</p>";
	}elseif($user->mRole>1){
		$_SESSION['auth']=$user;
		//header("location: admin-index.php");
		echo "<script language='javascript' type='text/javascript'>window.location='admin-index.php';</script>";
	}else{
		$_SESSION['auth']=$user;
		//header("location: member-index.php");
	}
}

?>