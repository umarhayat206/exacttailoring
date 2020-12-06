<?php
 /*
 * Disclaimer: PaymentSense provides this code as an example of a working integration module.
 * Responsibility for the final implementation, functionality and testing of the module resides with the merchant/merchants website developer.
*/
// Will need to set these variables to valid a Gateway MerchantID and Password (not the MMS login Details)
// These were obtained during sign up

/*merchants details*/
$MerchantID = 'wwwexa-3674937';
$Password = 'paYmenT5en5e3';
$PreSharedKey = 'RvWpi/2twdRCAeMEasmrmP6SDoIhxP4Y23DNzn+EmT/RX6NWZus=';

// This method MUST match the hash method set for the merchant in the MMS
$HashMethod = 'SHA1';

// The domain ONLY for the hosted payment form - Do Not Change
$PaymentProcessorDomain = 'paymentsensegateway.com';

/* determines how the transaction result will be delivered back to this site:
	* "POST" - only use if this site has an SSL certificate. Best method to use if you do have an SSL
	* "SERVER" - best method with no SSL - don't use if this site requires to maintain 
	*			  cookie-based session to access its order object)
	* "SERVER_PULL" - only use if no SSL and site also requires cookie-based session to access 
	*			  	   its order object
	*/

$ResultDeliveryMethod = 'SERVER_PULL';

//Hosted Payment Form Settings	
$EmailAddressEditable = PaymentFormHelper::boolToString(true);
$PhoneNumberEditable = PaymentFormHelper::boolToString(true);
$CV2Mandatory = PaymentFormHelper::boolToString(true);
$Address1Mandatory = PaymentFormHelper::boolToString(true);
$CityMandatory = PaymentFormHelper::boolToString(true);
$PostCodeMandatory = PaymentFormHelper::boolToString(true);
$StateMandatory = PaymentFormHelper::boolToString(true);
$CountryMandatory = PaymentFormHelper::boolToString(true);

//misc return values
$EchoCardType = PaymentFormHelper::boolToString(true); //set to true by default



//Security Override Policys
$AVSOverridePolicy = '';
$CV2OverridePolicy = '';
$ThreeDSecureOverridePolicy = PaymentFormHelper::boolToString(false);
 