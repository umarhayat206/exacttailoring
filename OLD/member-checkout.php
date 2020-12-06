<?php
$pageTitle = "Checkout - ";

include("code/application_code_includes_and_globals_file.php");

include($siteRoot."panels/cart_details_code.php");

include($siteRoot."includes/html_head.php");
include($siteRoot."includes/page_header.php");

//echo $_SESSION['auth']->mFirstname." ".$_SESSION['auth']->mLastname." ".$_SESSION['auth']->mEmail;

?>
<h2>Checkout</h2>
<p>Please review your shopping cart below. If you wish to remove an item from the cart, please click on the red cross to the left of the description.</p>
<?php include($siteRoot."panels/cart_details_panel.php"); ?>

<script type="text/javascript">
<!--
	$(document).ready(function(){
		$('#payCreditCard').click(function(){
			$('#mainform').slideToggle();
			$('#transactionform').slideToggle();
		});
		
		$('#returnToPay').click(function(){
			$('#mainform').slideToggle();
			$('#transactionform').slideToggle();
		});
	});
	
	function chkInput() {
		var errorMsg = "";
		var frm=document.getElementById('payWithCreditCard');
		
		/*var checkEmail=frm.email.value;
		if((checkEmail.indexOf('@') < 0) || ((checkEmail.charAt(checkEmail.length-4) != '.') && (checkEmail.charAt(checkEmail.length-3) != '.'))){
			errorMsg += "- Invalid E-Mail\n\n";
		}
		 if (errorMsg != ""){
			errorMsg += alert(errorMsg);
			frm.email.select();
			return false;
		}
		if(!frm.email.value){
			alert("Email address please.");
			frm.email.select();
			return false;		
		}*/
		
		if(!frm.billFirstName.value){
			alert("Request billing first name.");
			frm.billFirstName.select();
			return false;
		}	
		if(!frm.billSurname.value){
			alert("Request billing surname.");
			frm.billSurname.select();
			return false;
		}
		if(!frm.billAddress1.value){
			alert("Request billing address.");
			frm.billAddress1.select();
			return false;
		}
		if(!frm.billCity.value){
			alert("Request billing city.");
			frm.billCity.select();
			return false;
		}
		if(!frm.billPostCode.value){
			alert("Request billing post/zip code.");
			frm.billPostCode.select();
			return false;
		}
		if(!frm.billCountry.value){
			alert("Request billing country.");
			frm.billPostCode.select();
			return false;
		}
		//----------------------------------------------
		
		if(!frm.deliFirstName.value){
			alert("Request delivery first name.");
			frm.deliFirstName.select();
			return false;
		}	
		if(!frm.deliSurname.value){
			alert("Request delivery surname.");
			frm.deliSurname.select();
			return false;
		}
		if(!frm.deliAddress1.value){
			alert("Request delivery address.");
			frm.deliAddress1.select();
			return false;
		}
		if(!frm.deliCity.value){
			alert("Request delivery city.");
			frm.deliCity.select();
			return false;
		}
		if(!frm.deliPostCode.value){
			alert("Request delivery post/zip code.");
			frm.deliPostCode.select();
			return false;
		}
		if(!frm.deliCountry.value){
			alert("Request delivery country.");
			frm.deliPostCode.select();
			return false;
		}
		//----------------------------------------------
		
		if(!frm.payCreditType.value){
			alert("Request card type.");
			frm.payCreditHolderName.select();
			return false;
		}	
		if(!frm.payCreditHolderName.value){
			alert("Request card holder name.");
			frm.payCreditHolderName.select();
			return false;
		}
		if(!frm.payCreditNumber.value){
			alert("Request card number.");
			frm.payCreditNumber.select();
			return false;
		}
		if(!frm.payCreditStartDate.value){
			alert("Request start date.");
			frm.payCreditStartDate.select();
			return false;
		}
		if(!frm.payCreditExpiryDate.value){
			alert("Request expiry date.");
			frm.payCreditExpiryDate.select();
			return false;
		}
		if(!frm.payCreditCV2.value){
			alert("Request card verification value.");
			frm.payCreditCV2.select();
			return false;
		}
		
	}	// n function chkInput
