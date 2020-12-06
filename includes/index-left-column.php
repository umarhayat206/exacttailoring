<?php

$countallitems = smSetting::countProduct("");



// comment start here pahla hi comment tha  


/*
function shopByCategories($cateId, $cate, $fabric, $color, $pattern){
    $htmlToReturn = "";
    $maincate = explode("-", $cate);

    if($maincate[1] =="mens" || $maincate[1] =="womens" || $maincate[1] == "accessories"){
        $mc = $maincate[1];  //echo "-/2-";
    }else{
        $mc = "mens"; //echo "-/1-".$m;
    }
    //echo "($cateId)";
    $maincateId = smCategory::getCategoryByName($mc);
    
    // echo "-*-".$maincateId."-*-";
    $catelists = smCategory::GetMenuAndPages(null, false);
    
    $k=0;

    foreach($catelists as $items){
        
        if($items->categoryId == $maincateId || $items->categoryRootId == $maincateId){
        
            if($items->categoryRootId>0){
                $catename = str_replace(" ", "-", strtolower($items->categoryName));
                $catename1 = str_replace("&", "&amp;", $items->categoryName);
                $countitem = smSetting::countProduct(" AND productCategoryId = '{$items->categoryId}' ");
                
                if($items->categoryId == $cateId){
                    $htmlToReturn .= "<li><a class='invarseColor active' href='"._URL_."collection/categories-$maincatename-$catename{$fabric}{$color}{$pattern}'><i class='icon-caret-right'></i> $catename1 ($countitem)</a></li>";
                }else{
                    $htmlToReturn .= "<li><a class='invarseColor' href='"._URL_."collection/categories-$maincatename-$catename{$fabric}{$color}{$pattern}'><i class='icon-caret-right'></i> $catename1 ($countitem)</a></li>";
                }
                
            }else{
                $k++;
                
                if($k > 1 ){ $htmlToReturn .= "</ul></li>"; }
                
                $maincatename = str_replace(" ", "-", strtolower($items->categoryName));
                $maincatename1 = str_replace("&", "&amp;", $items->categoryName);
                $subcateId = smCategory::getSubCategory($items->categoryId);
                $subsql = "";
                
                foreach($subcateId as $sub){
                    $subsql .= " productCategoryId = '{$sub->categoryId}' OR ";
                    $lastsubcategory = $items->categoryId;
                }
                $subsql .= " productCategoryId = '$lastsubcategory' ";
                
                $countitem = smSetting::countProduct(" AND ($subsql) ");
                $htmlToReturn .= "<li>
                    <a class='invarseColor' href='"._URL_."collection/categories-$maincatename-all{$fabric}{$color}{$pattern}'>$maincatename1 ($countitem)</a>
                    <ul>";
            }
            
        }
        
    }   // n foreach
    
    $htmlToReturn .= "</ul></li>";
    
    return $htmlToReturn;
}
*/


// comment end here 

function shopByColor()
{
    $htmlToReturn = "";
    $colorlists = smColor::GetMenuAndPages(null, true);

    foreach ($colorlists as $items) {
        $colorname = strtolower($items->colorTitle);
        $colorname1 = str_replace(" ", "", strtolower($items->colorTitle));
        $countitem = smSetting::countProduct(" AND productColorId = '{$items->colorId}' ");

        if ($countitem > 0) {
            $htmlToReturn .= "<li>
                <a href='" . _URL_ . "collection/allcategories/color-$colorname{$pattern}' class='invarseColor'>
                    <span class='label-color' style='width:10px; height:10px; background-color:$colorname1; display:inline-block;'></span>&nbsp;&nbsp;
                    Filter By {$items->colorTitle} colour ($countitem)
                </a>
            </li>";
        }
    }

    return $htmlToReturn;
}

function shopByFabric()
{
    $htmlToReturn = "";
    $sqlcount = "";

    $fabriclists = smFabric::GetMenuAndPages(null, true);

    foreach ($fabriclists as $items) {
        $fabricname = str_replace(" ", "-", strtolower($items->fabricName));
        $fabricname1 = str_replace("&", "&amp;", $items->fabricName);
        $countitem = smSetting::countProduct(" AND productFabricId = '{$items->fabricId}' ");
        $countitem1 = smSetting::countProduct(" AND productFabricId = '{$items->fabricId}'  ");

        if ($countitem > 0) {
            $htmlToReturn .= "<li>
                <a href='" . _URL_ . "collection/allcategories/fabric-$fabricname{$color}{$pattern}' class='invarseColor'>
                    $fabricname1 ($countitem)
                </a>
            </li>";
        }
    }

    return $htmlToReturn;
}

