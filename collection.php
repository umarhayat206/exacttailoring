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

function checkPrevPrice($price,$fabObj){
    $prevPrice = "";
    
    if($fabObj->isShowPrevPrice==1 ){
        $percentage = $fabObj->PrevPricePercentage;
        $n = $price + (($price * $percentage)/100) ;
        $prevPrice = ' <span style="text-decoration:line-through;color:#f00;padding:0;font-size:.9em;font-style: italic;" >'. number_format($n,2) . '</span> ';
    }
    return $prevPrice;
}

if(!empty($__get[1]) && empty($__get[2])){
    //echo "-1-";

    $getcate1 = explode("-", $__get[1]);
    $maincate = smCategory::getCategoryByName($getcate1[1]);
    $categoryId = smSetting::getSearchCategoryId($getcate1[1], $__get[1], $maincate);
    
    $cate = $__get[1];
    if($getcate1[0] == "categories"){  //echo "-1-";
        $titlemaincate = smCategory::getCategory($maincate);
        $titlesubcate = smCategory::getCategory($categoryId);
        
        if($getcate1[2] != "all"){
            $sqlsearch = " AND productCategoryId = '$categoryId' ";
            $resultstitle = "<strong><a>".$titlesubcate->categoryName."</a></strong> (".$titlemaincate->categoryName.")";
        }else{ 
            $returnSubCate = searchSubCategory($maincate);
            $sqlsearch = $returnSubCate;
            $resultstitle = "<strong><a>".$titlemaincate->categoryName."</a></strong>";
        }
    }else{  
        $sqlsearch = "";
        $resultstitle = "<strong><a>All Categories</a></strong>";
    }
    
}else if(!empty($__get[2]) && empty($__get[3])){
    //echo "-2-<br/>";
    
    //$getcate1 = explode("-", $__get[1]);
    //print_r($getcate1)."<br/>";
    
    $getcate1 = explode("-", $__get[1]); // // for category
    $maincate = smCategory::getCategoryByName($getcate1[1]);
    $categoryId = smSetting::getSearchCategoryId($getcate1[1], $__get[1], $maincate);
    $titlemaincate = smCategory::getCategory($maincate);
    $titlesubcate = smCategory::getCategory($categoryId);
    
    if($getcate1[0] != "allcategories"){
    
        if($__get[1] != "all-categories"){
            if($getcate1[2] != "all"){ //echo "-2.1-"; 
                $sqlsearch = " AND productCategoryId = '$categoryId' ";
                $resultstitle = "<strong><a>".$titlesubcate->categoryName."</a></strong> (".$titlemaincate->categoryName.")";
            }else{  //echo "-2.2-";
                $returnSubCate = searchSubCategory($maincate);
                $sqlsearch = $returnSubCate;
                $resultstitle = "<strong><a>".$titlemaincate->categoryName."</a></strong>";
            }
        }
        
    }else{
        $sqlsearch = " "; // not select category
        $resultstitle = "<strong><a>All Category</a></strong>";
    }
    
    $cate = $__get[1];
    
    $getarray2 = explode("-", $__get[2]);
    //print_r($getarray2)."<br/>";
    if($getarray2[0] == "fabric"){   //echo "-2.1-";
        $fabric = "/".$__get[2];
        $fabricId = smSetting::getSearchFabricId($__get[2]);
        $sqlsearch .= " AND productFabricId = '$fabricId' ";
        $titlefabric = smFabric::getFabric($fabricId);
        $resultstitle .= " | <strong><a>".$titlefabric->fabricName."</a></strong>";
        
    }else if($getarray2[0] == "color"){  //echo "-2.2-";
        $color = "/".$__get[2];
        $colorId = smSetting::getSearchColorId($__get[2]);
        $sqlsearch .= " AND productColorId = '$colorId' ";
        $titlecolor = smColor::getColor($colorId);
        $resultstitle .= " | Color: <strong><a>".$titlecolor->colorTitle."</a></strong>";
        
    }else if($getarray2[0] == "pattern"){  //echo "-2.3-";
        $pattern = "/".$__get[2];
        $patternId = smSetting::getSearchPatternId($__get[2]);
        $sqlsearch .= " AND productPatternId = '$patternId' ";
        $titlepattern = smPattern::getPattern($patternId);
        $resultstitle .= " | Pattern: <strong><a>".$titlepattern->patternTitle."</a></strong>";
    }
    
}else if(!empty($__get[3]) && empty($__get[4])){
    //echo "-3-<br/>";
    $getcate1 = explode("-", $__get[1]); // // for category
    $maincate = smCategory::getCategoryByName($getcate1[1]);
    $categoryId = smSetting::getSearchCategoryId($getcate1[1], $__get[1], $maincate);
    $titlemaincate = smCategory::getCategory($maincate);
    $titlesubcate = smCategory::getCategory($categoryId);
    
    if($getcate1[0] != "allcategories"){
        
        if($__get[1] != "all-categories"){
            if($getcate1[2] != "all"){ //echo "-3.1-<br/>";
                $sqlsearch = " AND productCategoryId = '$categoryId' ";
                $resultstitle = "<strong><a>".$titlesubcate->categoryName."</a></strong> (".$titlemaincate->categoryName.")";
            }else{  //echo "-3.2-<br/>";
                $returnSubCate = searchSubCategory($maincate);
                $sqlsearch = $returnSubCate;
                $resultstitle = "<strong><a>".$titlemaincate->categoryName."</a></strong>";
            }
        }
    
    }else{
        $sqlsearch = " "; // not select category
        $resultstitle = "<strong><a>All Category</a></strong>";
    }
    
    $cate = $__get[1];
    
    $getarray2 = explode("-", $__get[2]);
    //print_r($getarray2)."<br/>";
    if($getarray2[0] == "fabric"){  //echo "-3.2.1-<br/>";
        $fabric = "/".$__get[2];
        $fabricId = smSetting::getSearchFabricId($__get[2]);
        $sqlsearch .= " AND productFabricId = '$fabricId' ";
        $titlefabric = smFabric::getFabric($fabricId);
        $resultstitle .= " | <strong><a>".$titlefabric->fabricName."</a></strong>";

    }else if($getarray2[0] == "color"){  //echo "-3.2.2-<br/>";
        $color = "/".$__get[2];
        $colorId = smSetting::getSearchColorId($__get[2]);
        $sqlsearch .= " AND productColorId = '$colorId' ";
        $titlecolor = smColor::getColor($colorId);
        $resultstitle .= " | Color: <strong><a>".$titlecolor->colorTitle."</a></strong>";
        
    }else if($getarray2[0] == "pattern"){  //echo "-3.2.3-<br/>";
        $pattern = "/".$__get[2];
        $patternId = smSetting::getSearchPatternId($__get[2]);
        $sqlsearch .= " AND productPatternId = '$patternId' ";
        $titlepattern = smPattern::getPattern($patternId);
        $resultstitle .= " | Pattern: <strong><a>".$titlepattern->patternTitle."</a></strong>";
    }
    
    $getarray3 = explode("-", $__get[3]);
    //print_r($getarray3)."<br/>";
    if($getarray3[0] == "color"){   //echo "-3.3.1-<br/>";
        $color = "/".$__get[3];
        $colorId = smSetting::getSearchColorId($__get[3]);
        $sqlsearch .= " AND productColorId = '$colorId' ";
        $titlecolor = smColor::getColor($colorId);
        $resultstitle .= " | Color: <strong><a>".$titlecolor->colorTitle."</a></strong>";
        
    }else if($getarray3[0] == "pattern"){    //echo "-3.3.2-<br/>";
        $pattern = "/".$__get[3];
        $patternId = smSetting::getSearchPatternId($__get[3]);
        $sqlsearch .= " AND productPatternId = '$patternId' ";
        $titlepattern = smPattern::getPattern($patternId);
        $resultstitle .= " | Pattern: <strong><a>".$titlepattern->patternTitle."</a></strong>";
    }

}else if(!empty($__get[4])){
    //echo "-4-";
    $getcate1 = explode("-", $__get[1]); // // for category
    $maincate = smCategory::getCategoryByName($getcate1[1]);
    $categoryId = smSetting::getSearchCategoryId($getcate1[1], $__get[1], $maincate);
    $titlemaincate = smCategory::getCategory($maincate);
    $titlesubcate = smCategory::getCategory($categoryId);
    
    if($getcate1[0] != "allcategories"){
        
        if($__get[1] != "all-categories"){
            if($getcate1[2] != "all"){ 
                $sqlsearch = " AND productCategoryId = '$categoryId' ";
                $resultstitle = "<strong><a>".$titlesubcate->categoryName."</a></strong> (".$titlemaincate->categoryName.")";
            }else{  
                $returnSubCate = searchSubCategory($maincate);
                $sqlsearch = $returnSubCate;
                $resultstitle = "<strong><a>".$titlemaincate->categoryName."</a></strong>";
            }
        }

    }else{
        $sqlsearch = " "; // not select category
        $resultstitle = "<strong><a>All Category</a></strong>";
    }
    
    $fabricId = smSetting::getSearchFabricId($__get[2]);
    $sqlsearch .= " AND productFabricId = '$fabricId' ";
    $titlefabric = smFabric::getFabric($fabricId);
    $resultstitle .= " | <strong><a>".$titlefabric->fabricName."</a></strong>";
        
    $colorId = smSetting::getSearchColorId($__get[3]);
    $sqlsearch .= " AND productColorId = '$colorId' ";
    $titlecolor = smColor::getColor($colorId);
    $resultstitle .= " | Color: <strong><a>".$titlecolor->colorTitle."</a></strong>";
    
    $patternId = smSetting::getSearchPatternId($__get[4]);
    $sqlsearch .= " AND productPatternId = '$patternId' ";
    $titlepattern = smPattern::getPattern($patternId);
    $resultstitle .= " | Pattern: <strong><a>".$titlepattern->patternTitle."</a></strong>";
    
    $cate = $__get[1]; 
    $fabric = "/".$__get[2]; 
    $color = "/".$__get[3]; 
    $pattern = "/".$__get[4];
    
}else{
    $cate = "all-categories"; 
}

