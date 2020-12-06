<?php

function topNevGetCategory()
{
    $htmlToReturn = "";

    $catelists = smCategory::GetMenuAndPages(null, true);
    $k = 0;

    $catSub = array(4 => 'Design Your Shirt', 7 => 'Design Your Trouser'); // ID:4 is Shirts, ID:7 is Trousers
    foreach ($catelists as $items) {
        if ($items->categoryRootId > 0) {
            if ($items->categoryVisible == 1) {
                $catename = str_replace(" ", "-", strtolower($items->categoryName));
                $catename1 = strtoupper($items->categoryName);
                //$countitem = smSetting::countProduct(" AND productCategoryId = '{$items->categoryId}' ");
                //$htmlToReturn .= "<li><a href='" . _URL_ . "collection/categories-$maincatename-$catename'> <span>-</span><i class='icon-caret-right'></i> $catename1 ($countitem)</a></li>";
                if ($items->categoryId == 4 || $items->categoryId == 7) {
                    $htmlToReturn .= "<li><a href='" . _URL_ . "collection/categories-{$maincatename}-{$catename}'> <span>-</span><i class='icon-caret-right'></i> " . $catSub[$items->categoryId] . "</a></li>";
                }
            }
        } else {
            $k++;

            if ($k > 1) {
                $htmlToReturn .= "</ul></div></li>";
            }

            $maincatename = str_replace(" ", "-", strtolower($items->categoryName));
            $maincatename1 = strtoupper($items->categoryName);
            $htmlToReturn .= "<li><a>$maincatename1 &nbsp;<i class='icon-caret-down'></i></a>
                    <div><ul>";
            /*
            $htmlToReturn .= "<li>
                <a href='"._URL_."collection/categories-$maincatename-all'>$maincatename1 &nbsp;<i class='icon-caret-down'></i></a>
                <div><ul>";
            */
        }
    }

    $htmlToReturn .= "</ul></div></li>";

    return $htmlToReturn;
}

function topNevGetFabric()
{
    $htmlToReturn = "";

    $fabriclists = smFabric::GetMenuAndPages(null, true);

    $htmlToReturn .= "<li><a href='" . _URL_ . "collection/fabric-all'>FABRIC &nbsp;<i class='icon-caret-down'></i></a>
        <div><ul>";

    foreach ($fabriclists as $items) {
        $fabricname = str_replace(" ", "-", strtolower($items->fabricName));
        $fabricname1 = strtoupper($items->fabricName);
        $countitem = smSetting::countProduct(" AND productFabricId = '{$items->fabricId}' ");
        $htmlToReturn .= "<li><a href='" . _URL_ . "collection/fabric-$fabricname'> <span>-</span><i class='icon-caret-right'></i> $fabricname1 ($countitem)</a></li>";
    }

    $htmlToReturn .= "</ul><div></li>";

    return $htmlToReturn;
}

function topNevGetPattern()
{
    $htmlToReturn = "";

    $patternlists = smPattern::GetMenuAndPages(null, true);

    $htmlToReturn .= "<li><a href='" . _URL_ . "collection/pattern-all'>PATTERN &nbsp;<i class='icon-caret-down'></i></a>
        <div><ul>";

    foreach ($patternlists as $items) {
        $patternname = str_replace(" ", "-", strtolower($items->patternTitle));
        $patternname1 = strtoupper($items->patternTitle);
        $countitem = smSetting::countProduct(" AND productPatternId = '{$items->patternId}' ");
        $htmlToReturn .= "<li><a href='" . _URL_ . "collection/pattern-$patternname'> <span>-</span><i class='icon-caret-right'></i> $patternname1 ($countitem)</a></li>";
    }

    $htmlToReturn .= "</ul><div></li>";

    return $htmlToReturn;
}
?>
<div class="container-fluid">

<nav class="navbar  navbar-default" id="navbar-margin" >
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?=_URL_;?>" ><img src="<?=_URL_;?>images/logo.png" alt="Shoppest" class="img-responsive" style="margin-top:-10px;"/></a> 
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                    <ul class="nav navbar-nav ">
                        <li><a href="<?=_URL_;?>">Home</a></li>
                        <li><a href="<?= _URL_; ?>collection/categories-mens-shirts">Design Your Shirt</a></li>
                        <li><a href="<?= _URL_; ?>collection/categories-mens-trousers">Design Your Trouser</a></li>
                        <li><a href="<?= _URL_; ?>promotion" style="cursor:pointer;">Promotions</a></li>

                   <!-- <li><a href="<?=_URL_;?>contact">contact Us</a></li>
                    <li><a href="<?= _URL_; ?>content/how-to-order">How to order</a></li> -->
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php if(empty($_SESSION['chkmemberuser'])){ ?>
                    <li><a class="invarseColor loginclick" href="<?=_URL_;?>loginform">Login</a></li>
                   
                    <!-- <li><a class="invarseColor passwordclick" href="<?=_URL_; ?>">Password Reminder</a></li> -->
                    
                    
                    <li><a class="invarseColor" href="<?=_URL_; ?>regisform">Register</a></li>
                    <?php }else{ ?>
                    
                    <li><a class="invarseColor" href="<?=_URL_; ?>my-designs">My Designs</a></li>
                    
                    <li><a class="invarseColor" href="<?=_URL_; ?>my-account">My Account</a></li>
                    
                    <li><a class="invarseColor" href="<?=_URL_; ?>memberlogout">Sign Out</a></li>
                    <?php } ?>
                       
                        <li><a href="<?=_URL_;?>shoppingcart">Shopping Cart<i class="icon-shopping-cart all-icon"></i> </a></li> 
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav><br><br>

</div>
<!-- <ul class="nav">
    <li class="active"><a href="<?= _URL_; ?>" style="cursor:pointer;"><i class="icon-home" style="cursor:pointer;"></i>home</a></li>
    <li><a href="<?= _URL_; ?>collection/categories-mens-shirts" style="cursor:pointer;">Design Your Shirt</a></li>
    <li><a href="<?= _URL_; ?>collection/categories-mens-trousers" style="cursor:pointer;">Design Your Trouser</a></li> -->

    <!-- Pahla hi comment tha  -->
    <?php
    //echo topNevGetCategory();
    //echo topNevGetFabric();
    //echo topNevGetPattern();
    ?>
    <!-- yahan end hova ha  -->
    <!-- <li><a href="<?= _URL_; ?>promotion" style="cursor:pointer;">Promotions</a></li>
    <li><a href="<?= _URL_; ?>content/how-to-order" style="cursor:pointer;">How To Order</a></li> -->

    <!-- pahla hi comment tha  -->
    
    <?php /* <li><a href="<?=_URL_;?>contact" style="cursor:pointer;">Contact Us</a></li> */ ?>
    <!-- yahan end hova ha  -->
<!-- </ul> -->