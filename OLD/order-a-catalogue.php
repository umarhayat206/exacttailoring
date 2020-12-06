<?php
$pageTitle = "Order a catalogue from ";

include("code/application_code_includes_and_globals_file.php");
include($siteRoot."includes/html_head.php");
include($siteRoot."includes/page_header.php");

$mailSent = false;
$errMessage = "";
if($_POST['msgSend']=="Send"){
	$yourName = trim($_POST['yourName']);
	$yourEmail = trim($_POST['yourEmail']);
	$msgAddress = trim($_POST['msgAddress']);
	$msgContent = trim($_POST['msgContent']);
	if($yourName!="" || $yourEmail!="" || $msgSubject!="" || $msgContent!=""){
		//All good, send mail. TODO: validation email address
		$subject = "Catalogue request - sent via ".$siteBasicTitle;
		$message = $msgContent."\r\n".
			"From ".$yourName." [".$yourEmail."]".
			"\r\n Heard about us from: ".$_POST['howHear'].
			"\r\n Telephone number: ".$_POST['yourTel'].
			"\r\n Address: ".$msgAddress.
			"\r\n Postcode: ".$_POST['yourPostcode'].
			"\r\n Country: ".smCountries::countryById($_POST['country']);
		$headers = "From: ".$yourEmail."\r\n"."Reply-To: ".$yourEmail."\r\n";
		//mail($siteEmail,$subject,$message,$headers);
		//$mailSent = true;
		
		$mail = new PHPMailer();
		$mail->From = $yourEmail;
		$mail->FromName = $yourName;
		$mail->AddAddress($siteEmail, $siteEmail);
		//$mail->AddAddress("may@silvermover.com", "aaaa");
		$mail->Subject = $subject;
		$mail->MsgHTML($message);
		//$mail->SetLanguage('en','language/'); 
		if($mail->Send()){
			$mailSent = true;
		}else{
			echo "<script language='javascript' type='text/javascript'>
				alert('" .$mail->ErrorInfo. "');
			</script>";
		}
		
		
		$errMessage="<p class='validationArea'>Thank you. We will send your catalogue very soon.</p>";
		// Now add user to database member list
		$newMem = new tsMembers;
		$nameArray = explode(" ",$yourName);
		$newMem->mFirstname = $nameArray[0];
		$newMem->mLastname = $nameArray[1];
		$newMem->mAddress = $msgAddress;
		$newMem->mEmail = $yourEmail;
		$newMem->mPostcode = $_POST['yourPostcode'];
		$newMem->mCountry = $_POST['country'];
		$newMem->mTel = $_POST['yourTel'];
		$newMem->mAdminNotes = "Heard about us from: ".$_POST['howHear']."\n\r";
		$newMem->mAdminNotes.= "Catalog request message: ".$_POST['msgContent'];
		$newMem->mCatalogOrder = 1;
		$newMem->mRole = 0;
		$newMem->memberSave($newMem);
	}else{
		$errMessage="<p class='validationArea'>Please ensure all fields are completed</p>";
	}
}

?>
<h2>Order a catalogue</h2>
<img src="styles/images/main_open_catalog.gif" alt="Photoshopped image showing the Exact Tailoring Catalogue" title="Exact Tailoring Catalog" />
<p>
	The Exact Tailor Store Latest Catalogue is now available. If you would like
	to receive our latest catalogue, please phone, email us, fill in the form
	below and we will send one out immediately, or simply download the
	<a href="Catalogue.pdf" title="Download the Exact catalogue">Exact Latest Catalogue</a>
	and the
	<a href="ExactSpring2009OrderForm.pdf" title="Download the Exact order form">Exact Order Form</a>
	(right click and choose "save as"). All contact info can be found at the
	bottom of the page.
</p>
<p>
	We do not send out any flyers or junk mail at any time. Submitting your details
	here will result in you receiving one catalogue only, on one occasion, not an
	endless stream of junk mail. We do not lend or sell our mailing list to anyone.
</p>
<form id="contactUsForm" method="post" action="<?php echo($_SERVER['PHP_SELF']);?>">
	<fieldset>
		<legend>Order a catalogue</legend>
		<?php echo($errMessage);?>
		<?php smControls::smTextBox("Your Name: ","yourName",$_POST['yourName']);?><br />
		<?php smControls::smTextBox("Your email: ","yourEmail",$_POST['yourEmail']);?><br />
		<?php smControls::smTextBox("Telephone number: ","yourTel",$_POST['yourTel']);?><br />
		<?php smControls::smTextArea("Delivery Address: ","msgAddress",$_POST['msgSubject']);?><br />
		<?php smControls::smTextBox("Postcode: ","yourPostcode",$_POST['yourPostcode']);?><br />
		<?php smControls::smDropDownList("Country","country",smCountries::countriesKeyValueArray(),$_POST['country']==""?"United Kingdom":$_POST['country'],"","","true");?><br />
		<?php smControls::smTextArea("Further details: ","msgContent",$_POST['msgContent']);?><br />
		<?php
			smControls::smDropDownList(
				"How did you hear about us?",
				"howHear",
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
				$_POST['howHear'],
				"",
				"",
				"true"
			);
		?><br />
		<?php smControls::smButton("Send","msgSend"); ?>
	</fieldset>
</form>
<?php include($siteRoot."includes/page_footer.php"); ?>