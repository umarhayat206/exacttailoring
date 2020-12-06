<?php

include_once("includes/script.php");

$currentPages = new smPromotion;
$currentPage = new smPromotion;

//See if the a page has been selected
if($_REQUEST['promotionId']!=''){
	//echo($_POST['promotionId']);
	$currentPage = $currentPage->GetPromotion($_POST['promotionId']);
}

$erContent = "";
//See if the Add/Edit form has been submitted
if($_POST['addEditPromotionFormSubmitted']=='true'){
	$currentPage->promotionId = $_POST['promotionId'];
	$currentPage->promotionTitle = $_POST['promotionTitle'];
	//$currentPage->promotionBanner = $_POST['promotionBanner'];
	$currentPage->promotionType = $_POST['promotionType'];
	$currentPage->promotionItemType = $_POST['selectitem'];
	$currentPage->promotionDiscount = str_replace(",", "", $_POST['promotionDiscount']);
	$currentPage->promotionGetfreeItem = 1;
	$currentPage->promotionStart = $_POST['promotionStart'];
	$currentPage->promotionUntill = $_POST['promotionUntill'];
	$currentPage->promotionVisible = $_POST['promotionVisible'];
	$currentPage->promotionHidden = $_POST['promotionHidden'];
	$currentPage->promotionCode = $_POST['promotionCode'];
	
	//$currentPage->promotionType2 = 1;
	//$currentPage->promotionFreeShipping = $_POST['promotionFreeShipping'];
	
	$IMAGES = new smImage;
	$uploaddir1 = "upload_pictures/";
	$limitSize = 1024000;		//1mb
	$tt = mktime();
	
	$uploadmainimg= $tt."-promotion-".$_FILES['promotionBanner']['name']; 
	$filename_tmp1 = $_FILES['promotionBanner']['name']; 
	if($filename_tmp1!=""){      // upload main picture 
		if(copy($_FILES['promotionBanner']['tmp_name'], $uploaddir1.$uploadmainimg)){ 
			$currentPage->promotionBanner = $uploadmainimg; 
		}else{
			$currentPage->promotionBanner = $_POST['hiddenPromotionBanner']; 
		}
	}else{
		$currentPage->productMainPicture = $_POST['hiddenPromotionBanner']; 
		//echo "<script>alert('Your picture size more than 1mb ....... please try again!!!.');</script>";
	}

	//See if this is an update or an insert
	if($currentPage->promotionId==''){ 	//INSERT
		$PROMOTIONID=$currentPage->Insert($currentPage); 
		$currentPage=null;	
	}else{  //UPDATE
		$PROMOTIONID=$currentPage->Update($currentPage); 
		$currentPage=null; 
	} 
	
	// for on promotion
	$INDEXPROMOTION = new smPromotion;
	$INDEXPROMOTION->promotionId = $PROMOTIONID;
	$additems = smProduct::GetAllVisible();
	$INDEXPROMOTION->type = 1;
	

	mysql_query("DELETE FROM ex_promotion_index WHERE promotionId='".$INDEXPROMOTION->promotionId."' AND type = '1' ");
	
	//echo $PROMOTIONID;
	//print_r($_POST);
	if($_POST['selectitem'] == 2){ 	//echo "---2---";
		foreach($additems as $item){
			$onpromotion = "onpromotion-".$item->productId;
			//echo $onpromotion ." - ".$$onpromotion."<br/>";
			
			if($_POST[$onpromotion] == 1){
				$productId = explode("-",$onpromotion);
				$INDEXPROMOTION->productId = $productId[1];
				$INDEXPROMOTION->AddPromotionIndex($INDEXPROMOTION);
			}
		}
		
	// add all product
	}else if($_POST['selectitem'] == 1){	//echo "---1---";
		foreach($additems as $item){
			$INDEXPROMOTION->productId = $item->productId;
			$INDEXPROMOTION->AddPromotionIndex($INDEXPROMOTION);
		}
	}
	
	// for free item
	$INDEXPROMOTION2 = new smPromotion;
	$INDEXPROMOTION2->promotionId = $PROMOTIONID;
	$INDEXPROMOTION2->type = 2;
	
	mysql_query("DELETE FROM ex_promotion_index WHERE promotionId='".$INDEXPROMOTION2->promotionId."' AND type = '2' ");

	//print_r($_POST);
	if($_POST['selectitem'] == 2){ 	//echo "---2---";
		foreach($additems as $item){
			$freeitem = "freeitem-".$item->productId;
			if($_POST[$freeitem] == 1){
				$productId = explode("-",$freeitem);
				$INDEXPROMOTION2->productId = $productId[1];
				$INDEXPROMOTION2->AddPromotionIndex($INDEXPROMOTION2);
			}
		}
		
	// add all product
	}else if($_POST['selectitem'] == 1){	//echo "---1---";
		foreach($additems as $item){
			$INDEXPROMOTION2->productId = $item->productId;
			$INDEXPROMOTION2->AddPromotionIndex($INDEXPROMOTION2);
		}
	}

	echo ("<script>window.location='"._URL_."admin_promotion';</script>");
	
}

