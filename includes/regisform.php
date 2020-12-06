<?php

function countryDropdownList($checkedId){
    $htmlToReturn ="";
    $countrylist = smSetting::getAllCountry();
    
    foreach($countrylist as $item){
        $htmlToReturn .= "<option value='".$item->rowId."'";
        $htmlToReturn .= $checkedId == $item->rowId ? " SELECTED ":"";
        $htmlToReturn .= ">".$item->countryName."</option>";
    }
    
    return $htmlToReturn;
}

?>

<script type="text/javascript">
<!--
function chkConfirmPassword() {
	var errorMsg = "";
	var frmregis=document.getElementById('memberregisform');
        //var _returnregisform = true;

	if(frmregis.r_confirmpassword.value != frmregis.r_password.value){
		alert("Please correct confirm password.");
		frmregis.r_confirmpassword.select();
		return false;
	}	
}		
//-->
</script>

<form id="memberregisform" class="contactForm" method="post" action="<?=_URL_;?>takeregisform.php" enctype="multipart/form-data" onsubmit="return chkConfirmPassword()">
    <fieldset>
        <legend>Personal information</legend>
        <label>Firstname *</label><input type="text" id="r_firstname" name="r_firstname" value="" class="required" /><br/>
        <label>Lastname *</label><input type="text" id="r_lastname" name="r_lastname" value="" class="required" /><br/>
        <label>Gender *</label>
        <select id="r_gender" name="r_gender">
            <option value="1" selected="selected">Male</option>
            <option value="2">Female</option>
        </select><br/>
        
        <label>Shipping Address *</label><textarea id="r_address" name="r_address" class="required"></textarea><br/>
        <label>Postcode</label><input type="text" id="r_postcode" name="r_postcode" value="" class="required" /><br/>
        <label>Country</label>
        <select id="r_country" name="r_country">
            <?php echo countryDropdownList(183); ?>
        </select><br/>
        
        <label>Where did you hear<br/>about Exact? *</label>
        <select id="r_howhear" name="r_howhear">
            <?php echo smSetting::getHowhearDropdowm(); ?>
        </select><br/>
    </fieldset>
    
    <fieldset>
        <legend>Preffered login details</legend>
        <label>Email address *</label><input type="text" id="r_email" name="r_email" value="" class="required email" /><br/>
        <label>Password *</label><input type="password" id="r_password" name="r_password" value="" class="required" />
        <label>Confirm Password *</label><input type="password" id="r_confirmpassword" name="r_confirmpassword" value="" class="required" /><br/>
    </fieldset>
    
    <!--
    <fieldset>
        <legend>Contact details</legend>
        <label>Telephone </label><input type="text" id="r_telephone" name="r_telephone" value="" class="required" /><br/>
        <label>Mobile </label><input type="text" id="r_mobile" name="r_mobile" value="" class="required" /><br/>
        <label>Fax</label><input type="text" id="r_fax" name="r_fax" value="" class="required" />
    </fieldset>
    -->
    
    <fieldset>
        <legend>Security Code</legend>
        <img src="get_captcha.php" alt="" id="captcha" />
        <img src="refresh.jpg" width="25" alt="" id="refresh" />	
        <input name="r_verify" type="text" id="r_verify" style=" margin:3px 0 0 15px; width:80px; float:none;" />
    </fieldset>
    
    <input type="hidden" id="memberregisformsubmit" name="memberregisformsubmit" value="true" />
</form>