<form id="productCategoryForm" method="post" action="<?php echo($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data">
	<fieldset>
		<legend>Add/Edit product categories</legend>
		<?php echo($productCategoryError);?>
		<?php smControls::smHiddenText("pcId",$selectedProductCategory->pcId);?>
		<?php smControls::smTextBox("Name","pcName",$selectedProductCategory->pcName);?><br />
		<?php smControls::smDropDownList("Parent category","pcPcId",tsProductCategory::getCategoriesForDDL(),$selectedProductCategory->pcPcId,"","",true);?><br />
		<?php smControls::smDropDownList("Measurement group","pcPmgId",tsProductMeasurmentGroup::pmgGetKeyValueArray(),$selectedProductCategory->pcPmgId,"","",true);?><br />
		<?php smControls::smTextArea("Description","pcDescription",$selectedProductCategory->pcDescription);?><br />
		<?php smControls::smFileUpload("Category Image", "pcImage");?><br />
		<?php smControls::smButton("Save","pcSave");?>
	</fieldset>
</form>