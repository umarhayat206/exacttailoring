<?php

include_once('includes/globals.php');
include_once('includes/html_head.php');
include_once("forms/form_head.php");

?>

<div class="jumbotron" style="margin-top:-50px;">
<div class="container">
    <h4 class="text-center"id="contactus-h1">Let us know if you have a problem<br> with our website</h4><br><br>
<div class="row">    
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <!-- <div class="span8"> -->

    <div id="contactus-info-div">
    
        
       
        <!-- <div class="contact-us-form"> -->

            <form id="contactform" name="contactform" method="post" action="<?php echo _URL_; ?>send-problem.php">
                <div class="controls controls-row">
                    <input id="contactname" name="contactname" type="text"class="span4  form-control contactus-input " placeholder="Your Name - Required" required="" /><br>
                    <input id="contactemail" name="contactemail" type="text" class="span4 email form-control contactus-input" required="" placeholder="Your E-Mail - Required" /><br>
                </div>
                <div class="controls controls-row">
                    <input id="contacttelephone" name="contacttelephone" class="span4 form-control contactus-input" type="text" placeholder="Telephone / Mobile" /><br>
                    <input id="contactsubject" name="contactsubject" class="span4 form-control contactus-input" type="text" placeholder="What problem?" /><br>
                </div>

                <div class="controls">
                    <textarea id="contactmessage" name="contactmessage" class="span8 required  form-control contactus-input" placeholder="You Message..."style="height:150px;" required=""></textarea><br>
                </div>

                <div class="controls controls-row">
                    <img src="get_captcha.php" alt="captcha" id="captcha" class="left" />
                    <img src="refresh.jpg" alt="captcha" id="refresh" class="left" style="width:25px; cursor:pointer; margin:13px 10px 0 0;" />
                    <input type="text" id="contactverify" name="contactverify" value="" class=" form-control contactus-input" placeholder="Security Code - Required" style="margin-top:11px; text-transform:uppercase;" required="" />
                    <input type="hidden" id="contactformSubmitted" name="contactformSubmitted" value="true" /><br>
                    <button type="submit" class="btn btn-default" style="margin-top:px;">Send Email</button>
                </div>
            </form>
        <!-- </div> -->
    </div>
    <!-- </div> -->
   </div>
    <!--end span8-->
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    
        <div id="contactus-info-div">
            
                <h3 id="contactus-h1" class="text-center">Contact Information</h3><br>
            

                <address>
                <h3 style="font-weight:bold;"><i class="icon-pushpin all-icon"></i> Address Info:</h3>
                <b style="padding-left:30px;font-size:15px;">Exact Personal Tailoring Services.</b>
                </address>
            
           
            <address>
                <h3 style="font-weight:bold;"><i class="icon-envelope-alt all-icon"></i> E-Mail Us on:</h3>
                <a style="padding-left:30px;font-weight:bold;"><?php echo $smMainEmail; ?></a><br />
            </address>

            <address>
                <h3 style="font-weight:bold;"><i class="icon-pushpin all-icon"></i> Find Us on:</h3><br>
                <ol class="socials clearfix" style="padding-left:30px;">
                    <li>
                        <a class="social-facebook" href="#"><i class="icon-facebook"></i></a>
                    </li>
                    <li>
                        <a class="social-twitter" href="#"><i class="icon-twitter "></i></a>
                    </li>
                    <li>
                        <a class="social-gooleplus" href="#"><i class="icon-google-plus"></i></a>
                    </li>
                    <li>
                        <a class="social-linkedin" href="#"><i class="icon-linkedin"></i></a>
                    </li>
                    <li>
                        <a class="social-github" href="#"><i class="icon-github"></i></a>
                    </li>
                    <li>
                        <a class="social-pinterest" href="#"><i class="icon-pinterest"></i></a>
                    </li>
                </ol>
            </address>
        </div>
        </div>    
        
        
   
</div>
</div>    
</div>


<?php include_once('forms/form_end.php'); ?>