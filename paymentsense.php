<?php

include_once('includes/globals.php');
include_once('includes/html_head.php');
include_once("forms/form_head.php");


require_once("PMS/PaymentFormHelper.php");
include("PMS/Config.php");
include("PMS/ISOCurrencies.php");

?>



<div class="row">

    <div class="span8">
    
    <?php
	include ("PMS/PreProcessPaymentForm.php");

	$Width = 800;
	include ("PMS/Templates/FormHeader.tpl");

	switch ($NextFormMode)
	{
		case "RESULTS":
			if (isset($DuplicateTransaction) != true)
			{
				$DuplicateTransaction = false;							
			}
			if ($TransactionSuccessful == false)
			{
				$MessageClass = "ErrorMessage";
			}
			else
			{
				$MessageClass = "SuccessMessage";
			}
			include ("PMS/Templates/FinalResultsPanel.tpl");
			break;
		case "THREE_D_SECURE":
			$SiteSecureBaseURL = PaymentFormHelper::getSiteSecureBaseURL();
			include ("PMS/Templates/3DSIFrame.tpl");
			break;
		case "PAYMENT_FORM":
			if (isset($Message) == true &&
				$Message != "")
			{
				include ("PMS/Templates/ProcessingErrorResultsPanel.tpl");
			}

			if ($SuppressFormDisplay == false)
			{
				include ("PMS/ISOCountries.php");
				include ("PMS/ISOCurrencies.php");

				if ($iclISOCurrencyList->getISOCurrency($CurrencyShort, $icISOCurrency))
				{
					$szDisplayAmount = $icISOCurrency->getAmountCurrencyString($Amount);
				}

				$szHashDigest = PaymentFormHelper::calculateHashDigest(PaymentFormHelper::generateStringToHash($Amount,
			                        $CurrencyShort,
			                        $OrderID,
			                        $OrderDescription,
			                        $SecretKey));

				$lilExpiryDateMonthList = PaymentFormHelper::createExpiryDateMonthListItemList($ExpiryDateMonth);
				$lilExpiryDateYearList = PaymentFormHelper::createExpiryDateYearListItemList($ExpiryDateYear);
				$lilStartDateMonthList = PaymentFormHelper::createStartDateMonthListItemList($StartDateMonth);
				$lilStartDateYearList = PaymentFormHelper::createStartDateYearListItemList($StartDateYear);
				
				$lilISOCountryList = PaymentFormHelper::createISOCountryListItemList($CountryShort, $iclISOCountryList);

				include ("PMS/Templates/PaymentForm.tpl");
			}
			break;
	}
	include ("PMS/Templates/FormFooter.tpl");
?>


        
    </div><!--end span8-->

    <div class="span4">
        
    </div><!--end span4-->
        
</div>
<script type="text/javascript">
    $(document).ready(function(){
           

    });
</script>
<?php include_once('forms/form_end.php'); ?>