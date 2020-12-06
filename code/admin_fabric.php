<?php
/*
function fillParentNodeDDL($selectedNode){
	$parentNodes = new smFabric;
	$parentNodes = $parentNodes->GetParentNodes();
	foreach($parentNodes as $aNode){
		if($selectedNode==$aNode->fabricId){
			$selected="SELECTED";
		}else{
			$selected="";
		}
		echo("<option value='".$aNode->fabricId."' ".$selected.">".$aNode->fabricName."</option>");
	}
}
*/

$currentPages = new smFabric;
$currentPage = new smFabric;

//Move up
if($_POST['fabricIUpSelected']=='true'){
	$currentPage->MoveUp($_POST['fabricId']);
	$_POST['fabricId'] = "";
}

//Move down
if($_POST['fabricIDownSelected']=='true'){
	$currentPage->MoveDown($_POST['fabricId']);
	$_POST['fabricId'] = "";
}

//See if the a page has been selected
if($_POST['fabricId']!=''){
	//echo($_POST['fabricId']);
	$currentPage = $currentPage->GetMenuAndPages($_POST['fabricId'], true);
	$currentPage = $currentPage[0]; //Only one page so whip it out of the returned array
}

$erContent = "";
//See if the Add/Edit form has been submitted
if($_POST['addEditFabricFormSubmitted']=='true'){
	if(!empty($_POST['fabricName'])){
		//Populate $currentPageValues
		$currentPage->fabricId = $_POST['fabricId'];
		$currentPage->fabricName = $_POST['fabricName'];
		$currentPage->fabricVisible = $_POST['fabricVisible'];
		//$currentPage->categoryRootId = $_POST['categoryRootId'];	// $_POST['parentNode']
		$currentPage->fabricDescriptions = $_POST['fabricDescriptions'];
		$currentPage->fabricShortDescriptions = $_POST['fabricShortDescriptions'];

		$currentPage->isShowPrevPrice = $_POST['isShowPrevPrice'];
		$currentPage->PrevPricePercentage = $_POST['PrevPricePercentage'];
		
		$uploaddircate = "upload_pictures/";
		$limitSize=1024000;		//1mb
		$tt=mktime();

		// upload picture
		if($_FILES['fabricImage']['tmp_name']!=""){
			$uploadimgcate= $tt."-fabric-".str_replace(" ","-",$_FILES['fabricImage']['name']);
			if(filesize($_FILES['fabricImage']['tmp_name'])<=$limitSize){				
				if(copy($_FILES['fabricImage']['tmp_name'], $uploaddircate.$uploadimgcate)){
					$currentPage->fabricImage = $uploadimgcate;
					//chmod($root."upload_pictures/".$uploadbg,0644);
				}else{
					$currentPage->fabricImage = $_POST['photohidden3'];
				}
			}else{
				echo "<script>alert('Your picture size more than 1mb ....... please try again!!!.');</script>";
			}
		}else{
			$currentPage->fabricImage = $_POST['photohidden3'];
		}
		// ----------- n save images -----------
	
		//See if this is an update or an insert
		if($currentPage->fabricId==''){ 	//INSERT
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
if($_POST['fabricIDeleteFormSubmitted']=='true'){
	smFabric::Delete($_POST['fabricId']);
}

if($_GET['imageFabricDeleteSubmitted']=='true'){
	$sqldeletecateimage = mysql_query("UPDATE ex_fabric SET fabricImage='' WHERE fabricId='".$_REQUEST['fabricId']."' ");	
	@unlink($root.'upload_pictures/'.$_REQUEST['imName']);	// remove picture in folder
	//echo "<script language='javascript' type='text/javascript'>history.go(-1);</script>";
}

$currentPages = $currentPages->GetMenuAndPages(null, true);
//print_r($currentPages);
?>

<div class="leftblock vertsortable" style="width:30%; float:left;">
	<!-- gadget left 1 -->
	<div class="gadget">
		<div class="titlebar vertsortable_head">
			<!--<a href="#" class="hidegadget" rel="hide_block"><img src="<?//=_URL_;?>styles/images/spacer.gif" alt="picture" width="19" height="33" /></a>-->
			<h3>Add / Edit Fabric Type<a href='<?=$site_admin;?>admin_settings' title='Clear Form' style="text-decoration:none; font-weight:normal;">(Clear Form)</a></h3>
		</div>
		<div class="gadgetblock">
			<form id="contentAddEdit" action="<?=$site_admin; ?>admin_settings" method="post" enctype="multipart/form-data">
				<?php if(!empty($erContent)){ echo('<p class="validationArea">'.$erContent.'</p>'); } ?>
				<?php smControls::smTextBox("Fabric Name", "fabricName", $currentPage->fabricName); ?><br />
				<?php smControls::smCheckBox("Is show previous price?", "isShowPrevPrice","1", $currentPage->isShowPrevPrice); ?><br />
				<?php smControls::smTextBox("Previous price (%)", "PrevPricePercentage", $currentPage->PrevPricePercentage); ?><br /><br/>
				<!--<label for="Parent">Select parent category</label>-->
				<!--<select id="categoryRootId" name="categoryRootId">-->
				<!--<option value="0">Root</option>-->
				<?php //fillParentNodeDDL($currentPage->categoryRootId); ?>
				<!--</select><br />-->
				
				<!--<label for="Parent">Select parent category</label>-->
				<!--<select id="categoryRootId" name="categoryRootId">-->
				<!--	<?php //echo mainCateDropDownList($currentPage->categoryRootId); ?>-->
				<!--</select><br />-->
				
				<label>Short Descriptions</label>
				<textarea name="fabricShortDescriptions" id="fabricShortDescriptions" style="height:50px; width:100%;"><?=stripcslashes($currentPage->fabricShortDescriptions);?></textarea>
				<br />
				
				<label>Descriptions</label>
				<textarea name="fabricDescriptions" id="fabricDescriptions" class="tinymce" style="height:250px; width:100%;"><?=stripcslashes($currentPage->fabricDescriptions);?></textarea>
				<br />

				<?php smControls::smFileUpload("Upload picture", "fabricImage", $currentPage->fabricImage); ?><br/>
				<?php
				if(!empty($currentPage->fabricImage)){
					echo "<img src='{$site_admin}upload_pictures/{$currentPage->fabricImage}' alt='' width='100' height='75' style='border:solid 2px #FF0000;'  />
					<a href='{$site_admin}admin_settings/?fabricId={$currentPage->fabricId}&imageFabricDeleteSubmitted=true&imName={$currentPage->fabricImage}'>
						<img src='"._URL_."styles/images/delete2.gif' alt='Delete' title='Delete' />
					</a>";
				}
				?><br />
			
				<?php smControls::smCheckBox("Visible?", "fabricVisible","1", $currentPage->fabricVisible); ?><br /><br/>
				
				<input type="hidden" name="fabricId" id="fabricId" value="<?php echo($currentPage->fabricId);?>" />
				<input type="hidden" id="photohidden3" name="photohidden3" value="<?php echo($currentPage->fabricImage); ?>" />
				<input type="hidden" name="addEditFabricFormSubmitted" id="addEditFabricFormSubmitted" value="true" />
				<input type="submit" value="Save" style="cursor:pointer;" />
			</form><br/>
		</div>	<!-- n gadgetblock -->
	</div>	<!-- n gadget -->
	
	<!-- gadget left 1 -->
	<div class="gadget">
		<div class="titlebar vertsortable_head">
			<!--<a href="#" class="hidegadget" rel="hide_block"><img src="<?//=_URL_;?>styles/images/spacer.gif" alt="picture" width="19" height="33" /></a>-->
			<h3>Fabric Type</h3>
		</div>
		<div class="gadgetblock">
			<div id="contentCurrent">
				<?php
				foreach($currentPages as $aPage){
					/*
					if($aPage->categoryRootId>0){
						echo("<span class='indent'>&nbsp</span>");
						$mcate = "";
					}else{
						$mcate = " style='font-weight:bold;' ";
					}
					*/
					?>
					<form id="pageDeleteForm" action="<?=$site_admin; ?>admin_settings" method="post">
						<input type="hidden" id="fabricIDeleteFormSubmitted" name="fabricIDeleteFormSubmitted" value="true" />
						<input type="hidden" id="fabricId" name="fabricId" value="<?php echo($aPage->fabricId); ?>" />
						<input id="Delete" name="Delete" value="<?php echo($aPage->fabricId); ?>" title="Delete" type="image" src="<?=_URL_;?>styles/images/cross.png" class="button" onclick="javascript:return confirm('Are you sure...?')" />			
					</form>
					<form id="pageSelect" method="post" action="<?=$site_admin; ?>admin_settings">
						<input type="hidden" id="fabricISelectFormSubmitted" name="fabricISelectFormSubmitted" value="true" />
						<input type="hidden" id="fabricId" name="fabricId" value="<?php echo($aPage->fabricId); ?>" />
						<input id="Select" name="Select" value="Select" type="image" title="Edit" src="<?=_URL_;?>styles/images/pencil.png" class="button" />
					</form>
					<form id="pageUp" method="post" action="<?=$site_admin; ?>admin_settings">
						<input type="hidden" id="fabricIUpSelected" name="fabricIUpSelected" value="true" />
						<!--<input type="hidden" id="fabricOrdernumber" name="fabricOrdernumber" value="<?php //echo($aPage->categoryRootId);?>"/>-->
						<input type="hidden" id="fabricId" name="fabricId" value="<?php echo($aPage->fabricId);?>" />
						<input id="Select" name="Select" value="Select" type="image" title="Move up" src="<?=_URL_;?>styles/images/up.gif" class="button" />	
					</form>
					<form id="pageDown" method="post" action="<?=$site_admin; ?>admin_settings">
						<input type="hidden" id="fabricIDownSelected" name="fabricIDownSelected" value="true" />
						<!--<input type="hidden" id="fabricOrdernumber" name="fabricOrdernumber" value="<?php //echo($aPage->categoryRootId);?>"/>-->
						<input type="hidden" id="fabricId" name="fabricId" value="<?php echo($aPage->fabricId);?>" />
						<input id="Select" name="Select" value="Select" type="image" title="Move down" src="<?=_URL_;?>styles/images/down.gif" class="button" />	
					</form>
					<label <?php echo $mcate; ?>><?php echo($aPage->fabricName);?>
					
					<?php if($aPage->isShowPrevPrice==1):?>
					
						<img src="<?=_URL_;?>styles/images/prev_price.png" alt="Showing Previous Price (<?=$aPage->		$sql .="PrevPricePercentage='".$fabric->PrevPricePercentage."' ";
?>%)" />
					<?php endif; ?>
					</label><br style="margin-bottom:5px;" />
					<?php
				}
				?>
			</div><br/>	<!-- n contentCurrent -->
		</div>	<!-- n gadgetblock -->
	</div>	<!-- n gadget -->
</div>	<!-- n leftblock vertsortabl -->
