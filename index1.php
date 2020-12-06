<?php

include_once('includes/globals.php');
include_once('includes/html_head.php');
include_once("forms/form_head.php");
//include_once("includes/script.php");

function searchSubCategory($c){
    $htmlToReturn = "";
    $sub = smCategory::getSubCategory($c);
    $htmlToReturn .= " AND (";
    
    foreach($sub as $item){
        $htmlToReturn .= " productCategoryId = '{$item->categoryId}' OR ";
        $lastsubid = $item->categoryId;
    }
    
    $htmlToReturn .= " productCategoryId = '$lastsubid')";
    
    return $htmlToReturn;
}

$returnSubCate = searchSubCategory(1); // Mens
$sqlsearch = $returnSubCate;

//echo "<br/>".$sqlsearch;

//$sumsearchitems = smSetting::countProduct($sqlsearch);
$searchresults = smProduct::searchProduct($sqlsearch, 9, "");

include_once("includes/search_next_previous.php");

$getOurPromotion = smPromotion::GetAllPromotion(false); // status = Live

$i=0;
$promotionMainPhoto="";
foreach($getOurPromotion as $item){
    $i++;
    
    if($i == 1){
        $active="active";
    }else{
        $active="";
    }
    
    $promotiontitle = strtolower(str_replace(array(" - ", " "),"-", $item->promotionTitle));
    $promotiontitle = strtolower(str_replace("%","percen", $promotiontitle));
    $promotionMainPhoto .= "<div class='item $active'>
		<a href='"._URL_."product-on-promotion/{$item->promotionId}/$promotiontitle'>
			<img src='"._URL_."upload_pictures/{$item->promotionBanner}' alt='{$item->promotionTitle}' title='{$item->promotionTitle}' />
		</a>
	</div>";
    
}

?>
<div class="row">

    <?php include_once('includes/index-left-column.php'); ?>
    
    <div class="span9">
    
        <div id="productSlider" class="carousel slide">
                <!-- Carousel items -->
            <div class="carousel-inner">
		<!--
		<div class="item"><img src="<?//=_URL_; ?>images/694x246.jpg" alt=""></div>
		<div class="item active"><img src="<?//=_URL_; ?>images/694x246.jpg" alt=""></div>
		<div class="item"><img src="<?//=_URL_; ?>images/694x246.jpg" alt=""></div>
		-->
		<?php echo $promotionMainPhoto; ?>
            </div>
    
            <!-- Carousel nav -->
            <a class="carousel-control left" href="<?=_URL_; ?>collection#productSlider" data-slide="prev">‹</a>
            <a class="carousel-control right" href="<?=_URL_; ?>collection#productSlider" data-slide="next">›</a>
        </div><!--end productSlider-->

        <div class="row">
            <ul class="hProductItems clearfix">
            <?php
                foreach($searchresults as $item){
                    $staricon ="";
                    
                    for($rating=1;$rating<6;$rating++){
                        if($rating <= $item->productRating){
                            $staricon .= "<li><i class='star-on'></i></li>";
                        }else{
                            $staricon .= "<li><i class='star-off'></i></li>";
                        }
                    }
                    
                    //$productref = str_replace(" ", "-", strtolower($item->productRefCode));
                    
                    $productname = str_replace(" - ", " ", $item->productTitle);
                    $productlink = str_replace(" ", "-", strtolower($productname))."_".$item->productId.".html";

                    $checkProductOnPromotion = smPromotion::checkProductOnPromotion($item->productId);
                    //print_r($checkProductOnPromotion);

                        $promotiondetails = smPromotion::GetPromotion($checkProductOnPromotion->promotionId);
                        // print_r($promotiondetails);
                        
                        if($promotiondetails->promotionType == 1){  // discount
                            $promotiontype = "";
                            $price = $item->productPrice - (($item->productPrice * $promotiondetails->promotionDiscount) / 100);
                            $showprice = "<span><span class='strike-through'>&pound;".number_format($item->productPrice,2)."</span>&pound;".number_format($price,2)."</span>";

                        }else if($promotiondetails->promotionType == 2){    // free item
                            $promotiontype = "<i class='right'><a>Buy 1 free ".$promotiondetails->promotionGetfreeItem."</a></i>";
                            $showprice = "<span>&pound;".number_format($item->productPrice,2)."</span>";
                        
                        }else{  // not on promotion
                            $promotiontype = "";
                            $showprice = "<span>&pound;".number_format($item->productPrice,2)."</span>";
                        }

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
                            <ul class='rating clearfix left'>$staricon</ul>
                            $promotiontype
                            
                            <br/>
                            <div class='thumbPrice'>
                                <span>$showprice</span>
                            </div>

                            <div class='thumbButtons'>
                                <a href='"._URL_."product/$productlink'>
                                <button class='btn btn-primary btn-small btn-block'>SELECT THIS ITEM</button>
                                </a>
                            </div>
                        </div>
                    </li>";

                }   // n foreach

            ?>
            </ul>

        </div> <!-- end row -->
    </div> <!-- end span9 -->
    
    
</div> <!-- end row -->

<?php include_once('forms/form_end.php'); ?>