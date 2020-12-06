<?php

include_once('includes/globals.php');
include_once('includes/html_head.php');
include_once("forms/form_head.php");

$explode_url = explode("_", $__get[1]);
$explode_id = explode(".", $explode_url[1]);
//echo $b[0] . " - " . $b[1];

$productdetails = smProduct::GetIndividual($explode_id[0]);
$categoryname = smCategory::getCategory($productdetails->productCategoryId);
$fabric = smFabric::getFabric($productdetails->productFabricId);
$pattern = smPattern::getPattern($productdetails->productPatternId);
$color = smColor::getColor($productdetails->productColorId);


function checkPrevPrice($price,$fabObj){
    $prevPrice = "";
    
    if($fabObj->isShowPrevPrice==1 ){
        $percentage = $fabObj->PrevPricePercentage;
        $n = $price + (($price * $percentage)/100) ;
        $prevPrice = ' <span style="text-decoration:line-through;color:#f00;padding:0;font-size:.9em;font-style: italic;" >'. number_format($n,2) . '</span> ';
    }
    return $prevPrice;
}



if(!empty($color)){
    $stylecolor = str_replace(" ","", strtolower($color->colorTitle));
    $showcolor ="<label style='width:15px; height:13px; background:$stylecolor; float:left; margin: 4px 5px 0 0;'>&nbsp;</label> ".$color->colorTitle;
}

$designmenu = smFeature::getIndexFeatures($productdetails->productCategoryId);

//print_r($designmenu); 

//echo $productdetails->productId."--*--"; 
$checkProductOnPromotion = smPromotion::checkProductOnPromotion($explode_id[0]);

/*
if(!empty($checkProductOnPromotion)){
    echo "---";
}else{
    echo "-3-";
}
*/

//if(!empty($checkProductOnPromotion)){
    $promotiondetails = smPromotion::GetPromotion($checkProductOnPromotion->promotionId);
    if($promotiondetails->promotionType == 1){  // discount
        $promotiontype = "";
        
        // EDIT 30/7/14
        //$price = $productdetails->productPrice - (($productdetails->productPrice * $promotiondetails->promotionDiscount) / 100);
        //$showprice = "<span><span class='strike-through'>&pound;".number_format($productdetails->productPrice,2)."</span>&pound;".number_format($price,2)."</span>";
        $price = $productdetails->productPrice;
        $showprice = "<span>&pound;".number_format($price,2)."</span>";

    }else if($promotiondetails->promotionType == 2){    // free item
        
        if(!empty($designmenu)){ 
            echo "<script language='javascript' type='text/javascript'>
                    alert('Before save {$categoryname->categoryName} designer please choose {$promotiondetails->promotionGetfreeItem} item for free below.');
                </script>"; 
        }else{
            echo "<script language='javascript' type='text/javascript'>
                    alert('Please choose {$promotiondetails->promotionGetfreeItem} item for free.');
                </script>"; 
        }
        
        $promotiontype = "<i class='right'><a>Buy 1 free ".$promotiondetails->promotionGetfreeItem."</a></i>"; 
        $showprice = checkPrevPrice($productdetails->productPrice,$fabric)."<span>&pound;".number_format($productdetails->productPrice, 2)."</span>"; 
        
        $itemforfree = getFreeItem($checkProductOnPromotion->promotionId, $productdetails->productPrice); 
    
    }else{  // not on promotion 
        $promotiontype = ""; 
        $showprice = checkPrevPrice($productdetails->productPrice,$fabric)."<span>&pound;".number_format($productdetails->productPrice, 2)."</span>"; 
    }
//}

function getFreeItem($promotion, $productprice){ 
    $htmlToReturn = ""; 
    $listItem = smPromotion::GetAllIndex($promotion, 2); 
    $promotiondetails = smPromotion::GetPromotion($promotion); 
    
    // print_r($listItem);
    $htmlToReturn .= "
    <script type='text/javascript'>
    <!--

    $(document).ready(function(){

        $('#choosefreeitem input:checkbox').change(function(){
            var count1 = 0;
            $('#choosefreeitem input:checkbox').each(function(i,v){
                if($(this).is(':checked'))
                {
                        count1++;
                }
            });
            if(count1>{$promotiondetails->promotionGetfreeItem})
            {
                alert('This promotion only permits requests for a maximum of {$promotiondetails->promotionGetfreeItem} item');
                $(this).removeAttr('checked');
                return false;
            }
        });
        
    });
       
    //-->	
    </script>";

    $htmlToReturn .= "<fieldset id='choosefreeitem'>
        <legend>
            {$promotiondetails->promotionTitle}
            <span>(Please choose {$promotiondetails->promotionGetfreeItem} item)</span>
        </legend>
        <ul class='hProductItems clearfix'>";
    
    foreach($listItem as $item){
        $itemdetails = smProduct::GetIndividual($item);
        
        $freeitem = "freeitem-".$item;
        
        if($itemdetails->productPrice <= $productprice){
            
            if(!empty($itemdetails->productFabricPicture)){
                $sp = $itemdetails->productFabricPicture;
            }else{
                $sp = $itemdetails->productMainPicture;
            }
            
            $htmlToReturn .= "<li class='span14 clearfix'>
                <div class='thumbnail2'>
                    <img src='"._URL_."upload_pictures/$sp' alt='{$itemdetails->productTitle}' title='{$itemdetails->productTitle}' />
                </div>
                <div class='thumbSetting'>
                    <div class='thumbTitle'>
                        <input type='checkbox' id='$freeitem' name='$freeitem' value='1' class='left' />
                        <a class='invarseColor left'>{$itemdetails->productRefCode}</a>
                    </div>
                </div>
            </li>";
            
        }else{
            $htmlToReturn .= "";
        }

    }
    
    $htmlToReturn .= "</ul></fieldset>";
    
    return $htmlToReturn;
}

