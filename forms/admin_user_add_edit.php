<?php

$USERS = new smUser;
$userErrorMessage = "";

if ($_POST['userDeleteSubmitted']){
 	$USERS->Delete($_POST['usId']);
}

if ($_POST['userSelectSubmitted']){
	$USERS = $USERS->GetIndividual($_POST['usId']);
}

if ($_POST['userFormSubmitted']){
	$USERS->usId = $_POST['usId'];
	$USERS->usUsername = $_POST['usUsername'];
	$USERS->usPassword = $_POST['usPassword'];
	$USERS->usAuthorised = $_POST['usAuthorised'];
	$USERS->usRoLevel = $_POST['usRoLevel'];
	
	if ($USERS->usUsername!=""){
		if ($_POST['usId']==""){
		 	$USERS->Add($USERS);
		}else{	
			$USERS->usId = $_POST['usId'];
		 	$USERS->Update($USERS);
		}
	}else{	
	 	$userErrorMessage = "#$#@!^%+*&&)";
	}	
}

function usRoleDropDownList($checkedId){
	$htmlToReturn = "";

        $htmlToReturn .= "<option value='1'";
        $htmlToReturn .= $checkedId == 1 ? " SELECTED ":"";
        $htmlToReturn .= ">Administrator</option>";
        
        //$htmlToReturn .= "<option value='2'";
        //$htmlToReturn .= $checkedId == 2 ? " SELECTED ":"";
        //$htmlToReturn .= ">User</option>";

	return $htmlToReturn;
}

$listUser = new smUser;
$listUser = $listUser->GetAll(1,"");

?>
<div class="vertsortable" style="width:40%; margin: 0 auto;">
	
	<!-- gadget left 1 -->
	<div class="gadget">
		<div class="titlebar vertsortable_head">
			<!--<a href="#" class="hidegadget" rel="hide_block"><img src="<?//=_URL_;?>styles/images/spacer.gif" alt="picture" width="19" height="33" /></a>-->
			<h3>User</h3>
		</div>
		<div class="gadgetblock">
			<div id="selectDelete">
			<?php foreach ($listUser as $userDel){ ?>
				<form id="userDelete" method="post" action="<?=$site_admin; ?>admin_user">
					<input type="hidden" id="userDeleteSubmitted" name="userDeleteSubmitted" value="true" />
					<input type="hidden" id="usId" name="usId" value="<?php echo $userDel->usId; ?>" />
					<input id="Delete" name="Delete" value="<?php echo $userDel->usId; ?>" title="Delete user" type="image" src="<?=_URL_; ?>styles/images/cross.png" alt="Delete" class="button" onclick="javascript:return confirm('Are you sure...?')" />	
				</form> 
				<form id="userSelect" method="post" action="<?=$site_admin; ?>admin_user" >
					<input type="hidden" id="userSelectSubmitted" name="userSelectSubmitted" value="true" />
					<input type="hidden" id="usId" name="usId" value="<?php echo $userDel->usId; ?>" />
					<input id="Select" name="Select" value="Select" type="image" title="Edit user" src="<?=_URL_; ?>styles/images/pencil.png" alt="Edit" class="button" />
				</form>
				
				<?php echo("<label style='margin-top:5px;'><b>".$userDel->usUsername."</b></label>"); ?>
				<?php echo("<label style='font-size:11px; margin:7px 0 0 5px;'>".date("Y-m-d",$userDel->usLastActivity)."</label>"); ?><br />
			<?php } ?>
			</div>	<!-- n selectDelete -->
		</div>	<!-- n gadgetblock -->
	</div>	<!-- n gadget -->
	
	<!-- gadget left 1 -->
	<div class="gadget">
		<div class="titlebar vertsortable_head">
			<!--<a href="#" class="hidegadget" rel="hide_block"><img src="<?//=_URL_;?>styles/images/spacer.gif" alt="picture" width="19" height="33" /></a>-->
			<h3>Add / Edit User</h3>
		</div>
		<div class="gadgetblock">
			<form id="addEditForm" method="post" action="<?php echo $site_admin; ?>admin_user">
				<?php if (!$userErrorMessage == ""){ echo ("<p class='validationError'>".$userErrorMessage."</p>"); } ?>
				<label>Role</label>
				<select id="usRoLevel" name="usRoLevel">
					<option>-Select-</option>
					<?php echo(usRoleDropDownList($USERS->usRoLevel)); ?>
				</select><br /> 
				<?php smControls::smTextBox("User name", "usUsername", $USERS->usUsername); ?><br />
				<?php //smControls::smPasswordBox("Password", "usPassword", $USERS->usPassword); ?>
				<?php smControls::smTextBox("Password", "usPassword", $USERS->usPassword); ?><br />
				<?php //smControls::smTextBox("Email address", "usEmail", "$USERS->usEmail"); ?>
				<?php smControls::smCheckBox("Authorised", "usAuthorised","1", $USERS->usAuthorised); ?><br />
				
				<input type="hidden" id="usId" name="usId" value="<?php echo $USERS->usId; ?>" />
				<input type="hidden" id="userFormSubmitted" name="userFormSubmitted" value="true" />
				<input type="submit" value="Save" class="button" />
			</form><br/>
		</div>	<!-- n gadgetblock -->
	</div>	<!-- n gadget -->
	
</div><br/>	<!-- n vertsortable -->
