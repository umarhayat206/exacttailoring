        </div>
        <!--end conatiner-->

<footer>
            <!-- pahla hi comment tha  -->
        	<?php /*
        	<!-- TrustBox widget - Starter -->
        	<div class="trustpilot-widget" data-locale="en-GB" data-template-id="5613c9cde69ddc09340c6beb" data-businessunit-id="5bacbec764839f00014c39e3" data-style-height="100px" data-style-width="100%" data-theme="light">
        		<a href="https://uk.trustpilot.com/review/exacttailoring.com" target="_blank">Trustpilot</a>
        	</div>
			<!-- End TrustBox widget -->
			*/ ?>
            <!-- comment end here -->

        	<!-- <div class="footerOuter">
        		<div class="container">
        			<div class="row-fluid">

        				<div class="span4">
        					<div class="titleHeader clearfix"> -->
        						<!-- <h3>Customer Service</h3> -->
        
<div class="container-fluid">        					<!-- </div> -->
<div id="div-footer">
<div class="container">

     <div >  
       <div class="row">
               <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                  <div style="height:auto;margin-bottom:40px;">
                  <img src="images/logo.png" id="logo_img-footer" class="img-responsive"><br><br>
                  <p style="font-size:14px;">
                  Far far away, behind the word<br /> mountains, far from the<br /> countries Vokalia and<br /> Consonantia.
                  </p><br /><br />
                   <ul id="ul-footer" style="margin-top:-35px;">
                   <li><img  style=""src="<?= _URL_ ?>styles/all-major-cards-accepted.jpg" alt="All major cards accepted" /></li>
                  <li class="paypal"></li>
                  <li style="margin-top:20px"><span id="siteseal">
                  <script async type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=4f6p4tUFFam1How3jOye3Gaoac3tuHTr9kDyXVMXFoaXrNiOrbVhgtvQKTmj"></script>
                  </span></li>
                  </ul>
                  <br>
                  <i class="fab fa-facebook" style="font-size:28px"></i>
                   <i class="fab fa-twitter" style="font-size:28px"></i>
                    <i class="fab fa-instagram" style="font-size:28px"></i>

                    
                     
                  </div>
              </div>
              
              <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                 <div style="height:200px;margin-bottom:40px;">
                 <h1 id="h1-footer-1">Menu</h1>
                 <ul id="ul-footer">
                <?php
                $getNevContent = smContent::GetContentMenu(2);
                foreach ($getNevContent as $item) {
                $pagelink = str_replace(" ", "-", strtolower($item->pageName));
                $pagename = str_replace("&", "&amp;", $item->pageName);
                echo "<li><a class='invarseColor' href='" . _URL_ . "content/$pagelink'><i class='icon-caret-right'></i> $pagename</a></li>";
                }
                ?>
                <li><a class="invarseColor" href="<?= _URL_; ?>customer-comments"><i class="icon-caret-right"></i> Customer Comments</a></li>
                 </ul>
                 </div>
              </div>
              
              <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                 <div style="height:200px;margin-bottom:40px;">
                 <h1 id="h1-footer-1">About Exact Tailoring</h1>
                 <ul id="ul-footer">

                    <?php
                    $getNevContent = smContent::GetContentMenu(1);
                    foreach ($getNevContent as $item) {
                    $pagelink = str_replace(" ", "-", strtolower($item->pageName));
                    $pagename = str_replace("&", "&amp;", $item->pageName);
                    echo "<li><a class='invarseColor' href='" . _URL_ . "content/$pagelink'><i class='icon-caret-right'></i> $pagename</a></li>";
                    }
                    ?>
                
                </ul>
                </div>
             </div>
              
              
              <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                   <div style="height:200px">
                   <h1 id="h1-footer-1">Contact Information</h1>
                   <p style="font-size:14px;">Exact Personal Tailoring Services. </p>
                  

                      <ul id="ul-footer">
                        <li><span class="glyphicon glyphicon-earphone ear2"></span><p style="font-size:14px;color: white;margin-left:40px;margin-top:-35px;">01 789 205612</p></li>

                          <li><span class="glyphicon glyphicon-earphone ear2"></span><p style="font-size:14px;color: white;margin-left:40px;margin-top:-35px;">+44 (0) 1789 205 612</p></li>
                          <li><span class="glyphicon glyphicon-envelope">  </span><p style="font-size:14px;margin-left:40px;margin-top:-35px;">Email: info@exacttailoring.com</p></li>
                          <li><a href="<?= _URL_; ?>contact" style="font-size:14px;color:white;">Contact Form click here</a></li>

                      </ul>
                     
                  </div>     
                     
               </div>
              </div>
              
       </div>
    </div>    <br><br><br>
    <div id="footer-border"></div><br>
    <div>
        <center><p>Website Design by <a href="http://webdesignpattaya.com/" target="_blank">SWM</a>, &copy; <?= date("Y"); ?> for <a href="<?= _URL_; ?>">exacttailoring.com</a></p></center>

    </div>
