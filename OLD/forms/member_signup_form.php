<?php
/** NOTE: This form is used during sign up AND on the My account page **/
if($success==false || $_SESSION['auth']!="false"){ //Bad signup or editing from my account page
?>
<form id="memberSignUp" method="post" action="<?php echo($_SERVER['PHP_SELF']);?>">
	<?php echo($errSignUp);?>
	<fieldset>
		<legend>Personal information</legend>
		<?php smControls::smHiddenText("mId",$selectedUser->mId);?>
		<?php smControls::smTextBox("Firstname <span class='required'>*</span>","mFirstname",$selectedUser->mFirstname);?><br />
		<?php smControls::smTextBox("Lastname <span class='required'>*</span>","mLastname",$selectedUser->mLastname);?><br />
		<?php smControls::smRadioButton("Male","mGender","mMale","1",$selectedUser->mGender==1 || $selectedUser->mGender==""?"Checked":"");?><br />
		<?php smControls::smRadioButton("Female","mGender","mFemale","0",$selectedUser->mGender==="0"?"Checked":"");?><br />
		<?php smControls::smTextArea("Address","mAddress",$selectedUser->mAddress);?><br />
		<?php smControls::smTextBox("Postcode","mPostcode",$selectedUser->mPostcode);?><br />
		<?php smControls::smDropDownList("Country","mCountry", smCountries::countriesKeyValueArray(),$selectedUser->mCountry,"","",true);?><br />
		<?php // smControls::smDropDownList("Currency","mCurrency",array("USD"=>"Dollars","EUR"=>"Euros","GBP"=>"Pounds"),$selectedUser->mCurrency,"","",true);?>
		<?php
			smControls::smDropDownList(
				"Where did you hear about Exact?<span class='required'>*</span>",
				"mHowhear",
				array(
					"Avery"=>"Avery",
					"Cricket"=>"Cricket",
					"Nauticalia"=>"Nauticalia",
					"Virgin"=>"Virgin",
					"AA Magazine"=>"AA Magazine",
					"Daily Telegraph"=>"Daily Telegraph",
					"Sunday Telegraph"=>"Sunday Telegraph",
					"Daily Express"=>"Daily Express",
					"Daily Mail"=>"Daily Mail",
					"Mail On Sunday"=>"Mail On Sunday",
					"The Times"=>"The Times",
					"Sunday People"=>"Sunday People",
					"Daily Mirror"=>"Daily Mirror",
					"Sunday Mirror"=>"Sunday Mirror",
					"Saga Magazine"=>"Saga Magazine",
					"MSN"=>"MSN",
					"Altavista"=>"Altavista",
					"AOL"=>"AOL",
					"Freeserve"=>"Freeserve",
					"BT Internet"=>"BT Internet",
					"Ask Jeeves"=>"Ask Jeeves",
					"Google"=>"Google",
					"Yahoo"=>"Yahoo",
					"Other"=>"Other"
				),
				$_SESSION['auth']->mHowhear,
				"",
				"",
				"true"
			);
		?><br /><br />
		
		<fieldset>
			<legend>Preffered login details</legend>
			<?php 
				if($_SESSION['auth']=='false'){
					smControls::smTextBox("Username <span class='required'>*</span>","mUsername",$selectedUser->mUsername);
				}else{
					smControls::smTextBox("Username <span class='smallText'>(Cannot be changed)</span>","mUsername",$selectedUser->mUsername, "readonly='readonly'");
				}
			?><br />
			<?php smControls::smPasswordBox("Password <span class='required'>*</span>","mPassword");?><br />
			<?php smControls::smPasswordBox("Confirm Password <span class='required'>*</span>","mConfirmPassword");?><br />	
		</fieldset>
		<fieldset>
			<legend>Contact details</legend>
			<?php smControls::smTextBox("Telephone","mTel",$selectedUser->mTel);?><br />
			<?php smControls::smTextBox("Mobile","mMobile",$selectedUser->mMobile);?><br />
			<?php smControls::smTextBox("Fax","mFax",$selectedUser->mFax);?><br />
			<?php smControls::smTextBox("Email <span class='required'>*</span>","mEmail",$selectedUser->mEmail);?><br />
		</fieldset>

		<?php smControls::smHiddenText("mSignUp","true");?>
		<?php
		//See if in store
		if($_GET['purchase']!=""){ 
			smControls::smHiddenText("purchase",$_GET['purchase']);
		}
		?>
		<?php 
		if($_SESSION['auth']=="false"){
			smControls::smButton("Register","mSave");
		}else{
			smControls::smButton("Save","mSave");
		}
		?>
	</fieldset>	
</form>
<?php
}else{ //if success
?>
	<div id="thankYou">
		<h3>Thank you for signing up to Exact Tailoring</h3>
		<p>You can now login to your members area by entering your username and password on the left</p>
	</div>
<?php
}
?>