<?php
@session_start();
include_once('includes/globals.php');
include_once('includes/html_head.php');
include_once("forms/form_head.php");
//include_once("includes/script.php");

$getOurPromotion = smPromotion::GetAllPromotion(false); // status = Live

$i = 0;
$promotionMainPhoto = "";
foreach ($getOurPromotion as $item) {
	$i++;

	if ($i == 1) {
		$active = "active";
	} else {
		$active = "";
	}

	$promotiontitle = strtolower(str_replace(array(" - ", " "), "-", $item->promotionTitle));
	$promotiontitle = strtolower(str_replace("%", "percen", $promotiontitle));
	$promotionMainPhoto .= "<div class='item $active'>
		<a href='" . _URL_ . "product-on-promotion/{$item->promotionId}/$promotiontitle'>
			<img src='" . _URL_ . "upload_pictures/{$item->promotionBanner}' alt='{$item->promotionTitle}' title='{$item->promotionTitle}' />
		</a>
	</div>";
}

function getHomepageProductsList($sql, $limit)
{
	$homepage = smProduct::searchProduct($sql, $limit, "");
	$htmlToReturn = "";

	foreach ($homepage as $item) {
		$productname = str_replace(" - ", " ", $item->productTitle);
		$productlink = str_replace(" ", "-", strtolower($productname)) . "_" . $item->productId . ".html";

		$checkProductOnPromotion = smPromotion::checkProductOnPromotion($item->productId);
		$promotiondetails = smPromotion::GetPromotion($checkProductOnPromotion->promotionId);

		if ($promotiondetails->promotionType == 1) {  // discount
			$promotiontype = "";

			// EDIT 30/7/14
			//$price = $item->productPrice - (($item->productPrice * $promotiondetails->promotionDiscount) / 100);
			$price = $item->productPrice;

			if ($promotiondetails->promotionDiscount == 0) {
				$showprice = "<span>Just &pound;" . number_format($price, 2) . "</span>";
			} else {
				// EDIT 30/7/14
				//$showprice = "<span><span class='strike-through'>&pound;".number_format($item->productPrice, 2)."</span>&pound;".number_format($price,2)."</span>";
				$showprice = "<span>&pound;" . number_format($price, 2) . "</span>";
			}
		} else if ($promotiondetails->promotionType == 2) {    // free item
			$promotiontype = "<i class='right'><a>Buy 1 free " . $promotiondetails->promotionGetfreeItem . "</a></i>";
			$showprice = "<span>&pound;" . number_format($item->productPrice, 2) . "</span>";
		} else {  // not on promotion
			$promotiontype = "";
			$showprice = "<span>&pound;" . number_format($item->productPrice, 2) . "</span>";
		}

		if ($item->productCategoryId == 8) {
			$forLadies = "<span style='color:#B88AB4;' class='right'>(for LADIES)</span>";
		} else {
			$forLadies = "";
		}

		$picdisplay = "";

		$farbicname = smFabric::getFabric($item->productFabricId);

		if (!empty($item->productMainPicture)) {
			$picdisplay = "<img src='" . _URL_ . "upload_pictures/{$item->productMainPicture}' alt='Buy tailor made shirts online - {$farbicname->fabricName} - {$item->productTitle}' title='Buy tailor made shirts online - {$farbicname->fabricName} - {$item->productTitle}' height='250px' width='100%'>";
		} else if (!empty($item->productFabricPicture)) {
			$picdisplay = "<img src='" . _URL_ . "upload_pictures/{$item->productFabricPicture}' alt='Buy tailor made shirts online - {$farbicname->fabricName} - {$item->productTitle}' title='Buy tailor made shirts online - {$farbicname->fabricName} - {$item->productTitle}' height='250px' width='100%'>";
		}

		//print_r($checkProductOnPromotion);

		$htmlToReturn .= "<div class='col-lg-3 col-md-6 col-sm-12 col-xs-12'>
		<div id='services-div'>
	    
		<a href='" . _URL_ . "product/$productlink'>
		    $picdisplay
		</a>
	    
	    
		    
	    <h4  class='text-center product-name'>
	    <a style='color:black;'href='" . _URL_ . "product/$productlink'>{$item->productTitle} ({$item->productRefCode})</a>
	    </h4>
	    <p id='about-us-p' class='text-center'>{$farbicname->fabricName} $promotiontype $forLadies</p>
		    
		

		
		    <p class='text-center price'>$showprice</p>
		

		
		    <center><a href='" . _URL_ . "product/$productlink'>
		    <button class='btn btn-default'>SELECT THIS ITEM</button>
		    </a></center>
		
	    </div>
	    </div>
	";
	}

	return $htmlToReturn;
}