</div>
</div>



             

        					<!-- <div class="usefullLinks">
        						<div class="row-fluid">
        							<div class="span12">
        								<ul class="unstyled"> -->
        									<?php
											// $getNevContent = smContent::GetContentMenu(2);
											// foreach ($getNevContent as $item) {
											// 	$pagelink = str_replace(" ", "-", strtolower($item->pageName));
											// 	$pagename = str_replace("&", "&amp;", $item->pageName);
											// 	echo "<li><a class='invarseColor' href='" . _URL_ . "content/$pagelink'><i class='icon-caret-right'></i> $pagename</a></li>";
											// }
											?>
                                            <!-- comment start here -->
        									<!-- <li><a class="invarseColor" href="<?= _URL_; ?>my-account"><i class="icon-caret-right"></i> Measurements</a></li> -->
                                            <!-- end here -->
                                          <!--   
        									<li><a class="invarseColor" href="<?= _URL_; ?>customer-comments"><i class="icon-caret-right"></i> Customer Comments</a></li>
        								</ul>
        							</div>
        						</div>
        					</div>
        				</div> -->
        				

        				<!-- <div class="span4">
        					<div class="titleHeader clearfix">
        						<h3>About Exact Tailoring</h3>
        					</div> -->





        					<!-- < <div class="usefullLinks">
        						<div class="row-fluid">
        							<div class="span12">
        								<ul class="unstyled"> -->
        									<?php
											// $getNevContent = smContent::GetContentMenu(1);
											// foreach ($getNevContent as $item) {
											// 	$pagelink = str_replace(" ", "-", strtolower($item->pageName));
											// 	$pagename = str_replace("&", "&amp;", $item->pageName);
											// 	echo "<li><a class='invarseColor' href='" . _URL_ . "content/$pagelink'><i class='icon-caret-right'></i> $pagename</a></li>";
											// }
											?> 
                                            <!-- comment start here -->
        									<!-- <li><a class="invarseColor" href="<?= _URL_; ?>newsletter"><i class="icon-caret-right"></i> Newsletter</a></li>
        									<li><a class="invarseColor" href="<?= _URL_; ?>order-catalogue"><i class="icon-caret-right"></i> Order Catalogue</a></li> -->
                                            <!-- end here -->
        								<!-- </ul>
        							</div>
        						</div>
        					</div>
        				</div> -->
        				<!--end span4-->

        				<!-- <div class="span4">
        					<div class="titleHeader clearfix">
        						<h3>Contact Information</h3>
        					</div>

        					<div class="usefullLinks">
        						<div class="row-fluid">
        							<div class="span12" style="color:#CCC; margin-top:32px;">
        								<p>
        									Exact Personal Tailoring Services. <br /> -->
        									<?php  /*
											PO Box 3370, <br />
											Stratford Upon Avon, CV37 7XR <br />
											*/ ?>
        								<!-- </p>
        								<p>
        									Tel. <br />
        									01 789 205612 <br />
        									+44 (0) 1789 205 612
        								</p>
        								<p>Email: info@exacttailoring.com</p>
        								<p><a href="<?= _URL_; ?>contact" style="color:#CCC; text-decoration:underline;">Contact Form click here</a></p> -->
        								<!--
							<form id="subcontactform" name="subcontactform" method="post" action="<?php //echo _URL_; 
																									?>send-contact.php">
								<input class="input-block-level required" type="text" name="subcontactname" id="subcontactname" value="" placeholder="Your Name...">
								<input class="input-block-level required email" type="text" name="subcontactemail" id="subcontactemail" value="" placeholder="Your E-Mail...">
								<textarea class="input-block-level required" name="subcontactmessage" id="subcontactmessage" placeholder="type your message here..."></textarea>
								<input type="hidden" id="subcontactformSubmitted" name="subcontactformSubmitted" value="true" />
								<button class="btn btn-primary btn-block" type="submit" name="">Send Message</button>
							</form>
							-->
        						<!-- 	</div>
        						</div>
        					</div>
        				</div> -->
        				<!--end span4-->

        			<!-- </div> -->
        			<!--end row-fluid-->

        		<!-- </div> -->
        		<!--end container-->
        	<!-- </div> -->
        	<!--end footerOuter-->

        	<!-- <div class="container">
        		<div class="row">
        			<div class="span12">
        				<div class="inline pull-right"> -->

        					<!-- <span id="siteseal">
        						<script async type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=4f6p4tUFFam1How3jOye3Gaoac3tuHTr9kDyXVMXFoaXrNiOrbVhgtvQKTmj"></script>
        					</span>
 -->
        				<!-- </div> -->
        				<!-- <ul class="payments inline pull-right"> -->
        					<!--<li class="visia"></li>-->
        					<!-- <li class="paypal"></li> -->
        					<!--<li class="electron"></li>-->
        					<!--<li class="discover"></li>-->
        				<!-- </ul>
        				<p>Website Design by <a href="http://webdesignpattaya.com/" target="_blank">SWM</a>, &copy; <?= date("Y"); ?> for <a href="<?= _URL_; ?>">exacttailoring.com</a></p>
        			</div>
        		</div>
        	</div>
        </footer> -->

        <!-- </div>  -->

        <!-- <div id="dialog1" title="Member Login"> -->
        	<?php //include_once("includes/loginform.php"); ?>
        <!-- </div> -->
        <!--
