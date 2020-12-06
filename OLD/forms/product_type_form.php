<form id="productTypeForm" method="post" action="<?php echo($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data">
	<fieldset>
		<legend>Add/Edit products</legend>
		<?php smControls::smHiddenText("ptId",$selectedProductType->ptId);?>
		<?php smControls::smTextBox("Name","ptName",$selectedProductType->ptName);?><br />
		<?php smControls::smDropDownList("Category","ptPcId",tsProductCategory::getCategoriesForDDL(),$selectedProductType->pcId,"","",true);?><br />
		<?php smControls::smCheckBox("Available","ptAvailable","1",$selectedProductType->ptAvailable);?><br />
		<?php smControls::smTextBox("Price (&pound;)","ptPrice",$selectedProductType->ptPrice,"class='numeric'");?><br />
		<?php smImages::showThumb($selectedProductType->ptImagePath,$selectedProductType->ptName,180);?>
		<?php smControls::smFileUpload("Image","ptImage","");?><br />
		<?php smControls::smButton("Save","ptSave");?>		
	</fieldset>
</form>