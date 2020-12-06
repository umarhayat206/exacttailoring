<?php
function fillFacilitiesParentNodeDDL($selectedNode){
	$parentNodes = new smFeature;
	$parentNodes = $parentNodes->GetParentNodes();
	foreach($parentNodes as $aNode){
		if($selectedNode==$aNode->featuresId){
			$selected="SELECTED";
		}else{
			$selected="";
		}
		
		if(!empty($aNode->featuresCategory)){
			$cate = smCategory::getCategory($aNode->featuresCategory);
			$catename = $cate->categoryName." - ";
		}else{
			$catename = "";
		}
		echo("<option value='".$aNode->featuresId."' ".$selected.">".$catename.$aNode->featuresName."</option>");
	}
}

function fillCategoryDDL($selectedNode){
	$parentNodes = new smCategory;
	$parentNodes = $parentNodes->GetMenuAndPages(null, true);

	foreach($parentNodes as $aNode){
		
		if($selectedNode==$aNode->categoryId){
			$selected="SELECTED";
		}else{
			$selected="";
		}
		
		if($aNode->categoryRootId>0){
			echo("<option value='".$aNode->categoryId."' ".$selected.">&nbsp;&nbsp;&nbsp;- ".$aNode->categoryName."</option>");
		}else{
			echo("<option value='".$aNode->categoryId."' ".$selected." disabled='disabled'>".$aNode->categoryName."</option>");
		}
		
	}
}

$currentFeats = new smFeature;
$currentFeat = new smFeature;

//Move up
if($_POST['featesUpSelected']=='true'){
	$currentFeat->MoveUp($_POST['featuresId'], $_POST['featuresOrdernumber']);
	$_POST['featuresId'] = "";
}

//Move down
if($_POST['featesDownSelected']=='true'){
	$currentFeat->MoveDown($_POST['featuresId'], $_POST['featuresOrdernumber']);
	$_POST['featuresId'] = "";
	
}

//See if the a page has been selected
if($_REQUEST['featuresId']!=''){
	//echo($_POST['featuresId']);
	$currentFeat = $currentFeat->GetMenuAndPages($_REQUEST['featuresId'], true);
	$currentFeat = $currentFeat[0]; //Only one page so whip it out of the returned array
}

$erContent = "";
//See if the Add/Edit form has been submitted
if($_POST['addEditFeatureFormSubmitted']=='true'){
	if(!empty($_POST['featuresName'])){
		//Populate $currentFeatValues
		$currentFeat->featuresId = $_POST['featuresId'];
		$currentFeat->featuresName = $_POST['featuresName'];
		$currentFeat->featuresSetHome = $_POST['featuresSetHome'];
		$currentFeat->featuresRootId = $_POST['featuresRootId'];	// $_POST['parentNode']
		$currentFeat->featuresCategory = $_POST['featuresCategory'];
		$currentFeat->featuresDescriptions = mysql_real_escape_string($_POST['featuresDescriptions']);
		
		$uploaddiroption = "upload_pictures/";
		$limitSize=1024000;		//1mb
		$tt=mktime();
		
		// upload picture
		if($_FILES['featuresPicture']['tmp_name']!=""){
			$uploadimgoption= $tt."-option-".str_replace(" ","-",$_FILES['featuresPicture']['name']);
			if(filesize($_FILES['featuresPicture']['tmp_name'])<=$limitSize){				
				if(copy($_FILES['featuresPicture']['tmp_name'], $uploaddiroption.$uploadimgoption)){
					$currentFeat->featuresImages = $uploadimgoption;
					//chmod($root."upload_pictures/".$uploadbg,0644);
				}else{
					$currentFeat->featuresImages = $_POST['photohidden2'];
				}
			}else{
				echo "<script>alert('Your picture size more than 1mb ....... please try again!!!.');</script>";
			}
		}else{
			$currentFeat->featuresImages = $_POST['photohidden2'];
		}

		//See if this is an update or an insert
		if($currentFeat->featuresId==''){ //INSERT
			$currentFeat->Insert($currentFeat);
			$currentFeat=null;	
		}else{  //UPDATE
			$currentFeat->Update($currentFeat);
			$currentFeat=null;
		}
	}else{
		$erContent = "Please ensure all required fields are completed";		
	} 
} 

