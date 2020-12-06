<?php

include_once('includes/globals.php');
include_once('includes/html_head.php');
include_once("forms/form_head.php");

?>
<div class="row">

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <img src="<?=_URL_;?>images/tape-measure-madeto-measure-shirt.jpg" alt="Buy tailor made shirts online" title="Buy tailor made shirts online" style="width:100%; margin-top:10px;" />
    </div><!--end span4-->

    <div class="col-lg-6 col-md-6  col-sm-12 col-xs-12">
        


            <form id="tapemeasureofferFrm" name="tapemeasureofferFrm" method="post" action="<?php echo _URL_; ?>send-tapemeasureoffer.php">


                <div class="form-group">
                    <label for="tapemeasure_name" class="span2 control-label">NAME</label>
                    <div class="span5">
                        <input type="text" class="form-control contact-name account-input" id="tapemeasure_name" name="tapemeasure_name" placeholder="Full name" value=""  required >
                    </div>
                </div><br style="clear:both;">
                <div class="form-group">
                    <label for="tapemeasure_address" class="span2 control-label">ADDRESS</label>
                    <div class="span5">
                        <input type="text" class="form-control contact-name account-input" id="tapemeasure_address" name="tapemeasure_address" placeholder="Address" value=""  required >
                    </div>
                </div><br style="clear:both;">
                <div class="form-group">
                    <label for="tapemeasure_postcode" class="span2 control-label">POST CODE</label>
                    <div class="span5">
                        <input type="text" class="form-control contact-name account-input" id="tapemeasure_postcode" name="tapemeasure_postcode" placeholder="Post code" value=""  required>
                    </div>
                </div><br style="clear:both;">
                <div class="form-group">
                    <label for="tapemeasure_email" class="span2 control-label">E MAIL ADDRESS</label>
                    <div class="span5">
                        <input type="email" class="form-control contact-email account-input" id="tapemeasure_email" name="tapemeasure_email" placeholder="youEmail@domain.com" value=""  required >
                    </div>
                </div><br style="clear:both;">
                <div class="form-group">
                    <label for="tapemeasure_tel" class="span2 control-label">TELEPHONE NUMBER <small>( OPTIONAL )</small></label>
                    <div class="span5">
                        <input type="text" class="form-control contact-name account-input" id="tapemeasure_tel" name="tapemeasure_tel" placeholder="Telephone" value="" >
                        <small>We will not call you</small>
                    </div>
                </div><br style="clear:both;">





                <? /* ?><div class="controls controls-row">
                    <label>Name *</label>
                   <input id="contactname" name="contactname" class="span4" type="text" class="required" placeholder="Your Name - Required"/>
                   <input id="contactemail" name="contactemail" class="span4" type="text" class="required email" placeholder="Your E-Mail - Required" />
                </div>
                <div class="controls">
                   <textarea id="contactmessage" name="contactmessage" class="span8" class="required" placeholder="You Message..."></textarea>
                </div><? */ ?>
                <? /* ?>
                _gaq.push(['_trackEvent', 'tapemeasureoffer', 'Click', 'Tape Measure Offer', 1, true]);


                <? */ ?>
                <div class="controls controls-row">
                    <img src="get_captcha.php" alt="captcha" id="captcha" class="left" />
                    <img src="refresh.jpg" alt="captcha" id="refresh" class="left" style="width:25px; cursor:pointer; margin:13px 10px 0 0;" />
                    <input type="text" id="contactverify" name="contactverify" value="" class="form-control account-input" placeholder="Security Code - Required" style="margin-top:11px; text-transform: uppercase;" />
                    <input type="hidden" id="tapemeasureofferFrmSubmitted" name="tapemeasureofferFrmSubmitted" value="true" />
                    <br style="clear:both;">
                   <button type="submit" class="btn btn-default-shop " style="margin-top:11px;" onclick="ga('send', 'event', 'tapemeasureoffer', 'click', 'Tape Measure Offer');">Send Email</button>
                </div>
            </form>
        
    </div><!--end span8-->


        
</div>

<?php include_once('forms/form_end.php'); ?>