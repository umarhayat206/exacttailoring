<?php
/*
function fillParentNodeDDL($selectedNode){
	$parentNodes = new smPattern;
	$parentNodes = $parentNodes->GetParentNodes();
	foreach($parentNodes as $aNode){
		if($selectedNode==$aNode->patternId){
			$selected="SELECTED";
		}else{
			$selected="";
		}
		echo("<option value='".$aNode->patternId."' ".$selected.">".$aNode->patternName."</option>");
	}
}
*/

$patternPages = new smPattern;
$patternPage = new smPattern;

//Move up
if($_POST['patternIUpSelected']=='true'){
	$patternPage->MoveUp($_POST['patternId']);
	$_POST['patternId'] = "";
}

//Move down
if($_POST['patternIDownSelected']=='true'){
	$patternPage->MoveDown($_POST['patternId']);
	$_POST['patternId'] = "";
}

//See if the a page has been selected
if($_POST['patternId']!=''){
	//echo($_POST['patternId']);
	$patternPage = $patternPage->GetMenuAndPages($_POST['patternId'], true);
	$patternPage = $patternPage[0]; //Only one page so whip it out of the returned array
}

$erContent = "";
//See if the Add/Edit form has been submitted
if($_POST['addEditPatternFormSubmitted']=='true'){
	if(!empty($_POST['patternTitle'])){
		//Populate $patternPageValues
		$patternPage->patternId = $_POST['patternId'];
		$patternPage->patternTitle = $_POST['patternTitle'];
		/*
		$uploaddircate = "upload_pictures/";
		$limitSize=1024000;		//1mb
		$tt=mktime();

		// upload picture
		if($_FILES['patternImage']['tmp_name']!=""){
			$uploadimgcate= $tt."-pattern-".str_replace(" ","-",$_FILES['patternImage']['name']);
			if(filesize($_FILES['patternImage']['tmp_name'])<=$limitSize){				
				if(copy($_FILES['patternImage']['tmp_name'], $uploaddircate.$uploadimgcate)){
					$patternPage->patternImage = $uploadimgcate;
					//chmod($root."upload_pictures/".$uploadbg,0644);
				}else{
					$patternPage->patternImage = $_POST['photohidden3'];
				}
			}else{
				echo "<script>alert('Your picture size more than 1mb ....... please try again!!!.');</script>";
			}
		}else{
			$patternPage->patternImage = $_POST['photohidden3'];
		}
		// ----------- n save images -----------
		*/
		
		//See if this is an update or an insert
		if($patternPage->patternId==''){ 	//INSERT
			$patternPage->Insert($patternPage);
			$patternPage=null;	
		}else{  //UPDATE
			$patternPage->Update($patternPage);
			$patternPage=null;
		}
	}else{
		$erContent = "Please ensure all required fields are completed";		
	}
}

//Page Deleted
if($_POST['patternIDeleteFormSubmitted']=='true'){
	smPattern::Delete($_POST['patternId']);
}
/*
if($_GET['imagePatternDeleteSubmitted']=='true'){
	$sqldeletecateimage = mysql_query("UPDATE ex_pattern SET patternImage='' WHERE patternId='".$_REQUEST['patternId']."' ");	
	@unlink($root.'upload_pictures/'.$_REQUEST['imName']);	// remove picture in folder
	//echo "<script language='javascript' type='text/javascript'>history.go(-1);</script>";
}
*/
$patternPages = $patternPages->GetMenuAndPages(null, true);
//print_r($patternPages);
?>

