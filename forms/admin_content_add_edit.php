<?php
include_once("includes/tiny_mce_script.php");
include_once("includes/script.php");

/**
 * Title:-
 * Description:-
 * @copyright 2008
 */
 
//Add edit code moved to admin_content_current_pages.php - allows update to take place before current page list is built

function fillParentNodeDDL($selectedNode){
	$parentNodes = new smContent;
	$parentNodes = $parentNodes->GetParentNodes();
	foreach($parentNodes as $aNode){
		if($selectedNode==$aNode->id){
			$selected="SELECTED";
		}else{
			$selected="";
		}
		echo("<option value='".$aNode->id."' ".$selected.">".$aNode->pageName."</option>");
	}
}

?>

<div class="vertsortable" style="width:60%; margin: 0 auto;">
	<!-- gadget left 1 -->
	<div class="gadget">
		<div class="titlebar vertsortable_head">
			<!--<a href="#" class="hidegadget" rel="hide_block"><img src="<?//=_URL_;?>styles/images/spacer.gif" alt="picture" width="19" height="33" /></a>-->
			<h3>Edit Page / Slide</h3>
		</div>
		<div class="gadgetblock">
			<form id="contentAddEdit" action="<?=$site_admin; ?>admin_content.php" method="post" enctype="multipart/form-data">
				<center><p><a href='<?=$site_admin;?>admin_content.php' title='Clear Form' style="text-decoration:none;">(Clear Form)</a></p></center>
				<?php if(!empty($erContent)){ echo('<p class="validationArea">'.$erContent.'</p>'); } ?>
				<?php smControls::smTextBox("Page", "pageName", $currentPage->pageName); ?><br />
				<?php smControls::smTextBox("Title", "linkTitle", $currentPage->linkTitle); ?><br />
				
				<label for="Parent">Parent node</label>
				<select id="parentCategory" name="parentCategory">
					<!--<option value="0">Root</option>-->
					<?php fillParentNodeDDL($currentPage->parentNode); ?>
				</select><br />

				<label>Content</label><br/>
				<textarea name="textContent" id="textContent" class="tinymce"><?=stripcslashes($currentPage->content);?></textarea><br/>
				
				<?php smControls::smCheckBox("Show left menu?", "showleftmenu","1", $currentPage->showleftmenu); ?><br />
				<?php smControls::smCheckBox("Visible?", "published","1", $currentPage->published); ?><br /><br/>
				
				<input type="hidden" name="linkId" id="linkId" value="<?php echo($currentPage->id);?>" />
				<input type="hidden" name="addEditContentFormSubmitted" id="addEditContentFormSubmitted" value="true" />
				<input type="submit" value="Save" style="cursor:pointer;" />
			</form><br/>
		</div>	<!-- n gadgetblock -->
	</div>	<!-- n gadget -->
</div><br/>	<!-- n leftblock vertsortabl -->

