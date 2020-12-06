<?php

include_once('includes/globals.php');
include_once('includes/html_head.php');
include_once("forms/form_head.php");

/*
if(empty($_SESSION['chkmemberuser'])){ // member not login 
    echo "<script language='javascript' type='text/javascript'>
            alert('You are not login. Please login to your account.');
            history.go(-1);
        </script>";

}else{
    
}
*/

$htmlToReturn = "<ul class='hProductItems clearfix'>";

// get mens & womens category
$getCategory = "SELECT * FROM ex_category WHERE categoryRootId ='1' OR categoryRootId = '2' ORDER BY categoryId ";
$queryGetCategory = mysql_query($getCategory);

while($rowGetCategory=mysql_fetch_array($queryGetCategory)){
//echo $rowGetCategory['categoryId']." - ".$rowGetCategory['categoryName']."---<br/>";

    // AND shopCompleted = '4'
    $getCart = "SELECT * FROM ex_shoppingcart WHERE shopUserId = '{$_SESSION['chkmemberuser']}'  AND shopConfirmOrder = '1' ";
    $queGetCart = mysql_query($getCart);
    
    while($rowGetCart=mysql_fetch_array($queGetCart)){
        
        $getProductItem = "SELECT * FROM ex_shoppingcart_items WHERE shopId = '{$rowGetCart['shopId']}' ORDER BY productId DESC";
        $queGetProductItem = mysql_query($getProductItem);
        
        while($rowGetProductItem=mysql_fetch_array($queGetProductItem)){
 
            $getProduct = "SELECT * FROM ex_product_details WHERE productId = '{$rowGetProductItem['productId']}' AND productCategoryId = '{$rowGetCategory['categoryId']}' ";
            $queryGetProduct = mysql_query($getProduct);
            
            while($rowProduct=mysql_fetch_array($queryGetProduct)){
                //echo $rowProduct['productId']." - ".$rowProduct['productTitle']."---<br/>";

                // Product Details
                $item = smProduct::GetIndividual($rowProduct['productId']);
                
                //if($rowGetCart['shopId']==$rowGetProductItem['shopId'] && $rowGetProductItem['productId'] == $rowProduct['productId']){
                    
                    //echo $rowGetProductItem['itemId']." - ".$rowProduct['productId']."<br/>";
                    
                    // SELECT * FROM ex_shoppingcart_items WHERE itemId = '{$rowGetProductItem['itemId']'}
                    // SELECT * FROM ex_item_details_index WHERE itemId = '{$rowGetProductItem['itemId']'}
                    
                //}

                //$productref = str_replace(" ", "-", strtolower($item->productRefCode));
                
                $productname = str_replace(" - ", " ", $item->productTitle);
                $productlink = str_replace(" ", "-", strtolower($productname))."_".$item->productId.".html";

                $checkProductOnPromotion = smPromotion::checkProductOnPromotion($item->productId);
                //print_r($checkProductOnPromotion);
                //if(!empty($checkProductOnPromotion)){
                    
                    $promotiondetails = smPromotion::GetPromotion($checkProductOnPromotion->promotionId);
                    // print_r($promotiondetails);
                    
                    if($promotiondetails->promotionType == 1){  // discount
                        //$promotiontype = "";
                        // EDIT 30/7/14
                        //$price = $item->productPrice - (($item->productPrice * $promotiondetails->promotionDiscount) / 100);
                        //$showprice = "<span><span class='strike-through'>&pound;".number_format($item->productPrice,2)."</span>&pound;".number_format($price,2)."</span>";
                        $price = $item->productPrice;
                        $showprice = "<span>&pound;".number_format($price,2)."</span>";

                    }else if($promotiondetails->promotionType == 2){    // free item
                        //$promotiontype = "<i class='right'><a>Buy 1 free ".$promotiondetails->promotionGetfreeItem."</a></i>";
                        $showprice = "<span>&pound;".number_format($item->productPrice,2)."</span>";
                    
                    }else{  // not on promotion
                        //$promotiontype = "";
                        $showprice = "<span>&pound;".number_format($item->productPrice,2)."</span>";
                    }
                    
                    if(!empty($productdetails->productMainPicture)){ 
                        $showPic = $item->productMainPicture;
                        
                    }else if(!empty($item->productFabricPicture)){
                        $showPic = $item->productFabricPicture;
                    }
                    
                    $htmlToReturn .="<div class='col-lg-4 col-md-4 col-sm-12 col-xs-12'>
                      <div id='services-div'>
                        
                            <a href='"._URL_."view-design/{$rowGetProductItem['itemId']}-{$rowProduct['productId']}' target='_blank'>
                                <img src='"._URL_."upload_pictures/$showPic' alt='{$item->productTitle}' title='{$item->productTitle}' height='250px' width='100%'>
                            </a>
                        
                        
                            
                        <h4 class='text-center product-name'>
                    <a href='"._URL_."view-design/{$rowGetProductItem['itemId']}-{$rowProduct['productId']}' target='_blank'style='color:black'>{$item->productTitle} ({$item->productRefCode})</a>
                        </h4>
                            
                            
                            
                                <p class='text-center price'>$showprice</p>
                            

                            
                                <a href='"._URL_."view-design/{$rowGetProductItem['itemId']}-{$rowProduct['productId']}' target='_blank'>
                                    <button class='btn btn-default'>VIEW DESIGN</button>
                                </a>
                                
                            
                        
                        </div>
                    </div>";
                    /*
                    <a href='"._URL_."product/$productlink'>
                        <button class='btn btn-primary btn-small btn-block'>ORDER THIS ITEM</button>
                    </a>
                    */
                
            } // n $getProduct
            
        } // n $getProductItem

    } // n $rowGetCart
    
} // n $getCategory

// $htmlToReturn .="</ul>";

?>
<div class="container-fluid">
<div class="row row-offcanvas row-offcanvas-left">
    <div class="col-lg-3 col-md-3 sidebar-offcanvas" id="sidebar" role="navigation">
        
        
        
            <h3 id="contactus-h1" class="text-center" style="margin-top:-25px;">Account</h3>
        
        
        <ul class="nav nav-sidebar" >
            <li><a class="invarseColor" href="<?=_URL_;?>memberlogout"><i class="icon-caret-right"></i> Logout</a></li>
            <li><a class="invarseColor" href="<?=_URL_; ?>my-account"><i class="icon-caret-right"></i> My Account</a></li>
            <li><a class="invarseColor" href="<?=_URL_; ?>customer-comments"><i class="icon-caret-right"></i> Leave Comment</a></li>
            <li><a class="invarseColor" href="<?=_URL_; ?>newsletter"><i class="icon-caret-right"></i> Newsletter</a></li>
        </ul>
    

    </div>
    <div class="col-lg-9 col-md-9">
        <div class="memberpanel-div">
            <p class="visible-xs">
            <button type="button" class="btn btn-primary btn-lg" data-toggle="offcanvas"><i class="glyphicon glyphicon-chevron-left"></i></button>
          </p>
        
            
                <h3 id="contactus-h1" class="text-center">My Designs</h3>
            
            
            <div class="row"><?php echo $htmlToReturn; ?></div>
        </div>
    </div>
    
    
    

</div>
</div>

<?php include_once('forms/form_end.php'); ?>