//echo "<br/>".$cate." -*- ".$categoryId;
//echo "<br/>".$sqlsearch;

$sumsearchitems = smSetting::countProduct($sqlsearch);

$searchresults = smProduct::searchProduct($sqlsearch, 200, "");

include_once("includes/search_next_previous.php");

?>
<div class="container-fluid">
<div class="row row-offcanvas row-offcanvas-left">
  <div class="col-lg-3 col-md-3 sidebar-offcanvas" id="sidebar" role="navigation">
    <?php include_once('includes/collection-left-column.php'); ?>
  </div>
  <div class="col-lg-9 col-md-9">
    <div class="memberpanel-div">
      <p class="visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas"><i class="glyphicon glyphicon-chevron-left"></i></button>
          </p>
    <div class="row">
    
        
        <div id="hiddenstyleoptions-shirts" style="display:none;">
            <img src="<?=_URL_;?>images/stylesoption1.jpg" alt="" title="" />
        </div>
        <div id="hiddenstyleoptions-trousers" style="display:none;">
            <img src="<?=_URL_;?>images/stylesoption2.jpg" alt="" title="" />
        </div>
        
        <div style="height:60px;background-color: #fff;padding:20px;">
            <?php  //echo $searchnextpage; ?>
            <div style="float:left;color:black;"><?=$resultstitle;?></div>
            <div style="float:right;">
                <strong>Result <u><?=$sumsearchitems;?></u> Items</strong>
            </div>        
        </div><br>
        
        <?php
        if(!empty($titlesubcate->categoryDescriptions)){
            echo "<blockquote>
                {$titlesubcate->categoryDescriptions}
                <div class='quoteFrom'></div>
            </blockquote>";
        }else if(!empty($titlefabric->fabricDescriptions)){
            echo "<blockquote>
                {$titlefabric->fabricDescriptions}
                <div class='quoteFrom'></div>
            </blockquote>";
        }
        ?>

        
            <?php
                $cl=0;
                foreach($searchresults as $item){
                    $cl++;
                    $staricon ="";
                    
                    /*
                    for($rating=1;$rating<6;$rating++){
                        if($rating <= $item->productRating){
                            $staricon .= "<li><i class='star-on'></i></li>";
                        }else{
                            $staricon .= "<li><i class='star-off'></i></li>";
                        }
                    }
                    */

                    $farbicname = smFabric::getFabric($item->productFabricId);
                    


                    
                    if($item->productCategoryId==8){
                        $forLadies = "<span style='color:#B88AB4;' class='right'>(for LADIES)</span>";
                    }else{
                        $forLadies = "";
                    }
                    
                    //$productref = str_replace(" ", "-", strtolower($item->productRefCode));
                    
                    $productname = str_replace(" - ", " ", $item->productTitle);
                    $productlink = str_replace(" ", "-", strtolower($productname))."_".$item->productId.".html";

                    $checkProductOnPromotion = smPromotion::checkProductOnPromotion($item->productId);
                    //print_r($checkProductOnPromotion);
                    //if(!empty($checkProductOnPromotion)){
                        
                        $promotiondetails = smPromotion::GetPromotion($checkProductOnPromotion->promotionId);
                        // print_r($promotiondetails);
                        
                        if($promotiondetails->promotionType == 1){  // discount
                            $promotiontype = "";
                            
                            // EDIT 30/7/14
                            //$price = $item->productPrice - (($item->productPrice * $promotiondetails->promotionDiscount) / 100);
                            $price = $item->productPrice;
                            
                            if($promotiondetails->promotionDiscount == 0){
                                $showprice = checkPrevPrice($price,$farbicname)."<span>Just &pound;".number_format($price,2)."</span>";
                            }else{
                                // EDIT 30/7/14
                                //$showprice = "<span><span class='strike-through'>&pound;".number_format($item->productPrice, 2)."</span>&pound;".number_format($price,2)."</span>";
                                $showprice = checkPrevPrice($item->productPricee,$farbicname)."<span>&pound;".number_format($item->productPrice,2)."</span>";
                            }

                        }else if($promotiondetails->promotionType == 2){    // free item
                            $promotiontype = "<i class='right'><a>Buy 1 free ".$promotiondetails->promotionGetfreeItem."</a></i>";
                            $showprice = checkPrevPrice($item->productPrice,$farbicname)."<span>&pound;".number_format($item->productPrice,2)."</span>";
                        
                        }else{  // not on promotion
                            $promotiontype = "";
                            $showprice = checkPrevPrice($item->productPrice,$farbicname)."<span>&pound;".number_format($item->productPrice,2)."</span>";
                        }

                    //}
                    
                    $picdisplay = "";
                    
                    

                    if(!empty($item->productMainPicture)){
                        $picdisplay = "<img src='"._URL_."upload_pictures/{$item->productMainPicture}' alt='Buy tailor made shirts online - {$farbicname->fabricName} - {$item->productTitle}' title='Buy tailor made shirts online - {$farbicname->fabricName} - {$item->productTitle}' height='250px' width='100%' />";
                    }else if(!empty($item->productFabricPicture)){
                        $picdisplay = "<img src='"._URL_."upload_pictures/{$item->productFabricPicture}' alt='Buy tailor made shirts online - {$farbicname->fabricName} - {$item->productTitle}' title='Buy tailor made shirts online - {$farbicname->fabricName} - {$item->productTitle}'height='250px' width='100%'/>";
                    }
                    
                    //print_r($checkProductOnPromotion);
                    
                    
                    
                    //$productlink = $item->productId."-".$productref."-".$producttitle;
                    
                    if($cl % 3 == 1){
                        $clear = " style='clear:both;' ";
                    }else{
                        $clear = "";
                    }
                    
                    //<ul class='rating clearfix left'>$staricon</ul>
                    
                    echo "
        <div class='col-lg-4 col-md-4 col-sm-12 col-xs-12'$clear>
        <div id='services-div'>
        <a href='"._URL_."product/$productlink'> $picdisplay</a>
                        
                        
                                
        <h4 class='text-center product-name'>
        <a style='color:black;'href='"._URL_."product/$productlink'class='text-center product-name'>
        {$item->productTitle} ({$item->productRefCode}) </a>
        </h4>
        <p id='about-us-p' class='text-center'>{$farbicname->fabricName} $promotiontype $forLadies</p>
                            

                            
         <p class='text-center price'>$showprice</p>
                            

                            
        <center><a href='"._URL_."product/$productlink'>
                <button class='btn btn-default'>SELECT THIS ITEM</button>
                </a></center>
                            
        </div>
        </div>";
                
                }   // n foreach

            ?>
            </div>
        </div>
   </div>
</div><br><br><br><br><br>
    
    </div>
    <?php //include_once('includes/collection-left-column.php'); ?>
    </div>
</div> <!-- end row -->
</div>
<?php include_once('forms/form_end.php'); ?>