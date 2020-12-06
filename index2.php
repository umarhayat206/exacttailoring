<?php
include_once('includes/globals.php');
include_once('includes/html_head.php');
include_once("forms/form_head.php");
//include_once("includes/script.php");

?>
<div class="row">
	
	<?php
	//include_once("includes/promotion-slide.php");
	
	include_once('includes/index-left-column.php');
	?>
    
	<div class="span9">


		<div id="slideShow" class="carousel slide" style="width:440px; float:left;">
			<!-- Carousel items -->
			<div class="carousel-inner">
				<div class="item active"><img src="<?=_URL_; ?>images/front_banner.gif" alt="slide1"></div>
				
				<div class="item"><img src="<?=_URL_; ?>images/614x300-2.jpg" alt="slide1"></div>
				<!--<div class="item"><img src="<?//=_URL_; ?>images/614x300.jpg" alt="slide1"></div>
				-->
			</div><!--end carousel-inner-->
	    
			<!-- Carousel nav -->
			<a class="carousel-control left" href="#slideShow" data-slide="prev">‹</a>
			<a class="carousel-control right" href="#slideShow" data-slide="next">›</a>
		</div><!--end carousel-->

		<div class="span4" style="width:218px;">
	    
		    <ul class="thumb-banner">
			<li>
			    <div class="thumbnail">
				<a href="#"><img src="<?=_URL_; ?>images/coats-new-product-en.jpg" alt="banner"></a>
			    </div>
			</li>
			<li>
			    <div class="thumbnail">
				<a href="#"><img src="<?=_URL_; ?>images/hostens-accessoarer-en.jpg" alt="banner"></a>
			    </div>
			</li>
			<!--
			<li>
			    <div class="thumbnail">
				<a href="#"><img src="<?//=_URL_; ?>images/292x83-3.jpg" alt="banner"></a>
			    </div>
			</li>
			-->
		    </ul><!--end homeSpecial-->
	    
		</div><!--end span4-->
		<br/>
		
		<div id="featuredItems">

			
			<div class="titleHeader clearfix">
				<h3>Featured Items</h3>
				<div class="pagers">
					<div class="btn-toolbar">
						<button class="btn btn-mini" onclick="window.location='<?//=_URL_;?>collection/categories-mens-all'">View All</button>
					</div>
				</div>
			</div>
			<!--end titleHeader-->

			
			<div class="row">
				<ul class="hProductItems clearfix">
					
				<?php
				
				$homepagelistfeature = smProduct::searchProduct("", 4, "");
				foreach($homepagelistfeature as $item){
					$staricon ="";
					
					for($rating=1;$rating<6;$rating++){
						if($rating <= $item->productRating){
							$staricon .= "<li><i class='star-on'></i></li>";
						}else{
							$staricon .= "<li><i class='star-off'></i></li>";
						}
					}
					
					$productname = str_replace(" - ", " ", $item->productTitle);
					$productlink = str_replace(" ", "-", strtolower($productname))."_".$item->productId.".html";
					
					echo "<li class='span3 clearfix'>
						<div class='thumbnail'>
							<a href='"._URL_."product/$productlink'>
								<img src='"._URL_."upload_pictures/{$item->productMainPicture}' alt='{$item->productTitle}' title='{$item->productTitle}' class='mainpicture'>
							</a>
						</div>
						<div class='thumbSetting'>
							<div class='thumbTitle'>
								<h3>
								<a href='"._URL_."product/$productlink' class='invarseColor'>{$item->productTitle} ({$item->productRefCode})</a>
								</h3>
							</div>
							<ul class='rating clearfix'>$staricon</ul>
							
							<div class='thumbPrice'>
								<span>&pound; ".number_format($item->productPrice, 2)."</span>
							</div>

							<div class='thumbButtons'>
								<a href='"._URL_."product/$productlink'>
								<button class='btn btn-primary btn-small btn-block'>
									SELECT THIS ITEM
								</button>
								</a>
							</div>
						</div>
					</li>";
					
					
					//<div class='product-desc'>
					//	<p>
					//		Praesent ac condimentum felis. Nulla at nisl orci, at dignissim dolor...
					//	</p>
					//</div>

				}
				
				// <span class='label label-info'>Sales</span>
				// <span class='label label-success'>Offer</span>
				// <span><span class="strike-through">$177.00</span>$150.00</span>
				?>
					
				</ul>
			</div><!--end row-->
			
		</div><!--end featuredItems-->
	</div><!--end span12-->

</div><!--end row-->

<div class="row">
	<div class="span12">
		<div class="tagline">
			<div class="pull-right">
				<a href="<?php echo _URL_; ?>collection" class="btn btn-large">Start Shopping</a>
			</div><!--end pull-right-->

			<div>
				<h2>Shoppest is your first shop choise</h2>
				Get all fun in shoppest now, new offers and sale waiting for you.
			</div>
		</div><!--end tagline-->
	</div><!--end span12-->
</div><!--end row-->

<?php include_once('forms/form_end.php'); ?>