<div id="dialog2" title="Member Register">
        <?php //include_once("includes/regisform.php"); 
		?>
</div>
-->

        <!-- <div id="dialog3" title="Password Reminder"> -->
        	<?php// include_once("includes/password-reminder.php"); ?>
        <!-- </div> -->

        <script type="text/javascript" src="<?= _URL_; ?>js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?= _URL_; ?>js/jquery.cookie.js"></script>
        <script type="text/javascript" src="<?= _URL_; ?>js/jquery.fancybox.js"></script>
        <script type="text/javascript" src="<?= _URL_; ?>js/jquery.tweet.js"></script>
        <script type="text/javascript" src="<?= _URL_; ?>js/custom.js"></script>
        <script type="text/javascript" src="<?= _URL_; ?>js/jquery.validate.js"></script>
        <script type="text/javascript" src="<?= _URL_; ?>js/jquery.prettyPhoto.js"></script>
        <script type="text/javascript" src="<?= _URL_; ?>js/jquery.digits.js"></script>
        <?php /*
<!-- TrustBox script -->
<script type="text/javascript" src="//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>
<!-- End Trustbox script -->

*/ ?>


        <?php //include_once("includes/script.php"); ?>

        <!--
<embed id="chrome-plugin-npapi-helper" type="application/chrome-extension-helper" style="visibility:hidden;max-width:1px;max-height:1px;position:absolute;left:-100px;top:-100px;">
-->
        <?php /*
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-68610668-1', 'auto');
  ga('send', 'pageview');

</script>

 <!-- Keptify Tracking -->
<script type='text/javascript'>
(function() {
    var s = document.createElement('script'); s.type = 'text/javascript';
    s.async = true;
    s.src = '//app.keptify.com/54c62926da5b1';
    var x = document.getElementsByTagName('script')[0];
    x.parentNode.insertBefore(s, x);
})();
</script>
<!-- Keptify Tracking -->
 */ ?>
        <script>
        	(function(i, s, o, g, r, a, m) {
        		i['GoogleAnalyticsObject'] = r;
        		i[r] = i[r] || function() {
        			(i[r].q = i[r].q || []).push(arguments)
        		}, i[r].l = 1 * new Date();
        		a = s.createElement(o),
        			m = s.getElementsByTagName(o)[0];
        		a.async = 1;
        		a.src = g;
        		m.parentNode.insertBefore(a, m)
        	})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        	ga('create', 'UA-2874486-57', 'auto');
        	ga('send', 'pageview');
        </script>


        <script type="text/javascript">
        	var callback = function(formatted_number, unformatted_number) {
        		jQuery('.usefullLinks .span12 p:contains("01 789 205612"),address:contains("01 789 205612") ').each(function() {
        			var e = jQuery(this);
        			var innerStr = jQuery(this).html().split('01 789 205612');
        			e.html(innerStr.join(formatted_number));
        		});
        	};
        	jQuery(document).ready(function() {
        		_googWcmGet(callback, '01 789 205612');
        	});
        </script>


        <!-- Google Code for Remarketing Tag -->
        <!--------------------------------------------------
Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. See more information and instructions on how to setup the tag on: http://google.com/ads/remarketingsetup
------------------------------------------------- -->
        <script type="text/javascript">
        	/* <![CDATA[ */
        	var google_conversion_id = 919188432;
        	var google_custom_params = window.google_tag_params;
        	var google_remarketing_only = true;
        	/* ]]> */
        </script>
        <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
        </script>
        <noscript>
        	<div style="display:inline;">
        		<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/919188432/?value=0&amp;guid=ON&amp;script=0" />
        	</div>
        </noscript>



        <script>
        	window.addEventListener('load', function() {
        		if (window.location.href.indexOf("/send-contact.php") != -1) {
        			ga('send', 'event', 'form', 'submit', 'contact us');
        		}
        	});
        </script>

        <script>
        	! function(f, b, e, v, n, t, s) {
        		if (f.fbq) return;
        		n = f.fbq = function() {
        			n.callMethod ?
        				n.callMethod.apply(n, arguments) : n.queue.push(arguments)
        		};
        		if (!f._fbq) f._fbq = n;
        		n.push = n;
        		n.loaded = !0;
        		n.version = '2.0';
        		n.queue = [];
        		t = b.createElement(e);
        		t.async = !0;
        		t.src = v;
        		s = b.getElementsByTagName(e)[0];
        		s.parentNode.insertBefore(t, s)
        	}(window,
        		document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');

        	fbq('init', '1069763303102834');
        	fbq('track', "PageView");
        </script>
        <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1069763303102834&ev=PageView&noscript=1" /></noscript>


        </body>

        </html>