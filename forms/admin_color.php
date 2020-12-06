<?php
/*
function fillParentNodeDDL($selectedNode){
	$parentNodes = new smColor;
	$parentNodes = $parentNodes->GetParentNodes();
	foreach($parentNodes as $aNode){
		if($selectedNode==$aNode->colorImages){
			$selected="SELECTED";
		}else{
			$selected="";
		}
		echo("<option value='".$aNode->colorImages."' ".$selected.">".$aNode->colorName."</option>");
	}
}
*/


$colorPages = new smColor;
$colorPage = new smColor;

//Move up
if($_POST['colorUpSelected']=='true'){
	$colorPage->MoveUp($_POST['colorId']);
	$_POST['colorId'] = "";
}

//Move down
if($_POST['colorDownSelected']=='true'){
	$colorPage->MoveDown($_POST['colorId']);
	$_POST['colorId'] = "";
}

//See if the a page has been selected
if($_POST['colorId']!=''){
	//echo($_POST['colorId']);
	$colorPage = $colorPage->GetMenuAndPages($_POST['colorId'], true);
	$colorPage = $colorPage[0]; //Only one page so whip it out of the returned array
}

$erContent = "";
//See if the Add/Edit form has been submitted
if($_POST['addEditColorFormSubmitted']=='true'){
	if(!empty($_POST['colorTitle'])){
		//Populate $colorPageValues
		$colorPage->colorId = $_POST['colorId'];
		$colorPage->colorTitle = $_POST['colorTitle'];
		/*
		$uploaddircate = "upload_pictures/";
		$limitSize=1024000;		//1mb
		$tt=mktime();

		// upload picture
		if($_FILES['colorImage']['tmp_name']!=""){
			$uploadimgcate= $tt."-color-".str_replace(" ","-",$_FILES['colorImage']['name']);
			if(filesize($_FILES['colorImage']['tmp_name'])<=$limitSize){				
				if(copy($_FILES['colorImage']['tmp_name'], $uploaddircate.$uploadimgcate)){
					$colorPage->colorImage = $uploadimgcate;
					//chmod($root."upload_pictures/".$uploadbg,0644);
				}else{
					$colorPage->colorImage = $_POST['photohidden3'];
				}
			}else{
				echo "<script>alert('Your picture size more than 1mb ....... please try again!!!.');</script>";
			}
		}else{
			$colorPage->colorImage = $_POST['photohidden3'];
		}
		// ----------- n save images -----------
		*/
		
		//See if this is an update or an insert
		if($colorPage->colorId==''){ 	//INSERT
			$colorPage->Insert($colorPage);
			$colorPage=null;	
		}else{  //UPDATE
			$colorPage->Update($colorPage);
			$colorPage=null;
		}
	}else{
		$erContent = "Please ensure all required fields are completed";		
	}
}

//Page Deleted
if($_POST['colorDeleteFormSubmitted']=='true'){
	smColor::Delete($_POST['colorId']);
}
/*
if($_GET['imagePatternDeleteSubmitted']=='true'){
	$sqldeletecateimage = mysql_query("UPDATE ex_color SET colorImage='' WHERE colorId='".$_REQUEST['colorId']."' ");	
	@unlink($root.'upload_pictures/'.$_REQUEST['imName']);	// remove picture in folder
	//echo "<script language='javascript' type='text/javascript'>history.go(-1);</script>";
}
*/
$colorPages = $colorPages->GetMenuAndPages(null, true);
//print_r($colorPages);
?>

