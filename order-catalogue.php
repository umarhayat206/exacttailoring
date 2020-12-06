<?php

include_once('includes/globals.php');
include_once('includes/html_head.php');
include_once("forms/form_head.php");


function countryDropdownList2($checkedId){
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
<div class="container">
<div class="row">
    <div class="span12">
        

    <h3 class="text-center" id="contactus-h1">Order a catalogue</h3>
<br/>

<div class="col-lg-6 col-md-6" >
     <img src="<?php echo _URL_; ?>images/ExactTrousers1.jpg" class="left" style="margin:0 10px 10px 0; width:100%;" alt="Made to Measure Coduroy Trousers in your choice of Styling Fabric Colour" title="Exact Tailoring Catalog" />
     
      <img src="<?php echo _URL_; ?>images/ExactTrousers2.jpg" class="left" style="margin:0 10px 10px 0; width:100%;" alt="Made to Measure Coduroy Trousers in your choice of styling and 8 colourways" title="Exact Tailoring Catalog" />
      
    <img src="<?php echo _URL_; ?>images/main_open_catalog.jpg" class="left" style="margin:0 10px 10px 0; width:100%;" alt="Photoshopped image showing the Exact Tailoring Catalogue" title="Exact Tailoring Catalog" />
    
    <br style="clear:both;"/>
   
</div>

<script>
$(function(){
    $('#lookup_field').setupPostcodeLookup({
        api_key: 'ak_ic5l861dk3hDAgI3jXOEGl4qPxOqv', // real key
        // Pass in CSS selectors pointing to your input fields
        output_fields: {
            line_1: '#catalogueaddress',
            line_2: '#catalogueaddress2',
            line_3: '#catalogueaddress3',
            post_town: '#cataloguecity',
            postcode: '#cataloguepostcode',
            organisation_name: '#cataloguecompany',
        }
    });
});
</script>

<div class="col-lg-6 col-md-6">
    <div class="contact-us-form" id="orderacatalogue">
        <form id="ordercatalogueform" method="post" action="<?php echo _URL_; ?>send-order-catalogue">
            <fieldset>
                
                <label>Name:</label>
                <input id="cataloguename" name="cataloguename"  type="text"required placeholder="Your Name - Required" class="form-control account-input" /><br>
		
		        <label>Surname:</label>
                <input id="cataloguesurname" name="cataloguesurname"  type="text" required placeholder="Surname - Required" class="form-control account-input" /><br/>
                
                <label>Your Email:</label>
                <input id="catalogueemail" name="catalogueemail" type="text" required placeholder="Your E-Mail - Required"  class="form-control account-input" /><br/>
                
		 <label style="width: 100%;">Sign up for exclusive email offers and promotions ?:
                <input id="catalogueexclusive" name="catalogueexclusive" type="checkbox" value="1" /></label><br/><br>
		
                <label>Telephone Number:</label>
                <input id="cataloguephone" name="cataloguephone" type="text" placeholder="Telephone number" class="form-control account-input" /><br/>

                <div id="lookup_field" style="clear:both; margin-top:15px; float:left;"></div>

                <label>Organisation Name:</label>
                <input id="cataloguecompany" name="cataloguecompany" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text"  placeholder="Organisation Name" class="form-control account-input"/><br/>

                <label>Address Line One:</label>
                <input id="catalogueaddress" name="catalogueaddress" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" value="" class="form-control account-input"/><br>

                <label>Address Line Two:</label>
                <input id="catalogueaddress2" name="catalogueaddress2" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" value="" class="form-control account-input"/><br>

                <label>Address Line Three:</label>
                <input id="catalogueaddress3" name="catalogueaddress3" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" value="" class="form-control account-input"/><br>

                <label>City/Town:</label>
                <input id="cataloguecity" name="cataloguecity" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" value="" class="form-control account-input"/><br>
                
                <label>Postcode:</label>
                <input id="cataloguepostcode" name="cataloguepostcode" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" value="" class="form-control account-input"/><br>
                
                <label>Country:</label>
                <select id="cataloguecountry" name="cataloguecountry" class="form-control account-input">
                    <?php echo countryDropdownList2(183); ?>
                </select><br/>

                <div style="clear:both; margin-top:15px; float:left;"></div>

 
                <label>Further details:</label>
                <textarea id="cataloguemessage" name="cataloguemessage" placeholder="You Message..." class="form-control account-input" style="height:150px;"></textarea><br/>

    
                <?php
                smControls::smDropDownList(
                    "How did you hear about us?",
                    "cataloguehowHear",
                    array(
			    "Facebook"=>"Facebook",
                            "Google"=>"Google",
                            "Daily Mail"=>"Daily Mail",
                            "Daily Telegraph"=>"Daily Telegraph",
                            "Daily Express"=>"Daily Express",
                            "Mail on Sunday"=>"Mail on Sunday",
                            "Sunday Telegraph"=>"Sunday Telegraph",
                            "Sunday Express"=>"Sunday Express",
                            "The Times"=>"The Times",
                            "Sunday Times"=>"Sunday Times",
                            "Recommendation"=>"Recommendation",
                            "Other"=>"Other",
                    ),
                    "",
                    "",
                    "",
                    "true"
                );
                ?>
                <br style="clear:both;"/>
                <img src="get_captcha.php" alt="captcha" id="captcha" class="left" />
                <img src="refresh.jpg" alt="captcha" id="refresh" class="left" style="width:25px; cursor:pointer; margin:13px 10px 0 0;" />
                <input type="text" id="catalogueverify" name="catalogueverify" value="" class='form-control account-input' onkeyup="javascript:this.value=this.value.toUpperCase();" required="" placeholder="Security Code - Required"  />
                <input type="hidden" id="ordercatalogueSubmitted" name="ordercatalogueSubmitted" value="true" />
               
               <label>&nbsp;</label>
               <button type="submit" class="btn btn-primary pull-right" style="margin-top:11px;">Send</button>
        
            </fieldset>
        </form>
    </div><br><br>
    
     <p>
        The Exact Tailor Store Latest Catalogue is now available. If you would like
        to receive our latest catalogue, please phone, email us, fill in the form
        below and we will send one out immediately, or simply download the
        <a href="<?=_URL_; ?>images/ExactSpringCatalogue.pdf" target="_blank" title="Download the Exact catalogue">Exact Latest Catalogue</a>
        and the
        <a href="<?=_URL_; ?>images/order-form.pdf"  target="_blank"  title="Download the Exact order form">Exact Order Form</a>
        (right click and choose "save as"). All contact info can be found at the bottom of the page.
    </p>
    <p>
        We do not send out any flyers or junk mail at any time. Submitting your details
        here will result in you receiving one catalogue only, on one occasion, not an
        endless stream of junk mail. We do not lend or sell our mailing list to anyone.
    </p>


</div> 

    </div>
</div>
</div>


<?php include_once('forms/form_end.php'); ?>