//Page Deleted
if($_POST['featesDeleteFormSubmitted']=='true'){ 
	smFeature::Delete($_POST['featuresId']);
	echo ("<script>window.location='"._URL_."admin_settings';</script>");
} 

if($_GET['imageFeaturesDeleteSubmitted']=='true'){
	$sqldeletecateimage = mysql_query("UPDATE ex_features SET featuresImages='' WHERE featuresId='".$_REQUEST['featuresId']."' ");	
	@unlink($root.'upload_pictures/'.$_REQUEST['imName']);	// remove picture in folder
	echo "<script>window.location='"._URL_."admin_settings/?featuresId={$_REQUEST['featuresId']}';</script>";
	
}

$currentFeats = $currentFeats->GetMenuAndPages(null, true); 
//print_r($currentFeats);
?>

<div class="leftblock vertsortable" style="width:30%; float:left;">
	<!-- gadget left 1 -->
	<div class="gadget">
		<div class="titlebar vertsortable_head">
			<!--<a href="#" class="hidegadget" rel="hide_block"><img src="<?//=_URL_;?>styles/images/spacer.gif" alt="picture" width="19" height="33" /></a>-->
			<h3>Add / Edit Customize <a href='<?=$site_admin;?>admin_settings' title='Clear Form' style="text-decoration:none; font-weight:normal;">(Clear Form)</a></h3>
		</div>
		<div class="gadgetblock">
			<form id="contentAddEdit" action="<?=$site_admin; ?>admin_settings" method="post" enctype="multipart/form-data">
				<?php if(!empty($erContent)){ echo('<p class="validationArea">'.$erContent.'</p>'); } ?>

				<?php smControls::smTextBox("Features Name", "featuresName", $currentFeat->featuresName); ?><br />

				<label for="Parent">Parent node</label>
				<select id="featuresRootId" name="featuresRootId">
					<option value="0">Root</option>
					<?php fillFacilitiesParentNodeDDL($currentFeat->featuresRootId);?>
				</select><br />
				
				
				<label for="Parent">Category<br/>(for root level)</label>
				<select id="featuresCategory" name="featuresCategory">
					<option value="0">Category</option>
					<?php fillCategoryDDL($currentFeat->featuresCategory);?>
				</select><br />

				<label>Descriptions</label>
				<textarea name="featuresDescriptions" id="featuresDescriptions" class="tinymce" style="height:250px; width:100%;"><?=stripcslashes($currentFeat->featuresDescriptions);?></textarea>
				<br />
				
				<label for="Parent">Upload picture</label>
				<?php smControls::smFileUpload("", "featuresPicture", ""); ?><br />
				<?php
				if(!empty($currentFeat->featuresImages)){
					echo "<img src='{$site_admin}upload_pictures/{$currentFeat->featuresImages}' alt='' style='width:110px;'  />
					<a href='{$site_admin}admin_settings/?featuresId={$currentFeat->featuresId}&imageFeaturesDeleteSubmitted=true&imName={$currentFeat->featuresImages}'>
						<img src='"._URL_."styles/images/delete2.gif' alt='Delete' title='Delete' />
					</a>";
				}
				?><br />
				
				<input type="hidden" name="featuresId" id="featuresId" value="<?php echo($currentFeat->featuresId);?>" />
				<input type="hidden" id="photohidden2" name="photohidden2" value="<?php echo($currentFeat->featuresImages); ?>" />
				<input type="hidden" name="addEditFeatureFormSubmitted" id="addEditFeatureFormSubmitted" value="true" />
				<input type="submit" value="Save" style="cursor:pointer;" />
			</form><br/>
		</div>	<!-- n gadgetblock -->
	</div>	<!-- n gadget -->
	
	<!-- gadget left 1 -->
	<div class="gadget">
		<div class="titlebar vertsortable_head">
			<!--<a href="#" class="hidegadget" rel="hide_block"><img src="<?//=_URL_;?>styles/images/spacer.gif" alt="picture" width="19" height="33" /></a>-->
			<h3>Customize</h3>
		</div>
		<div class="gadgetblock">
			<div id="contentCurrent">
				<?php
				$k2=0;
				foreach($currentFeats as $aPage){
	
					if($aPage->featuresRootId>0){
						
						echo("<span class='indent'>&nbsp</span>");
						$mfeat = "";
						$catename = "";
					
					}else{
						$k2++;
						
						if(!empty($aPage->featuresCategory)){
							$cate = smCategory::getCategory($aPage->featuresCategory);
							$maincatename = smCategory::getCategory($cate->categoryRootId);
							$catename = $maincatename->categoryName." - ".$cate->categoryName." - ";
						}else{
							$catename = "";
						}
						
						if($k2 > 1){ echo "<br/>"; }
						
						$mfeat = " style='font-weight:bold;' ";
					}
					
					?>
					<form id="pageDeleteForm" action="<?=$site_admin; ?>admin_settings" method="post">
						<input type="hidden" id="featesDeleteFormSubmitted" name="featesDeleteFormSubmitted" value="true" />
						<input type="hidden" id="featuresId" name="featuresId" value="<?php echo($aPage->featuresId); ?>" />
						<input id="Delete" name="Delete" value="<?php echo($aPage->featuresId); ?>" title="Delete" type="image" src="<?=_URL_;?>styles/images/cross.png" class="button" onclick="javascript:return confirm('Are you sure...?')" />			
					</form>
					<form id="pageSelect" method="post" action="<?=$site_admin; ?>admin_settings">
						<input type="hidden" id="featesSelectFormSubmitted" name="featesSelectFormSubmitted" value="true" />
						<input type="hidden" id="featuresId" name="featuresId" value="<?php echo($aPage->featuresId); ?>" />
						<input id="Select" name="Select" value="Select" type="image" title="Edit" src="<?=_URL_;?>styles/images/pencil.png" class="button" />
					</form>
					<form id="pageUp" method="post" action="<?=$site_admin; ?>admin_settings">
						<input type="hidden" id="featesUpSelected" name="featesUpSelected" value="true" />
						<input type="hidden" id="featuresOrdernumber" name="featuresOrdernumber" value="<?php echo($aPage->featuresRootId);?>"/>
						<input type="hidden" id="featuresId" name="featuresId" value="<?php echo($aPage->featuresId);?>" />
						<input id="Select" name="Select" value="Select" type="image" title="Move up" src="<?=_URL_;?>styles/images/up.gif" class="button" />	
					</form>
					<form id="pageDown" method="post" action="<?=$site_admin; ?>admin_settings">
						<input type="hidden" id="featesDownSelected" name="featesDownSelected" value="true" />
						<input type="hidden" id="featuresOrdernumber" name="featuresOrdernumber" value="<?php echo($aPage->featuresRootId);?>"/>
						<input type="hidden" id="featuresId" name="featuresId" value="<?php echo($aPage->featuresId);?>" />
						<input id="Select" name="Select" value="Select" type="image" title="Move down" src="<?=_URL_;?>styles/images/down.gif" class="button" />	
					</form>
					<label <?php echo $mfeat; ?>><?php echo($catename.$aPage->featuresName);?></label><br style="margin-bottom:5px;" />
					<?php
				}
				?>
			</div><br/>	<!-- n contentCurrent -->
		</div>	<!-- n gadgetblock -->
	</div>	<!-- n gadget -->
</div>	<!-- n leftblock vertsortabl -->
