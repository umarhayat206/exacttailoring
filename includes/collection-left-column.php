<?php

$countallitems = smSetting::countProduct("");

function shopByCategories($cateId, $cate, $fabric, $color, $pattern)
{
    $htmlToReturn = "";
    $maincate = explode("-", $cate);

    if ($maincate[1] == "mens" || $maincate[1] == "womens" || $maincate[1] == "accessories") {
        $mc = $maincate[1];  //echo "-/2-";
    } else {
        $mc = "mens"; //echo "-/1-".$m;
    }
    //echo "($cateId)";
    $maincateId = smCategory::getCategoryByName($mc);
    // echo "-*-".$maincateId."-*-";
    $catelists = smCategory::GetMenuAndPages(null, false);

    $k = 0;

    foreach ($catelists as $items) {

        if ($items->categoryId == $maincateId || $items->categoryRootId == $maincateId) {

            if ($items->categoryRootId > 0) {
                $catename = str_replace(" ", "-", strtolower($items->categoryName));
                $catename1 = str_replace("&", "&amp;", $items->categoryName);
                $countitem = smSetting::countProduct(" AND productCategoryId = '{$items->categoryId}' ");

                /*
                if($items->categoryId == $cateId){
                    $htmlToReturn .= "<li><a class='invarseColor active' href='"._URL_."collection/categories-$maincatename-$catename{$fabric}{$color}{$pattern}'><i class='icon-caret-right'></i> $catename1 ($countitem)</a></li>";
                }else{
                    $htmlToReturn .= "<li><a class='invarseColor' href='"._URL_."collection/categories-$maincatename-$catename{$fabric}{$color}{$pattern}'><i class='icon-caret-right'></i> $catename1 ($countitem)</a></li>";
                }
                */

                if ($items->categoryId == $cateId) {
                    $subcate = "<i class='icon-caret-right'></i> " . strtoupper($catename1) . " ($countitem)";
                    $catename2 = $catename1;
                }
            } else {
                //$k++;

                //if($k > 1 ){ $htmlToReturn .= "</ul></li>"; }

                $maincatename = str_replace(" ", "-", strtolower($items->categoryName));
                $maincatename1 = str_replace("&", "&amp;", $items->categoryName);

                /*
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
                */

                $maincate = $maincatename1;
            }
        }
    }   // n foreach

    //$htmlToReturn .= "</ul></li>";

    if ($maincate == "Mens" || $maincate == "Womens") {
        if ($catename2 == "Suits" || $catename2 == "Shirts" || $catename2 == "Dress Shirts" || $catename2 == "Blouse") {
            $styleoption = "<br/><br><a style='color:black' href='javascript:void(0)' class='shirtsoption'><i class='icon-caret-right'></i>View Style Options</a>";
        } else if ($catename2 == "Trousers") {
            $styleoption = "<br><br/><a style='color:black'href='javascript:void(0)' class='trousersoption'><i class='icon-caret-right'></i>View Style Options</a>";
        }
    }

    $htmlToReturn = "<a class='invarseColor'>" . strtoupper($maincate) . "&nbsp; $subcate</a>" . $styleoption;

    return $htmlToReturn;
}

function shopByColor($colorId, $cate, $fabric, $color, $pattern, $cateId)
{
    $htmlToReturn = "";
    $colorlists = smColor::GetMenuAndPages(null, true);

    foreach ($colorlists as $items) {
        if (!empty($cateId)) {
            $sqlcount = " AND productCategoryId = '$cateId' ";
        } else {
            $sqlcount = smCategory::exportsqlcount($cate);
        }

        $colorname = strtolower($items->colorTitle);
        $colorname1 = str_replace(" ", "", strtolower($items->colorTitle));
        $countitem = smSetting::countProduct(" AND productColorId = '{$items->colorId}' $sqlcount");

        if ($countitem > 0) {
            if ($items->colorId == $colorId) {
                $htmlToReturn .= "<li>
                    <a href='" . _URL_ . "collection/{$cate}{$fabric}/color-$colorname{$pattern}' class='invarseColor active'><i class='icon-caret-right'></i>
                        <span class='label-color' style='width:10px; height:10px; background-color:$colorname1; display:inline-block;'></span>&nbsp;&nbsp;
                        Filter By {$items->colorTitle} colour ($countitem)
                    </a>
                </li>";
            } else {
                $htmlToReturn .= "<li>
                    <a href='" . _URL_ . "collection/{$cate}{$fabric}/color-$colorname{$pattern}' class='invarseColor'><i class='icon-caret-right'></i>
                        <span class='label-color' style='width:10px; height:10px; background-color:$colorname1; display:inline-block;'></span>&nbsp;&nbsp;
                        Filter By {$items->colorTitle} colour ($countitem)
                    </a>
                </li>";
            }
        }
    }

    return $htmlToReturn;
}

