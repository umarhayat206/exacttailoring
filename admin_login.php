<?php
//echo ("~".$_SESSION['auth']);

/**
 * Title:- Login Form and Logic
 * Description:- Username and password form for members and admin to login with
 * @copyright 2007
 */
@session_start(); 


//session_register('chkrole');
//session_register('chkbranch');

//$chkuser="";
//$chkrole="";

include "includes/globals.php";
	
if ((!empty($_POST['username'])) AND (!empty($_POST['password']))){
	
	//Connect to db to see if username and pass exist
	$sql = "SELECT * FROM ex_users WHERE usUsername='".mysql_real_escape_string($_POST['username'])."' AND usPassword='".mysql_real_escape_string($_POST['password'])."' AND usAuthorised='1' ";
	$query = mysql_query($sql);
	$row =mysql_fetch_array($query);
	$n = mysql_num_rows($query);

	//see if username and password vars match the embarrasingly hard coded values
	if ($n == 1){
		if($row['usRoLevel']==1 || $row['usRoLevel']==2){
			
			
			$shippingcountry = smSetting::getCountry($row['usCountry']);
			
			$_SESSION['chklevel'] = $row['usRoLevel'];
			$_SESSION['chkuser'] = $row['usId'];
			$_SESSION['username'] = $row['usUsername'];
			$_SESSION['shippingaddress'] = $row['usAddress']."<br/>".$row['usPostcode']." ".$shippingcountry->countryName;
			$_SESSION['auth'] = true;
			
			$updateLastActivity=mysql_query("UPDATE ex_users SET usLastActivity='".mktime()."' WHERE usId='".$row['usId']."' ");
			echo ("<script>window.location='"._URL_."admin_order';</script>");

		}else{
			$error="Your account no permition";
		}
		
	}else{
		//no match:- set auth as false and echo message to 5h1t3 h4x0r
		$error ="Incorrect username and/or password";
	}
}
//}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Administrator Login</title>
	<!--<link href="<?//=_URL_;?>styles/reset.css" rel="stylesheet" type="text/css" />
	<link href="<?//=_URL_;?>styles/admin_style.css" rel="stylesheet" type="text/css" />-->
	<!--[IF IE 6]>
	 	<link href="../styles/admin2.css" rel="stylesheet" type="text/css" media="screen" />
	<![endif]-->
	<style>
		body { font-family:Arial;font-size: 13px; color:#FFF; }
		#login {
			position: relative;
			background: url('styles/images/login-bkg-tile.gif') no-repeat top center;
			color: #fff;
			margin: 5em auto 1em;
			padding: 20px 0 0 0;
			width: 480px;
			height: 305px;
		    }
		    
		    #login form {
			background: url('styles/images/login-bkg-bottom.gif') no-repeat bottom center;
			padding: 0 25px 0 30px;
			width: 325px;
			margin: 0 auto;
			min-height: 185px;
			height: 200px;
			/* height: auto !important; min-height fast hack */
		    }
		    
		    #login #login_error {background: #0e3350;color: #ebcd4e;font-size: 11px;font-weight: bold;padding: .6em;width: 310px; margin: 0 50px;text-align: center;}
		    #login p { font-size: 12px;}
		    #login p a{ color: #fff; }
		    #login span a{ color: #fff; }
		    #login p.message {width: 310px;	margin: 0 auto 1em;}
		    #login #login_error a {	color: #ebcd4e;	border-color: #ebcd4e;}
		    #login h1 a {margin: 0 auto; height: 60px; width: 320px; display: block; border-bottom: none; text-indent: -9999px;}
		    .ERror{text-align: center; color: red; margin-top:0px;}
		    #login .message {font-size: 10pt; text-align: center;}
		    #login input {padding: 4px; }
		    
		    #login .input {font-size: 1.8em; margin-top: 3px; width: 97%;}
		    #login p label {font-size: 13px;}
		    #login #submit {margin: 0; font-size: 15px;}
		    
		    .submit input{border: 2px double #999; border-left-color: #ccc; border-top-color: #ccc; color: #333; padding: 0.25em; float: right;}
	</style>
</head>
<body style="background: #FFF;">
	<script type="text/javascript">
		function focusit() {
			document.getElementById('username').focus();
		}
		window.onload = focusit;
	</script>

	<div id="login">
		<h1><a href="http://silvermover.com/" title="Powered by Silvermover.com">Silvermover</a></h1>
		<?php echo "<p class='ERror'>&nbsp;".$error."</p>";?>
		<form id="loginform" action="<?=$site_admin; ?>admin_login" method="post"  enctype="multipart/form-data">
			<p>
				<label>Username:</label><br />
				<input name="username" id="username" class="input" value="" size="20" tabindex="10" type="text" />
			</p>
			<p>
				<label>Password:</label><br />
				<input name="password" id="password" class="input" value="" size="20" tabindex="20" type="password" />
			</p>
			<p class="submit">
				<input name="admin-submit" id="admin-submit" value="Login" tabindex="100" type="submit" style="cursor:pointer;" />
			</p><br style="clear: both;" />
			<span><a href="<?=_URL_; ?>" title="Back to Home Page">Back to Home Page</a></span><br/>
		</form>
	</div>
</body>
</html>


