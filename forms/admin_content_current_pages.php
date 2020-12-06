<?php

/**
 * Title:-
 * Description:-
 * @copyright 2008
 */

$currentPages = new smContent;
$currentPage = new smContent;

//Move up
if($_POST['pageUpSelected']=='true'){
	$currentPage->MoveUp($_POST['linkId'], $_POST['pageLevel']);
	$_POST['linkId'] = "";
}

//Move down
if($_POST['pageDownSelected']=='true'){
	$currentPage->MoveDown($_POST['linkId'], $_POST['pageLevel']);
	$_POST['linkId'] = "";
}

//See if the a page has been selected
if($_REQUEST['linkId']!=''){
	//echo($_POST['linkId']);
	$currentPage = $currentPage->GetMenuAndPages($_POST['linkId'], true);
	$currentPage = $currentPage[0]; //Only one page so whip it out of the returned array
}

$erContent = "";
//See if the Add/Edit form has been submitted
if($_POST['addEditContentFormSubmitted']=='true'){
	if(!empty($_POST['linkTitle'])){
		//Populate $currentPageValues
		$currentPage->id = $_POST['linkId'];
		$currentPage->pageName = $_POST['pageName'];
		$currentPage->linkTitle = $_POST['linkTitle'];
		$currentPage->parentCategory = $_POST['parentCategory'];	// $_POST['parentNode']
		$currentPage->content = mysql_real_escape_string($_POST['textContent']);
		$currentPage->showleftmenu = $_POST['showleftmenu'];
		$currentPage->published = $_POST['published'];
		
		//See if this is an update or an insert
		if($currentPage->id==''){ //INSERT
			$CONTENTID=$currentPage->Insert($currentPage);
			$currentPage=null;	
		}else{  //UPDATE
			$CONTENTID=$currentPage->Update($currentPage);
			$currentPage=null;
		}

	}else{
		$erContent = "Please ensure all required fields are completed";		
	}
}

if($_GET['imageDeleteAll']==true){
	$IMAGES = smImage::GetAllImage($_GET['linkId'], 3);
	foreach ($IMAGES as $image){
		smImage::Delete($image->imId,$image->imPhysicalPath);
	}
	echo ("<script>window.location='"._URL_."admin_content.php?linkId={$_GET['linkId']}';</script>");
}

if ($_GET['imageDeleteSubmitted']==true){
	$IMAGES = new smImage;
 	$IMAGES->Delete($_GET['imId'],$_GET['imName']);
	echo ("<script>window.location='"._URL_."admin_content.php?linkId={$_GET['linkId']}';</script>");
}

//Page Deleted
if($_POST['pageDeleteFormSubmitted']=='true'){
	smContent::Delete($_POST['linkId']);
	echo ("<script>window.location='"._URL_."admin_content.php';</script>");
}

$currentPages = $currentPages->GetMenuAndPages(null, true);
//print_r($currentPages);
?>

<div class="vertsortable" style="width:60%; margin: 0 auto;">
	<!-- gadget left 1 -->
	<div class="gadget">
		<div class="titlebar vertsortable_head">
			<!--<a href="#" class="hidegadget" rel="hide_block"><img src="<?//=_URL_;?>styles/images/spacer.gif" alt="picture" width="19" height="33" /></a>-->
			<h3>Page</h3>
		</div>
		<div class="gadgetblock">
			<div id="contentCurrent">
				<?php
				foreach($currentPages as $aPage){
					if($aPage->parentNode>0){
						echo("<span class='indent'>&nbsp</span>");
					?>
					
					<form id="pageDeleteForm" action="<?=$site_admin; ?>admin_content.php" method="post">
						<input type="hidden" id="pageDeleteFormSubmittedaccept" name="pageDeleteFormSubmitted" value="true" />
						<input type="hidden" id="linkId" name="linkId" value="<?php echo($aPage->id); ?>" />
						<input id="Delete" name="Delete" value="<?php echo($aPage->id); ?>" title="Delete" type="image" src="<?=_URL_;?>styles/images/delete.gif" class="button" onclick="javascript:return confirm('Are you sure...?')" />			
					</form>
					
					<form id="pageSelect" method="post" action="<?=$site_admin; ?>admin_content.php">
						<input type="hidden" id="pageSelectFormSubmitted" name="pageSelectFormSubmitted" value="true" />
						<input type="hidden" id="linkId" name="linkId" value="<?php echo($aPage->id); ?>" />
						<input id="Select" name="Select" value="Select" type="image" title="Edit details" src="<?=_URL_;?>styles/images/select.gif" class="button" />
					</form>
					
					<form id="pageUp" method="post" action="<?=$site_admin; ?>admin_content.php">
						<input type="hidden" id="pageUpSelected" name="pageUpSelected" value="true" />
						<input type="hidden" id="pageLevel" name="pageLevel" value="<?php echo($aPage->parentNode);?>"/>
						<input type="hidden" id="linkId" name="linkId" value="<?php echo($aPage->id);?>" />
						<input id="Select" name="Select" value="Select" type="image" title="Move up" src="<?=_URL_;?>styles/images/up.gif" class="button" />	
					</form>
					<form id="pageDown" method="post" action="<?=$site_admin; ?>admin_content.php">
						<input type="hidden" id="pageDownSelected" name="pageDownSelected" value="true" />
						<input type="hidden" id="pageLevel" name="pageLevel" value="<?php echo($aPage->parentNode);?>"/>
						<input type="hidden" id="linkId" name="linkId" value="<?php echo($aPage->id);?>" />
						<input id="Select" name="Select" value="Select" type="image" title="Move down" src="<?=_URL_;?>styles/images/down.gif" class="button" />	
					</form>

					<?php
					if($aPage->showleftmenu == 1){
						$showleft = "<img src='"._URL_."styles/images/primary.gif' alt='show left menu' title='show left menu' />";
					}else{
						$showleft = "";
					}
					
					if($aPage->published == 1){
						$hiddenpage = "";
					}else{
						$hiddenpage = "<img src='"._URL_."styles/images/hidden.gif' alt='hidden' title='hidden' />";
					}
					?>
					<label><?php echo $hiddenpage." ".$aPage->pageName; ?></label><?php echo $showleft; ?><br style="margin-bottom:5px;" />
					
					<?php }else{ ?>

					<br/>
					<label><strong><?php echo($aPage->pageName); ?></strong></label><br style="margin-bottom:5px;" />
					
					<?php
					}
				}
				?>
			</div><br/>	<!-- n contentCurrent -->
		</div>	<!-- n gadgetblock -->
	</div>	<!-- n gadget -->
</div>	<!-- n leftblock vertsortabl -->
