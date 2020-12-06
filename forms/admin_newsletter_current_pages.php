<?php

$currentPages = new smCatalogue;
$currentPage = new smCatalogue;

//Move up
if($_POST['catalogueIUpSelected']=='true'){
	$currentPage->MoveUp($_POST['catalogueId']);
	$_POST['catalogueId'] = "";
}

//Move down
if($_POST['catalogueIDownSelected']=='true'){
	$currentPage->MoveDown($_POST['catalogueId']);
	$_POST['catalogueId'] = "";
}

//See if the a page has been selected
if($_POST['catalogueId']!=''){
	//echo($_POST['catalogueId']);
	$currentPage = $currentPage->GetMenuAndPages($_POST['catalogueId'], true);
	$currentPage = $currentPage[0]; //Only one page so whip it out of the returned array
}

$erContent = "";
//See if the Add/Edit form has been submitted
if($_POST['addEditCatalogueFormSubmitted']=='true'){
	if(!empty($_POST['catalogueName'])){
		//Populate $currentPageValues
		$currentPage->catalogueId = $_POST['catalogueId'];
		$currentPage->catalogueName = $_POST['catalogueName'];
		$currentPage->catalogueVisible = $_POST['catalogueVisible'];
		$currentPage->catalogueDescriptions = $_POST['catalogueDescriptions'];
		
		$uploaddircate = "upload_pictures/";
		$limitSize=1024000;		//1mb
		$limitSize2=5120000;		//5mb
		$tt=mktime();

		// upload picture
		if($_FILES['catalogueImage']['tmp_name']!=""){
			$uploadimgcate= $tt."-catalogue-ss-".str_replace(" ","-",$_FILES['catalogueImage']['name']);
			if(filesize($_FILES['catalogueImage']['tmp_name'])<=$limitSize){				
				if(copy($_FILES['catalogueImage']['tmp_name'], $uploaddircate.$uploadimgcate)){
					$currentPage->catalogueImage = $uploadimgcate;
					//chmod($root."upload_pictures/".$uploadbg,0644);
				}else{
					$currentPage->catalogueImage = $_POST['photohidden'];
				}
			}else{
				echo "<script>alert('Your picture size more than 1mb ....... please try again!!!.');</script>";
			}
		}else{
			$currentPage->catalogueImage = $_POST['photohidden'];
		}
		// ----------- n save images -----------
		
		// upload PDF
		if($_FILES['cataloguePdf']['tmp_name']!=""){
			$uploadimgcate= $tt."-catalogue-pdf-".str_replace(" ","-",$_FILES['cataloguePdf']['name']);
			if(filesize($_FILES['cataloguePdf']['tmp_name'])<=$limitSize2){				
				if(copy($_FILES['cataloguePdf']['tmp_name'], $uploaddircate.$uploadimgcate)){
					$currentPage->cataloguePdf = $uploadimgcate;
					//chmod($root."upload_pictures/".$uploadbg,0644);
				}else{
					$currentPage->cataloguePdf = $_POST['pdfhidden'];
				}
			}else{
				echo "<script>alert('Your PDF size more than 5mb ....... please try again!!!.');</script>";
			}
		}else{
			$currentPage->cataloguePdf = $_POST['pdfhidden'];
		}
		// ----------- n save PDF -----------
	
		//See if this is an update or an insert
		if($currentPage->catalogueId==''){ 	//INSERT
			$currentPage->Insert($currentPage);
			$currentPage=null;	
		}else{  //UPDATE
			$currentPage->Update($currentPage);
			$currentPage=null;
		}
	}else{
		$erContent = "Please ensure all required fields are completed";		
	}
}

//Page Deleted
if($_POST['catalogueIDeleteFormSubmitted']=='true'){
	smCatalogue::Delete($_POST['catalogueId']);
}

