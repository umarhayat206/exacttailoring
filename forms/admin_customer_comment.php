<?php

$currentPages = new smComment;
//$currentPage = new smComment;

//See if the a page has been selected
if($_POST['commentId']!=''){
	//echo($_POST['commentId']);
	$currentPage = smComment::GetComment($_POST['commentId']);
	
}

$erContent = "";
//See if the Add/Edit form has been submitted
if($_POST['addEditCommentFormSubmitted']=='true'){
	$currentPage->commentId = $_POST['commentId'];
	$currentPage->commentName = $_POST['commentName'];
	$currentPage->commentVisible = $_POST['commentVisible'];
	$currentPage->commentDescriptions = mysql_real_escape_string($_POST['commentDescriptions']);
	
	//See if this is an update or an insert
	if($currentPage->commentId==''){ 	//INSERT
		smComment::Insert($currentPage);
		$currentPage=null;	
	}else{  //UPDATE
		smComment::Update($currentPage);
		$currentPage=null;
	}
}

//Page Deleted
if($_POST['commentDeleteFormSubmitted']=='true'){
	smComment::Delete($_POST['commentId']);
}

$currentPages = $currentPages->GetAllComment(true);
//print_r($currentPages);
?>

<div class="vertsortable" style="width:50%; margin: 0 auto;">
	<!-- gadget left 1 -->
	<div class="gadget">
		<div class="titlebar vertsortable_head">
			<!--<a href="#" class="hidegadget" rel="hide_block"><img src="<?//=_URL_;?>styles/images/spacer.gif" alt="picture" width="19" height="33" /></a>-->
			<h3>Add / Edit Comment <a href='<?=$site_admin;?>admin_customer_comment' title='Clear Form' style="text-decoration:none; font-weight:normal;">(Clear Form)</a></h3>
		</div>
		<div class="gadgetblock">
			<form id="contentAddEdit" action="<?=$site_admin; ?>admin_customer_comment" method="post" enctype="multipart/form-data">
				<?php if(!empty($erContent)){ echo('<p class="validationArea">'.$erContent.'</p>'); } ?>
				<?php smControls::smTextBox("Customer Name", "commentName", $currentPage->commentName); ?><br />
				
				<label>Comment</label>
				<textarea name="commentDescriptions" id="commentDescriptions" class="tinymce" style="height:100px; width:100%;"><?=stripcslashes($currentPage->commentDescriptions);?></textarea><br/>
				<br />
				<?php smControls::smCheckBox("Visible?", "commentVisible","1", $currentPage->commentVisible); ?><br /><br/>
				
				<input type="hidden" name="commentId" id="commentId" value="<?php echo($currentPage->commentId);?>" />
				<input type="hidden" name="addEditCommentFormSubmitted" id="addEditCommentFormSubmitted" value="true" />
				<input type="submit" value="Save" style="cursor:pointer;" />
			</form><br/>
		</div>	<!-- n gadgetblock -->
	</div>	<!-- n gadget -->
	
	<!-- gadget left 1 -->
	<div class="gadget">
		<div class="titlebar vertsortable_head">
			<!--<a href="#" class="hidegadget" rel="hide_block"><img src="<?//=_URL_;?>styles/images/spacer.gif" alt="picture" width="19" height="33" /></a>-->
			<h3>Comments</h3>
		</div>
		<div class="gadgetblock">
			<div id="contentCurrent">
				<?php foreach($currentPages as $aPage){ ?>
					<form id="pageDeleteForm" action="<?=$site_admin; ?>admin_customer_comment" method="post">
						<input type="hidden" id="commentDeleteFormSubmitted" name="commentDeleteFormSubmitted" value="true" />
						<input type="hidden" id="commentId" name="commentId" value="<?php echo($aPage->commentId); ?>" />
						<input id="Delete" name="Delete" value="<?php echo($aPage->commentId); ?>" title="Delete" type="image" src="<?=_URL_;?>styles/images/cross.png" class="button" onclick="javascript:return confirm('Are you sure...?')" />			
					</form>
					<form id="pageSelect" method="post" action="<?=$site_admin; ?>admin_customer_comment">
						<input type="hidden" id="commentSelectFormSubmitted" name="commentSelectFormSubmitted" value="true" />
						<input type="hidden" id="commentId" name="commentId" value="<?php echo($aPage->commentId); ?>" />
						<input id="Select" name="Select" value="Select" type="image" title="Edit" src="<?=_URL_;?>styles/images/pencil.png" class="button" />
					</form>
					<label><?php echo date("Y-m-d H:i:s" ,$aPage->commentDate); ?>- <strong><?php echo $aPage->commentName; ?></strong></label><br style="margin-bottom:5px;" />
				<?php } ?>
			</div><br/>	<!-- n contentCurrent -->
		</div>	<!-- n gadgetblock -->
	</div>	<!-- n gadget -->
</div>	<!-- n leftblock vertsortabl -->