<div class="leftblock vertsortable" style="width:30%; float:left;">
	<!-- gadget left 1 -->
	<div class="gadget">
		<div class="titlebar vertsortable_head">
			<!--<a href="#" class="hidegadget" rel="hide_block"><img src="<?//=_URL_;?>styles/images/spacer.gif" alt="picture" width="19" height="33" /></a>-->
			<h3>Add / Edit Colour <a href='<?=$site_admin;?>admin_settings' title='Clear Form' style="text-decoration:none; font-weight:normal;">(Clear Form)</a></h3>
		</div>
		<div class="gadgetblock">
			<form id="contentAddEdit" action="<?=$site_admin; ?>admin_settings" method="post" enctype="multipart/form-data">
				<?php if(!empty($erContent)){ echo('<p class="validationArea">'.$erContent.'</p>'); } ?>
				<?php smControls::smTextBox("Colour", "colorTitle", $colorPage->colorTitle); ?><br />
	
				<?php //smControls::smFileUpload("Upload picture", "colorImage", $colorPage->colorImage); ?><br/>
				<?php
				/*
				if(!empty($colorPage->colorImage)){
					echo "<img src='{$site_admin}upload_pictures/{$colorPage->colorImage}' alt='' width='100' height='75' style='border:solid 2px #FF0000;'  />
					<a href='{$site_admin}admin_settings/?colorId={$colorPage->colorId}&imagePatternDeleteSubmitted=true&imName={$colorPage->colorImage}'>
						<img src='"._URL_."styles/images/delete2.gif' alt='Delete' title='Delete' />
					</a>";
				}
				*/
				?><br />
				
				<input type="hidden" name="colorId" id="colorId" value="<?php echo($colorPage->colorId);?>" />
				<!--<input type="hidden" id="photohidden3" name="photohidden3" value="<?php //echo($colorPage->colorImage); ?>" />-->
				<input type="hidden" name="addEditColorFormSubmitted" id="addEditColorFormSubmitted" value="true" />
				<input type="submit" value="Save" style="cursor:pointer;" />
			</form><br/>
		</div>	<!-- n gadgetblock -->
	</div>	<!-- n gadget -->
	
	<!-- gadget left 1 -->
	<div class="gadget">
		<div class="titlebar vertsortable_head">
			<!--<a href="#" class="hidegadget" rel="hide_block"><img src="<?//=_URL_;?>styles/images/spacer.gif" alt="picture" width="19" height="33" /></a>-->
			<h3>Colour (Shades)</h3>
		</div>
		<div class="gadgetblock">
			<div id="contentCurrent">
				<?php
				foreach($colorPages as $aPage){
					$stylecolor=str_replace(" ","", strtolower($aPage->colorTitle));
					?>
					<form id="pageDeleteForm" action="<?=$site_admin; ?>admin_settings" method="post">
						<input type="hidden" id="colorDeleteFormSubmitted" name="colorDeleteFormSubmitted" value="true" />
						<input type="hidden" id="colorId" name="colorId" value="<?php echo($aPage->colorId); ?>" />
						<input id="Delete" name="Delete" value="<?php echo($aPage->colorId); ?>" title="Delete" type="image" src="<?=_URL_;?>styles/images/cross.png" class="button" onclick="javascript:return confirm('Are you sure...?')" />			
					</form>
					<form id="pageSelect" method="post" action="<?=$site_admin; ?>admin_settings">
						<input type="hidden" id="colorSelectFormSubmitted" name="colorSelectFormSubmitted" value="true" />
						<input type="hidden" id="colorId" name="colorId" value="<?php echo($aPage->colorId); ?>" />
						<input id="Select" name="Select" value="Select" type="image" title="Edit" src="<?=_URL_;?>styles/images/pencil.png" class="button" />
					</form>
					<form id="pageUp" method="post" action="<?=$site_admin; ?>admin_settings">
						<input type="hidden" id="colorUpSelected" name="colorUpSelected" value="true" />
						<!--<input type="hidden" id="colorOrdernumber" name="colorOrdernumber" value="<?php //echo($aPage->categoryRootId);?>"/>-->
						<input type="hidden" id="colorId" name="colorId" value="<?php echo($aPage->colorId);?>" />
						<input id="Select" name="Select" value="Select" type="image" title="Move up" src="<?=_URL_;?>styles/images/up.gif" class="button" />	
					</form>
					<form id="pageDown" method="post" action="<?=$site_admin; ?>admin_settings">
						<input type="hidden" id="colorDownSelected" name="colorDownSelected" value="true" />
						<!--<input type="hidden" id="colorOrdernumber" name="colorOrdernumber" value="<?php //echo($aPage->categoryRootId);?>"/>-->
						<input type="hidden" id="colorId" name="colorId" value="<?php echo($aPage->colorId);?>" />
						<input id="Select" name="Select" value="Select" type="image" title="Move down" src="<?=_URL_;?>styles/images/down.gif" class="button" />	
					</form>
					<div style="width:25px; height:15px; background:<?=$stylecolor; ?>;  float:left; margin-left:5px;">&nbsp;</div>
					<label><?php echo($aPage->colorTitle);?></label><br style="margin-bottom:5px;" />
					<?php
				}
				?>
			</div><br/>	<!-- n contentCurrent -->
		</div>	<!-- n gadgetblock -->
	</div>	<!-- n gadget -->
</div>	<!-- n leftblock vertsortabl -->
