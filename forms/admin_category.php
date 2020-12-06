<?php
function fillParentNodeDDL($selectedNode){
	$parentNodes = new smCategory;
	$parentNodes = $parentNodes->GetParentNodes();
	foreach($parentNodes as $aNode){
		if($selectedNode==$aNode->categoryId){
			$selected="SELECTED";
		}else{
			$selected="";
		}
		echo("<option value='".$aNode->categoryId."' ".$selected.">".$aNode->categoryName."</option>");
	}
}

$currentPages = new smCategory;
$currentPage = new smCategory;

//Move up
if($_POST['cateUpSelected']=='true'){
	$currentPage->MoveUp($_POST['categoryId'], $_POST['categoryOrdernumber']);
	$_POST['categoryId'] = "";
}

//Move down
if($_POST['cateDownSelected']=='true'){
	$currentPage->MoveDown($_POST['categoryId'], $_POST['categoryOrdernumber']);
	$_POST['categoryId'] = "";
}

//See if the a page has been selected
if($_POST['categoryId']!=''){
	//echo($_POST['categoryId']);
	$currentPage = $currentPage->GetMenuAndPages($_POST['categoryId'], true);
	$currentPage = $currentPage[0]; //Only one page so whip it out of the returned array
}

function mainCateDropDownList($cate){
	$htmlToReturn = "";

        $htmlToReturn .= "<option value='1'";
        $htmlToReturn .= $cate == "1" ? " SELECTED ":"";
        $htmlToReturn .= ">Mens</option>";
        
        $htmlToReturn .= "<option value='2'";
        $htmlToReturn .= $cate == "2" ? " SELECTED ":"";
        $htmlToReturn .= ">Womens</option>";
        
	/*
        $htmlToReturn .= "<option value='3'";
        $htmlToReturn .= $cate == "3" ? " SELECTED ":"";
        $htmlToReturn .= ">Accessories</option>";
	*/
	return $htmlToReturn;
}

