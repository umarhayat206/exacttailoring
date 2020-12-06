<?php
// The message
$message = "Line 1\nLine 2\nLine 3";

// In case any of our lines are larger than 70 characters, we should use wordwrap()
$message = wordwrap($message, 70);

// Send
//mail('ablake@cwcs.co.uk', 'Test', $message);
/*mail('may@silvermover.com', 'Exact Personal Tailoring Services', $message, "Exact Personal Tailoring");
mail('itsaret_m@hotmail.com', 'Exact Personal Tailoring Services', $message, "Exact Personal Tailoring");
mail('itsaret.h@gmail.com', 'Exact Personal Tailoring Services', $message, "Exact Personal Tailoring");
mail('name_may13@yahoo.com', 'Exact Personal Tailoring Services', $message, "Exact Personal Tailoring");*/

include('class.phpmailer.php');
$mail = new PHPMailer();
$mail->From = "may@silvermover.com";
$mail->FromName = "exacttailoring.com";
//$mail->AddAddress($siteEmail, "exacttailoring.com");
$mail->AddAddress("may@silvermover.com", "exacttailoring.com");
$mail->Subject = $subject;
$mail->MsgHTML($message);
//$mail->SetLanguage('en','language/'); 
$mail->Send();
                    
?>

