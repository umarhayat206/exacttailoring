<?php

//session_start();
include_once('includes/globals.php');

$_SESSION['chklevel'] = "";
$_SESSION['chkmemberuser'] = "";
$_SESSION['membername'] = "";
$_SESSION['memberlastactivity'] = "";
$_SESSION['currentOrder'] = "";
$_SESSION['auth'] = "";

//header('location:login.php');
echo ("<script>window.location='"._URL_."';</script>");

?>     