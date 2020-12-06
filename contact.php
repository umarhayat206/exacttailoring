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
    var input_lat = '#frmLat';
    var input_log = '#frmLon';
    var input_zoom = '#googlezoom';

    function initialize() {
        GGM = new Object(google.maps);
        geocoder = new GGM.Geocoder();

        var my_Latlng = new GGM.LatLng(52.198822067169885, -1.715540885925293);
        var my_mapTypeId = GGM.MapTypeId.ROADMAP;
        var my_DivObj = $("#map_canvas")[0];
        var myOptions = {
            zoom: 13,
            center: my_Latlng,
            scrollwheel: false,
            mapTypeId: my_mapTypeId,
            disableDefaultUI: true,
            zoomControl: true,
            //scaleControl: false,
            disableDoubleClickZoom: true
        };
        map = new GGM.Map(my_DivObj, myOptions);

        my_Marker = new GGM.Marker({
            position: my_Latlng,
            map: map,
            draggable: false,
            title: "Exact Personal Tailoring Services, PO Box 3370, Stratford Upon Avon, CV37 7XR"
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
<div class="container-fluid">

   <div id="contactus-background-1">
    <br><br><br><br><br>
     
     <h1 id="div-background-h1" class="text-center">Contact Us</h1>
       
  </div>


<div class="jumbotron" style="margin-top:px;">
<div class="container">
    <h1 class="text-center" id="contactus-h1">Send Us Message</h1><br><br>
  <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6">

        <div id="contactus-info-div">
            
          <form id="contactform" name="contactform" method="post" action="<?php echo _URL_; ?>send-contact.php">
                <div class="controls controls-row">
                    <input id="contactname" name="contactname" class="span4 cutcopypaste  limited60 form-control contactus-input" type="text" placeholder="Your Name - Required" maxlength="60" required /><br>
                    <input id="contactemail" name="contactemail" class="span4 cutcopypaste limited60  email form-control contactus-input" type="text" placeholder="Your E-Mail - Required" maxlength="60" required="" /><br>
                </div>
                <div class="controls">
                    <textarea id="contactmessage" name="contactmessage" class="span8 cutcopypaste limited300  form-control" placeholder="You Message...(Max 300 Characters)" style="height:150px;" maxlength="300" required=""></textarea>
                </div>

                <div class="controls controls-row">
                    <img src="get_captcha.php" alt="captcha" id="captcha" class="left" />
                    <img src="refresh.jpg" alt="captcha" id="refresh" class="left" style="width:25px; cursor:pointer; margin:13px 10px 0 0;" />
                    <input type="text" id="contactverify" name="contactverify" value="" class=" cutcopypaste limited10 form-control contactus-input" placeholder="Security Code - Required" maxlength="10" style="margin-top:11px; text-transform: uppercase;" required="
                    " />
                    <input type="hidden" id="contactformSubmitted" name="contactformSubmitted" value="true" /><br>
                    <button type="submit" class="btn btn-default">Send Email</button>
                </div>
            </form>

        </div>
          
      </div>

      <div class="col-lg-6 col-md-6 col-sm-6">

         <div id="contactus-info-div">
            
                <h1 id="contactus-h1" class="text-center">Contact Information</h1>
            
            <address>
                <h3 style="font-weight:bold;"><i class="icon-pushpin all-icon"></i> Address Info:</h3>
                <b style="padding-left:30px;font-size:15px;">Exact Personal Tailoring Services.</b>
                </address>
           
            <address>
                <h3 style="font-weight:bold;"><i class="icon-volume-up all-icon"></i> Give Us a call on:</h3>
                <p style="padding-left:30px;"><?php echo $siteContactNumber ."<br>".
                $siteContactNumber2; ?></p>
            </address>

            <address>
                <h3 style="font-weight:bold;"><i class="icon-envelope-alt all-icon"></i> E-Mail Us on:</h3>
                <a style="padding-left:30px;font-weight:bold;"><?php echo $smMainEmail; ?></a><br />
            </address>

            <address>
                <h3 style="font-weight:bold;"><i class="icon-pushpin all-icon"></i> Find Us on:</h3><br>
                <ol class="socials clearfix" style="padding-left:30px;">
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

      </div>
  </div> 
</div>
</div>







    <!-- <div class="span8">
        

        <div class="">
            <div class="titleHeader clearfix">
                <h3>Send Us Message</h3>
            </div> -->

            
       <!--  </div>
    </div> -->
    <!--end span8-->

    <!-- <div class="span4"> -->
        
        <?php /*

        <a href="<?php echo _URL_; ?>collection/categories-mens-shirts/fabric-mauritius-">
            <img src="<?= _URL_; ?>images/mauritius-montage.jpg" alt="Buy tailor made shirts online" title="Buy tailor made shirts online" style="width:100%; margin-top:10px;" />
        </a>
        */ ?>
    <!-- </div> -->
    <!--end span4-->


</div>

</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.cutcopypaste').bind("cut copy paste", function(e) {
            e.preventDefault();
        });

        $('.limited10').keypress(function() {
            if ($(this).val().length >= 10) {
                $(this).val($(this).val().slice(0, 10));
                return false;
            }
        });
        $('.limited60').keypress(function() {
            if ($(this).val().length >= 60) {
                $(this).val($(this).val().slice(0, 60));
                return false;
            }
        });
        $('.limited300').keypress(function() {
            if ($(this).val().length >= 300) {
                $(this).val($(this).val().slice(0, 300));
                return false;
            }
        });

    });
</script>
<?php include_once('forms/form_end.php'); ?>