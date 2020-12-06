<div class="vertsortable" style="width:50%; margin: 0 auto;">
	<!-- gadget left 1 -->
	<div class="gadget">
		<div class="titlebar vertsortable_head">
			<!--<a href="#" class="hidegadget" rel="hide_block"><img src="<?//=_URL_;?>styles/images/spacer.gif" alt="picture" width="19" height="33" /></a>-->
			<h3>
				Add / Edit News Letter
				<a href="<?php echo _URL_; ?>admin_newsletter" title="Clear Form" style="text-decoration:none; font-weight:normal;">(Clear Form)</a>
			</h3>
		</div>
		<div class="gadgetblock">
			<form id="contentAddEdit" action="<?=$site_admin; ?>admin_newsletter" method="post" enctype="multipart/form-data">
				<?php if(!empty($erContent)){ echo('<p class="validationArea">'.$erContent.'</p>'); } ?>
				<?php smControls::smTextBox("Title", "catalogueName", $currentPage->catalogueName); ?><br />
				
				<!--
				<label>Descriptions</label>
				<textarea name="catalogueDescriptions" id="catalogueDescriptions" class="tinymce" style="height:250px; width:100%;"><?//=stripcslashes($currentPage->catalogueDescriptions);?></textarea>
				<br />
				-->
				
				<?php smControls::smFileUpload("Upload Screenshort", "catalogueImage", $currentPage->catalogueImage); ?><br/>
				<?php
				if(!empty($currentPage->catalogueImage)){
					echo "<img src='{$site_admin}upload_pictures/{$currentPage->catalogueImage}' alt='' width='100' height='75' style='border:solid 2px #FF0000;'  />
					<a href='{$site_admin}admin_settings/?catalogueId={$currentPage->catalogueId}&screenshortDeleteSubmitted=true&imName={$currentPage->catalogueImage}'>
						<img src='"._URL_."styles/images/delete2.gif' alt='Delete' title='Delete' />
					</a>";
				}
				?><br />
				
				<?php smControls::smFileUpload("Upload PDF", "cataloguePdf", $currentPage->cataloguePdf); ?><br/>
				<?php
				if(!empty($currentPage->cataloguePdf)){
					echo "<img src='{$site_admin}upload_pictures/{$currentPage->cataloguePdf}' alt='' width='100' height='75' style='border:solid 2px #FF0000;'  />
					<a href='{$site_admin}admin_settings/?catalogueId={$currentPage->catalogueId}&pdfDeleteSubmitted=true&imName={$currentPage->cataloguePdf}'>
						<img src='"._URL_."styles/images/delete2.gif' alt='Delete' title='Delete' />
					</a>";
				}
				?><br />
				
				<?php smControls::smCheckBox("Visible?", "catalogueVisible","1", $currentPage->catalogueVisible); ?><br /><br/>
				
				<input type="hidden" name="catalogueId" id="catalogueId" value="<?php echo($currentPage->catalogueId);?>" />
				<input type="hidden" id="photohidden" name="photohidden" value="<?php echo($currentPage->photohidden); ?>" />
				<input type="hidden" id="pdfhidden" name="pdfhidden" value="<?php echo($currentPage->pdfhidden); ?>" />
				<input type="hidden" name="addEditCatalogueFormSubmitted" id="addEditCatalogueFormSubmitted" value="true" />
				<input type="submit" value="Save" style="cursor:pointer;" />
			</form><br/>
		</div>	<!-- n gadgetblock -->
	</div>	<!-- n gadget -->
</div><br/>		<!-- n leftblock vertsortabl -->