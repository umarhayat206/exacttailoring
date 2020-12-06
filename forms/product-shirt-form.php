<div class="container">
<div class="row">
<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">


    <form action="<?= _URL_; ?>addcart.php" method="post" enctype="multipart/form-data">
        

            
                <?php
                if ($productdetails->productCategoryId == 4 || $productdetails->productCategoryId == 8) {
                    $styleoption = "<span><a href='javascript:void(0)' class='shirtsoption'>(View Style Options)</a></span>";
                } else {
                    $styleoption = "<span><a href='javascript:void(0)' class='trousersoption'>(View Style Options)</a></span>";
                }
                ?>
                <h3 id="account-h1" class="text-center">
                    <?php echo $categoryname->categoryName; ?> creator
                    <?php echo $styleoption; ?>
                </h3><br>
            
            <!--end titleHeader-->

            
                <div id="hiddenstyleoptions-shirts" style="display:none;">
                    <a href="<?= _URL_; ?>images/stylesoption1.jpg" rel="prettyPhoto[styleoptions]">
                        <img src="<?= _URL_; ?>images/stylesoption1.jpg" alt="" title="" />
                    </a>
                </div>
                <div id="hiddenstyleoptions-trousers" style="display:none;">
                    <a href="<?= _URL_; ?>images/stylesoption2.jpg" rel="prettyPhoto[styleoptions]">
                        <img src="<?= _URL_; ?>images/stylesoption2.jpg" alt="" title="" />
                    </a>
                </div>

                <div class=" productdesign">
                    <?php
                    // Shirts and Blouse
                    if ($productdetails->productCategoryId == 4 || $productdetails->productCategoryId == 5 || $productdetails->productCategoryId == 8) { // shirts and blouse
                        include_once('forms/shirt-design.php');
                    } else if ($productdetails->productCategoryId == 7) { // Trousers
                        include_once('forms/trousers-design.php');
                        /*echo "<div id='shirtView'>
                                <div id='shirtBody' style='background-image: url("._URL_."CONTENTs/picture-design-trousers/trousers.png);'></div>
                            </div>";*/
                    }

                    echo "<div id='opttionView'>";

                    if (!empty($designmenu)) {

                        $k = 0;
                        $embroideryColorID = 53; // ID:#53 = Embroidery Color
                        $embroideryColor = '';
                        foreach ($designmenu as $menu) {
                            //echo "<label>{$menu->featuresName} - {$menu->featuresId} - {$menu->featuresRootId}</label>";
                            //$designitem = smFeature::getFeatures($menu->featuresId);

                            if ($menu->featuresRootId > 0) {
                                //$itemDropdown .= "<label>--------- {$menu->featuresName} - {$menu->featuresId}</label><br/>";
                                if ($menu->featuresRootId == $embroideryColorID) {
                                    $embroideryColor .= "<option value='{$menu->featuresId}' >{$menu->featuresName}</option>";
                                } else {
                                    $itemDropdown .= "<option value='{$menu->featuresId}'>{$menu->featuresName}</option>";
                                }
                            } else {
                                if ($menu->featuresId == $embroideryColorID) {
                                    $embroideryColor .=  "<label class='left'>{$menu->featuresName}</label>";
                                    $embroideryColor .=  "<select id='f-{$menu->featuresId}' name='f-{$menu->featuresId}' class='left form-control'>";
                                } else {
                                    $k++;
                                    if ($k > 1) {
                                        $itemDropdown .=  "</select><br style='clear:both;'/>";
                                    }

                                    $itemDropdown .=  "<label class='left'>{$menu->featuresName}</label>";
                                    $itemDropdown .=  "<select id='f-{$menu->featuresId}' name='f-{$menu->featuresId}' class='left form-control'>";
                                }
                            }
                        }

                        $itemDropdown .=  "</select>";
                        echo $itemDropdown;
                    }

                    if ($productdetails->productCategoryId == 4 || $productdetails->productCategoryId == 5 || $productdetails->productCategoryId == 8) {

                        echo "<label class='left'>Inside Collar &amp; Cuff</label>";

                        $listInsideCollarCuff =  smProduct::searchProduct(" AND productFabricId = '{$productdetails->productFabricId}' AND productCategoryId = '{$productdetails->productCategoryId}' AND productId != '{$productdetails->productId}'  ", 200, "");

                        echo "<select id='hiddeninsidecollarcuff' name='hiddeninsidecollarcuff' class='left form-control'>
                                <option value='Same as shirt'>Same as shirt</option>";

                        foreach ($listInsideCollarCuff as $item) {
                            $captionInsideCollarCuff = strtoupper($item->productTitle . " (" . $item->productRefCode . ")");
                            echo "<option value='$captionInsideCollarCuff'>$captionInsideCollarCuff</option>";
                        }

                        echo "</select>";
                    }

                    echo " <label class='left'>Initials</label>
                            <input type='text' id='hiddeninitials' name='hiddeninitials' value='" . $_SESSION['initials'] . "' class='form-control' style='width:12em;'/><br>";


                    echo $embroideryColor . "</select>";

                    echo "</div>";
                    ?>

                    <input type="hidden" id="hiddenproductid" name="hiddenproductid" value="<?= $productdetails->productId; ?>" />
                    <input type="hidden" id="hiddencategoryid" name="hiddencategoryid" value="<?= $productdetails->productCategoryId; ?>" />
                    <br  /><br>
                    <button type="submit" class="btn btn-default-shop">Continue to measurements</button><br><br><br><br>

                </div> <!-- n div productdesign -->
            

        

        <?php echo $itemforfree; ?>
    </form>

 