//-->	
</script>		

<?php if($cartValue>0){ ?>
<p id="paymentOptions">
	Payments can be made securely via PayPal or by calling 01 789 205612
</p>
<form id="payWithPayPal" method="post" action="paypal_outward.php">
	<div id="mainform" style="display:run-in;">
		<fieldset>
			<?php smControls::smTextArea("Delivery address <span class='smallText'>(Optional - If different from your members account)</span>","deliveryAddress"); ?><br />
			<?php smControls::smTextArea("Special details","specialDetails"); ?><br />
			
			<!-- edit 11-11-11 CODE FOR FRIEND -->
			<script type="text/javascript">
			<!--
				$(document).ready(function(){				
					$('#sendCodetoFriend').click(function(){
						$('#hiddenfriendform').slideToggle();
					});
					
					$('#sendFirstOrderCode').click(function(){
						$('#hiddenfirstorderform').slideToggle();
					});
					
				});  
			//-->	
			</script>
			<!--
			<?php //smControls::smCheckBox("Send special offer for your friend save 25% per order","sendCodetoFriend",1); ?><br/>
			<div id="hiddenfriendform" style="display:none;">
				<?php //smControls::smTextBox("Your friend email address","yourFriendEmail"); ?><br />
				<?php //smControls::smTextArea("Message","sendMessagetoFriend"); ?><br />
			</div><br/>
			
			<?php //smControls::smPasswordBox("Save your money 25% (not include shipping, not include discount from promotion), Do you have friend code?","codeForFriend","");?><br/><br/>
			-->
			
			<?php smControls::smCheckBox("Do you have voucher codes?","sendFirstOrderCode",1); ?><br/>
			<div id="hiddenfirstorderform" style="display:none;">
				<?php smControls::smPasswordBox("Save your money 50% (not include shipping, not include discount from promotion), Put voucher code","codeForFirstOrder","");?><br/><br/>
			</div><br/>
			
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

			<?php smControls::smHiddenText("amount",$cartValue); ?>
			<?php
				$cartId = tsShoppingCart::scGetInProgressMemberCart($_SESSION['auth']->mId);
				smControls::smHiddenText("scId",$cartId->scId);
				$_SESSION['orderRef'] = $cartId->scId;
				$_SESSION['orderValue'] = $cartValue;
			?>
			<p>Pay via the telephone by calling 01 789 205612 and talking with one of our representatives. Or pay online<!--directly using your Credit Card (securely via Sage) or --> by Paypal.</p>
			<?php smControls::smButton("Pay via telephone","payDirect"); ?>
			<?php
			if($_SESSION['auth']->mUsername=="may"){
				//echo "<p>Pay via the telephone by calling 01 789 205612 and talking with one of our representatives. Or pay online directly using your Credit Card (securely via Sage) or by Paypal.</p>";
				//smControls::smButton("Pay via telephone","payDirect");
				//echo"<input type='button' id='payCreditCard' name='payCreditCard' class='button' value='Pay via credit card' />";
			}
			//echo $rando = tsMembers::_randomVoucherCode(6);
			?>
			<input type="image" src="https://www.paypal.com/en_GB/i/btn/btn_buynowCC_LG.gif" alt="Make payments with PayPal - it's fast, free and secure!" />
		</fieldset>
	</div>
</form>

<form id="payWithCreditCard" method="post" action="paypal_outward.php" enctype="multipart/form-data" onsubmit="return chkInput()">
	<div id="transactionform" style="display:none;">
		<? include('transaction-form.php'); ?>
	</div>
</form>

<?php }  // end if cart val > 0  ?>
<?php include($siteRoot."includes/page_footer.php"); ?>
