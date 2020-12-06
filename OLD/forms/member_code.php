<?php

$memberAddEditError = "";
$selectedUser = new tsMembers;
$selectedUser->mId = $_REQUEST['mId'];
if($selectedUser->mId>0){ //Get member details
	$selectedUser = $selectedUser->memberGet($selectedUser->mId);
}

if($_POST['mSave']!="" && $_SESSION['auth']!="false"){
	$selectedUser->mFirstname = $_POST['mFirstname'];
	$selectedUser->mLastname = $_POST['mLastname'];
	$selectedUser->mGender = $_POST['mGender'];
	$selectedUser->mAddress = $_POST['mAddress'];
	$selectedUser->mCountry = $_POST['mCountry'];
	$selectedUser->mPostcode = $_POST['mPostcode'];
	if($selectedUser->mUsername != $_POST['mUsername'] && tsMembers::memberUsernameIsUnique($_POST['mUsername'])){ // Trying for a new username
		$selectedUser->mUsername = $_POST['mUsername'];
	}else if ($selectedUser->mUsername == $_POST['mUsername']){ // Keeping old username
		$selectedUser->mUsername = $_POST['mUsername'];
	}else{
		$memberAddEditError = "<p class='validationArea'>Username already exists. Please choose another.</p>";
	}
	$selectedUser->mPasswordHashed = $_POST['mPassword'];
	$selectedUser->mTel = $_POST['mTel'];
	$selectedUser->mMobile = $_POST['mMobile'];
	$selectedUser->mFax = $_POST['mFax'];
	$selectedUser->mEmail = $_POST['mEmail'];
	$selectedUser->mCurrency = $_POST['mCurrency'];
	$selectedUser->mLockedOut = $_POST['mLockedOut'];
	if($_SESSION['auth']->mRole==4){ //Only admin can create new users
		$selectedUser->mRole = $_POST['mRole'];
	}else{
		$selectedUser->mRole = 1;
	}
	$selectedUser->mAdminNotes = $_POST['mAdminNotes'];
	
	$selectedUser->mHowhear = $_POST['mHowhear'];

	if($memberAddEditError==""){
		$selectedUser->mId = $selectedUser->memberSave($selectedUser);
		$selectedUser = null;
	}	
}else{
	//$memberAddEditError = "<p class='validationArea'>Please ensure the users last name is entered</p>";
}

?>