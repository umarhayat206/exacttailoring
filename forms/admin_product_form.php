<?php
include_once("includes/tiny_mce_script.php");
include_once("includes/script.php");

//echo $_REQUEST['ex_product_detailsId']."-".$_GET['action'];

if(empty($_REQUEST['action'])){	// view all ex_product_details list
	
	if(empty($_GET['page'])){ $page = 1; }
	
	$listProduct = new smProduct;
	$listProduct = $listProduct->GetAll($_REQUEST['page'], $sqladminsearch, $_GET['sort'], $_GET['sorttype']);

	if($_REQUEST['page']>0){ $k= ($_REQUEST['page'] * 100) - 100; }
	
	$sql=mysql_query("select * from ex_product_details where productId !='' $sqladminsearch");
	
	$countpage=mysql_num_rows($sql) / 100;
	if($countpage>((int) $countpage)){ $countpage=((int) $countpage)+1; }
	if($countpage>0){
		
		$getsearchurl = $_GET;
		unset($getsearchurl['get0']);
	
		for($j=1;$j<=$countpage;$j++){
			$getsearchurl['page'] = $j;
			
			if($_GET['page']!=$j){	
				if($j>0){
					$gp .= "<span style='margin: 0 5px;'><a href='admin_product?".http_build_query($getsearchurl,'','&amp;')."'>$j</a></span>";
				}
			}else{
				$gp .= "<span style='margin: 0 5px;'><b>$j</b></span>";
			}
		}
	}
	
	if($_GET['sorttype'] == "desc"){	
		$sorttype = "asc";
	}else{
		$sorttype = "desc";
	}
	
?>


<div class="leftblock vertsortable" style="width:100%;">
	<!-- gadget left 1 -->
	<div class="gadget">
		<div class="titlebar vertsortable_head">
			<h3>Property</h3>
		</div>
		<div class="gadgetblock">
			
			<form id='productCategorySearch' method='get' action='<?=$site_admin; ?>admin_product' style="float:left; padding:0px 5px;" >
				<select id="searchcategory" name="searchcategory" onchange="this.form.submit();">
					<option value="0">Show all Category</option>
					<?=pdCategoryDropDownList($_POST['searchcategory']); ?>
				</select>
			</form>
			
			<form id="adminSearch" method="get" action="<?=$site_admin; ?>admin_product.php" enctype="multipart/form-data" style="margin-top:3px;">
				<label>Ref Code</label>
				<input type="text" id="searchrefcode" name="searchrefcode" value="<?=$_REQUEST['searchRefCode']; ?>" />
				<input type="hidden" id="adminSearchSubmit" name="adminSearchSubmit" value="true" />
				<input type="submit" id="search" name="search" value="Search" style="cursor:pointer;" /><br/>
			</form>
			
			<div id="selectDelete">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="gwlines">
					<tr>
						<th style="width:4%;">&nbsp;</th>
						<th style="width:7%;">Ref Code</th>
						<th style="width:14%;">Category</th>
						<th style="width:20%;">Product name</th>
						<th style="width:14%; text-align:center;">Farbic</th>
						<th style="width:10%; text-align:center;">Colour</th>
						<th style="width:10%; text-align:center;">Pattern</th>
						<th style="width:7%; text-align:right;">Price</th>
						<!--<th style="width:11%; text-align:center;">Rating</th>-->
						<th style="width:10%; text-align:center;">User Update</th>
						<th>&nbsp;</th>
					</tr>
					
					<?php
					foreach ($listProduct as $product){
						$k++;
							
						if($k % 2 == 0){
							$trstyle = " style='background:#FFF;' ";
						}else{
							$trstyle = "";
						}
						
						$categoryname = smCategory::getCategory($product->productCategoryId);
						$farbicname = smFabric::getFabric($product->productFabricId);
						$colorname = smColor::getColor($product->productColorId);
						$patternname = smPattern::getPattern($product->productPatternId);
						
					?>
					<tr <?=$trstyle;?>>
						<td>
							<form id="productVisible" method="post" action="<?=$site_admin; ?>admin_product">
								<input type="hidden" id="productVisibleSubmitted" name="productVisibleSubmitted" value="true" />
								<input type="hidden" id="productId" name="productId" value="<?=$product->productId; ?>" />
								<?php if($product->productVisibleFlag != 1){ ?>
								<input id="Select" name="Select" value="Select" type="image" title="Visible" src="<?=_URL_; ?>styles/images/set_home_featured.gif" alt="Visible" class="button" />
								<?php }else{ ?>
								<input id="Select" name="Select" value="Select" type="image" title="Remove visible" src="<?=_URL_; ?>styles/images/is_home_featured.gif" alt="Remove visible" class="button" />
								<?php } ?>
							</form>
						</td>
						<td><?=$product->productRefCode; ?></td>
						<td><?=$categoryname->categoryName; ?></td>
						<td><?=$product->productTitle; ?></td>
						<td style="text-align: center;"><?=$farbicname->fabricName; ?></td>
						<td style="text-align: center;"><?=$colorname->colorTitle; ?></td>
						<td style="text-align: center;"><?=$patternname->patternTitle; ?></td>
						<td style="text-align: right; font-size:15px;">&pound;<?=number_format($product->productPrice,2); ?></td>
						<!--<td style="text-align: center;">-->
							<?php
							/*
							for($rating=1;$rating<6;$rating++){
								
								if($rating <= $product->productRating){
									echo "<img src='"._URL_."styles/images/star-on.png' alt='' />";
								}else{
									echo "<img src='"._URL_."styles/images/star-off.png' alt='' />";
								}
								
							}
							*/
							?>
						<!--</td>-->
						<td style="text-align: center; font-style:italic;"><?=$product->productUserUpdate; ?></td>

						<td>
							<?php //if($_SESSION['chklevel'] == 1){  ?>
							<form id="productDelete" method="post" action="<?=$site_admin; ?>admin_product">
								<input type="hidden" id="productDeleteSubmitted" name="productDeleteSubmitted" value="true" />
								<input type="hidden" id="productId" name="productId" value="<?=$product->productId; ?>" />
								<input id="Delete" name="Delete" value="<?=$product->productId; ?>" title="Delete - <?=$product->productRefCode; ?>" alt="Delete - <?=$ex_product_details->productRefCode; ?>" type="image" src="<?=_URL_; ?>styles/images/delete.gif" class="button" onclick="javascript:return confirm('Are you sure...?')" />	
							</form>
							<?php //} ?>
							<a href="<?=$site_admin; ?>admin_product/?productId=<?=$product->productId; ?>&action=editdata">
								<img src="<?=_URL_; ?>styles/images/select.gif" alt="Edit - <?=$product->productRefCode; ?>" title="Edit - <?=$product->productRefCode; ?>" />
							</a>
						</td>
					</tr>
					<?php } ?>
				</table>
			</div>	<!-- n selectDelete -->
		</div>	<!-- n gadgetblock -->
	</div>	<!-- n gadget -->
</div><br/>	<!-- n leftblock vertsortabl -->

<p><?="Go to page ".$gp; ?></p>

<?php }else{  ?>

<div class="vertsortable" style="width:66%; margin: 0 auto;">
	<!-- gadget left 1 -->
	<div class="gadget">
		<div class="titlebar vertsortable_head">
			<!--<a href="#" class="hidegadget" rel="hide_block"><img src="<?//=_URL_;?>styles/images/spacer.gif" alt="picture" width="19" height="33" /></a>-->
			<h3>Add / Edit Product</h3>
		</div>
		<div class="gadgetblock">
                        <form id="addEditForm" method="post" action="<?php echo $site_admin; ?>admin_product" enctype="multipart/form-data">

				<div style="width:49%; float:left;">
					<fieldset>
						<legend>Product Details</legend>
						
						<?php smControls::smTextBox("Ref Code", "productRefCode", $PRODUCT->productRefCode); ?><br />
						<?php smControls::smTextBox("Product name", "productTitle", $PRODUCT->productTitle); ?><br />
		
						<label>Category</label>
						<select id="productCategoryId" name="productCategoryId">
							<option value="">- Select Category -</option>
							<?php echo(pdCategoryDropDownList($PRODUCT->productCategoryId)); ?>
						</select><br />
						
						<label>Fabric</label>
						<select id="productFabricId" name="productFabricId">
							<option value="">- Select Fabric -</option>
							<?php echo(pdFabricDropDownList($PRODUCT->productFabricId)); ?>
						</select><br />
						
						<label>Pattern</label>
						<select id="productPatternId" name="productPatternId">
							<option value="">- Select Pattern -</option>
							<?php echo(pdPatternDropDownList($PRODUCT->productPatternId)); ?>
						</select><br />
						
						<label>Colour (Shades)</label>
						<select id="productColorId" name="productColorId">
							<option value="">- Select Colour -</option>
							<?php echo(pdColorDropDownList($PRODUCT->productColorId)); ?>
						</select><br />
				
						<?php smControls::smTextBox("Sale Price (numeric)", "productPrice", $PRODUCT->productPrice); ?><br />
						
						<label>Rating</label>
						<select id="productRating" name="productRating">
							<option value="0">- Select Rating -</option>
							<?php echo(pdRatingDropDownList($PRODUCT->productRating)); ?>
						</select><br />
						
						<!--
						<br />
						<label>Descriptions</label>
						<textarea name="productDescription" id="productDescription" class="tinymce" style="height:300px; width:100%;"><?//=stripcslashes($PRODUCT->productDescription);?></textarea><br/>
						-->
						
						<label>Keyword</label>
						<textarea name="productKeyword" id="productKeyword" style="height:50px; width:98%;"><?=stripcslashes($PRODUCT->productKeyword);?></textarea><br/>
						
						<div style="width:40%; float:left;">&nbsp;
						<?php
						if(!empty($PRODUCT->productMainPicture)){
							echo "<img src='"._URL_."upload_pictures/{$PRODUCT->productMainPicture}' width='100%' />";
						}
						?>
						</div><br/>
						<input type="hidden" id="hiddenMainPicture" name="hiddenMainPicture" value="<?php echo($PRODUCT->productMainPicture); ?>" />
						<?php smControls::smFileUpload("Upload picture (minimumn width 400 x 400px)", "productMainPicture", ""); ?>
						<br/>
	
						<!--		
						<label class="taptitle">Upload Picture (A maximum of 4 images can be uploaded at any time. To add more than 4 images of a product return here after saving.)</label><br/>
						<div class="hiddenUploadPicture" style="display:run-in; width:100%; margin-bottom:15px;">
							<br/>
							<u><a href="<?//=$site_admin;?>admin_product/?productId=<?//=$PRODUCT->productId; ?>&amp;imageDeleteAll=true&amp;action=save" style="margin:15px 0;">DELETE ALL PICTURES CLICK HERE</a></u><br/>
							<div style="width:60%; float:left; margin-top:5px;">&nbsp;
								<?php //echo(showImageList($PRODUCT->productId)); ?>
							</div>
							<div style="width:40%; float:left;">
								<?php //smControls::smFileUpload("", "productPicture1", ""); ?><br/>
								<?php //smControls::smFileUpload("", "productPicture2", ""); ?><br/>
								<?php //smControls::smFileUpload("", "productPicture3", ""); ?><br/>
								<?php //smControls::smFileUpload("", "productPicture4", ""); ?><br/>
							</div>
						</div><br/>
						-->
						
						<?php //smControls::smCheckBox("Bestseller", "productBestSale","1", $PRODUCT->productBestSale); ?><br />
						<?php smControls::smCheckBox("Visible?", "productVisibleFlag","1", $PRODUCT->productVisibleFlag); ?>
					</fieldset>
					
				</div>
				<div style="width:49%; float: right;">
					<fieldset>
						<legend>Fabric Information</legend>
						<?php
						if(!empty($PRODUCT->productFabricPicture)){
							echo "<img src='"._URL_."upload_pictures/{$PRODUCT->productFabricPicture}' width='30%;' /><br/>";
						}
						?>
						<?php smControls::smFileUpload("Upload fabric  (400 x 400 px)", "productFabricPicture", ""); ?><br/>
						<input type="hidden" id="hiddenFabricPicture" name="hiddenFabricPicture" value="<?php echo($PRODUCT->productFabricPicture); ?>" />
						<?php smControls::smTextBox("Composition", "productFabricComposition", $PRODUCT->productFabricComposition); ?><br />
						<?php smControls::smTextBox("Colour Information", "productFabricColorInfo", $PRODUCT->productFabricColorInfo); ?><br />
						<?php smControls::smTextBox("Yarn", "productFabricYarn", $PRODUCT->productFabricYarn); ?><br />
						<?php smControls::smTextBox("Weaving", "productFabricWeaving", $PRODUCT->productFabricWeaving); ?><br />
						<?php smControls::smTextBox("Weigth (g/m²)", "productFabricWeigth", $PRODUCT->productFabricWeigth); ?>
					</fieldset>
				</div>	
				
				<br/><br/>
				Listed on: <strong><?=$PRODUCT->productDateAdded; ?></strong> | Last update: <strong><?=date("l j F Y", $PRODUCT->productLastdate); ?></strong> By <strong><?=$PRODUCT->productUserUpdate; ?></strong>
				
				<input type="hidden" id="productId" name="productId" value="<?php echo($PRODUCT->productId); ?>" />
				<input type="hidden" id="productFormSubmitted" name="productFormSubmitted" value="true" />

				<label style="float:right; width:auto; margin:auto 5px;">Save and go to products list</label><input type="radio" id="saveoption1" name="saveoption" checked="checked" value="1" style="float:right; width:auto; margin:3px 5px;" />
				<label style="float:right; width:auto; margin:auto 5px;">Save and return to this product</label><input type="radio" id="saveoption2" name="saveoption" value="2" style="float:right; width:auto; margin:3px 5px;" />
				<br />
				
				<input type="submit" id="save" value="Save" title="" style="cursor:pointer; " />
				<button style="cursor:pointer; float:right; width:8em;" onclick="window.location('<?=_URL_;?>admin_product');">Cancel</button>
			
			</form><br/>
		</div>      <!-- n gadgetblock -->
	</div>	<!-- n gadget -->
</div><br/>	<!-- n leftblock vertsortabl -->

<?php } ?>


