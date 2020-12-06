<?php

session_start();
$_SESSION['auth']='false';
session_destroy();
//header("location:index.php");

echo "<script language='javascript' type='text/javascript'>window.location='index.php';</script>";

?>