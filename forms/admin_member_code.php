<?php

$MEMBERS = new smUser;
$userErrorMessage = "";

if ($_POST['memberDeleteSubmitted']){
 	$MEMBERS->Delete($_POST['usId']);
}

if ($_POST['memberSelectSubmitted']){
	$MEMBERS = $MEMBERS->GetIndividual($_POST['usId']);
}

if ($_POST['memberFormSubmitted']){
	
	$MEMBERS->usId = $_POST['usId'];
	$MEMBERS->usUsername = $_POST['usUsername'];
	$MEMBERS->usPassword = $_POST['usPassword'];
	$MEMBERS->usAuthorised = $_POST['usAuthorised'];
	$MEMBERS->usAddress = $_POST['usAddress'];
	$MEMBERS->usEmail = $_POST['usEmail'];
	$MEMBERS->usFirstname = $_POST['usFirstname'];
	$MEMBERS->usLastname = $_POST['usLastname'];
	
//echo "---------";
	
	if ($MEMBERS->usUsername!=""){
		if ($_POST['usId']==""){ echo "-1-";
		 	//$MEMBERS->Add($MEMBERS);
		}else{	echo "-2-";
			$MEMBERS->usId = $_POST['usId'];
		 	//$MEMBERS->Update($MEMBERS);
		}
	}else{	
	 	$userErrorMessage = "#$#@!^%+*&&)";
	}
	
}

function usRoleDropDownList($checkedId){
	$htmlToReturn = "";
        $htmlToReturn .= "<option value='2'";
        $htmlToReturn .= $checkedId == 2 ? " SELECTED ":"";
        $htmlToReturn .= ">Member</option>";

	return $htmlToReturn;
}

$listUser = new smUser;
$listUser = $listUser->GetAll(2, $search);

?>
<div class="leftblock vertsortable" style="">
	<!-- gadget left 1 -->
	<div class="gadget">
		<div class="titlebar vertsortable_head">
			<!--<a href="#" class="hidegadget" rel="hide_block"><img src="<?//=_URL_;?>styles/images/spacer.gif" alt="picture" width="19" height="33" /></a>-->
			<h3>User</h3>
		</div>
		<div class="gadgetblock">
			<div id="selectDelete">
			<?php foreach ($listUser as $userDel){ ?>
                                <form id="memberDelete" method="post" action="<?=$site_admin; ?>admin_member">
                                        <input type="hidden" id="memberDeleteSubmitted" name="memberDeleteSubmitted" value="true" />
                                        <input type="hidden" id="usId" name="usId" value="<?php echo($userDel->usId); ?>" />
                                        <input id="Delete" name="Delete" value="<?php echo($userDel->usId); ?>" title="Delete user" type="image" src="<?=_URL_; ?>styles/images/delete.gif" alt="Delete" class="button" onclick="javascript:return confirm('Are you sure...?')" />	
                                </form> 
                                <form id="memberSelect" method="post" action="<?=$site_admin; ?>admin_member" >
                                        <input type="hidden" id="memberSelectSubmitted" name="memberSelectSubmitted" value="true" />
                                        <input type="hidden" id="usId" name="usId" value="<?php echo($userDel->usId); ?>" />
                                        <input id="Select" name="Select" value="Select" type="image" title="Edit user" src="<?=_URL_; ?>styles/images/select.gif" alt="Edit" class="button" />
                                </form>
                                <?php echo("<label style='margin-top:5px;'><b>".$userDel->usUsername."</b></label>"); ?>
                                <?php echo("<label style='font-size:11px; margin:7px 0 0 5px;'>".date("Y-m-d",$userDel->usLastActivity)."</label>"); ?><br />
                        <?php } ?>
			</div>	<!-- n selectDelete -->
		</div>	<!-- n gadgetblock -->
	</div>	<!-- n gadget -->
</div>	<!-- n leftblock vertsortabl -->