if($_GET['screenshortDeleteSubmitted']=='true'){
	$sqldeletecateimage = mysql_query("UPDATE ex_catalogue SET catalogueImage='' WHERE catalogueId='".$_REQUEST['catalogueId']."' ");	
	@unlink($root.'upload_pictures/'.$_REQUEST['imName']);	// remove picture in folder
	//echo "<script language='javascript' type='text/javascript'>history.go(-1);</script>";
}

if($_GET['pdfDeleteSubmitted']=='true'){
	$sqldeletecateimage = mysql_query("UPDATE ex_catalogue SET cataloguePdf='' WHERE catalogueId='".$_REQUEST['catalogueId']."' ");	
	@unlink($root.'upload_pictures/'.$_REQUEST['imName']);	// remove picture in folder
	//echo "<script language='javascript' type='text/javascript'>history.go(-1);</script>";
}

$currentPages = $currentPages->GetMenuAndPages(null, true);
//print_r($currentPages);

?>
<div class="vertsortable" style="width:50%; margin: 0 auto;">
	<!-- gadget left 1 -->
	<div class="gadget">
		<div class="titlebar vertsortable_head">
			<!--<a href="#" class="hidegadget" rel="hide_block"><img src="<?//=_URL_;?>styles/images/spacer.gif" alt="picture" width="19" height="33" /></a>-->
			<h3>News Letter</h3>
		</div>
		<div class="gadgetblock">
			<div id="contentCurrent">
				<?php foreach($currentPages as $aPage){ ?>
					<form id="pageDeleteForm" action="<?=$site_admin; ?>admin_newsletter" method="post">
						<input type="hidden" id="catalogueIDeleteFormSubmitted" name="catalogueIDeleteFormSubmitted" value="true" />
						<input type="hidden" id="catalogueId" name="catalogueId" value="<?php echo($aPage->catalogueId); ?>" />
						<input id="Delete" name="Delete" value="<?php echo($aPage->catalogueId); ?>" title="Delete" type="image" src="<?=_URL_;?>styles/images/cross.png" class="button" onclick="javascript:return confirm('Are you sure...?')" />			
					</form>
					<form id="pageSelect" method="post" action="<?=$site_admin; ?>admin_newsletter">
						<input type="hidden" id="catalogueISelectFormSubmitted" name="catalogueISelectFormSubmitted" value="true" />
						<input type="hidden" id="catalogueId" name="catalogueId" value="<?php echo($aPage->catalogueId); ?>" />
						<input id="Select" name="Select" value="Select" type="image" title="Edit" src="<?=_URL_;?>styles/images/pencil.png" class="button" />
					</form>
					<form id="pageUp" method="post" action="<?=$site_admin; ?>admin_newsletter">
						<input type="hidden" id="catalogueIUpSelected" name="catalogueIUpSelected" value="true" />
						<input type="hidden" id="catalogueId" name="catalogueId" value="<?php echo($aPage->catalogueId);?>" />
						<input id="Select" name="Select" value="Select" type="image" title="Move up" src="<?=_URL_;?>styles/images/up.gif" class="button" />	
					</form>
					<form id="pageDown" method="post" action="<?=$site_admin; ?>admin_newsletter">
						<input type="hidden" id="catalogueIDownSelected" name="catalogueIDownSelected" value="true" />
						<input type="hidden" id="catalogueId" name="catalogueId" value="<?php echo($aPage->catalogueId);?>" />
						<input id="Select" name="Select" value="Select" type="image" title="Move down" src="<?=_URL_;?>styles/images/down.gif" class="button" />	
					</form>
					
					<?php
						if($aPage->catalogueVisible==1){
							echo "";
						}else{
							echo "<img src='"._URL_."styles/images/hidden.gif' alt='' title='' />";
						}
					?>
					<label><?php echo($aPage->catalogueName);?></label><br style="margin-bottom:5px;" />
					<?php
				}
				?>
			</div><br/>	<!-- n contentCurrent -->
		</div>	<!-- n gadgetblock -->
	</div>	<!-- n gadget -->
</div>	<!-- n leftblock vertsortabl -->
