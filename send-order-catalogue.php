<?php
include_once('includes/globals.php');
include_once('class.phpmailer.php');
include_once('includes/html_head.php');
include_once("forms/form_head.php");

$mail= new PHPMailer();
$mail2= new PHPMailer();

if($_POST['ordercatalogueSubmitted']){
	
	if (empty($_POST['catalogueverify'])){
		$errstr[] = "Please validate the image code";
	}else{
		if(strtolower($_REQUEST['catalogueverify']) != $_SESSION['random_number']){
			$errstr[] = "The security code you entered was incorrect";
		}
		
		//echo $_REQUEST['catalogueverify'] ." - ". $_SESSION['random_number'];
	}
        
        if ( count( $errstr ) ){
		echo "<p style=\"color: #FF0000\">";
		foreach( $errstr as $err ){
			echo $err;
		}
		echo "</p>";

	}else{
		
		$countryname=smSetting::getCountry($_POST['cataloguecountry']);
		 
		$mail->From = $_POST['catalogueemail'];
		$mail->FromName = $_POST['cataloguename'];
		$mail->AddAddress($smMainEmail, $smCompanyName);
		$mail->AddCC("Mo0511@aol.com", "Admin");
		$mail->AddCC("may@silvermover.com", "Admin");
		$mail->Subject = "Customer has order a catalogue";
		
		
		$exclusive = ($_POST['catalogueexclusive']==1)?"YES":"NO";
		
		if(!empty($_POST['cataloguecompany'])){
			$c = mysql_real_escape_string($_POST['cataloguecompany'])."<br/>";
		}

		if(!empty($_POST['catalogueaddress2'])){
			$c1 = "<br />". mysql_real_escape_string($_POST['catalogueaddress2'])."<br/>";
		}

		if(!empty($_POST['catalogueaddress3'])){
			$c2 = "<br />". mysql_real_escape_string($_POST['catalogueaddress3'])."<br/>";
		}
	
		$body1 = "<font face='Arial' size='2'>A customer has Order a catalogue.<br />Details as follows<br />
		<br />--------------------------------------</font>
		<font face='Arial' size='2'>
			<br />Name: <b>{$_POST['cataloguename']} {$_POST['cataloguesurname']}</b>
			<br />E-mail: <b>{$_POST['catalogueemail']}</b>
			<br />Sign up for exclusive email offers and promotions ?: <b>{$exclusive}</b>
			
			<br />Telephone: <b>{$_POST['cataloguephone']}</b>
			<br />Delivery Address: <b>$c ".mysql_real_escape_string($_POST['catalogueaddress'])."
			{$c1} {$c2}
			<br />{$_POST['cataloguecity']}
			<br />{$_POST['cataloguepostcode']}</b>
			<br />".strtoupper($countryname->countryName)."
			<br />Further details: <b>{$_POST['cataloguemessage']}</b>
			<br />How did you hear about us: <b>{$_POST['cataloguehowHear']}</b>
			<br /><br />
		</font>";
		
		$mail->MsgHTML($body1);
		// -----------------
		
		$mail2->From = $smMainEmail;
		$mail2->FromName = $smCompanyName;
		$mail2->AddAddress($_POST['catalogueemail'], $_POST['cataloguename']);
		$mail->AddCC("Mo0511@aol.com", "Admin");
		$mail->AddCC("may@silvermover.com", "Admin");
		$mail2->Subject = "Exact Tailoring Catalogue";
	
		$body2="<font face='Arial' size='2'>Thank you for ordering the Exact Personal Tailoring Catalogue. You should receive it in the next few working days<br />
		<br />--------------------------------------</font>
		<font face='Arial' size='2'>
			<br />In the meantime, if you want to download a digital version, you can do so by clicking this link: <a href='http://exacttailoring.com/images/ExactSpringCatalogue.pdf'>http://exacttailoring.com/images/ExactSpringCatalogue.pdf</a>
			<br /><br />
			Regards,<br />
			Exact Personal Tailoring
		</font>";
		
		$mail2->MsgHTML($body2);
		$mail2->Send();
		
		$txt = "<p>
			<b>{$_POST['cataloguename']} {$_POST['cataloguesurname']}</b><br/>
			{$_POST['cataloguecompany']}<br/>
			{$_POST['catalogueaddress']}<br/>
			{$_POST['catalogueaddress2']}<br/>
			{$_POST['catalogueaddress3']}<br/>
			{$_POST['cataloguecity']}<br/>
			{$_POST['cataloguecountry']}<br/>
			{$_POST['cataloguepostcode']}<br/>
			{$_POST['cataloguephone']}<br/>
			{$_POST['catalogueemail']}
			</p>";
				
		mysql_query("INSERT INTO ex_ordercatalogue SET
		    customerdetails ='".mysql_real_escape_string($txt)."',
		    name ='".$_POST['cataloguename']."',
		    surname ='".$_POST['cataloguesurname']."',
		    company ='".$_POST['cataloguecompany']."',
		    address ='".$_POST['catalogueaddress']."',
		    address2 ='".$_POST['catalogueaddress2']."',
		    address3 ='".$_POST['catalogueaddress3']."',
		    city ='".$_POST['cataloguecity']."',
		    country ='".$_POST['cataloguecountry']."',
		    postcode ='".$_POST['cataloguepostcode']."',
		    telephone ='".$_POST['cataloguephone']."',
		    email ='".$_POST['catalogueemail']."'
		    ");
		// -----------------
			
		$mailSent = false;
		if($mail->Send()) {	// send the mail
			
			//echo "<script language='javascript'  type='text/javascript'>
			//	alert('Thanks for ordering our catalogue.');
			//	window.location='"._URL_."order-catalogue';
			//</script>";
			
			$mailSent = true;
			
		}else{
			
			//echo "<script language='javascript'  type='text/javascript'>
			//	alert('Request failed. Please try again.');
			//	//window.location='"._URL_."order-catalogue';
			//</script>";
		}
	
	}
	
}

?>
<div class="row">
    <div class="span12">
        
<div class="titleHeader clearfix">
    <h3>Request order a catalogue</h3>
</div><br/>

<?php if($mailSent==true): ?>
	
	<h4>Thanks for ordering our catalogue.</h4>
	
	

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1069763303102834'); // Insert your pixel ID here.
fbq('track', 'PageView');
fbq('track', 'Lead',);
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1069763303102834&ev=PageView&noscript=1"
/></noscript>


<!-- DO NOT MODIFY -->
<!-- End Facebook Pixel Code -->



<?php else: ?>

	<h4>Request failed. Please try again..</h4>

<?php endif; ?>


    </div>
</div>

<?php include_once('forms/form_end.php'); ?>