<?php

//***** DECLARATIONS *****

//GLOBALS
$siteRoot = $_SERVER['DOCUMENT_ROOT']."/OLD/";
//$siteRoot = "/home/exacttai/public_html/";
$siteLocalRoot = "http://www.exacttailoring.com/OLD/";
//$siteLocalRoot = "http://184.154.61.194/~exacttai/";
//$siteRoot = $_SERVER['DOCUMENT_ROOT']."/exact/";
//$siteLocalRoot = "http://localhost/exact/";

//$siteUrl = "http://www.exacttailoring.com";

//TODO: Move to settings file
//$siteBasicTitle = "Tailor made shirts - Order made to measure shirts online";
$siteBasicTitle = "Measure Shirts - Order made to measure shirts online";
$siteKeywords = "made to measure shirts, tailor made shirts, hand made shirts, bespoke shirts, design your own shirt, tailored shirts.";
$siteDescription = "Hand made shirts, bespoke made-to-measure by Exact Tailoring, design and order your own shirt online.";

$companyName = "Exact";
$siteEmail = "info@exacttailoring.com";
//$siteEmail = "webmaster@exacttailoring.com";
//$siteEmail = "silvermover@yahoo.com";
$shippingHandlingCharge = 4.95;
//$promotionDiscount = 15.00;
$OpenPromotion = "OPEN"; // OPEN , CLOSE  set status to OPEN

$siteGuvnerEmail = "peter@lavery-bir.com";
//$siteSalesEmail = "mo0511@aol.com";
$siteSalesEmail = "orders@exacttailoring.com";
$siteProductionEmail = "anand@indrafashion.com, anand@exacttailoring.com";

//PAYMENT GATEWAY STUFF
$paypalApiKey = "";
$paypalEmail = "info@exacttailoring.com";
//$paypalEmail = "webmaster@exacttailoring.com";
//$paypalEmail = "silvermover@yahoo.com";

//PROTX GATEWAY VARIABLES
$siteVendorTxCodePart = "EX";
$siteProtxVendorName = "exactpersonalta";
$siteProtxCryptPassword = "quBC42XKRAUriWsR";     //SIM ACCOUNT PASSWORD
$siteProtxEmail = "orders@exacttailoring.com";
$strConnectTo = "LIVE"; // values can be "LIVE" or "TEST" or "SIMULATION"

//PRE-REQS
include($siteRoot."code/connection.php"); //Database connections
include($siteRoot."class.phpmailer.php");

//CLASSES
include($siteRoot."code/sm_functions.php");
include($siteRoot."code/sm_images.php");
include($siteRoot."code/sm_controls.php");
include($siteRoot."code/sm_countries.php");

include($siteRoot."code/ts_fabrics.php");
include($siteRoot."code/ts_members.php");
include($siteRoot."code/ts_products.php");
include($siteRoot."code/ts_shirt_measurements.php");
include($siteRoot."code/ts_body_measurements.php");
include($siteRoot."code/ts_shirt_design.php");
include($siteRoot."code/ts_shoppingcart.php");

session_start();

$user= new tsMembers;
$user->mId = "2826";
$user->mUsername = "may";
$user->mRole = 4;
$user->mGender = "";
$user->mFirstname = "";
$user->mLastname = "";
$user->mAddress = "";
$user->mCountry = "";
$user->mPostcode = "";
$user->mTel = "";
$user->mMobile = "";
$user->mFax = "";
$user->mEmail = "";
$user->mCurrency = "";
$user->mSignUpDate = "";
$user->mLastActivity = "";
$user->mLogins = "";
$user->mAdminNotes = "";
$user->mCatalogOrder = "";
$user->mLockedOut = "";
$user->mHowhear = "";
                
$_SESSION['auth']=$user;
           
include($siteRoot."forms/login_code.php");
include_once($siteRoot."includes/security.php");

?>