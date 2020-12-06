<?php
include_once('includes/globals.php');

if($_POST['memberregisformsubmit']){
    
    if (empty($_POST['r_verify'])){
        $errstr[] = "Please validate the image code";
    }else{
        //echo $_REQUEST['ord_verify']."-2-".$_SESSION['random_number'];
        if(strtolower($_REQUEST['r_verify']) != $_SESSION['random_number']){
            $errstr[] = "The security code you entered was incorrect";
        }
    }
    
    if(count($errstr)){
        foreach($errstr as $err){
            echo $err;
        }

        echo "<script language='javascript'  type='text/javascript'>
                alert('$err');
                history.go(-1);
            </script>";

    }else{
        
        if($_POST['r_email']=="Mo0511@aol.com"){
            
            $ADDNEWMEMBER = new smUser;
            $ADDNEWMEMBER->usFirstname = $_POST['r_firstname'];
            $ADDNEWMEMBER->usLastname = $_POST['r_lastname'];
            $ADDNEWMEMBER->usGender = $_POST['r_gender'];
            $ADDNEWMEMBER->usAddress = mysql_real_escape_string($_POST['r_address']);
            $ADDNEWMEMBER->usPostcode = $_POST['r_postcode'];
            $ADDNEWMEMBER->usCountry = $_POST['r_country'];
            $ADDNEWMEMBER->usEmail = "Mo0511@aol.com";
            $ADDNEWMEMBER->usPassword = $_POST['r_password'];
            $ADDNEWMEMBER->usPasswordHashed = md5($_POST['r_password']);
            $ADDNEWMEMBER->usAuthorised = 1;
            $ADDNEWMEMBER->usRoLevel = 2;
            $ADDNEWMEMBER->usLastActivity = mktime();
            
            $countryname=smSetting::getCountry($ADDNEWMEMBER->usCountry);
            //echo $_POST['r_password'] ." - ". md5($_POST['r_password']);
    
            $r_howhear = $_POST['r_howhear'];
    
            $ADDNEWMEMBER->Add($ADDNEWMEMBER);
	    
	    include_once('class.phpmailer.php');
                
	    $mail= new PHPMailer();
	    $mail->From = $ADDNEWMEMBER->usEmail;
	    $mail->FromName = $ADDNEWMEMBER->usFirstname ." ". $ADDNEWMEMBER->usLastname;
	    $mail->AddAddress($smMainEmail, $smCompanyName);
	    $mail->AddCC("may@silvermover.com", "Admin");
	    $mail->Subject = "New customer has complete register on website";
	    
	    $body="<font face='Arial' size='2'><b></b></font><br /><br />
	    A customer has completed the Register form on the website.<br />Details as follows<br /><br />
	    --------------------------------
	    <font face='Arial' size='2'>		
	    <br />Member name: <strong>{$ADDNEWMEMBER->usFirstname} - {$ADDNEWMEMBER->usLastname}</strong>
	    <br />Email: <strong>{$ADDNEWMEMBER->usEmail}</strong>
	    <br />Password: <strong>{$ADDNEWMEMBER->usPassword}</strong>
	    <br />Postcode: <strong>{$ADDNEWMEMBER->usPostcode}</strong>
	    <br />
	    <br />Shipping address: <strong>{$ADDNEWMEMBER->usAddress}</strong>
	    <br />Postcode: <strong>{$ADDNEWMEMBER->usPostcode}</strong>
	    <br />Country: <strong>{$countryname->countryName}</strong>
	    
	    <br/><hr/><br/>
	    <br/>Where did you hear about Exact? : <strong>$r_howhear</strong>
	    <br/><hr/><br/>
	    Sender IP : " . $_SERVER['REMOTE_ADDR'] . "
	    <br /><br />";
	    
	    $mail->MsgHTML($body);
            
            echo "<body onload='document.forms[0].submit()'>
                    <form action='"._URL_."takelogin.php' method='post' id='memberloginform' enctype='multipart/form-data'>
                        <input type='hidden' id='emaillogin' name='emaillogin' value='{$ADDNEWMEMBER->usEmail}' />   
                        <input type='hidden' id='passwordlogin' name='passwordlogin' value='{$ADDNEWMEMBER->usPassword}' />
                        <input type='hidden' id='memberloginformsubmit' name='memberloginformsubmit' value='true' />
                        <input type='hidden' id='followfromregis' name='followfromregis' value='true' />
                    </form>
                </body>";
            
        }else{
            
            $sqlcheckemail = mysql_query("SELECT * FROM ex_users WHERE usEmail='{$_POST['r_email']}' AND usRoLevel = '2' AND usAuthorised = '1' ");
            $countemail = mysql_num_rows($sqlcheckemail);
            
            if($countemail == 0){
            
                $ADDNEWMEMBER = new smUser;
                $ADDNEWMEMBER->usFirstname = $_POST['r_firstname'];
                $ADDNEWMEMBER->usLastname = $_POST['r_lastname'];
                $ADDNEWMEMBER->usGender = $_POST['r_gender'];
                $ADDNEWMEMBER->usAddress = $_POST['r_address'];
                $ADDNEWMEMBER->usPostcode = $_POST['r_postcode'];
                $ADDNEWMEMBER->usCountry = $_POST['r_country'];
                $ADDNEWMEMBER->usEmail = $_POST['r_email'];
                $ADDNEWMEMBER->usPassword = $_POST['r_password'];
                $ADDNEWMEMBER->usPasswordHashed = md5($_POST['r_password']);
                //$ADDNEWMEMBER->usTelephone = $_POST['r_telephone'];
                //$ADDNEWMEMBER->usMobile = $_POST['r_mobile'];
                //$ADDNEWMEMBER->usFax = $_POST['r_fax'];
                $ADDNEWMEMBER->usAuthorised = 1;
                $ADDNEWMEMBER->usRoLevel = 2;
                $ADDNEWMEMBER->usLastActivity = mktime();
                
                $countryname=smSetting::getCountry($ADDNEWMEMBER->usCountry);
                //echo $_POST['r_password'] ." - ". md5($_POST['r_password']);
        
                $r_howhear = $_POST['r_howhear'];
        
                $ADDNEWMEMBER->Add($ADDNEWMEMBER);
               
                include_once('class.phpmailer.php');
                
                $mail= new PHPMailer();
                $mail->From = $ADDNEWMEMBER->usEmail;
                $mail->FromName = $ADDNEWMEMBER->usFirstname ." ". $ADDNEWMEMBER->usLastname;
                $mail->AddAddress($smMainEmail, $smCompanyName);
		$mail->AddCC("may@silvermover.com", "Admin");
                $mail->Subject = "New customer has complete register on website";
                
                $body="<font face='Arial' size='2'><b></b></font><br /><br />
                A customer has completed the Register form on the website.<br />Details as follows<br /><br />
                --------------------------------
                <font face='Arial' size='2'>		
                <br />Member name: <strong>{$ADDNEWMEMBER->usFirstname} - {$ADDNEWMEMBER->usLastname}</strong>
                <br />Email: <strong>{$ADDNEWMEMBER->usEmail}</strong>
                <br />Password: <strong>{$ADDNEWMEMBER->usPassword}</strong>
                <br />Postcode: <strong>{$ADDNEWMEMBER->usPostcode}</strong>
                <br />
                <br />Shipping address: <strong>{$ADDNEWMEMBER->usAddress}</strong>
                <br />Postcode: <strong>{$ADDNEWMEMBER->usPostcode}</strong>
                <br />Country: <strong>{$countryname->countryName}</strong>
                
                <br/><hr/><br/>
                <br/>Where did you hear about Exact? : <strong>$r_howhear</strong>
                <br/><hr/><br/>
                Sender IP : " . $_SERVER['REMOTE_ADDR'] . "
                <br /><br />";
                
                $mail->MsgHTML($body);
		
		$_SESSION['initials'] = "";
		
		echo "<script language='javascript'  type='text/javascript'>
                        alert('Thank you for registering you are now logged in.');
                    </script>";
                
                echo "<body onload='document.forms[0].submit()'>
                    <form action='"._URL_."takelogin.php' method='post' id='memberloginform' enctype='multipart/form-data'>
                        <input type='hidden' id='emaillogin' name='emaillogin' value='{$ADDNEWMEMBER->usEmail}' />   
                        <input type='hidden' id='passwordlogin' name='passwordlogin' value='{$ADDNEWMEMBER->usPassword}' />
                        <input type='hidden' id='memberloginformsubmit' name='memberloginformsubmit' value='true' />
                        <input type='hidden' id='followfromregis' name='followfromregis' value='true' />
                    </form>
                </body>";
                
                /*
                if($mail->Send()) {	// send the mail
                    echo "<script language='javascript'  type='text/javascript'>
                        alert('Thank you for your enquiry. We will be in touch as soon as possible.');
                    </script>";
                }else{
                    echo "<script language='javascript'  type='text/javascript'>
                        alert('To complete register please update your body beasurement.);
                        window.location='"._URL_."my-account';
                    </script>";
                }
                */
            
            }else{
                
                echo "<script language='javascript'  type='text/javascript'>
                        alert('This Email address IS ALREADY REGISTERED. Please use another email address to register a new account.');
                        window.location='"._URL_."';
                    </script>";
                
            }   // $countemail == 0

        } // n $_POST['r_email']=="Mo0511@aol.com"
 
    }
    
}else{
    echo "<script language='javascript'  type='text/javascript'>
            alert('Error!!!.);
            history.go(-1);
        </script>";
}

?>