$erContent = "";
//See if the Add/Edit form has been submitted
if($_POST['addEditCategoryFormSubmitted']=='true'){
	if(!empty($_POST['categoryName'])){
		//Populate $currentPageValues
		$currentPage->categoryId = $_POST['categoryId'];
		$currentPage->categoryName = $_POST['categoryName'];
		$currentPage->categoryVisible = $_POST['categoryVisible'];
		$currentPage->categoryRootId = $_POST['categoryRootId'];	// $_POST['parentNode']
		$currentPage->categoryDescriptions = $_POST['categoryDescriptions'];
		
		$uploaddircate = "upload_pictures/";
		$limitSize=1024000;		//1mb
		$tt=mktime();

		// upload picture
		if($_FILES['categoryPicture']['tmp_name']!=""){
			$uploadimgcate= $tt."-category-".str_replace(" ","-",$_FILES['categoryPicture']['name']);
			if(filesize($_FILES['categoryPicture']['tmp_name'])<=$limitSize){				
				if(copy($_FILES['categoryPicture']['tmp_name'], $uploaddircate.$uploadimgcate)){
					$currentPage->categoryImage = $uploadimgcate;
					//chmod($root."upload_pictures/".$uploadbg,0644);
				}else{
					$currentPage->categoryImage = $_POST['photohidden1'];
				}
			}else{
				echo "<script>alert('Your picture size more than 1mb ....... please try again!!!.');</script>";
			}
		}else{
			$currentPage->categoryImage = $_POST['photohidden1'];
		}
		// ----------- n save images -----------
	
		//See if this is an update or an insert
		if($currentPage->categoryId==''){ 	//INSERT
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
if($_POST['cateDeleteFormSubmitted']=='true'){
	smCategory::Delete($_POST['categoryId']);
}

if($_GET['imageCategoryDeleteSubmitted']=='true'){
	$sqldeletecateimage = mysql_query("UPDATE ex_category SET categoryName='' WHERE categoryId='".$_REQUEST['categoryId']."' ");	
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
			<h3>Add / Edit Category <a href='<?=$site_admin;?>admin_settings' title='Clear Form' style="text-decoration:none; font-weight:normal;">(Clear Form)</a></h3>
		</div>
		<div class="gadgetblock">
			<form id="contentAddEdit" action="<?=$site_admin; ?>admin_settings" method="post" enctype="multipart/form-data">
				<?php if(!empty($erContent)){ echo('<p class="validationArea">'.$erContent.'</p>'); } ?>
				<?php smControls::smTextBox("Category Name", "categoryName", $currentPage->categoryName); ?><br />
				
				<label for="Parent">Parent category</label>
				<select id="categoryRootId" name="categoryRootId">
				<option value="0">Root</option>
				<?php fillParentNodeDDL($currentPage->categoryRootId); ?>
				</select><br />
				
				<!--<label for="Parent">Select parent category</label>-->
				<!--<select id="categoryRootId" name="categoryRootId">-->
				<!--	<?php //echo mainCateDropDownList($currentPage->categoryRootId); ?>-->
				<!--</select><br />-->
				
				<label>Descriptions</label>
				<textarea name="categoryDescriptions" id="categoryDescriptions" class="tinymce" style="height:250px; width:100%;"><?=stripcslashes($currentPage->categoryDescriptions);?></textarea>
				<br />

				<?php smControls::smFileUpload("Upload picture", "categoryPicture", $currentPage->categoryImage); ?><br/>
				<?php
				if(!empty($currentPage->categoryImage)){
					echo "<img src='{$site_admin}upload_pictures/{$currentPage->categoryImage}' alt='' width='100' height='75' style='border:solid 2px #FF0000;'  />
					<a href='{$site_admin}admin_settings/?categoryId={$currentPage->categoryId}&imageCategoryDeleteSubmitted=true&imName={$currentPage->categoryImage}'>
						<img src='"._URL_."styles/images/delete2.gif' alt='Delete' title='Delete' />
					</a>";
				}
				?><br />
			
				<?php smControls::smCheckBox("Visible?", "categoryVisible","1", $currentPage->categoryVisible); ?><br /><br/>
				
				<input type="hidden" name="categoryId" id="categoryId" value="<?php echo($currentPage->categoryId);?>" />
				<input type="hidden" id="photohidden1" name="photohidden1" value="<?php echo($currentPage->categoryImage); ?>" />
				<input type="hidden" name="addEditCategoryFormSubmitted" id="addEditCategoryFormSubmitted" value="true" />
				<input type="submit" value="Save" style="cursor:pointer;" />
			</form><br/>
		</div>	<!-- n gadgetblock -->
	</div>	<!-- n gadget -->
	
	<!-- gadget left 1 -->
	<div class="gadget">
		<div class="titlebar vertsortable_head">
			<!--<a href="#" class="hidegadget" rel="hide_block"><img src="<?//=_URL_;?>styles/images/spacer.gif" alt="picture" width="19" height="33" /></a>-->
			<h3>Category</h3>
		</div>
		<div class="gadgetblock">
			<div id="contentCurrent">
				<?php
				$k1=0;
				foreach($currentPages as $aPage){
					if($aPage->categoryVisible==0){
						$showhiddenicon = "<img src='"._URL_."styles/images/hidden.gif' alt='not available' title='not available' />";
					}else{
						$showhiddenicon = "";
					}
					
					if($aPage->categoryRootId>0){
						echo("<span class='indent'>&nbsp</span>");
						$mcate = "";
					?>	
					<form id="pageDeleteForm" action="<?=$site_admin; ?>admin_settings" method="post">
						<input type="hidden" id="cateDeleteFormSubmitted" name="cateDeleteFormSubmitted" value="true" />
						<input type="hidden" id="categoryId" name="categoryId" value="<?php echo($aPage->categoryId); ?>" />
						<input id="Delete" name="Delete" value="<?php echo($aPage->categoryId); ?>" title="Delete" type="image" src="<?=_URL_;?>styles/images/cross.png" class="button" onclick="javascript:return confirm('Are you sure...?')" />			
					</form>
					<form id="pageSelect" method="post" action="<?=$site_admin; ?>admin_settings">
						<input type="hidden" id="cateSelectFormSubmitted" name="cateSelectFormSubmitted" value="true" />
						<input type="hidden" id="categoryId" name="categoryId" value="<?php echo($aPage->categoryId); ?>" />
						<input id="Select" name="Select" value="Select" type="image" title="Edit" src="<?=_URL_;?>styles/images/pencil.png" class="button" />
					</form>
					<form id="pageUp" method="post" action="<?=$site_admin; ?>admin_settings">
						<input type="hidden" id="cateUpSelected" name="cateUpSelected" value="true" />
						<input type="hidden" id="categoryOrdernumber" name="categoryOrdernumber" value="<?php echo($aPage->categoryRootId);?>"/>
						<input type="hidden" id="categoryId" name="categoryId" value="<?php echo($aPage->categoryId);?>" />
						<input id="Select" name="Select" value="Select" type="image" title="Move up" src="<?=_URL_;?>styles/images/up.gif" class="button" />	
					</form>
					<form id="pageDown" method="post" action="<?=$site_admin; ?>admin_settings">
						<input type="hidden" id="cateDownSelected" name="cateDownSelected" value="true" />
						<input type="hidden" id="categoryOrdernumber" name="categoryOrdernumber" value="<?php echo($aPage->categoryRootId);?>"/>
						<input type="hidden" id="categoryId" name="categoryId" value="<?php echo($aPage->categoryId);?>" />
						<input id="Select" name="Select" value="Select" type="image" title="Move down" src="<?=_URL_;?>styles/images/down.gif" class="button" />	
					</form>
					
					<label><?php echo $showhiddenicon . $aPage->categoryName;?></label><br style="margin-bottom:5px;" />
					
					<?php
					
					}else{
						
						$k1++;
						if($k1 > 1){ echo "<br/>"; }
					?>
						
					<label style="font-weight:bold;"><?php echo $showhiddenicon . $aPage->categoryName;?></label><br style="margin-bottom:5px;" />
						
					<?php
					} 
				}
				?>
			</div><br/>	<!-- n contentCurrent -->
		</div>	<!-- n gadgetblock -->
	</div>	<!-- n gadget -->
</div>	<!-- n leftblock vertsortabl -->