function shopByPattern()
{
    $htmlToReturn = "";
    $patternlists = smPattern::GetMenuAndPages(null, true);

    foreach ($patternlists as $items) {
        $patternname = str_replace(" ", "-", strtolower($items->patternTitle));
        $patternname1 = str_replace("&", "&amp;", $items->patternTitle);
        $countitem = smSetting::countProduct(" AND productPatternId = '{$items->patternId}' ");

        if ($countitem > 0) {
            $htmlToReturn .= "<li>
                <a href='" . _URL_ . "collection/allcategories/pattern-$patternname' class='invarseColor'>
                    $patternname1 ($countitem)
                </a>
            </li>";
        }
    }

    return $htmlToReturn;
}

?>




      <!--comment start here pahla hi comment tha  -->
    <!--
    <div class="product-colors">
        <div class="titleHeader clearfix">
            <h3>Shop By Fabric</h3>
        </div>

        <ul class="unstyled pro-filter-color">
            <?php  ?>
        </ul>
    </div>
    
    <div class="product-colors">
        <div class="titleHeader clearfix">
            <h3>Shop By Pattern</h3>
        </div>

        <ul class="unstyled pro-filter-color">
            <?php  ?>
        </ul>
    </div>

    <div class="product-colors">
        <div class="titleHeader clearfix">
            <h3>Shop By Colours</h3>
        </div> 

        <ul class="unstyled pro-filter-color">
            <?php  ?>
        </ul>
    </div>
    -->

    <!-- comment end here -->

    <!-- <div class="product-colors"> -->
        <?php //if (empty($_SESSION['chkmemberuser'])) { ?>

            <!-- <div style="background: url('images/bg-regis.jpg') repeat-x;">
                <br /><button style="width:138px; margin: 0 auto;" class="btn btn-primary btn-block" onclick="window.location='<?= _URL_; ?>regisform'">
                    Register Now
                </button>
                <br />

                <div style="margin: 10px auto; width: 80%;">
                    <form id="quicklogin" name="quicklogin" method="POST" action="<?= _URL_; ?>takelogin.php" enctype="multipart/form-data">
                        <input type="text" id="emaillogin1" name="emaillogin" value="" class="required" placeholder="username/email" /><br />
                        <input type="password" id="passwordlogin1" name="passwordlogin" value="" class="required" placeholder="password" />
                        <input type="hidden" id="quickloginformsubmit1" name="quickloginformsubmit" value="true" />

                        <button style="width:138px; margin: 0 auto;" class="btn btn-primary btn-block" onclick="window.location='<?= _URL_; ?>regisform'">Login</button><br />
                    </form>
                </div>
            </div> -->

        <?php //} else { ?>

            <!-- <div class="titleHeader clearfix">
                <h3>START SHOPPING</h3>
            </div> -->

        <?php //} ?>

        <!-- <img src="<?= _URL_ ?>styles/all-major-cards-accepted.jpg" alt="All major cards accepted" /> -->
        <!-- <ul class="unstyled pro-filter-color">
            <li><a href="<?= _URL_; ?>content/how-to-order" class="invarseColor">How to Order</a></li> -->

            <!-- comment start here pahla hi comment tha -->

            <!-- <li><a href="<?= _URL_; ?>collection" class="invarseColor">Start Shopping</a></li> -->
            <!-- <li><a href="<?= _URL_; ?>order-catalogue" class="invarseColor">Order Catalogue</a></li> -->
           
            <!--<li><a href="<? ?>measurements" class="invarseColor loginclick">Measurements</a></li>-->
            
            <!--<li><a href="<? ?>my-account" class="invarseColor">Measurements</a></li>-->
            

            <!-- <li><a href="<?= _URL_; ?>images/order-form.pdf" class="invarseColor" target="_blank">Download an Order Form</a></li> -->

           <!-- commment end here -->


            <!-- <li><a href="<?= _URL_; ?>promotion" class="invarseColor">Promotions</a></li>
            <li><a href="<?= _URL_; ?>customer-comments" class="invarseColor">Customer Comments</a></li>
            <li><a href="<?= _URL_; ?>content/guarantee" class="invarseColor">Guarantee</a></li>
            <li><a href="<?= _URL_; ?>contact" class="invarseColor">Contact Us</a></li>
           
        </ul>
 -->
        <!-- <a href="<?= _URL_; ?>order-catalogue">
            
            <img src="<?= _URL_; ?>images/main_open_catalog.jpg" alt="Order Catalogue" title="Order Catalogue" style="margin:10px 0; clear:both; " /><br />
        </a> -->




<section class="testimonials">
<div class="container">
<h1>Customers Testimonials</h1>
<p class="text-center">Subscribe Easy Tutorials Chanel To watch More Videos</p>
        
  <div class="row">      
           
        
<?php
$comment3 = smComment::GetAllComment(false);
$co = 0;
foreach ($comment3 as $items) 
{
$co++;
if ($co <4) 
{?>
    
    <div class="col-md-4 text-center div-of-row">
    <div class="profile">
    <blockquote><?php echo stripcslashes($items->commentDescriptions);?></blockquote> 

    <h3><?php echo $items->commentName;?></h3>
    </div>
    </div>

<?php
}
}

?>
    
 
            
    </div>
</div>
    

  </section>    
    



