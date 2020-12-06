<?php

include_once('includes/globals.php');
include_once('class.phpmailer.php');
$mail= new PHPMailer();

/*
if($_POST['tapemeasureofferFrmSubmitted']){
	$mail->From = $_POST['subtapemeasure_email'];
	$mail->FromName = $_POST['subtapemeasure_name'];
	
	$mail->AddAddress($smMainEmail, $smCompanyName);
	$mail->AddCC("may@silvermover.com", "Admin");
	$mail->Subject = "Customer has completed the contact form";

	$body="<font face='Arial' size='2'>A customer has completed the contact form on the website.
	<br />Details as follows<br /><br />--------------------------------------</font>
	<font face='Arial' size='2'>
		<br />Name: <b>{$_POST['subtapemeasure_name']}</b>
		<br />E-mail: <b>{$_POST['subtapemeasure_email']}</b>
		<br />Message: <b>{$_POST['subcontactmessage']}</b>
		<br /><br />
	</font>";
	
	$mail->MsgHTML($body);
	if($mail->Send()) {	// send the mail
		echo "<script language='javascript' type='text/javascript'>
			alert('Thank you for your submit contact form. We will be in touch as soon as possible.');
			history.go(-1);
		</script>";
	}else{
		echo "<script language='javascript' type='text/javascript'>
			alert('Failed to send mail');
			history.go(-1);
		</script>";
	}
	
}
*/

if($_POST['tapemeasureofferFrmSubmitted']){
        if (empty($_POST['contactverify'])){
		$errstr[] = "Please validate the image code";
	}else{
		if(strtolower($_REQUEST['contactverify']) != $_SESSION['random_number']){
			$errstr[] = "The security code you entered was incorrect";
		}
	}
        
        if ( count( $errstr ) ){
		echo "<p style=\"color: #FF0000\">Error : ";
		foreach( $errstr as $k=>$err ){
			echo $err;
		}
		echo "</p>";

	}else{

                $mail->From = $_POST['tapemeasure_email'];
                $mail->FromName = $_POST['tapemeasure_name'];
                
                $mail->AddAddress($smMainEmail, $smCompanyName);
		$mail->AddCC("mo0511@aol.com", "Admin");
		$mail->AddBCC("poppo@silvermover.com", "Webmaster");
                $mail->Subject = "Customer has completed the tape measure offer form";

                $body="<font face='Arial' size='2'>A customer has completed the tapem easure offer form on the website.
		<br />Details as follows<br /><br />--------------------------------------</font>
		<font face='Arial' size='2'>
			<br />Name: <b>{$_POST['tapemeasure_name']}</b>
			<br />ADDRESS: <b>{$_POST['tapemeasure_address']}</b>		
			<br />POST CODE: <b>{$_POST['tapemeasure_postcode']}</b>				
			<br />E-mail: <b>{$_POST['tapemeasure_email']}</b>
			<br />TELEPHONE NUMBER: <b>{$_POST['tapemeasure_tel']}</b>
			<br /><br />
		</font>";
		$body .= "<br /><p>Sender IP: <strong>" . $_SERVER["REMOTE_ADDR"] . "</strong></p>";
		$body .= "<br /><p>Referer URL: <strong>" . $_SERVER['HTTP_REFERER'] . "</strong></p>";

		$sql = "INSERT INTO ex_subscriber SET "
		 . " sub_fullname ='" .mysql_real_escape_string($_POST['tapemeasure_name']) . "', "
		 . " sub_address ='" .mysql_real_escape_string($_POST['tapemeasure_address']) . "', "
		 . " sub_email ='" .mysql_real_escape_string($_POST['tapemeasure_email']) . "', "
		 . " sub_postcode ='" .mysql_real_escape_string($_POST['tapemeasure_postcode']) . "', "
		 . " sub_telephone ='" .mysql_real_escape_string($_POST['tapemeasure_tel']) . "', "
		 . " sub_dateadd ='" .date('Y-m-d H:s:i') . "', "
		 . " sub_status =1 , "
		 . " sub_title ='Tape Measure'"
		
		;
		//echo $sql;
		$result = mysql_query($sql);
		//echo $result;
		//echo $body;exit();
		
                $mail->MsgHTML($body);
                if($mail->Send()) {	// send the mail
                        echo "<script language='javascript'  type='text/javascript'>
                                alert('Thank you for your submit tape measure offer form. We will be in touch as soon as possible.');
                                window.location='"._URL_."tapemeasureoffer';
                        </script>";
                }else{
                        echo "<script language='javascript'  type='text/javascript'>
                                alert('Failed to send mail');
                                window.location='"._URL_."tapemeasureoffer';
                        </script>";
                }
        }
}

?>