//Page Deleted
if($_POST['promotionDeleteFormSubmitted']=='true'){
	smPromotion::Delete($_POST['promotionId']);
	echo ("<script>window.location='"._URL_."admin_promotion';</script>");
}

if(!empty($_REQUEST['promotionId'])){
    $checkedIndex =smPromotion::GetAllIndex($_REQUEST['promotionId'], 1);
    $checkedIndex2 =smPromotion::GetAllIndex($_REQUEST['promotionId'], 2);
}

function productList($productId, $checkedId, $type, $cls){			//show fertures list
	$htmlToReturn = "";

	$newArray=array();
	for($i=0;$i<count($checkedId);$i++){
		$newArray[$checkedId[$i]]=" checked=\"checked\" ";		
	}

	if(!empty($productId)){
		$htmlToReturn .= "<ul style='padding: 10px; margin:0 0 15px 0; clear:both; float:left; background:#E5EFFD; width:96.5%;'>";

		foreach ($productId as $item){
			if($type==1){
				$prName="onpromotion-".$item->productId;	
			}else{
				$prName="freeitem-".$item->productId;	
			}
			
			$htmlToReturn .= "<li style='width:25%; float:left; list-style:none;'>";
			$htmlToReturn .= "<input style='width:auto; float:left;' type='checkbox' name='$prName' ";
			$htmlToReturn .= $newArray[$item->productId];
			$htmlToReturn .= " id='$prName' value='1' class='$cls' />";
			$htmlToReturn .= "<label>".$item->productRefCode."</label>";
			$htmlToReturn .= "</li>";
		}

		$htmlToReturn .="</ul><br/>";
	}
	
	return $htmlToReturn;	
}


$currentPages = $currentPages->GetAllPromotion(true);
//print_r($currentPages);

$category = smCategory::GetMenuAndPages(null, true);
?>

