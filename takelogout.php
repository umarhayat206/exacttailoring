<?php

//session_start();
include_once('includes/globals.php');

//session_unregister('chkuser');
$_SESSION['chkuser'] = "";
$_SESSION['auth'] = false;
$_SESSION['initials'] = "";

//header('location:login.php');
echo ("<script>window.location='"._URL_."admin_login.php';</script>");

?>                                