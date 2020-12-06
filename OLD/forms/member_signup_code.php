<?php
/** NOTE: This form is used during sign up AND on the My account page **/
$errSignUp = "";
$success = false;

$selectedUser = new tsMembers;
if($_SESSION['auth']!=false){
	$selectedUser = $selectedUser->memberGet($_SESSION['auth']->mId);
}

if(isset($_POST['mSave'])){
	$selectedUser->mFirstname = $_POST['mFirstname'];
	$selectedUser->mLastname = $_POST['mLastname'];
	$selectedUser->mGender = $_POST['mGender'];
	$selectedUser->mAddress = $_POST['mAddress'];
	$selectedUser->mCountry = $_POST['mCountry'];
	$selectedUser->mPostcode = $_POST['mPostcode'];
	$selectedUser->mCurrency = $_POST['mCurrency'];
	if($_SESSION['auth']=='false'){
		$selectedUser->mUsername = $_POST['mUsername'];
	}
	$selectedUser->mPasswordHashed = $_POST['mPassword'];
	$selectedUser->mTel = $_POST['mTel'];
	$selectedUser->mMobile = $_POST['mMobile'];
	$selectedUser->mFax = $_POST['mFax'];
	$selectedUser->mEmail = $_POST['mEmail'];
	$selectedUser->mHowhear = $_POST['mHowhear'];
	
	
	//$vouchercodes  = tsMembers::_randomVoucherCode(6); // lmit character
	//$selectedUser->mVoucherCode = $vouchercodes;
	
	//Do validation
	if($_POST['mFirstname']==""){
		$errSignUp = "<li>First name is required</li>"; 
	}
	if($_POST['mLastname']==""){
		$errSignUp.= "<li>Last name is required</li>";
	}
	if($_POST['mHowhear']==""){
		$errSignUp.= "<li>Where did you hear about Exact? is required</li>";
	}
	if($_POST['mUsername']=="" && $_SESSION['auth']==false){
		$errSignUp.= "<li>Username is required</li>";
	}
	if($_POST['mPassword']==""){
		$errSignUp.= "<li>Password is required</li>";
	}
	if($_POST['mConfirmPassword']==""){
		$errSignUp.= "<li>Confirmation password is required</li>";
	}
	if($_POST['mPassword']!=$_POST['mConfirmPassword'] && $_POST['mConfirmPassword']!=""){
		$errSignUp.= "<li>Password and confirmation password must match</li>";
	}
	// Check user name is unique
	if($_SESSION['auth']==false && !tsMembers::memberUsernameIsUnique($_POST['mUsername']) && $_POST['mUsername']!=""){
		$errSignUp.= "<li>Username in use. Please choose a different username";
	}
	if($_POST['mEmail']==""){
		$errSignUp.= "<li>Email is required</li>";
	}	
	if($errSignUp!=""){
		$errSignUp = "<ul class='validationArea'>".$errSignUp."</ul>";
	}else{ // Success. Add new user
		$selectedUser->mRole = 1; //Sets the user as a member		
		$mId = $selectedUser->memberSave($selectedUser);
		$success = true;
		
		//$_SESSION['auth'] = $selectedUser->memberGet($mId);
		/*
		$body="<font face='Arial' size='2'>
				New member complete register form
				<br /><br />--------------------------------------
				Where did you hear about Exact? - <b>{$_POST['howHear']}</b>
			</font>";
			
		$mail = new PHPMailer();
		$mail->From = "no-reply@exacttailoring.com";
		$mail->FromName = "Exact Personal Tailoring Services";
		//$mail->AddAddress($siteEmail, "Exact");
		$mail->AddAddress("may@silvermover.com", "Exact");
		$mail->Subject = "Exact Tailoring - New member complete register form";
		$mail->MsgHTML($body);
		$mail->Send();
		*/
	}
}

?>