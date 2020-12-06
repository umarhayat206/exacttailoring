<?PHP
#############################################################
## iDevAffiliate Version 6
## Copyright - iDevDirect.com L.L.C.
## Website: http://www.idevdirect.com/
## Support: http://www.idevsupport.com/
## Email:   support@idevdirect.com
#############################################################

// ----------------------------------------------------------------
// We've designed this API file as simple as possible.  We didn't use any 
// complex queries and everything should be fairly self explanatory.
// Have fun customizing this API file to meet your needs.
// ----------------------------------------------------------------

// CONNECT TO THE DATABASE & MAKE SITE CONFIG SETTINGS AVAILABLE
// ----------------------------------------------------------------
require_once("../../API/config.php");
include_once("../../includes/validation_functions.php");

// QUERY THE DATABASE FOR SECRET KEY
// ------------------------------------------------------------------------------
$s_key = mysql_query("select secret from idevaff_config");
$s_key = mysql_fetch_array($s_key);
$s_key = $s_key['secret'];

// CHECK VALID SECRET KEY IS PRESENT AND VALID
// - The variable is already sanitized.
// - The variable is already validated through _GET, or _POST.
// ------------------------------------------------------------------------------

$secret = check_type_api('secret');
if ($secret == $s_key) {

// UPDATE ALL ACCOUNTS - RESET TO PAYOUT LEVEL 1
// ----------------------------------------------------------------
mysql_query("update idevaff_affiliates set level = 1");

// EMAIL ADMIN REPORT
// ----------------------------------------------------------------
include_once($path . "/templates/email/class.phpmailer.php");
include_once($path . "/templates/email/class.smtp.php");
$mail = new PHPMailer();
$mail->IsSMTP();

$mail->SMTPAuth = $smtp_auth;
$mail->SMTPSecure = "$smtp_security";
$mail->CharSet = "$smtp_char_set";
$mail->Host = "$smtp_host";
$mail->Port = $smtp_port;
$mail->Username = "$smtp_user";
$mail->Password = "$smtp_pass";

$mail->Subject = "iDevAffiliate API - Payout Level Reset";
$mail->From = "$address";
$mail->FromName = "iDevAffiliate System";
$mail->AddAddress("$address","iDevAffiliate System");
$mail->Body = "Payout levels for all affiliates have been reset to level 1.";

$mail->Send();
$mail->ClearAddresses();

} else {

// EMAIL FAILED SECRET NOTIFICATION
// ----------------------------------------------------------------
if (!$secret) { $secret = "None"; }
include_once($path . "/templates/email/class.phpmailer.php");
include_once($path . "/templates/email/class.smtp.php");
$mail = new PHPMailer();
$mail->IsSMTP();

$mail->SMTPAuth = $smtp_auth;
$mail->SMTPSecure = "$smtp_security";
$mail->CharSet = "$smtp_char_set";
$mail->Host = "$smtp_host";
$mail->Port = $smtp_port;
$mail->Username = "$smtp_user";
$mail->Password = "$smtp_pass";

$mail->Subject = "iDevAffiliate API - Payout Level Reset Failure";
$mail->From = "$address";
$mail->FromName = "iDevAffiliate System";
$mail->AddAddress("$address","iDevAffiliate System");
$mail->Body = "Invalid or missing secret key.  Payout levels have not been reset.\n\nKey Used: ". $secret;

$mail->Send();
$mail->ClearAddresses();

}


?>