?>

<div class="row">

    <?php if(empty($designmenu)){ // no option for design ?>

    <div class="span8">
        
        <form action="<?=_URL_;?>addcart.php" method="post" enctype="multipart/form-data">
        
            <div class="product-details">
        
               <div class="titleHeader clearfix">
                   <h3>Product Details :: <?php echo $categoryname->categoryName; ?> :: REF #<?=$productdetails->productRefCode; ?></h3>
               </div>
        
               <div class="media-list clearfix">
                    <div class="media">
                        <div class="hProductItems product-img-thumb">
                            
                            <div class="span3">
                               <div class="thumbnail">
                                    <?php if(!empty($productdetails->productMainPicture)){ ?>
                                        <a href="<?=_URL_;?>upload_pictures/<?=$productdetails->productMainPicture;?>" title="" rel="prettyPhoto">
                                            <img src="<?=_URL_;?>upload_pictures/<?=$productdetails->productMainPicture;?>" alt="<?=$productdetails->productTitle;?>" title="<?=$productdetails->productTitle;?>" class="mainpicture">
                                        </a>
                                    <?php }else if(!empty($productdetails->productFabricPicture)){ ?>
                                        <a href="<?=_URL_;?>upload_pictures/<?=$productdetails->productFabricPicture;?>" title="" rel="prettyPhoto">
                                            <img src="<?=_URL_;?>upload_pictures/<?=$productdetails->productFabricPicture;?>" alt="<?=$productdetails->productTitle;?>" title="<?=$productdetails->productTitle;?>" class="mainpicture">
                                        </a>
                                    <?php } ?>
                                    
                                    <!--
                                    <a href="<?//=_URL_;?>upload_pictures/<?//=$productdetails->productMainPicture;?>" title="" rel="prettyPhoto">
                                        <img src="<?//=_URL_;?>upload_pictures/<?//=$productdetails->productMainPicture;?>" alt="<?//=$productdetails->productTitle;?>" title="<?//=$productdetails->productTitle;?>" class="mainpicture">
                                    </a>
                                    -->
                                </div>
                                
                                <div class="thumbSetting">
                                    <div class="thumbButtons">
                                        <input type="hidden" id="hiddenproductid" name="hiddenproductid" value="<?=$productdetails->productId; ?>" />
                                        <input type="hidden" id="hiddennodesign" name="hiddennodesign" value="true" />
                                        <button class="btn btn-primary btn-small btn-block">
                                            ORDER THIS PRODUCT
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="thumbSetting product-set">
                                
                                <aside class="span13">
                                    <h3><?=$productdetails->productTitle; ?></h3>
                                  
                                    <div class="product-info">
                                        <dl class="dl-horizontal">
                                            <dt>Fabric:</dt>
                                            <dd><?=$fabric->fabricName; ?> </dd>
                    
                                            <dt>Pattern:</dt>
                                            <dd><?=$pattern->patternTitle; ?> </dd>
                    
                                            <dt>Colour:</dt>
                                            <dd><?=$showcolor; ?> </dd>
                                        </dl>
                                    </div>
 
                                    <div class="thumbPrice">
                                        <span><?php echo $showprice; ?></span>
                                    </div>
                                </aside>
                            
                                <aside class="span13">
                                    <h3>Fabric Information</h3>
                  
                                    <div class="product-info">
                                        <?=$fabric->fabricShortDescriptions; ?>
                                        <?php
                                        /*
                                        if(!empty($productdetails->productMainPicture) && !empty($productdetails->productFabricPicture)){
                                            echo "<center>
                                                <a href='"._URL_."upload_pictures/{$productdetails->productFabricPicture}' title='' rel='prettyPhoto'>
                                                    <img src='"._URL_."upload_pictures/{$productdetails->productFabricPicture}' width='50%;' style='margin-bottom:5px;' alt='{$fabric->fabricName}' />
                                                </a>
                                            </center>";
                                        }
                                        */
                                        ?>
                                        <!--
                                        <dl class="dl-horizontal">
                                            <dt>Composition:</dt>
                                            <dd><?//=$productdetails->productFabricComposition; ?></dd>
                    
                                            <dt>Colour Information:</dt>
                                            <dd><?//=$productdetails->productFabricColorInfo; ?></dd>
                    
                                            <dt>Yarn:</dt>
                                            <dd><?//=$productdetails->productFabricYarn; ?></dd>
                    
                                            <dt>Weaving:</dt>
                                            <dd><?//=$productdetails->productFabricWeaving; ?></dd>
                                            
                                            <dt>Weigth (g/m²):</dt>
                                            <dd><?//=$productdetails->productFabricWeigth; ?></dd>
                                        </dl>
                                    </div>
                                    -->
                                </aside>
                                    
                            </div> <!-- n div thumbSetting product-set -->
                        
                        </div> <!-- n div hProductItems -->
                    </div> <!-- n div productdesign -->
                </div> <!-- n div media-list -->
               
            </div><!-- n div product-details -->
            
            <?php echo $itemforfree; ?>
        </form>
    </div> <!-- n div span8 -->
    
    <?php
    
    }else{  //echo "-2-";
        include_once("forms/product-shirt-form.php");
    }
    
    ?>
    
</div><!--end row-->

<?php include_once('forms/form_end.php'); ?>