function shopByFabric($fabricId, $cate, $fabric, $color, $pattern, $cateId)
{
    $htmlToReturn = "";
    $sqlcount = "";

    if (!empty($cateId)) {
        $sqlcount = " AND productCategoryId = '$cateId' ";
    } else {
        $sqlcount = smCategory::exportsqlcount($cate);
    }
    //echo $sqlcount;

    $fabriclists = smFabric::GetMenuAndPages(null, true);

    foreach ($fabriclists as $items) {
        $fabricname = str_replace(" ", "-", strtolower($items->fabricName));
        $fabricname1 = str_replace("&", "&amp;", $items->fabricName);
        $countitem = smSetting::countProduct(" AND productFabricId = '{$items->fabricId}' $sqlcount");
        $countitem1 = smSetting::countProduct(" AND productFabricId = '{$items->fabricId}' $sqlcount ");

        if ($countitem > 0) {
            if ($items->fabricId == $fabricId) {
                $htmlToReturn .= "<li>
                    <a href='" . _URL_ . "collection/{$cate}/fabric-$fabricname{$color}{$pattern}' class='invarseColor active'>
                    <i class='icon-caret-right'></i>
                        $fabricname1 ($countitem)
                    </a>
                </li>";
            } else {
                $htmlToReturn .= "<li>
                    <a href='" . _URL_ . "collection/{$cate}/fabric-$fabricname{$color}{$pattern}' class='invarseColor'>
                    <i class='icon-caret-right'></i>
                        $fabricname1 ($countitem)
                    </a>
                </li>";
            }
        }
    }

    return $htmlToReturn;
}

function shopByPattern($patternId, $cate, $fabric, $color, $pattern, $cateId)
{
    $htmlToReturn = "";
    $patternlists = smPattern::GetMenuAndPages(null, true);

    if (!empty($cateId)) {
        $sqlcount = " AND productCategoryId = '$cateId' ";
    } else {
        $sqlcount = smCategory::exportsqlcount($cate);
    }

    foreach ($patternlists as $items) {
        $patternname = str_replace(" ", "-", strtolower($items->patternTitle));
        $patternname1 = str_replace("&", "&amp;", $items->patternTitle);
        $countitem = smSetting::countProduct(" AND productPatternId = '{$items->patternId}' $sqlcount");

        if ($countitem > 0) {
            if ($items->patternId == $patternId) {

                $htmlToReturn .= "<li>
                    <a href='" . _URL_ . "collection/{$cate}{$fabric}{$color}/pattern-$patternname' class='invarseColor active'><i class='icon-caret-right'></i>
                        $patternname1 ($countitem)
                    </a>
                </li>";
            } else {
                $htmlToReturn .= "<li>
                    <a href='" . _URL_ . "collection/{$cate}{$fabric}{$color}/pattern-$patternname' class='invarseColor'><i class='icon-caret-right'></i>
                        $patternname1 ($countitem)
                    </a>
                </li>";
            }
        }
    }

    return $htmlToReturn;
}

?>

<aside class="span3">

    <div class="categories">
       <!--  <div class="titleHeader clearfix"> -->
            <h3 id="contactus-h1">Categories</h3>
        <!-- </div> -->
        <ul class="nav nav-sidebar" style="margin-left:20px;">
            <?php echo shopByCategories($categoryId, $cate, $fabric, $color, $pattern); ?>
        </ul>
    </div>
