<?php

include_once('includes/globals.php');
include_once('includes/html_head.php');
include_once("forms/form_head.php");

$getCurrentPromotion = smPromotion::GetPromotion($__get[1]); // status = Live

$promotionMainPhoto = "<img src='"._URL_."upload_pictures/{$getCurrentPromotion->promotionBanner}' alt='{$getCurrentPromotion->promotionTitle}' title='{$getCurrentPromotion->promotionTitle}' />";
    
$getProductOnPromotion = smPromotion::GetAllIndex($__get[1], 1);

$showproduct = "<ul class='hProductItems clearfix'>";

$i=0;
foreach($getProductOnPromotion as $item){
    $i++;
    
    $product = smProduct::GetIndividual($item);
    $staricon ="";
    
    /*
    for($rating=1;$rating<6;$rating++){
        if($rating <= $product->productRating){
            $staricon .= "<li><i class='star-on'></i></li>";
        }else{
            $staricon .= "<li><i class='star-off'></i></li>";
        }
    }
    */

    $productname = str_replace(" - ", " ", $product->productTitle);
    $productlink = str_replace(" ", "-", strtolower($productname))."_".$product->productId.".html";

    //$checkProductOnPromotion->promotionId
    $promotiondetails = smPromotion::GetPromotion($__get[1]);
    $checkProductOnPromotion = smPromotion::GetAllIndex($__get[1], $promotiondetails->promotionType);
    
    if($promotiondetails->promotionType == 1){  // discount
        $promotiontype = "";
        
        // EDIT 30/7/14
        //$price = $product->productPrice - (($product->productPrice * $promotiondetails->promotionDiscount) / 100);
        $price = $product->productPrice;
        
        if($promotiondetails->promotionDiscount == 0){
            $showprice = "<span>Just &pound;".number_format($price,2)."</span>";
        }else{
            // EDIT 30/7/14
            //$showprice = "<span><span class='strike-through'>&pound;".number_format($product->productPrice, 2)."</span>&pound;".number_format($price,2)."</span>";
            $showprice = "<span>&pound;".number_format($price,2)."</span>";
        }

    }else if($promotiondetails->promotionType == 2){    // free item
        $promotiontype = "<i class='right'><a>Buy 1 free ".$promotiondetails->promotionGetfreeItem."</a></i>";
        $showprice = "<span>&pound;".number_format($product->productPrice, 2)."</span>";
    
    }else{  // not on promotion
        $promotiontype = "";
        $showprice = "<span>&pound;".number_format($product->productPrice, 2)."</span>";
    }
    
    $farbicname = smFabric::getFabric($product->productFabricId);
    
    if($i % 3 == 1){
        $clear = " style='clear:both;' ";
    }else{
        $clear = "";
    }
    
    $picdisplay = "";

    if(!empty($product->productMainPicture)){
        $picdisplay = "<img src='"._URL_."upload_pictures/{$product->productMainPicture}' alt='{$product->productTitle}' title='{$product->productTitle}' class='mainpicture' height='250px' width='100%'>";
    }else if(!empty($product->productFabricPicture)){
        $picdisplay = "<img src='"._URL_."upload_pictures/{$product->productFabricPicture}' alt='{$product->productTitle}' title='{$product->productTitle}' class='mainpicture' height='250px' width='100%'>";
    }
    
    // <ul class='rating clearfix left'>$staricon</ul>
    
    $showproduct .= "<div class='col-lg-4 col-md-4 col-sm-12 col-xs-12'$clear>
        <div id='services-div'>
            <a href='"._URL_."product/$productlink'>
                $picdisplay
            </a>
        
        
            
                <h4 class='text-center product-name'>
                
                    <a style='color:black;'href='"._URL_."product/$productlink' class='invarseColor'>
                        {$product->productTitle} ({$product->productRefCode})
                    </a>
                </h4>
            <p id='about-us-p' class='text-center'>{$farbicname->fabricName} $promotiontype</p> 

            
                <p class='text-center price'>$showprice</p>
            

            
                <a href='"._URL_."product/$productlink'>
                <button class='btn btn-default'>SELECT THIS ITEM</button>
                </a>
           
        </div>
    </div>";
    
}

$showproduct .= "</ul>";

?>
<div class="container-fluid">
<div class="row row-offcanvas row-offcanvas-left">
     <div class="col-lg-3 col-md-3 sidebar-offcanvas" id="sidebar" role="navigation">
    <?php include_once('includes/collection-left-column.php'); ?>
    </div>
    <div class="col-lg-9 col-md-9">
    <div class="memberpanel-div">
      <p class="visible-xs">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="offcanvas"><i class="glyphicon glyphicon-chevron-left"></i></button>
          </p>
        
        <div style="height:60px;background-color: #fff;padding:20px;">
            <div style="float:left;"><a style="color:black;"><?=$getCurrentPromotion->promotionTitle; ?></a></div>
            <div style="float:right;">
                <strong class="right">Result <u><a><?=$i; ?></a></u> Items</strong>
            </div>        
        </div><br><br>
        
        <div class="row"><?=$showproduct; ?></div>
    </div>

    
</div> 
</div>
</div>

<?php include_once('forms/form_end.php'); ?>

