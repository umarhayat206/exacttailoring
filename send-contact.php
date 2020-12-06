<?php

include_once('includes/globals.php');
include_once('class.phpmailer.php');
$mail= new PHPMailer();

/*
if($_POST['subcontactformSubmitted']){
	$mail->From = $_POST['subcontactemail'];
	$mail->FromName = $_POST['subcontactname'];
	
	$mail->AddAddress($smMainEmail, $smCompanyName);
	$mail->AddCC("may@silvermover.com", "Admin");
	$mail->Subject = "Customer has completed the contact form";

	$body="<font face='Arial' size='2'>A customer has completed the contact form on the website.
	<br />Details as follows<br /><br />--------------------------------------</font>
	<font face='Arial' size='2'>
		<br />Name: <b>{$_POST['subcontactname']}</b>
		<br />E-mail: <b>{$_POST['subcontactemail']}</b>
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


$contactname = limitText($_POST['contactname'],60);
$contactemail = limitText($_POST['contactemail'],60);
$contactmessage = limitText($_POST['contactmessage'],300);
$contactverify = limitText($_POST['contactverify'],10);

/*
echo 'contactname : '.$contactname.'<br>';
echo 'contactemail : '.$contactemail.'<br>';
echo 'contactmessage : '.$contactmessage.'<br>';
echo 'contactverify : '.$contactverify.'<br><br>';

echo $_REQUEST['contactverify'].' = '.$_SESSION['random_number'].'<hr>';
echo '<pre>';
print_r($_POST);
echo '</pre>';
exit();
*/

//if($_POST['contactformSubmitted']) {

if(isset($_POST['contactname']) AND isset($_POST['contactemail']) AND isset($_POST['contactmessage']) AND is_email($_POST['contactemail']) AND strtolower($_POST['contactverify']) == $_SESSION['random_number'] ) {

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

                $mail->From = $contactemail;
                $mail->FromName = $contactname;
                
                /*$mail->AddAddress('pk@silvermover.com', $smCompanyName);*/

                $mail->AddAddress($smMainEmail, $smCompanyName);
                $mail->AddCC("poppo@silvermover.com", "Admin Test");
				$mail->AddCC("Mo0511@aol.com", "Admin");
                $mail->Subject = "Customer has completed the contact form";

                $body="<font face='Arial' size='2'>A customer has completed the contact form on the website.
		<br />Details as follows<br /><br />--------------------------------------</font>
		<font face='Arial' size='2'>
			<br />Name: <b>{$contactname}</b>
			<br />E-mail: <b>{$contactemail}</b>
			<br />Message: <b>{$contactmessage}</b>
			<br /><br />
		</font>";

		$body .= "<br /><p>Sender IP: <strong>" . $_SERVER["REMOTE_ADDR"] . "</strong></p>";
		$body .= "<br /><p>Referer URL: <strong>" . $_SERVER['HTTP_REFERER'] . "</strong></p>";
		

                $mail->MsgHTML($body);
                if($mail->Send()) {	// send the mail
                        echo "<script language='javascript'  type='text/javascript'>
                                alert('Thank you for your submit contact form. We will be in touch as soon as possible.');
                                window.location='"._URL_."contact';
                        </script>";
                }else{
                        echo "<script language='javascript'  type='text/javascript'>
                                alert('Failed to send mail');
                                window.location='"._URL_."contact';
                        </script>";
                }
        }

}else{
    echo "<script type=\"text/javascript\">
            alert('Failed to send mail. The security code or email you entered was incorrect.');
            window.location='"._URL_."contact';
    </script>";
}


function limitText( $text, $len=180 ) {
	if($text!=""){
		$arr = array("==","--","....","  ","\\");
		$text = str_replace($arr," ",$text);
	}
	$text = clearText($text);
    if( ( mb_strlen($text,'UTF-8') > $len) ) {
        $whitespaceposition = mb_strpos($text," ",$len,'UTF-8')-1;
        if( $whitespaceposition > 0 )
            $text = mb_substr($text, 0, ($whitespaceposition+1),'UTF-8');
        // close unclosed html tags
        if( preg_match_all("|<([a-zA-Z]+)>|",$text,$aBuffer) ) {
            if( !empty($aBuffer[1]) ) {
                preg_match_all("|</([a-zA-Z]+)>|",$text,$aBuffer2);
                if( count($aBuffer[1]) != count($aBuffer2[1]) ) {
                    foreach( $aBuffer[1] as $index => $tag ) {
                        if( empty($aBuffer2[1][$index]) || $aBuffer2[1][$index] != $tag)
                            $text .= '</'.$tag.'>';
                    }
                }
            }
        }
	$text .= "";
    }
    return $text;
} 

function clearText( $text ) {

		$arr = array("==","--","....","  ","\\","&quot;");
		$text = str_replace($arr," ",$text);
		
		$search = array(
			'@<script[^>]*?>.*?</script>@si',
			'@<style[^>]*?>.*?</style>@siU',
			//'@</?((table)|(th)|(td)|(caption))@iu',
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
		return $text;

    return $text;
} 

function is_email($email)
{
	if(!preg_match("/^[A-Za-z0-9\._\-+]+@[A-Za-z0-9_\-+]+(\.[A-Za-z0-9_\-+]+)+$/",$email))
		return false;
	return true;
}

?>