<?php /*
    <div class="product-colors">
        <div class="titleHeader clearfix">
            <h3>Shop By Item</h3>
        </div>

        <ul class="unstyled pro-filter-color">
            <li>
                <a href="<?= _URL_; ?>collection/categories-mens-shirts" class='invarseColor'>Formal Shirts</a>
            </li>
            <li>
                <a href="<?= _URL_; ?>collection/categories-mens-dress-shirts" class='invarseColor'>Dress Shirts</a>
            </li>
            <li>
                <a href="<?= _URL_; ?>collection/categories-mens-trousers" class='invarseColor'>Trousers</a>
            </li>
            <!--<li>
                <a href="<? //=_URL_; 
                            ?>collection/categories-accessories-ties" class='invarseColor'>Ties</a>
            </li>-->
            <li>
                <a href="<?= _URL_; ?>collection/categories-womens-blouse" class='invarseColor'>Blouse</a>
            </li>
            <!--<li>
                <a href="<? //=_URL_; 
                            ?>collection/executive" class='invarseColor'>Executive Selection</a>
            </li>-->
            <li>
                <a href="<?= _URL_; ?>collection/categories-mens-jackets" class='invarseColor'>Jackets</a>
            </li>
            <li>
                <a href="<?= _URL_; ?>collection/categories-mens-pyjamas" class='invarseColor'>Pyjamas</a>
            </li>
            <li>
                <a href="<?= _URL_; ?>collection/categories-mens-boxers" class='invarseColor'>Boxer shorts</a>
            </li>

        </ul>
    </div>
*/ ?>
    <div class="product-colors">
        
            <h3 id="contactus-h1">Shop By Fabric</h3>
        

        <ul class="nav nav-sidebar">
            <li>
                <a href="<?= _URL_; ?>collection/<?= $cate . $color . $pattern; ?>" class='invarseColor'><i class="icon-caret-right"></i>
                    All Fabric
                    <!--(<? //=$countallitems;
                            ?>)-->
                </a>
            </li>
            <?php echo shopByFabric($fabricId, $cate, $fabric, $color, $pattern, $categoryId); ?>
        </ul>
    </div>

    <div class="product-colors">
       
            <h3 id="contactus-h1">Shop By Pattern</h3>
        

        <ul class="nav nav-sidebar">
            <li>
                <a href="<?= _URL_; ?>collection/<?= $cate . $fabric . $color; ?>" class='invarseColor'><i class="icon-caret-right"></i>
                    All Pattern
                    <!--(<? //=$countallitems;
                            ?>)-->
                </a>
            </li>
            <?php echo shopByPattern($patternId, $cate, $fabric, $color, $pattern, $categoryId); ?>
        </ul>
    </div>

    <?php if ($__get[0] != "product-on-promotion") { ?>
        <div class="product-colors">
            
                <h3 id="contactus-h1">Shop By Colours</h3>
            

            <ul class="nav nav-sidebar">
                <li>
                    <a href="<?= _URL_; ?>collection/<?= $cate . $fabric . $pattern; ?>" class='invarseColor'><i class="icon-caret-right"></i>
                        All Colours
                        <!--(<? //=$countallitems;
                                ?>)-->
                    </a>
                </li>
                <?php echo shopByColor($colorId, $cate, $fabric, $color, $pattern, $categoryId); ?>
            </ul>
        </div>
    <?php } ?>

    <div class="titleHeader clearfix" style="height: 20px;"></div>
    <?php /*
    <a href="<?php echo _URL_; ?>http://www.exacttailoring.com/collection/categories-mens-shirts/fabric-mauritius-">
        <img src="<?= _URL_; ?>images/mauritius-montage.jpg" alt="Buy tailor made shirts online" title="Buy tailor made shirts online" style="width:100%; margin-top:10px;" />
    </a>
    */ ?>

</aside>