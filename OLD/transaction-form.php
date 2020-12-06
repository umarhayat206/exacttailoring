<?php
//$pageTitle = "Checkout - ";
/*
include("code/application_code_includes_and_globals_file.php");

include($siteRoot."panels/cart_details_code.php");

include($siteRoot."includes/html_head.php");
include($siteRoot."includes/page_header.php");
*/
//echo $_SESSION['auth']->mFirstname." ".$_SESSION['auth']->mLastname." ".$_SESSION['auth']->mEmail;

// TODO:: Billing Form & Delivery Form

?>
<!--<form id="payWithPayPal" method="post" action="paypal_outward.php">-->
    
<h2>Please enter your Billing details below</h2>
    <?php smControls::smTextBox("*First Name","billFirstName"); ?><br/>
    <?php smControls::smTextBox("*Surname","billSurname"); ?><br/>
    <?php smControls::smTextBox("*Address Line 1","billAddress1"); ?><br/>
    <?php smControls::smTextBox("Address Line2","billAddress2"); ?><br/>
    <?php smControls::smTextBox("*City","billCity"); ?><br/>
    <?php smControls::smTextBox("*Post / Zip Code","billPostCode"); ?><br/>
    
    <label>*Country</label>
    <select id="billCountry" name="billCountry">
        <option value=""></option>
        <?
        $sql1="SELECT * FROM iso_countries ORDER BY countryName ASC";
	$query1=mysql_query($sql1);
	while($row1=mysql_fetch_array($query1)){
            $billCountryName=$row1['countryName'];
            $billCountryCode=$row1['countryCode'];
            echo "<option value='$billCountryCode'>$billCountryName</option>";
        }
        ?>
    </select><br/>
    
    <?php smControls::smTextBox("Phone","billPhone"); ?><br/>
    <?php smControls::smTextBox("State Code (U.S. only)","billStateCode"); ?><br/>
    <?php //smControls::smTextBox("E-Mail Address","billEmail"); ?><br/><br/>

<h2>Please enter your Delivery details below</h2>
    <?php smControls::smTextBox("*First Name","deliFirstName"); ?><br/>
    <?php smControls::smTextBox("*Surname","deliSurname"); ?><br/>
    <?php smControls::smTextBox("*Address Line 1","deliAddress1"); ?><br/>
    <?php smControls::smTextBox("Address Line2","deliAddress2"); ?><br/>
    <?php smControls::smTextBox("*City","deliCity"); ?><br/>
    <?php smControls::smTextBox("*Post / Zip Code","deliPostCode"); ?><br/>
    
    <label>*Country</label>
    <select id="deliCountry" name="deliCountry">
        <option value=""></option>
        <?
        $sql2="SELECT * FROM iso_countries ORDER BY countryName ASC";
	$query2=mysql_query($sql2);
	while($row2=mysql_fetch_array($query2)){
            $deliCountryName=$row2['countryName'];
            $deliCountryCode=$row2['countryCode'];
            echo "<option value='$deliCountryCode'>$deliCountryName</option>";
        }
        ?>
    </select><br/>
    
    <?php smControls::smTextBox("Phone","deliPhone"); ?><br/>
    <?php smControls::smTextBox("State Code (U.S. only)","deliStateCode"); ?><br/>
    <?php //smControls::smTextBox("E-Mail Address","deliEmail"); ?><br/><br/>

<h2>Enter Card Details</h2>
    <label>*Card Type: </label>
    <select id="payCreditType" name="payCreditType">
        <option value=""></option>
        <option value="VISA">Visa</option>
        <option value="MC">MasterCard</option>
        <option value="DELTA">Visa Debit / Delta</option>
        <option value="SOLO">Solo</option>
        <option value="MAESTRO">UK Maestro / International Maestro</option>
        <option value="AMEX">American Express</option>
        <option value="UKE">Visa Electron</option>
        <option value="JCB">JCB</option>
    </select><br/>
    
    <?php smControls::smTextBox("*Card Holder Name","payCreditHolderName"); ?><br/>
    <?php smControls::smPasswordBox("*Card Number (With no spaces or separations)","payCreditNumber"); ?><br/>
    <?php smControls::smTextBox("*Start Date (Where avaliable. Use MMYY format e.g. 0207)","payCreditStartDate"); ?><br/>
    <?php smControls::smTextBox("*Expiry Date (Use MMYY format with no / or - separations e.g. 1109)","payCreditExpiryDate"); ?><br/>
    <?php smControls::smTextBox("Issue Number (Older Switch cards only. 1 or 2 digits as printed on the card)","payCreditIssueNumber"); ?><br/>
    <?php smControls::smPasswordBox("*Card Verification Value (Additional 3 digits on card signature strip, 4 on Amax card)","payCreditCV2"); ?><br/><br/>
    
    <?php //smControls::smHiddenText("payCreditCard","payCreditCard"); ?>
    <?php //smControls::smButton("Go back","returnToPay");  ?>
    <?php smControls::smHiddenText("amount",$cartValue); ?>
    <?php smControls::smButton("Pay via credit card","payCreditCard"); ?>
    <?php echo"<input type='button' id='returnToPay' name='returnToPay' class='button' value='Go back' />"; ?><br/><br/>
<!--</form>-->

<?php //include($siteRoot."includes/page_footer.php");?>