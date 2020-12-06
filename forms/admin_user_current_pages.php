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
<div class="leftblock vertsortable" style="width:30%; float:left;">
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
                                        <input type="hidden" id="usId" name="usId" value="<?php echo($userDel->usId); ?>" />
                                        <input id="Delete" name="Delete" value="<?php echo($userDel->usId); ?>" title="Delete user" type="image" src="<?=_URL_; ?>styles/images/cross.png" alt="Delete" class="button" onclick="javascript:return confirm('Are you sure...?')" />	
                                </form> 
                                <form id="userSelect" method="post" action="<?=$site_admin; ?>admin_user" >
                                        <input type="hidden" id="userSelectSubmitted" name="userSelectSubmitted" value="true" />
                                        <input type="hidden" id="usId" name="usId" value="<?php echo($userDel->usId); ?>" />
                                        <input id="Select" name="Select" value="Select" type="image" title="Edit user" src="<?=_URL_; ?>styles/images/pencil.png" alt="Edit" class="button" />
                                </form>
                                
                                <?php echo("<label style='margin-top:5px;'><b>".$userDel->usUsername."</b></label>"); ?>
                                <?php echo("<label style='font-size:11px; margin:7px 0 0 5px;'>".date("Y-m-d",$userDel->usLastActivity)."</label>"); ?><br />
                        <?php } ?>
			</div>	<!-- n selectDelete -->
		</div>	<!-- n gadgetblock -->
	</div>	<!-- n gadget -->
</div>	<!-- n leftblock vertsortabl -->