<div class="vertsortable" style="width:50%; margin: 0 auto;">
	<!-- gadget left 1 -->
	<div class="gadget">
		<div class="titlebar vertsortable_head">
			<!--<a href="#" class="hidegadget" rel="hide_block"><img src="<?//=_URL_;?>styles/images/spacer.gif" alt="picture" width="19" height="33" /></a>-->
			<h3>Add / Edit Promotion <a href='<?=$site_admin;?>admin_promotion' title='Clear Form' style="text-decoration:none; font-weight:normal;">(Clear Form)</a></h3>
		</div>
		<div class="gadgetblock">
			<form id="contentAddEdit" action="<?=$site_admin; ?>admin_promotion" method="post" enctype="multipart/form-data">
				<?php if(!empty($erContent)){ echo('<p class="validationArea">'.$erContent.'</p>'); } ?>
				<?php smControls::smTextBox("Title", "promotionTitle", $currentPage->promotionTitle); ?><br />
				<br />
				
				<label>Promotion Type</label>
				
				<?php
				if($currentPage->promotionType == 2){
					$typechk2 = " checked='checked' ";
					//$showhiddendivfreeitem = " style='display:block;' ";
					//$showhiddendivdiscount = " style='display:none;' ";

				}else if($currentPage->promotionType == 1){
					$typechk1 = " checked='checked' ";
					//$showhiddendivdiscount = " style='display:block;' ";
					//$showhiddendivfreeitem = " style='display:none;' ";
					//$hiddendivproducttwo = " ";

				}else if($currentPage->promotionType == 3){
					$typechk3 = " checked='checked' ";
					//$showhiddendivdiscount = " style='display:block;' ";
					//$showhiddendivfreeitem = " style='display:none;' ";
					//$hiddendivproducttwo = " ";

				}else{
					$typechk1 = " checked='checked' ";
					//$showhiddendivdiscount = " style='display:block;' ";
					//$showhiddendivfreeitem = " style='display:none;' ";
					//$hiddendivproducttwo = "";

				}
				?>

				<span style="float:right;">Buy 2 Get 1 free</span>
				<input type="radio" id="promotionType3" name="promotionType" value="3" <?php echo $typechk3; ?> style="width:30px; float:right;" />

				<span style="float:right; margin-right:20px;">Buy 1 Get 1 free (Not use voucher code)</span>
				
				<input type="radio" id="promotionType2" name="promotionType" value="2" <?php echo $typechk2; ?> style="width:30px; float:right;" />
				
				<span style="float:right; margin-right:20px;">DISCOUNT</span>
				<input type="radio" id="promotionType1" name="promotionType" value="1" <?php echo $typechk1; ?> style="width:30px; float:right;" />
				<br /><br />
				
				<div id="hiddendivdiscount" <?php echo $showhiddendivdiscount; ?>>
					<?php smControls::smTextBox("How many percen for discount?", "promotionDiscount", $currentPage->promotionDiscount); ?><br />
				</div><br />

				<?/*<div id="hiddendivfreeitem" <?php echo $showhiddendivfreeitem; ?>>
					<?php smControls::smTextBox("How many product for get free?", "promotionGetfreeItem", $currentPage->promotionGetfreeItem); ?><br />
				</div>*/?>

				<?php smControls::smTextBox("Voucher Code", "promotionCode", $currentPage->promotionCode); ?><br />

				<?php
				/*
				if($currentPage->promotionItemType == 2){
					$itemtypechk2 = " checked='checked' ";
					//$hiddendivproducttwo = " style='display:block;' ";
					//$showhiddendivproductone = " style='display:none;' ";
				}else if($currentPage->promotionItemType == 1){
					$itemtypechk2 = " checked='checked' ";
					//$showhiddendivproductone = " style='display:block;' ";
					//$hiddendivproducttwo = " style='display:none;' ";
				}else{
					$itemtypechk2 = " checked='checked' ";
					//$showhiddendivproductone = "";
					//$hiddendivproducttwo = " style='display:none;' ";
				}
				*/
				?>
			

				<div id="hiddendivproductone" <?php echo $showhiddendivproductone; ?>>
					<br />
					<label>On selected items</label>
					<span style="float:right; ">Select Product</span>
					<input type="radio" id="selectproduct" name="selectitem" value="2" checked="checked" style="width:30px; float:right;" />
					
					<?/*
					<span style="float:right; margin-right:20px;">All Product</span>
					<input type="radio" id="allproduct" name="selectitem" value="1" <?php echo $itemtypechk1; ?> style="width:30px; float:right;" />
					*/?>

					<br />
					<fieldset>
						<legend>Items</legend>
						<br/>
						<p>Tick for choose all products <input id="checkall1" name="checkall1" value="1" type="checkbox" style="float:left; width:auto;" /></p>

						<?php
						foreach($category as $catelist){
						
							//if($catelist->categoryRootId>0){
							if($catelist->categoryId==4 || $catelist->categoryId==8 || $catelist->categoryId==7 || $catelist->categoryId==5){ // only shirt,  trousers and dress shirts
								//echo("<span class='indent'>&nbsp</span>");
								echo "<label>{$catelist->categoryName}</label><br style='margin-bottom:5px;' />";
								$productonpromotion = smProduct::searchProduct(" AND productCategoryId = '{$catelist->categoryId}' ", 600, "");
								
								echo productList($productonpromotion, $checkedIndex, 1, "checkallfree1");	// for on promotion
								
							}else{
								$k1++;
								//if($k1 > 1){ echo "<br/>"; }
								
								//echo "<label style='font-weight:bold;'>{$catelist->categoryName}</label><br style='margin-bottom:5px;' />";
							}
						}
						?>
					</fieldset>
				</div>
				<div id="hiddendivproducttwo" <?php echo $hiddendivproducttwo; ?>>
					<br />
					<fieldset>
						<legend>Select item for free</legend>
						<p>Tick for choose all products <input id="checkall" name="checkall" value="1" type="checkbox" style="float:left; width:auto;" /></p>
						<?php
						foreach($category as $catelist){
					
							if($catelist->categoryId==4 || $catelist->categoryId==8 || $catelist->categoryId==7 || $catelist->categoryId==5){ // only shirt,  trousers and dress shirts
								//echo("<span class='indent'>&nbsp</span>");
								echo "<label>{$catelist->categoryName}</label><br style='margin-bottom:5px;' />";
								$productonpromotion2 = smProduct::searchProduct(" AND productCategoryId = '{$catelist->categoryId}' ", 600, "");
								
								echo productList($productonpromotion2, $checkedIndex2, 2, "checkallfree");	// for free item
								
							}else{
								$k2++;
								//if($k2 > 1){ echo "<br/>"; }
								
								//echo "<label style='font-weight:bold;'>{$catelist->categoryName}</label><br style='margin-bottom:5px;' />";
							}
						}
						?>
					</fieldset>
				</div><br /><br />
				
				<?php smControls::smTextBox("Start date", "promotionStart", $currentPage->promotionStart); ?><br />

				<?php smControls::smTextBox("Untill date", "promotionUntill", $currentPage->promotionUntill); ?><br />
				
				<?php
				if(!empty($currentPage->promotionBanner)){
					echo "<img src='"._URL_."upload_pictures/{$currentPage->promotionBanner}' style='width:99%; margin:10px 0;' />";
				}
				?><br/>

				<input type="hidden" id="hiddenPromotionBanner" name="hiddenPromotionBanner" value="<?php echo($currentPage->promotionBanner); ?>" />
				
				<?php smControls::smFileUpload("Upload picture (fix size 694 x 246px)", "promotionBanner", ""); ?><br/><br/>
				
				<?php smControls::smCheckBox("Promotion on Hidden?", "promotionHidden","1", $currentPage->promotionHidden); ?><br /><br/>

				<?php smControls::smCheckBox("Visible?", "promotionVisible","1", $currentPage->promotionVisible); ?><br /><br/>
				
				<input type="hidden" name="promotionId" id="promotionId" value="<?php echo($currentPage->promotionId);?>" />

				<input type="hidden" name="addEditPromotionFormSubmitted" id="addEditPromotionFormSubmitted" value="true" />

				<input type="submit" value="Save" style="cursor:pointer;" />
			</form><br/>
		</div>	<!-- n gadgetblock -->
	</div>	<!-- n gadget -->
	
	<!-- gadget left 1 -->
	<div class="gadget">
		<div class="titlebar vertsortable_head">
			<!--<a href="#" class="hidegadget" rel="hide_block"><img src="<?//=_URL_;?>styles/images/spacer.gif" alt="picture" width="19" height="33" /></a>-->
			<h3>Promotion</h3>
		</div>
		<div class="gadgetblock">
			<div id="contentCurrent">
				<?php
				foreach($currentPages as $aPage){
					if($aPage->promotionVisible == 1){
						$ath="<input id='Select' name='Select' value='Select' type='image' title='Visible' src='"._URL_."styles/images/nothidden.gif' alt='' title='' />";
					}else{
						$ath="<input id='Select' name='Select' value='Select' type='image' title='Remove visible' src='"._URL_."styles/images/hidden.gif' alt='' title='' />";
					}
					?>
					<form id="pageDeleteForm" action="<?=$site_admin; ?>admin_promotion" method="post">
						<input type="hidden" id="promotionDeleteFormSubmitted" name="promotionDeleteFormSubmitted" value="true" />
						<input type="hidden" id="promotionId" name="promotionId" value="<?php echo($aPage->promotionId); ?>" />
						<input id="Delete" name="Delete" value="<?php echo($aPage->promotionId); ?>" title="Delete" type="image" src="<?=_URL_;?>styles/images/cross.png" class="button" onclick="javascript:return confirm('Are you sure...?')" />			
					</form>
					<form id="pageSelect" method="post" action="<?=$site_admin; ?>admin_promotion">
						<input type="hidden" id="promotionSelectFormSubmitted" name="promotionSelectFormSubmitted" value="true" />
						<input type="hidden" id="promotionId" name="promotionId" value="<?php echo($aPage->promotionId); ?>" />
						<input id="Select" name="Select" value="Select" type="image" title="Edit" src="<?=_URL_;?>styles/images/pencil.png" class="button" />
					</form>
					
					<label><strong><?php echo $aPage->promotionTitle; ?></strong> - Start <?php echo $aPage->promotionStart; ?> to <?php echo $aPage->promotionUntill; ?> <?php echo $ath; ?></label>
					<br style="margin-bottom:5px;" />
				<?php } ?>
			</div><br/>	<!-- n contentCurrent -->
		</div>	<!-- n gadgetblock -->
	</div>	<!-- n gadget -->
</div>	<!-- n leftblock vertsortabl -->