?>
<br>
<div class="container-fluid">

	

	<!-- <div class="span9">

		<div class="tagline" style="margin:0;">
			<div>
				<h2>EXACT TAILORING PROMOTIONS</h2>

				<div id="productSlider" class="carousel slide">

					
					<div class="carousel-inner">
						<div class="item active">

							<img src="<?= _URL_; ?>upload_pictures/1583826460-promotion-clearance-sale-40-banner.jpg" alt="Clearance sale 40%" title="Clearance sale 40%">

						</div>
						
					</div>

					
					<a class="carousel-control left" href="<?= _URL_; ?>collection#productSlider" data-slide="prev">‹</a>
					<a class="carousel-control right" href="<?= _URL_; ?>collection#productSlider" data-slide="next">›</a>
				</div>
				


			</div>

		</div> -->
 

 <div id="carousel-example-generic" class="carousel slide carousel-margin" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <div class="banner" id="div-1"style="background-image: url(images/slider/img1.jpeg);"></div>
                    <div class="carousel-caption">
                        <h2 class="animate__animated animate__bounceInRight" style="animation-delay: 1s">Tailor Made luxury Shirts</h2>
                        <h3 class="animate__animated animate__bounceInLeft" style="animation-delay: 2s;margin-top:20px;color:black">Over 450 Premium Cotton Fabrics To Choose From<br>Complimentary Monogramming And Unlimited Design Options</h3><br>
                        <div class="row">
                        <div class="col-lg-6 col-md-6" style="margin-bottom:30px;">	
                        <p class="animate__animated animate__bounceInLeft text-center" style="animation-delay: 3s"><a href="#">Design Your shirts</a></p>
                        </div>
                        <div class="col-lg-6 col-md-6">
                        <p class="animate__animated animate__bounceInRight text-center" style="animation-delay: 3s"><a href="#" class="btn-responsive">Design Your shirts</a></p>
                       </div>
                       </div>
                    </div>
                </div>
                <div class="item">
                    <div class="banner" style="background-image: url(images/slider/img2.jpeg);"></div>
                    <div class="carousel-caption">
                        <h2 class="animate__animated animate__slideInDown" style="animation-delay: 1s">The World's leading online Tailor</h2>
                        <h3 class="animate__animated animate__fadeInUp" style="animation-delay: 2s;color:black;">Superior service and quality Pioneers of the Tailoring Industry </h3><br>
                        <div class="row">
                        <div class="col-lg-6 col-md-6" style="margin-bottom:30px;">	
                        <p class="animate__animated animate__bounceInLeft text-center" style="animation-delay: 3s"><a href="#">Design Your shirts</a></p>
                        </div>
                        <div class="col-lg-6 col-md-6">
                        <p class="animate__animated animate__bounceInRight text-center" style="animation-delay: 3s"><a href="#" class="btn-responsive">Design Your shirts</a></p>
                       </div>
                       </div>
                    </div>
                </div>
                <div class="item">
                    <div class="banner" style="background-image: url(images/slider/img3.jpeg);"></div>
                    <div class="carousel-caption">
                        <h2 class="animate__animated animate__zoomIn" style="animation-delay: 1s">Custom Made Shirts</h2>
                        <h3 class="animate__animated animate__fadeInLeft" style="animation-delay: 2s;color:black;">Create a new wardrobe with just a few clicks!</h3><br>
                        <div class="row">
                        <div class="col-lg-6 col-md-6" style="margin-bottom:30px;">	
                        <p class="animate__animated animate__bounceInLeft text-center" style="animation-delay: 3s"><a href="#">Design Your shirts</a></p>
                        </div>
                        <div class="col-lg-6 col-md-6">
                        <p class="animate__animated animate__bounceInRight text-center" style="animation-delay: 3s"><a href="#" class="btn-responsive">Design Your shirts</a></p>
                       </div>
                       </div>
                    </div>
                </div>

            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div><br><br>


  
     
     <div class="aftercarousel-div">
  	
  		<h1 class="text-center" id="aftercarousel-h1">customer service 24/7</h1>
  		<p class="text-center" id="aftercarousel-p">Info@exacttailor.com</p>
  		
  	</div><br><br>

  	<!-- <div class="banner-1">
		<video autoplay loop muted>
			<source src="images/slider/video1.mp4" type="video/mp4">
		</video>
		<div class="video-content">
			<h1 class="text-center content-h1">ExactTailor World</h1>
			<h3 class="content-h3">the world's leading online tailor</h3><br>
			<div class="row">
			<div class="container">
				

			<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
				<center>
					<div class="video-div">
					<h3 class="num num-2">226000</h3>
				    </div>
				   <h4 style="color:white">CUSTOMER SERVED</h4>
				</center>
			</div>
			<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6"> 
				
               <center>
               	   <div class="video-div">
               	   <h3  class="num num-2">166</h3>
                   </div>
                  <h4 style="color:white">COUNTRIES SHIPPED</h4>
               </center>
          
			</div>
			<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
				<center><div class="video-div">
					   <h3  class="num num-2">800</h3>
				      </div>
				      <h4 style="color:white">FABRICS CHOICES</h4>
			   </center>
				
			</div>
			<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
				<center><div class="video-div">
					   <h3  class="num num-2">93000</h3>
				       </div>
				      <h4 style="color:white">FACEBOOK FANS</h4>
				 </center>
			</div>
			</div>
		</div>

		</div>
		
	</div><br><br> -->
	<div class="container">
	
	<div class="row">
		<div class="col-xl-6 col-md-6 col-sm-6">
		<div>
			<img src="images/slider/slider-new-2.jpg" width="98%" >
		</div>
		</div>
		<div class="col-xl-6 col-md-6 col-sm-6">
			<div>
			<h1 id="mainpage-aboutus" class="text-center">About Us</h1>
			
			<p id="mainpage-aboutus-p">
			<!-- 	Established for over a decade, Exact Personal Tailoring Services prides itself in providing probably the best made-to-measure shirt service in the UK. Taking your personal measurements, Exact will tailor make shirts to fit you perfectly whatever your size.

