<?php


if(empty($_SESSION['chkuser'])){ 
	echo ("<script>window.location='admin_login.php';</script>");
}

if($_SESSION['auth'] == false){ 
	echo ("<script>window.location='admin_login.php';</script>");
}

?>