<div class="leftblock vertsortable" style="width:30%; float:left;">
	<!-- gadget left 1 -->
	<div class="gadget">
		<div class="titlebar vertsortable_head">
			<!--<a href="#" class="hidegadget" rel="hide_block"><img src="<?//=_URL_;?>styles/images/spacer.gif" alt="picture" width="19" height="33" /></a>-->
			<h3>Add / Edit Pattern <a href='<?=$site_admin;?>admin_settings' title='Clear Form' style="text-decoration:none; font-weight:normal;">(Clear Form)</a></h3>
		</div>
		<div class="gadgetblock">
			<form id="contentAddEdit" action="<?=$site_admin; ?>admin_settings" method="post" enctype="multipart/form-data">
				<?php if(!empty($erContent)){ echo('<p class="validationArea">'.$erContent.'</p>'); } ?>
				<?php smControls::smTextBox("Pattern", "patternTitle", $patternPage->patternTitle); ?><br />
	
				<?php //smControls::smFileUpload("Upload picture", "patternImage", $patternPage->patternImage); ?><br/>
				<?php
				/*
				if(!empty($patternPage->patternImage)){
					echo "<img src='{$site_admin}upload_pictures/{$patternPage->patternImage}' alt='' width='100' height='75' style='border:solid 2px #FF0000;'  />
					<a href='{$site_admin}admin_settings/?patternId={$patternPage->patternId}&imagePatternDeleteSubmitted=true&imName={$patternPage->patternImage}'>
						<img src='"._URL_."styles/images/delete2.gif' alt='Delete' title='Delete' />
					</a>";
				}
				*/
				?><br />
				
				<input type="hidden" name="patternId" id="patternId" value="<?php echo($patternPage->patternId);?>" />
				<!--<input type="hidden" id="photohidden3" name="photohidden3" value="<?php //echo($patternPage->patternImage); ?>" />-->
				<input type="hidden" name="addEditPatternFormSubmitted" id="addEditPatternFormSubmitted" value="true" />
				<input type="submit" value="Save" style="cursor:pointer;" />
			</form><br/>
		</div>	<!-- n gadgetblock -->
	</div>	<!-- n gadget -->
	
	<!-- gadget left 1 -->
	<div class="gadget">
		<div class="titlebar vertsortable_head">
			<!--<a href="#" class="hidegadget" rel="hide_block"><img src="<?//=_URL_;?>styles/images/spacer.gif" alt="picture" width="19" height="33" /></a>-->
			<h3>Pattern</h3>
		</div>
		<div class="gadgetblock">
			<div id="contentCurrent">
				<?php
				foreach($patternPages as $aPage){
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
						<input type="hidden" id="patternIDeleteFormSubmitted" name="patternIDeleteFormSubmitted" value="true" />
						<input type="hidden" id="patternId" name="patternId" value="<?php echo($aPage->patternId); ?>" />
						<input id="Delete" name="Delete" value="<?php echo($aPage->patternId); ?>" title="Delete" type="image" src="<?=_URL_;?>styles/images/cross.png" class="button" onclick="javascript:return confirm('Are you sure...?')" />			
					</form>
					<form id="pageSelect" method="post" action="<?=$site_admin; ?>admin_settings">
						<input type="hidden" id="patternISelectFormSubmitted" name="patternISelectFormSubmitted" value="true" />
						<input type="hidden" id="patternId" name="patternId" value="<?php echo($aPage->patternId); ?>" />
						<input id="Select" name="Select" value="Select" type="image" title="Edit" src="<?=_URL_;?>styles/images/pencil.png" class="button" />
					</form>
					<form id="pageUp" method="post" action="<?=$site_admin; ?>admin_settings">
						<input type="hidden" id="patternIUpSelected" name="patternIUpSelected" value="true" />
						<!--<input type="hidden" id="patternOrdernumber" name="patternOrdernumber" value="<?php //echo($aPage->categoryRootId);?>"/>-->
						<input type="hidden" id="patternId" name="patternId" value="<?php echo($aPage->patternId);?>" />
						<input id="Select" name="Select" value="Select" type="image" title="Move up" src="<?=_URL_;?>styles/images/up.gif" class="button" />	
					</form>
					<form id="pageDown" method="post" action="<?=$site_admin; ?>admin_settings">
						<input type="hidden" id="patternIDownSelected" name="patternIDownSelected" value="true" />
						<!--<input type="hidden" id="patternOrdernumber" name="patternOrdernumber" value="<?php //echo($aPage->categoryRootId);?>"/>-->
						<input type="hidden" id="patternId" name="patternId" value="<?php echo($aPage->patternId);?>" />
						<input id="Select" name="Select" value="Select" type="image" title="Move down" src="<?=_URL_;?>styles/images/down.gif" class="button" />	
					</form>
					<label <?php echo $mcate; ?>><?php echo($aPage->patternTitle);?></label><br style="margin-bottom:5px;" />
					<?php
				}
				?>
			</div><br/>	<!-- n contentCurrent -->
		</div>	<!-- n gadgetblock -->
	</div>	<!-- n gadget -->
</div>	<!-- n leftblock vertsortabl -->