Select from out collection of stunning fabrics; Crisp Egyptian Cotton and beautiful Cotton Blended materials to create your own style of shirt for casual or work, and we can even make Dress Shirts! Choose from our huge variety of colours; Plain, Stripes, Checks and Herringbone, so many you will be spoilt for choice. Finally you can choose your body fit, length of sleeves, pockets, collars, cuffs and even buttons!<br>
   We also offer a made-to-measure service for trousers from just £69.95 per pair. Available in a selection of fabrics from Cotton Corduroy, Pure Wool, Wool Mix and Lightweight Cotton -->
			<span style="text-transform:uppercase;color:blue;">EXACT PERSONAL TAILORING SERVICES Tailor Made Shirts
personalize your shirts From</span>&nbsp;&nbsp;<b>£49.00</b><br><br>

	
Established for over two decades ago, Exact Personal Tailoring Services prides itself in providing probably the best made-to-measure shirt service in the UK. Taking your personal measurements, Exact will tailor make shirts to fit you perfectly whatever your size.<br><br>

Large Selection Of Fabrics<br>
Personalize Option For Fit, Collar, Cuff, Pockets, Buttons, Monogram etc <br>
9 Simple and Easy Measurements<br>
No Extra Charge for Personal Touch<br>



Every shirt is cut to your measurements and specification.<br> <br>

UNIQUELY YOURS<br><br>

Create your personal shirt now
	
			</p>
			
           <button style="width:250px; height:42px;" class="btn btn-default" onclick="window.location='<?= _URL_; ?>collection/categories-mens-all'">
					Start Shopping
				</button>
		</div>
		</div>
	</div>


</div>
      

  

<script type="text/javascript">
                                                                                                                                                                                       
$('.num').counterUp({
    delay: 10,
    time: 1000
});


