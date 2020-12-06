<?php

include_once('includes/globals.php');
include_once('class.phpmailer.php');
$mail= new PHPMailer();

if($_POST['contactformSubmitted']){
        if (empty($_POST['contactverify'])){
		$errstr[] = "Please validate the image code";
	}else{
		if(strtolower($_REQUEST['contactverify']) != $_SESSION['random_number']){
			$errstr[] = "The security code you entered was incorrect";
		}
	}
        
        if ( count( $errstr ) ){
		echo "<p style=\"color: #FF0000\">";
		foreach( $errstr as $err ){
			echo $err;
		}
		echo "</p>";

	}else{

                $mail->From = $_POST['contactemail'];
                $mail->FromName = $_POST['contactname'];
                
                $mail->AddAddress($smMainEmail, $smCompanyName);
                $mail->AddCC("may@silvermover.com", "Admin");
                $mail->Subject = $_POST['contactsubject'];

                $body="<font face='Arial' size='2'>Customer got problem on website.
		<br />Details as follows<br /><br />--------------------------------------</font>
		<font face='Arial' size='2'>
			<br />Name: <b>{$_POST['contactname']}</b>
			<br />E-mail: <b>{$_POST['contactemail']}</b>
			<br />Telephone: <b>{$_POST['contacttelephone']}</b>
			<br />Message: <b>{$_POST['contactmessage']}</b>
			<br /><br />
                </font>";
                $body .= "<br /><p>Sender IP: <strong>" . $_SERVER["REMOTE_ADDR"] . "</strong></p>";
		$body .= "<br /><p>Referer URL: <strong>" . $_SERVER['HTTP_REFERER'] . "</strong></p>";

                $mail->MsgHTML($body);
                if($mail->Send()) {	// send the mail
                        echo "<script language='javascript'  type='text/javascript'>
                                alert('Thank you for your submit contact form. We will be in touch as soon as possible.');
                                window.location='"._URL_."let_we_know_of_a_problem';
                        </script>";
                }else{
                        echo "<script language='javascript'  type='text/javascript'>
                                alert('Failed to send mail');
                                window.location='"._URL_."let_we_know_of_a_problem';
                        </script>";
                }
        }
}

?>