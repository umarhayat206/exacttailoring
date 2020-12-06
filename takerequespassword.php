<?php

include_once('includes/globals.php');

if($_POST['requestpassword'] && !empty($_POST['requestemail'])){
    //Connect to db to see if username and pass exist
    $sql = "SELECT * FROM ex_users WHERE (usEmail='".mysql_real_escape_string($_POST['requestemail'])."' OR usUsername='".mysql_real_escape_string($_POST['requestemail'])."') AND usAuthorised='1' AND usRoLevel='2' ";
    $query = mysql_query($sql);
    $row =mysql_fetch_array($query);
    $n = mysql_num_rows($query);
    
    if($n == 1){  
	
	if($row['usRoLevel']==2){
	    include_once('class.phpmailer.php');
	    
	    $mail2= new PHPMailer();
	    $mail2->From = "Exact Tailoring";
	    $mail2->FromName = "Exact Tailoring";
            $mail2->AddAddress($row['usEmail'], $row['usFirstname']);
            $mail2->AddCC("may@silvermover.com", "Admin");
	    $mail2->Subject = "Exact Tailoring - Request Password";
	    
	    $body="<font face='Arial' size='2'><b></b></font><br /><br />
	    Your login details for website <strong><a href='http://exacttailoring.com'>exacttailoring.com</a></strong> details as follows<br /><br />
	    --------------------------------
	    <font face='Arial' size='2'>		
	    <br />Email: <strong>{$row['usEmail']}</strong>
            <br />Username: <strong>{$row['usUsername']}</strong>
	    <br />Password: <strong>{$row['usPassword']}</strong>
	    <br/><hr/><br/>
	    Sender IP : " . $_SERVER['REMOTE_ADDR'] . "
	    <br /><br />";
    
	    $mail2->MsgHTML($body);
	    $mail2->Send();
 
	    echo ("<script>
                alert('Password will be sent to your email.');
                window.location='"._URL_."';
                </script>");

        }
	
    }else if($n > 1){
	echo ("<script>
                alert('Sorry this email address has more than 1 account associated within our database. Please contact our Admin team to send you a new password.');
                window.location='"._URL_."';
                </script>");
            
    }else{
	echo ("<script>
		alert('Sorry don\'t have your email on our database. Please register to create new account.');
		window.location='"._URL_."regisform';
	    </script>");
    }
    
}else{
    echo ("<script>window.location='"._URL_."';</script>");
}

?>