</script>

     <!-- <div class="jumbotron"> -->
  	   <div class="container">
  	   	<center>
  		<h2 id="aftercarousel-h1">TAILORED MADE CLOTHING MADE EASY</h2>
  		<p  id="aftercarousel-p">Choose your fabric and personalised design, a perfect tailored fit delivered to your door.</p>
  		<button style="width:250px; height:42px;" class="btn btn-default" onclick="window.location='<?= _URL_; ?>collection/categories-mens-all'">
					Start Shopping
				</button></center>
  		</div>
  	 <!-- </div> -->
  	 	





		<!-- <div class="welcomeboxleft">
			<!-- <img src="<?php echo _URL_; ?>images/exact-tailoring.jpg" style="width:100%;" alt="Buy tailor made shirts online" title="Buy tailor made shirts online" /><br />
			<a href="<?php echo _URL_; ?>collection/categories-mens-shirts">
				<img src="<?= _URL_; ?>images/Contrast-Lining.jpg" alt="Buy tailor made shirts online" title="Buy tailor made shirts online" style="width:100%; margin-top:10px;" />
			</a> -->



			



		<!-- 	<br />
		</div>

		<div class="welcomeboxright">
			<div class="welcomebox" style="margin-top:0;">
				<div>

					<h3>Exact Personal Tailoring Services </h3>
					<h3>Hand finished made-to-measure shirts </h3>
					<p>Any style, Any size, Any fabric</p>
					<p>Established for over a decade, Exact Personal Tailoring Services prides itself in providing probably the best made-to-measure shirt service in the UK. Taking your personal measurements, Exact will tailor make shirts to fit you perfectly whatever your size. </p>
					<p>Select from out collection of stunning fabrics; Crisp Egyptian Cotton and beautiful Cotton Blended materials to create your own style of shirt for casual or work, and we can even make Dress Shirts! Choose from our huge variety of colours; Plain, Stripes, Checks and Herringbone, so many you will be spoilt for choice. Finally you can choose your body fit, length of sleeves, pockets, collars, cuffs and even buttons!</p>

					<img src="<?= _URL_; ?>images/callordernow.jpg" alt="Buy tailor made shirts online" title="Buy tailor made shirts online" style="margin:15px 0;" />

					<h3><a href="<?= _URL_; ?>collection">Design Now! - using our unique shirt build interface start your design and create your own shirt today from just &pound;49.99</a></h3>
					<p>We also offer a made-to-measure service for trousers from just &pound;69.95 per pair. Available in a selection of fabrics from Cotton Corduroy, Pure Wool, Wool Mix and Lightweight Cotton</p>
				</div><br />

				<button style="width:139px; height:42px; margin:15px auto;" class="btn btn-primary btn-block" onclick="window.location='<?= _URL_; ?>collection/categories-mens-all'">
					Start Shopping
				</button>
			</div>
		</div><br class="clear" />


	</div>


 -->
			
		<h1 class="text-center" id="aftercarousel-h1">Men's shirts</h1>
			
			
		<div class="row">
				
		<?php echo getHomepageProductsList(" AND productCategoryId = 4 ", 4); ?>
				
		</div><br /><br />
			

			
		<h1 class="text-center" id="aftercarousel-h1">Men's trousers</h1>
			
			
		<div class="row">
				
	    <?php echo getHomepageProductsList(" AND productCategoryId = 7 ", 4); ?>
				
		</div><br /><br />
			

		
		<!-- <h1 class="text-center" id="aftercarousel-h1">Women's blouse</h1> -->
			
			

		<!-- <div class="row">
			
		   <?php //echo getHomepageProductsList(" AND productCategoryId = 8 ", 4); ?>
				
		</div> -->
			

		
	<?php include_once('includes/index-left-column.php'); ?>
</div>
<!--end row-->

<!-- <div class="row">
	<div class="span12">
		<div class="tagline" style="margin-top:10px;">
			<div class="pull-right">
				<button style="width:139px; height:42px;" class="btn btn-primary btn-block" onclick="window.location='<?= _URL_; ?>collection/categories-mens-all'">
					Start Shopping
				</button> -->
           
				<!--<a href="<?php //echo _URL_; 
								?>collection" class="btn btn-large">Start Shopping</a>-->
			<!-- </div>

			<div>
				<h2>TAILORED MADE CLOTHING MADE EASY</h2>
				Choose your fabric and personalised design, a perfect tailored fit delivered to your door.
			</div>
		</div>
	</div> -->

	<?php

	?>

	

</div>

 <?php include_once('forms/form_end.php'); ?>  