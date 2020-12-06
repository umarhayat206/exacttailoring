<?php

/** PREPARE THE FULL SERVER URL **/
$_SERVER['FULL_URL'] = 'http';
if($_SERVER['HTTPS']=='on'){$_SERVER['FULL_URL'] .=  's';}
$_SERVER['FULL_URL'] .=  '://';
if($_SERVER['SERVER_PORT']!='80') $_SERVER['FULL_URL'] .=  $_SERVER['HTTP_HOST'].':'.$_SERVER['SERVER_PORT'].$_SERVER['SCRIPT_NAME'];
else
$_SERVER['FULL_URL'] .=  $_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
if($_SERVER['QUERY_STRING']>' '){$_SERVER['FULL_URL'] .=  '?'.$_SERVER['QUERY_STRING'];}
/** *************************** **/

/** *******************************User Authentication******************************** **/
//Check to see if the Auth Session variable has been set... if not set it and make false
if ($_SESSION['auth']==""){
 	$_SESSION['auth']="false";
}

if ($_SESSION['backToAdmin']==""){
 	$_SESSION['backToAdmin']="false";
}
	
//Back to admin button has been clicked
if($_GET['backToAdmin']!="" && $_SESSION['backToAdminUser']->mRole>1){
	$_SESSION['auth'] = $_SESSION['backToAdminUser'];
	$_SESSION['backToAdminUser']="false";
	//header("location: admin-index.php");
	echo "<script language='javascript' type='text/javascript'>window.location='admin-index.php';</script>";
	
}

//Check if in admin page and authorised 
if (strstr($_SERVER['FULL_URL'], "/admin-")){
	if ($_SESSION['auth'] == 'false' || $_SESSION['auth']->mRole<2){
		//header("location: index.php");
		echo "<script language='javascript' type='text/javascript'>window.location='admin-index.php';</script>";
		echo("<META http-equiv='refresh' content='0;URL=index.php'>"); //Just to be sure...
	}
}

//Check if in member page and authorised 
if (strstr($_SERVER['FULL_URL'], "/member-")){
	if ($_SESSION['auth'] == 'false'){
		//header("location: index.php");
		echo "<script language='javascript' type='text/javascript'>window.location='admin-index.php';</script>";
		echo("<META http-equiv='refresh' content='0;URL=index.php'>"); //Just to be sure...
	}
}

?>