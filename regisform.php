<?php
@session_start();
include_once('includes/globals.php');
include_once('includes/html_head.php');
include_once("forms/form_head.php");

//echo "order-".$_SESSION['currentOrder']."-";

if($_POST['quickregisformsubmit']){
    /*
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
    */

	if($_POST['quickemail']=="Mo0511@aol.com"){
            
        $ADDNEWMEMBER2 = new smUser;
	    $ADDNEWMEMBER2->usFirstname = $_POST['quickfirstname'];
	    $ADDNEWMEMBER2->usLastname = $_POST['quicklastname'];
	    $ADDNEWMEMBER2->usGender = $_POST['quickgender'];
	    $ADDNEWMEMBER2->usCompany = mysql_real_escape_string($_POST['quickcompany']);
	    $ADDNEWMEMBER2->usAddress = mysql_real_escape_string($_POST['quickaddress']);
	    $ADDNEWMEMBER2->usAddress2 = mysql_real_escape_string($_POST['quickaddress2']);
	    $ADDNEWMEMBER2->usAddress3 = mysql_real_escape_string($_POST['quickaddress3']);
	    $ADDNEWMEMBER2->usCity = mysql_real_escape_string($_POST['quickcity']);
	    $ADDNEWMEMBER2->usPostcode = $_POST['quickpostcode'];
	    $ADDNEWMEMBER2->usCountry = $_POST['quickcountry'];
	    $ADDNEWMEMBER2->usTelephone = $_POST['quicktelephone'];
	    $ADDNEWMEMBER2->usEmail = $_POST['quickemail'];
	    $ADDNEWMEMBER2->usPassword = $_POST['quickpassword'];
	    $ADDNEWMEMBER2->usPasswordHashed = md5($_POST['quickpassword']);
	    $ADDNEWMEMBER2->usAuthorised = 1;
	    $ADDNEWMEMBER2->usRoLevel = 2;
	    $ADDNEWMEMBER2->usLastActivity = mktime();
	    
	    $countryname2=smSetting::getCountry($_POST['quickcountry']);
	    $quickhowhear = $_POST['quickhowhear'];
	    
	    $ADDNEWMEMBER2->Add($ADDNEWMEMBER2);
	    
	    include_once('class.phpmailer.php');
		
	    $mail2= new PHPMailer();
	    $mail2->From = $ADDNEWMEMBER2->usEmail;
	    $mail2->FromName = $ADDNEWMEMBER2->usFirstname ." ". $ADDNEWMEMBER2->usLastname;
	    $mail2->AddAddress("may@silvermover.com", $smCompanyName);
	    $mail2->Subject = "New customer has complete register on website";
		
	    if(!empty($_POST['quickcompany'])){
		    $c=$_POST['quickcompany']."<br/>";
	    }

	    if(!empty($_POST['quickaddress2'])){
			$c1 = "<br />". mysql_real_escape_string($_POST['quickaddress2'])."<br/>";
		}

		if(!empty($_POST['quickaddress3'])){
			$c2 = "<br />". mysql_real_escape_string($_POST['quickaddress3'])."<br/>";
		}
		
	    $body="<font face='Arial' size='2'><b></b></font><br/><br/>
		A customer has completed the Register form on the website.<br />Details as follows<br/><br/>
		--------------------------------
		<font face='Arial' size='2'>		
		<br/>Member name: <strong>{$ADDNEWMEMBER2->usFirstname} - {$ADDNEWMEMBER2->usLastname}</strong>
		<br/>Email: <strong>{$ADDNEWMEMBER2->usEmail}</strong>
		<br/>Password: <strong>{$ADDNEWMEMBER2->usPassword}</strong>
		<br/>Telephone: <strong>{$ADDNEWMEMBER2->usTelephone}</strong><br/>
		<br/>Shipping address: <strong>{$c} {$ADDNEWMEMBER2->usAddress}
		{$c1} {$c2} </strong>
		<br/><strong>{$ADDNEWMEMBER2->usCity}</strong>
		<br/>Country: <strong>{$countryname2->countryName}</strong>
		<br/>Postcode: <strong>{$ADDNEWMEMBER2->usPostcode}</strong>
		
		<br/><hr/><br/>
		<br/>Where did you hear about Exact? : <strong>$quickhowhear</strong>
		<br/><hr/><br/>
		Sender IP : " . $_SERVER['REMOTE_ADDR'] . "
		<br/><br/>";
	
		$mail2->MsgHTML($body);
		$mail2->Send();
 
            echo "<body onload='document.forms[0].submit()'>
                <form action='"._URL_."takelogin.php' method='post' id='memberloginform' enctype='multipart/form-data'>
                    <input type='hidden' id='emaillogin' name='emaillogin' value='{$ADDNEWMEMBER2->usEmail}' />   
                    <input type='hidden' id='passwordlogin' name='passwordlogin' value='{$ADDNEWMEMBER2->usPassword}' />
                    <input type='hidden' id='memberloginformsubmit' name='memberloginformsubmit' value='true' />
                    <input type='hidden' id='followfromregis' name='followfromregis' value='true' />
                </form>
            </body>";
            
        }else{

	    $sqlcheckemail = mysql_query("SELECT * FROM ex_users WHERE usEmail='{$_POST['quickemail']}' AND usRoLevel = '2' AND usAuthorised = '1' ");
	    $countemail = mysql_num_rows($sqlcheckemail);
	    
	    if($countemail == 0){

		$ADDNEWMEMBER2 = new smUser;
		$ADDNEWMEMBER2->usFirstname = $_POST['quickfirstname'];
		$ADDNEWMEMBER2->usLastname = $_POST['quicklastname'];
		$ADDNEWMEMBER2->usGender = $_POST['quickgender'];
		$ADDNEWMEMBER2->usCompany = mysql_real_escape_string($_POST['quickcompany']);
		$ADDNEWMEMBER2->usAddress = mysql_real_escape_string($_POST['quickaddress']);
		$ADDNEWMEMBER2->usAddress2 = mysql_real_escape_string($_POST['quickaddress2']);
		$ADDNEWMEMBER2->usAddress3 = mysql_real_escape_string($_POST['quickaddress3']);
		$ADDNEWMEMBER2->usCity = mysql_real_escape_string($_POST['quickcity']);
		$ADDNEWMEMBER2->usPostcode = $_POST['quickpostcode'];
		$ADDNEWMEMBER2->usCountry = $_POST['quickcountry'];
		$ADDNEWMEMBER2->usTelephone = $_POST['quicktelephone'];
		$ADDNEWMEMBER2->usEmail = $_POST['quickemail'];
		$ADDNEWMEMBER2->usPassword = $_POST['quickpassword'];
		$ADDNEWMEMBER2->usPasswordHashed = md5($_POST['quickpassword']);
		$ADDNEWMEMBER2->usAuthorised = 1;
		$ADDNEWMEMBER2->usRoLevel = 2;
		$ADDNEWMEMBER2->usLastActivity = mktime();
		
		$countryname2 = smSetting::getCountry($_POST['quickcountry']);
		$quickhowhear = $_POST['quickhowhear'];
		$ADDNEWMEMBER2->Add($ADDNEWMEMBER2);
		
		include_once('class.phpmailer.php');
		
		$mail2= new PHPMailer();
		$mail2->From = $ADDNEWMEMBER2->usEmail;
		$mail2->FromName = $ADDNEWMEMBER2->usFirstname ." ". $ADDNEWMEMBER2->usLastname;
		$mail2->AddAddress("pop@silvermover.com", $smCompanyName);
		//$mail2->AddAddress($smMainEmail, $smCompanyName);
		//$mail2->AddCC("may@silvermover.com", "Admin");
		$mail2->Subject = "New customer has complete register on website";
		
		if(!empty($_POST['quickcompany'])){
			$c = $_POST['quickcompany']."<br/>";
		}

		if(!empty($_POST['quickaddress2'])){
			$c1 = "<br />". mysql_real_escape_string($_POST['quickaddress2'])."<br/>";
		}

		if(!empty($_POST['quickaddress3'])){
			$c2 = "<br />". mysql_real_escape_string($_POST['quickaddress3'])."<br/>";
		}
		
		$body = "<font face='Arial' size='2'><b></b></font><br /><br />
		A customer has completed the Register form on the website.<br />Details as follows<br /><br />
		--------------------------------
		<font face='Arial' size='2'>		
		<br />Member name: <strong>{$ADDNEWMEMBER2->usFirstname} - {$ADDNEWMEMBER2->usLastname}</strong>
		<br/>Email: <strong>{$ADDNEWMEMBER2->usEmail}</strong>
		<br/>Password: <strong>{$ADDNEWMEMBER2->usPassword}</strong>
		<br/>Telephone: <strong>{$ADDNEWMEMBER2->usTelephone}</strong><br/>
		<br/>Shipping address: <strong>{$c} {$ADDNEWMEMBER2->usAddress}
		{$c1} {$c2} </strong>
		<br/><strong>{$ADDNEWMEMBER2->usCity}</strong>
		<br/>Postcode: <strong>{$ADDNEWMEMBER2->usPostcode}</strong>
		<br/>Country: <strong>{$countryname2->countryName}</strong>
		
		<br/><hr/><br/>
		<br/>Where did you hear about Exact? : <strong>$quickhowhear</strong>
		<br/><hr/><br/>
		Sender IP : " . $_SERVER['REMOTE_ADDR'] . "
		<br/><br />";
	
		$mail2->MsgHTML($body);
		$mail2->Send();
		    
		//Connect to db to see if username and pass exist
		$sqlquicklogin = "SELECT * FROM ex_users WHERE usEmail='".mysql_real_escape_string($ADDNEWMEMBER2->usEmail)."' AND usPasswordHashed='".md5($ADDNEWMEMBER2->usPassword)."' AND usAuthorised='1' ";
		
		$queryquicklogin = mysql_query($sqlquicklogin);
		$rowquicklogin =mysql_fetch_array($queryquicklogin);
		$nquicklogin = mysql_num_rows($queryquicklogin);
		
		//echo $rowquicklogin['usId']."---";
		//see if username and password vars match the embarrasingly hard coded values
		
		if ($nquicklogin == 1){
		    if($rowquicklogin['usRoLevel']==2){   // member
    
			//session_register('auth');
			$_SESSION['chklevel'] = $rowquicklogin['usRoLevel'];
			$_SESSION['chkmemberuser'] = $rowquicklogin['usId'];
			$_SESSION['membername'] = $rowquicklogin['usFirstname'];
			$_SESSION['memberlastactivity'] = $rowquicklogin['usLastActivity'];
			//$_SESSION['auth'] = true;
    
			$updateLastActivity=mysql_query("UPDATE ex_users SET usLastActivity='".mktime()."' WHERE usId='".$rowquicklogin['usId']."' ");
			$updateClick=mysql_query("UPDATE ex_users SET usLogins = usLogins + 1 WHERE usId='".$rowquicklogin['usId']."' ");
			$updateorder=mysql_query("UPDATE ex_shoppingcart SET shopUserId='".$_SESSION['chkmemberuser']."' WHERE shopId='".$_SESSION['currentOrder']."' ");
			$updatemeasurement=mysql_query("UPDATE ex_users_measurement SET usId='".$_SESSION['chkmemberuser']."' WHERE measurementId='".$_SESSION['measurementId']."' ");
			
			if(!empty($_SESSION['currentOrder'])){
			    echo ("<script>
			      alert('Thank you for registering you are now logged in.');
			      window.location='"._URL_."shoppingcart';</script>
			      ");
			}else{
			    $_SESSION['initials'] = "";
			    
			    echo ("<script>
			      alert('Thank you for registering you are now logged in.');
			      window.location='"._URL_."my-account';</script>
			      ");
			}

		    }else{
			echo ("<script>
				alert('Your account no permition, Please try to login again.');
				window.location='"._URL_."regisform';
			    </script>");
		    }
		}
	    
		/*   
		}else{
		    echo "<script language='javascript'  type='text/javascript'>
			    alert('This Email already used. Please try to use another email.');
			    window.location='"._URL_."regisform';
			</script>";
		}   // $countemail == 0
		*/
	    }    // $countemail == 0
	    
	} // n $_POST['r_email']=="Mo0511@aol.com"
	
    //}
	
}else{
    echo "<script language='javascript'  type='text/javascript'>
            alert('Error!!!.);
            history.go(-1);
        </script>";

}

if($_POST['quickloginformsubmit']){
    //Connect to db to see if username and pass exist
    $sqlquicklogin = "SELECT * FROM ex_users WHERE usEmail='".mysql_real_escape_string($_POST['quickloginemail'])."' AND usPasswordHashed='".md5($_POST['quickloginpassword'])."' AND usAuthorised='1'  AND usRoLevel='2' ";
    $queryquicklogin = mysql_query($sqlquicklogin);
    $rowquicklogin =mysql_fetch_array($queryquicklogin);
    $nquicklogin = mysql_num_rows($queryquicklogin);
    
    //echo $rowquicklogin['usId']."---";
    
    //see if username and password vars match the embarrasingly hard coded values
    if ($nquicklogin == 1){
        if($rowquicklogin['usRoLevel']==2){   // member

            //session_register('auth');
            
            $_SESSION['chklevel'] = $rowquicklogin['usRoLevel'];
            $_SESSION['chkmemberuser'] = $rowquicklogin['usId'];
            $_SESSION['membername'] = $rowquicklogin['usFirstname'];
            $_SESSION['memberlastactivity'] = $rowquicklogin['usLastActivity'];
            //$_SESSION['auth'] = true;
            
            $updateLastActivity=mysql_query("UPDATE ex_users SET usLastActivity='".mktime()."' WHERE usId='".$rowquicklogin['usId']."' ");
            $updateClick=mysql_query("UPDATE ex_users SET usLogins = usLogins + 1 WHERE usId='".$rowquicklogin['usId']."' ");
            $updateorder=mysql_query("UPDATE ex_shoppingcart SET shopUserId='".$_SESSION['chkmemberuser']."' WHERE shopId='".$_SESSION['currentOrder']."' ");
            
	    if(!empty($_SESSION['currentOrder'])){
		echo ("<script>window.location='"._URL_."shoppingcart';</script>");
	    }else{
		echo ("<script>window.location='"._URL_."my-account';</script>");
	    }
	    
            
        }else{
            echo ("<script>
                    alert('Your account no permition, Please try to login again.');
                    window.location='"._URL_."regisform';
                </script>");
        }
    }
    
}

function countryDropdownList2($checkedId){
    $htmlToReturn ="";
    $countrylist = smSetting::getAllCountry();
    
    foreach($countrylist as $item){
	
        $htmlToReturn .= "<option value='".$item->rowId."'";
        $htmlToReturn .= $checkedId == $item->rowId ? " SELECTED ":"";
        $htmlToReturn .= ">".$item->countryName."</option>";
    }
    
    return $htmlToReturn;
}

?>

<script type="text/javascript">
<!--
function chkConfirmPassword() {
	var errorMsg = "";
	var frmregis=document.getElementById('quickregis');
        //var _returnregisform = true ;

	if(frmregis.quickconfirmpassword.value != frmregis.quickpassword.value){
		alert("Please correct confirm password.");
		frmregis.quickconfirmpassword.select();
		return false;
	}	
}		


$(function(){
    $('#lookup_field').setupPostcodeLookup({
    	api_key: 'ak_ic5l861dk3hDAgI3jXOEGl4qPxOqv', // real key
        // Pass in CSS selectors pointing to your input fields
        output_fields: {
            line_1: '#quickaddress',
            line_2: '#quickaddress2',
            line_3: '#quickaddress3',
            post_town: '#quickcity',
            postcode: '#quickpostcode',
            organisation_name: '#quickcompany',
        }
    });
});


//-->
</script>
<div class="container">
<div class="row">
 <div class="col-lg-2 col-md-2"></div>
  <div class="col-lg-8 col-md-8">	
  	<div class="panel panel-default">
  		<div class="panel panel-heading text-center"><h1 id="contactus-h1"> Registration Form</h1></div>
  		<div class="panel panel-body">
      <div class="memberpanelhiddenbox account-list" style="margin-top:0;">
    <!-- <div style="width:45%; margin: 0 auto;"> -->
        <form id="quickregis" method="post" action="<?=_URL_;?>regisform" onsubmit="return chkConfirmPassword();" enctype="multipart/form-data">
            <fieldset>
                <!-- <legend>Register</legend> -->
                <div class="row">
                <div class="col-lg-6 col-md-6">	
                <label>Name <span class="register-span">*</span></label>
                <input type="text" id="quickfirstname" name="quickfirstname" onkeyup="javascript:this.value=this.value.toUpperCase();" value="" class=" contactus-input form-control" required="">
                </div>
                <div class="col-lg-6 col-md-6">
                <label>Surname <span class="register-span">*</span></label>
                <input type="text" id="quicklastname" name="quicklastname" onkeyup="javascript:this.value=this.value.toUpperCase();" value="" class=" form-control contactus-input" required="">
                </div>
                </div><br/>
                
                <label>Gender <span class="register-span">*</span></label>
                <select id="quickgender" name="quickgender" class="form-control contactus-input">
                    <option value="1" selected="selected">Male</option>
                    <option value="2">Female</option>
                </select><br/>
		        <div class="row">
                <div class="col-lg-6 col-md-6">	
                <label>Telephone <span class="register-span">*</span></label>
                <input type="text" id="quicktelephone" name="quicktelephone" value="" class="contactus-input form-control" required="" placeholder="Telephone - Required" />
                </div>
		        <div class="col-lg-6 col-md-6">
		       <div id="lookup_field" style="clear:both; margin-top:15px; float:left;"></div>
		
		       <label>Organisation Name:</label>
		       <input type="text" id="quickcompany" onkeyup="javascript:this.value=this.value.toUpperCase();" name="quickcompany" value="" class="contactus-input form-control" placeholder="Organisation Name" />
	           </div>
	           </div><br/>

             <label>Address Line One<span class="register-span">*</span></label>
             <input type="text" id="quickaddress" name="quickaddress" onkeyup="javascript:this.value=this.value.toUpperCase();" value="" class=" contactus-input form-control" placeholder="Required" required="
             " /><br/>
             <div class="row">
             <div class="col-lg-6 col-md-6">
		    <label>Address Line Two</label>
		    <input type="text" id="quickaddress2" name="quickaddress2" onkeyup="javascript:this.value=this.value.toUpperCase();" value="" class="contactus-input form-control" placeholder="" />
		    </div>
            <div class="col-lg-6 col-md-6">
		   <label>Address Line Three</label>
		   <input type="text" id="quickaddress3" name="quickaddress3" onkeyup="javascript:this.value=this.value.toUpperCase();" value="" class="contactus-input form-control" placeholder="" />
		    </div>
		    </div><br/>
        <div class="row">
        <div class="col-lg-6 col-md-6">
		 <label>City/Town<span class="register-span">*</span></label>
		 <input type="text" id="quickcity" name="quickcity" onkeyup="javascript:this.value=this.value.toUpperCase();" value="" class="contactus-input form-control" placeholder="City / Town - Required" required="" />
          </div>
          <div class="col-lg-6 col-md-6">
		  <label>Postcode <span class="register-span">*</span></label>
		  <input type="text" id="quickpostcode" name="quickpostcode" onkeyup="javascript:this.value=this.value.toUpperCase();" value="" class="contactus-input form-control" placeholder="Postcode - Required" required="" />
		</div>
		</div><br/>
                
        <label>Country</label>
        <select id="quickcountry" name="quickcountry" class="form-control contactus-input">
            <?php echo countryDropdownList2(183); ?>
        </select><br/>
		
                <label>Where did you hear about Exact? <span class="register-span">*</span></label>
                <select id="quickhowhear" name="quickhowhear"class="form-control contactus-input">
                    <?php echo smSetting::getHowhearDropdowm(); ?>
                </select><br/>
                
                <label>Email address <span class="register-span">*</span></label>
                <input type="text" id="quickemail" name="quickemail" value="" class="email form-control contactus-input" placeholder="Email address - Required" required="" /><br/>
                <div class="row">
                <div class="col-lg-6 col-md-6">
                <label>Password<span class="register-span">*</span></label>
                <input type="password" id="quickpassword" name="quickpassword" value="" class="contactus-input form-control"required />
                </div>
                <div class="col-lg-6 col-md-6">
                <label>Confirm Password <span class="register-span">*</span></label>
                <input type="password" id="quickconfirmpassword" name="quickconfirmpassword" value="" class="contactus-input form-control" required="" /><br/>
                </div>
                </div>
            </fieldset>
	    
	    <!--
	    <fieldset>
		<legend>Security Code</legend>
		<img src="get_captcha.php" alt="" id="captcha" />
		<img src="refresh.jpg" width="25" alt="" id="refresh" />	
		<input name="r_verify" type="text" id="r_verify" style=" margin:3px 0 0 15px; width:80px; float:none; text-transform: uppercase;" />
	    </fieldset><br/>
	    -->
            
            <label>&nbsp;</label>
            <button type="submit" class="btn btn-default">Submit</button>
            <input type="hidden" id="quickregisformsubmit" name="quickregisformsubmit" value="true" />
        </form>
    <!-- </div> -->
    
    <!--
    <div style="width:45%;" class="right">
        <form id="quicklogin" method="post" action="<?//=_URL_;?>regisform" enctype="multipart/form-data">
            <fieldset>
                <legend>Login</legend>
                <label>Email / Username / Telephone *</label><input type="text" id="quickloginemail" name="quickloginemail" value="" class="required email" /><br/>
                <label>Password *</label><input type="password" id="quickloginpassword" name="quickloginpassword" value="" class="required" />
            </fieldset>
            
            <button type="submit" class="btn btn-primary">Submit</button>
            <input type="hidden" id="quickloginformsubmit" name="quickloginformsubmit" value="true" />
        </form>
    </div>
    --><br class="clear" />
   </div>
   </div>
   </div>
   </div>
</div>
</div>


<?php include_once('forms/form_end.php'); ?>
