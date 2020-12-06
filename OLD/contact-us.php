<?php
$pageTitle = "Contact ";

include("code/application_code_includes_and_globals_file.php");
include($siteRoot."includes/html_head.php");
include($siteRoot."includes/page_header.php");

$mailSent = false;
$errMessage = "";
if($_POST['msgSend']=="Send"){
	$yourName = trim($_POST['yourName']);
	$yourEmail = trim($_POST['yourEmail']);
	$msgSubject = trim($_POST['msgSubject']);
	$msgContent = trim($_POST['msgContent']);
	if($yourName!="" || $yourEmail!="" || $msgSubject!="" || $msgContent!=""){
		//All good, send mail. TODO: validation email address
		$subject = $msgSubject." - sent via ".$siteBasicTitle;
		$message = $msgContent."\r\n"."From ".$yourName." [".$yourEmail."]";
		$headers = "From: ".$yourEmail."\r\n"."Reply-To: ".$yourEmail."\r\n";
		//mail($siteEmail,$subject,$message,$headers);
		//mail("may@silvermover.com",$subject,$message,$headers);
		//mail('may@silvermover.com', 'Test', $message);
		//mail('itsaret_m@hotmail.com', 'Exact Personal Tailoring Services', $message);
		//mail('itsaret.h@gmail.com', 'Exact Personal Tailoring Services', $message);
		//mail('name_may13@yahoo.com', 'Exact Personal Tailoring Services', $message);
		//$mailSent = true;

		//----------------

		$mail = new PHPMailer();
		$mail->From = $yourEmail;
		$mail->FromName = $yourName;
		$mail->AddAddress($siteEmail, $siteEmail);
		//$mail->AddAddress("may@silvermover.com", "aaaa");
		$mail->Subject = $subject;
		$mail->MsgHTML($message);
		//$mail->SetLanguage('en','language/'); 
		if($mail->Send()){
			$mailSent = true;
		}else{
			echo "<script language='javascript' type='text/javascript'>
				alert('" .$mail->ErrorInfo. "');
			</script>";
		}

	}else{
		$errMessage="<p class='validationArea'>Please ensure all fields are completed</p>";
	}
}

?>
<h2>Contact us</h2>
<div id="contactUs">
<?php if($mailSent==false){?>
	<p>Please complete the form below to contact us via email</p>
	<form id="contactUsForm" method="post" action="<?php echo($_SERVER['PHP_SELF']);?>">
		<fieldset>
			<legend>Message details</legend>
			<?php echo($errMessage);?>
			<?php smControls::smTextBox("Your Name: ","yourName",$_POST['yourName']);?><br />
			<?php smControls::smTextBox("Your email: ","yourEmail",$_POST['yourEmail']);?><br />
			<?php smControls::smTextBox("Subject: ","msgSubject",$_POST['msgSubject']);?><br />
			<?php smControls::smTextArea("Message: ","msgContent",$_POST['msgContent']);?><br />
			<?php smControls::smButton("Send","msgSend");?>
		</fieldset>
	</form>
</div>
<?php }else{ //Mail send ?>
	<p>Thank you for contacting us. We will be in touch soon.</p>
<?php } //If mail sent?>
<?php include($siteRoot."includes/page_footer.php");?>
   

