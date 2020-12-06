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
	$currentPage->promotionStart = $_POST['promotionStart'];
	$currentPage->promotionUntill = $_POST['promotionUntill'];
	$currentPage->promotionVisible = $_POST['promotionVisible'];
	$currentPage->promotionCode = $_POST['promotionCode'];
	$currentPage->promotionDiscount = $_POST['promotionDiscount'];
	$currentPage->promotionFreeShipping = $_POST['promotionFreeShipping'];
	
	/*
	$IMAGES = new smImage;
	$uploaddir1 = "upload_pictures/";
	$limitSize=1024000;		//1mb
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
	*/
	
	//See if this is an update or an insert
	if($currentPage->promotionId==''){ 	//INSERT
		$PROMOTIONID=$currentPage->InsertCoupon($currentPage);
		$currentPage=null;	
	}else{  //UPDATE
		$PROMOTIONID=$currentPage->UpdateCoupon($currentPage);
		$currentPage=null;
	}

	echo ("<script>window.location='"._URL_."admin_coupon';</script>");
	
}

//Page Deleted
if($_POST['promotionDeleteFormSubmitted']=='true'){
	smPromotion::DeleteCoupon($_POST['promotionId']);
}

$currentPages = $currentPages->GetAllCoupon();
//print_r($currentPages);

?>

<div class="vertsortable" style="width:50%; margin: 0 auto;">
	<!-- gadget left 1 -->
	<div class="gadget">
		<div class="titlebar vertsortable_head">
			<!--<a href="#" class="hidegadget" rel="hide_block"><img src="<?//=_URL_;?>styles/images/spacer.gif" alt="picture" width="19" height="33" /></a>-->
			<h3>Add / Edit Coupon <a href='<?=$site_admin;?>admin_coupon' title='Clear Form' style="text-decoration:none; font-weight:normal;">(Clear Form)</a></h3>
		</div>
		<div class="gadgetblock">
			<form id="contentAddEdit" action="<?=$site_admin; ?>admin_coupon" method="post" enctype="multipart/form-data">
				<?php if(!empty($erContent)){ echo('<p class="validationArea">'.$erContent.'</p>'); } ?>
				<?php smControls::smTextBox("Title", "promotionTitle", $currentPage->promotionTitle); ?><br />
				<?php smControls::smTextBox("Promotion Code", "promotionCode", $currentPage->promotionCode); ?><br /><br/>
				
				<div <?php echo $showhiddendivdiscount; ?>>
					<?php smControls::smTextBox("How many percen for discount?", "promotionDiscount", $currentPage->promotionDiscount); ?><br />
				</div><br />

				<?php smControls::smTextBox("Start date", "promotionStart", $currentPage->promotionStart); ?><br />
				<?php smControls::smTextBox("Untill date", "promotionUntill", $currentPage->promotionUntill); ?><br />
				
				<?php
				/*
				if(!empty($currentPage->promotionBanner)){
					echo "<img src='"._URL_."upload_pictures/{$currentPage->promotionBanner}' style='width:99%; margin:10px 0;' />";
				}
				*/
				?><!--<br/>
				<input type="hidden" id="hiddenPromotionBanner" name="hiddenPromotionBanner" value="<?php //echo($currentPage->promotionBanner); ?>" />
				<?php //smControls::smFileUpload("Upload picture (fix size 694 x 246px)", "promotionBanner", ""); ?><br/><br/>-->
				
				<?php smControls::smCheckBox("Includes free shipping?", "promotionFreeShipping","1", $currentPage->promotionFreeShipping); ?><br /><br/>
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
			<h3>Coupon</h3>
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
					<form id="pageDeleteForm" action="<?=$site_admin; ?>admin_coupon" method="post">
						<input type="hidden" id="promotionDeleteFormSubmitted" name="promotionDeleteFormSubmitted" value="true" />
						<input type="hidden" id="promotionId" name="promotionId" value="<?php echo($aPage->promotionId); ?>" />
						<input id="Delete" name="Delete" value="<?php echo($aPage->promotionId); ?>" title="Delete" type="image" src="<?=_URL_;?>styles/images/cross.png" class="button" onclick="javascript:return confirm('Are you sure...?')" />			
					</form>
					<form id="pageSelect" method="post" action="<?=$site_admin; ?>admin_coupon">
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
