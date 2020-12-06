<?php
if($_GET['mId']!=""){
?>
<form id="memberForm" method="post" action="<?php echo($_SERVER['PHP_SELF']);?>" >
	<h3>Add/Edit member</h3>
	<?php echo($memberAddEditError);?>
	<div class="columnLeft">
		<fieldset>
			<legend>Personal information</legend>
			<?php smControls::smHiddenText("mId",$selectedUser->mId);?>
			<?php smControls::smTextBox("Firstname","mFirstname",$selectedUser->mFirstname);?><br />
			<?php smControls::smTextBox("Lastname","mLastname",$selectedUser->mLastname);?><br />
			<?php smControls::smRadioButton("Male","mGender","mMale","1",$selectedUser->mGender==1?"Checked":"");?><br />
			<?php smControls::smRadioButton("Female","mGender","mFemale","0",$selectedUser->mGender==0?"Checked":"");?><br />
			<?php smControls::smTextArea("Address","mAddress",$selectedUser->mAddress);?><br />
			<?php smControls::smTextBox("Postcode","mPostcode",$selectedUser->mPostcode);?><br />
			<?php smControls::smDropDownList("Country","mCountry", smCountries::countriesKeyValueArray(),$selectedUser->mCountry,"","",true);?><br />
			<?php // smControls::smDropDownList("Currency","mCurrency",array("USD"=>"Dollars","EUR"=>"Euros","GBP"=>"Pounds"),$selectedUser->mCurrency,"","",true);?><br />
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
					$selectedUser->mHowhear,
					"",
					"",
					"true"
				);
			?><br /><br />
		</fieldset>
		<fieldset>
			<legend>Login details</legend>
			<?php smControls::smTextBox("Username","mUsername",$selectedUser->mUsername);?><br />
			<?php smControls::smPasswordBox("Password","mPassword","");?><br />
		</fieldset>
	</div>
	
	<div class="columnRight">
		<fieldset>
			<legend>Contact details</legend>
			<?php smControls::smTextBox("Telephone","mTel",$selectedUser->mTel);?><br />
			<?php smControls::smTextBox("Mobile","mMobile",$selectedUser->mMobile);?><br />
			<?php smControls::smTextBox("Fax","mFax",$selectedUser->mFax);?><br />
			<?php smControls::smTextBox("Email","mEmail",$selectedUser->mEmail);?><br />
		</fieldset>
		
		<fieldset>
			<legend>Miscellaneous information</legend>
			<?php smControls::smCheckBox("Block user access","mLockedOut","1",$selectedUser->mLockedOut);?><br />
			<?php 
			if($_SESSION['auth']->mRole==4){
				smControls::smDropDownList("User level","mRole",tsMembers::memberRolesArray(),$selectedUser->mRole,"","",true);
			}else{
				echo("<p>User created will be member level. To create other user types please contact an administrator.</p>");
			}	
			?><br />
		
			<?php smControls::smTextArea("Admin notes","mAdminNotes",$selectedUser->mAdminNotes);?><br />
			<p class="loginInfo">
				<?php echo(tsMembers::memberRoleName($selectedUser->mRole));?><br />
				Last logged in on <?php echo(smFunctions::displayDate($selectedUser->mLastActivity));?><br />
				Contact added on <?php echo(smFunctions::displayDate($selectedUser->mSignUpDate));?><br />
				Contact has logged in <?php echo($selectedUser->mLogins>0?$selectedUser->mLogins:0);?> time/s
			</p>
		</fieldset>
	</div>
	<div><br /><!-- The wonders of web standards --></div>
	<fieldset>
		<legend>Save contact</legend>
		<?php smControls::smButton("Save","mSave");?>
	</fieldset>
</form>
<?php
} //endif
?>