</div>
<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

    

      <h3 id="account-h1">Product Details: REF #<?= $productdetails->productRefCode; ?></h3>
        
        <!--end titleHeader-->
        

            
                <center>
                    <?php if (!empty($productdetails->productMainPicture)) { ?>
                        <a href="<?= _URL_; ?>upload_pictures/<?= $productdetails->productMainPicture; ?>" title="" rel="prettyPhoto">
                            <img src="<?= _URL_; ?>upload_pictures/<?= $productdetails->productMainPicture; ?>" alt="<?= $productdetails->productTitle; ?>" title="<?= $productdetails->productTitle; ?>" style="height:250px;width:100%;">
                        </a>
                    <?php } else if (!empty($productdetails->productFabricPicture)) { ?>
                        <a href="<?= _URL_; ?>upload_pictures/<?= $productdetails->productFabricPicture; ?>" title="" rel="prettyPhoto">
                            <img src="<?= _URL_; ?>upload_pictures/<?= $productdetails->productFabricPicture; ?>" alt="<?= $productdetails->productTitle; ?>" title="<?= $productdetails->productTitle; ?>" style="height:250px;width:100%;">
                        </a>
                    <?php } ?>
                    <!--              
                    <a href="<? //=_URL_;
                                ?>upload_pictures/<? //=$productdetails->productMainPicture;
                                                    ?>" title="" rel="prettyPhoto">
                        <img src="<? //=_URL_;
                                    ?>upload_pictures/<? //=$productdetails->productMainPicture;
                                                        ?>" alt="<? //=$productdetails->productTitle;
                                                                    ?>" title="<? //=$productdetails->productTitle;
                                                                                ?>" class="mainpicture">
                    </a>
                    -->
                </center>
            

            
                
            <p class="text-center price">Product Price:<?php echo $showprice; ?></p>
                

                <h3 id="account-h1"><?= $productdetails->productTitle; ?></h3>

                
                    <dl style="margin-left:30px;">
                        <dt>Fabric:</dt>
                        <dd><?= $fabric->fabricName; ?> </dd>

                        <dt>Pattern:</dt>
                        <dd><?= $pattern->patternTitle; ?> </dd>

                        <dt>Colour:</dt>
                        <dd><?= $showcolor; ?> </dd>
                    </dl>
                

                <h3 id="account-h1">Fabric Information</h3>

                
                    <?= $fabric->fabricShortDescriptions; ?>
                    

                

</div>
        

</div>
</div>
</div>

<!--end span3-->