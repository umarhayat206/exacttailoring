<?php

/**
 * Title:- Collection of standard/global variables and connection details
 * Description:-
 * @copyright 2007
 */

@session_start();

date_default_timezone_set('Europe/London');

// GLOBAL VARIABLES

$smCompanyName = "Exact Tailoring"; //TODO: Move to db table
$smMainEmail = "info@exacttailoring.com"; //TODO: Move to db table
$siteContactNumber = "01 789 205612";
$siteContactNumber2 = "+44 (0) 1789 205 612";

$siteDescription="Buy tailor made shirts - Handmade shirts, bespoke made-to-measure by Exact Tailoring, design and order your own shirt online.";
$siteKeywords="made to measure shirts, tailor made shirts, handmade shirts, bespoke shirts, design your own shirt, tailored shirts, tailor made trousers, Jackets, Trousers, Pyjamas, Boxers";
$siteBasicTitle="Buy tailor made shirts online -  Any size same price - no extra charge for large sizes";
//$siteBasicTitle="Buy tailor made shirts - Order made to measure shirts online";

$base_url = "";
if ($_SERVER['SERVER_PORT'] == '443' OR $_SERVER['SERVER_PORT'] == '80')
{
	$_base_path = $_SERVER['SERVER_NAME'].str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
	
	if ($_SERVER['SERVER_PORT'] == '443')
	{
		$base_url = "https://".$_base_path;
	}
	else
	{
		$base_url = "http://".$_base_path;
	}
}
else
{
	$base_url = "http://".$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
}

define(_URL_,$base_url);

$site_admin=$base_url;

$root= $_SERVER['DOCUMENT_ROOT']."/";
//$root= $_SERVER['DOCUMENT_ROOT']."/site-preview/exactnew/";

/*
$URL1 = explode('.', $_SERVER['HTTP_HOST']);
$subdomain = '';
if(count($URL1) === 3){
	if($URL1[0]=='www'){
		//$URL1[0] = 'en';
		$_SESSION['langAvailable'] = 0; 
		//$_SESSION['langAvailable'] = $URL1[0];
	}else{
		$_SESSION['langAvailable'] = 1; 
		//$_SESSION['langAvailable'] = $URL1[0];
	}
 
	$subdomain = $URL1[0].'.'; 
 
}else{
	$_SESSION['langAvailable'] = 0; 
}
*/


//echo $_SESSION['langAvailable']."-".$URL1[0]."-".$URL1[1];
/*
$host = 'localhost';
$use = 'root';
$pwd = 'root';
$dbname = 'db_exact_new';
*/

// $host = 'localhost';
// $use = 'exacttai_exact';
// $pwd = 'uSqwsL%te.s';
// $dbname = 'exacttai_exact2db';

$host = 'localhost';
$use = 'root';
$pwd = '';
$dbname = 'exacttai_exact2db';


$conn=mysql_connect($host,$use,$pwd);
$db=mysql_select_db($dbname,$conn);

//include_once "code/sm_input.php";
include_once "code/sm_controls.php";
include_once "code/sm_user.php";
include_once "code/sm_category.php";
include_once "code/sm_order.php";
include_once "code/sm_product.php";	
include_once "code/sm_image.php";
include_once "code/sm_indexfeature.php";	
include_once "code/sm_feature.php";
include_once "code/sm_fabric.php";
include_once "code/sm_comment.php";
include_once "code/sm_pattern.php";
include_once "code/sm_color.php";
include_once "code/sm_catalogue.php";
include_once "code/sm_content.php";
include_once "code/sm_setting.php";
include_once "code/sm_measurement.php";
include_once "code/sm_vouchers.php";
include_once "code/sm_promotion.php";

function setVar_GET(){
	//$request= substr($_SERVER['REQUEST_URI'],strlen("/"));
	$request= substr($_SERVER['REQUEST_URI'],strlen(str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME'])));
	$exQuestionMark=explode("?", $request);
	
	$checkOldPath=$exQuestionMark[0];
	
	//$exQuestionMark[0]= str_replace(".html","",$exQuestionMark[0]);
	$exSlash= explode("/",$exQuestionMark[0]);
	for($i=0;$i<count($exSlash);$i++):
		//if($i%2==0):
			if($exSlash[$i]!=""):
				$_GET["get".$i]=$exSlash[$i];
				$GLOBAL[$i]=$exSlash[($i)];
				//echo "<h1>\$_GET['{$exSlash[$i]}']=".$_GET[$exSlash[$i]]." </h1>" ;  
			endif;
		//endif;
	endfor;
	return $GLOBAL;
}	//__end func__//

//setVar_GET();
$__get=setVar_GET();

//$thismonth=substr(date('d/n/o',now()),3,2);

// update what room check out today
//$today =date("Y-m-d H:i:s",mktime());
//mysql_query("UPDATE booking SET bookVisibleFlag = '0' WHERE bookUntil < '$today' ");

function html2text($text='',$limit=0)
{
	if($text!='' && $limit>0)
	{
		$search = array(
			'@<script[^>]*?>.*?</script>@si',
			'@<style[^>]*?>.*?</style>@siU',
			'@<[\/\!]*?[^<>]*?>@si',
			'@<![\s\S]*?–[ \t\n\r]*>@',
			'/\s{2,}/'
			);
		$text = preg_replace($search, "\n", $text);
		$pat[0] = "/^\s+/";
		$pat[2] = "/\s+\$/";
		$rep[0] = "";
		$rep[2] = " ";
		$text = preg_replace($pat, $rep, trim($text));
		return substr($text,0,$limit);

	}
}


?>