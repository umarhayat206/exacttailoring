<?php

include_once('includes/globals.php');
include_once('includes/html_head.php');
include_once("forms/form_head.php");

?>

<script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
    var geocoder;
    var map;
    var my_Marker;
    var GGM;
    var input_lat='#frmLat';
    var input_log='#frmLon';
    var input_zoom='#googlezoom';
    
    function initialize() { 
        GGM=new Object(google.maps);
        geocoder = new GGM.Geocoder(); 

        var my_Latlng  = new GGM.LatLng(52.198822067169885, -1.715540885925293);
        var my_mapTypeId=GGM.MapTypeId.ROADMAP;
        var my_DivObj=$("#map_canvas")[0];
        var myOptions = {
                zoom: 13,
                center: my_Latlng ,
                scrollwheel: false ,
                mapTypeId:my_mapTypeId,
                disableDefaultUI: true,
                zoomControl: true,
                //scaleControl: false,
                disableDoubleClickZoom: true
        };
        map = new GGM.Map(my_DivObj,myOptions);
 
        my_Marker = new GGM.Marker({
            position: my_Latlng,
            map: map,
            draggable:false,
            title:"Exact Personal Tailoring Services, PO Box 3370, Stratford Upon Avon, CV37 7XR"
        });
        
        var infoWindow = new GGM.InfoWindow; 
        //infoWindow.setContent("Drag marker to position");
        //infoWindow.open(map,my_Marker);
        
        GGM.event.addListener(my_Marker, 'dragend', function() {
            var my_Point = my_Marker.getPosition();
            map.panTo(my_Point);
            $(input_lat).val(my_Point.lat());
            $(input_log).val(my_Point.lng());
            $(input_zoom).val(map.getZoom());			
        });		

        //  fix event when zoom map
        GGM.event.addListener(map, 'zoom_changed', function() {
            $(input_zoom).val(map.getZoom()); 	
        });
    }
</script>

<div class="row">

    <div class="span8">
        <div class="google-map">
            <div id="map_canvas" style="width: 580; height: 370px"></div>
            <script type="text/javascript">
                $(document).ready(function(){
                    window.onload=function(){initialize();}
                });
            </script>
        </div>

        <div class="contact-us-form">
            <div class="titleHeader clearfix">
                <h3>Send Us Message</h3>
            </div>

            <form id="contactform" name="contactform" method="post" action="<?php echo _URL_; ?>send-contact.php">
                <div class="controls controls-row">
                   <input id="contactname" name="contactname" class="span4" type="text" class="required" placeholder="Your Name - Required"/>
                   <input id="contactemail" name="contactemail" class="span4" type="text" class="required email" placeholder="Your E-Mail - Required" />
                </div>
                <div class="controls">
                   <textarea id="contactmessage" name="contactmessage" class="span8" class="required" placeholder="You Message..."></textarea>
                </div>
                
                <div class="controls controls-row">
                    <img src="get_captcha.php" alt="captcha" id="captcha" class="left" />
                    <img src="refresh.jpg" alt="captcha" id="refresh" class="left" style="width:25px; cursor:pointer; margin:13px 10px 0 0;" />
                    <input type="text" id="contactverify" name="contactverify" value="" class="required" placeholder="Security Code - Required" style="margin-top:11px; text-transform: uppercase;" />
                    <input type="hidden" id="contactformSubmitted" name="contactformSubmitted" value="true" />
                   <button type="submit" class="btn btn-primary pull-right" style="margin-top:11px;">Send Email</button>
                </div>
            </form>
        </div>
    </div><!--end span8-->

    <div class="span4">
        <div class="contact-info">
            <div class="titleHeader clearfix">
                <h3>Contact Information</h3>
            </div>

            <address>
               <strong><i class="icon-pushpin"></i> Address Info:</strong>
               <b>Exact Personal Tailoring Services.</b>
                PO Box 3370,<br/>
                Stratford Upon Avon,  CV37 7XR<br/>
            </address>

            <address>
               <strong><i class="icon-volume-up"></i> Give Us a call on:</strong>
                <?php echo $siteContactNumber ."<br/>". $siteContactNumber2; ?>
            </address>

            <address>
               <strong><i class="icon-envelope-alt"></i> E-Mail Us on:</strong>
                <a><?php echo $smMainEmail; ?></a><br />
            </address>

            <address>
               <strong><i class="icon-pushpin"></i> Find Us on:</strong>
                <ol class="socials clearfix">
                    <li>
                        <a class="social-facebook" href="https://www.facebook.com/ExactTailoring/" target="_blank"><i class="icon-facebook"></i></a>
                    </li>
                  <?php /* <li>  <li>
                        <a class="social-twitter" href="#"><i class="icon-twitter"></i></a>
                    </li>
                    <li>
                        <a class="social-gooleplus" href="#"><i class="icon-google-plus"></i></a>
                    </li>
                    <li>
                        <a class="social-linkedin" href="#"><i class="icon-linkedin"></i></a>
                    </li>
                    
                        <a class="social-github" href="#"><i class="icon-github"></i></a>
                    
                    <li>
                        <a class="social-pinterest" href="#"><i class="icon-pinterest"></i></a>
                    </li></li> */ ?>
                </ol>
            </address>
        </div>
        
        
    <a href="<?php echo _URL_; ?>collection/categories-mens-shirts/fabric-mauritius-">
			<img src="<?=_URL_;?>images/mauritius-montage.jpg" alt="Buy tailor made shirts online" title="Buy tailor made shirts online" style="width:100%; margin-top:10px;" />
	    </a>
    </div><!--end span4-->
        
</div>

<?php include_once('forms/form_end.php'); ?>