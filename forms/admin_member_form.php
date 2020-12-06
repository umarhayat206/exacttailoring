<?php

$MEMBERS = new smUser;
$userErrorMessage = "";

if ($_POST['memberDeleteSubmitted']){
 	$MEMBERS->Delete($_POST['usId']);
}

if ($_POST['memberSelectSubmitted']){
	$MEMBERS = $MEMBERS->GetIndividual($_POST['usId']);
}

if($_POST['memberVisibleSubmitted']){
	$MEMBERS->setVisible($_POST['usId']);
	//echo "<script>history.go(-1);</script>";
}

if ($_POST['memberFormSubmitted']){
	$MEMBERS->usId = $_POST['usId'];
	$MEMBERS->usUsername = $_POST['usUsername'];
	$MEMBERS->usPassword = $_POST['usPassword'];
	$MEMBERS->usPasswordHashed = md5($_POST['usPassword']);
	$MEMBERS->usAuthorised = $_POST['usAuthorised'];
	$MEMBERS->usCompany = mysql_real_escape_string($_POST['usCompany']);
	$MEMBERS->usAddress = mysql_real_escape_string($_POST['usAddress']);
	$MEMBERS->usAddress2 = mysql_real_escape_string($_POST['usAddress2']);
	$MEMBERS->usAddress3 = mysql_real_escape_string($_POST['usAddress3']);
	$MEMBERS->usCity = mysql_real_escape_string($_POST['usCity']);
	$MEMBERS->usPostcode = $_POST['usPostcode'];
	$MEMBERS->usCountry = $_POST['usCountry'];
	$MEMBERS->usEmail = $_POST['usEmail'];
	$MEMBERS->usFirstname = $_POST['usFirstname'];
	$MEMBERS->usLastname = $_POST['usLastname'];
	$MEMBERS->usTelephone = $_POST['usTelephone'];
	$MEMBERS->usRoLevel = 2;
	$MEMBERS->usReceiveInfo = $_POST['usReceiveInfo'];

	
	if ($_POST['usId']==""){
		$MEMBERS->Add($MEMBERS);
	}else{	
		$MEMBERS->usId = $_POST['usId'];
		$MEMBERS->Update($MEMBERS);
	}

}

function usRoleDropDownList($checkedId){
	$htmlToReturn = "";
        $htmlToReturn .= "<option value='2'";
        $htmlToReturn .= $checkedId == 2 ? " SELECTED ":"";
        $htmlToReturn .= ">Member</option>";

	return $htmlToReturn;
}

if($_POST['memberSearchFormSubmitted']){
	
	if(!empty($_POST['searchmembername'])){
		$membersearch = " AND usFirstname LIKE '".$_POST['searchmembername']."%' ";
	}

	if(!empty($_POST['searchsurname'])){
		$membersearch = " AND usLastname LIKE '".$_POST['searchsurname']."%' ";
	}

	if(!empty($_POST['searchpostcode'])){
		$membersearch = " AND usPostcode LIKE '%".$_POST['searchpostcode']."%' ";
	}
	
	if(!empty($_POST['searchtotalspend'])){
		if($_POST['searchtotalspend']==100){
			$membersearch = " AND usTotalSpend < '100') ";
		}else if($_POST['searchtotalspend']==200){
			$membersearch = " AND (usTotalSpend >= '100' AND usTotalSpend < '200') ";
		}else if($_POST['searchtotalspend']==300){
			$membersearch = " AND (usTotalSpend >= '200' AND usTotalSpend < '300') ";
		}else if($_POST['searchtotalspend']==400){
			$membersearch = " AND (usTotalSpend >= '300' AND usTotalSpend < '400') ";
		}else if($_POST['searchtotalspend']==500){
			$membersearch = " AND (usTotalSpend >= '400' AND usTotalSpend < '500') ";
		}else if($_POST['searchtotalspend']==999){
			$membersearch = " AND usTotalSpend >= '500' ";
		}

	}
	
	if(!empty($_POST['searchhowmanyorder'])){
		if($_POST['searchhowmanyorder']==99){
			$membersearch = " AND usHowmanyOrder >= 11 ";
		}else{
			$membersearch = " AND usHowmanyOrder = '{$_POST['searchhowmanyorder']}' ";
		}
		
	}

}

function memberCountryDropdownList($checkedId){
    $htmlToReturn ="";
    $countrylist = smSetting::getAllCountry();
    
    foreach($countrylist as $item){
        $htmlToReturn .= "<option value='".$item->rowId."'";
        $htmlToReturn .= $checkedId == $item->rowId ? " SELECTED ":"";
        $htmlToReturn .= ">".$item->countryName."</option>";
    }
    
    return $htmlToReturn;
}

if(!empty($_GET['member'])){
	$membersearch = " AND usId = {$_GET['member']} ";
}

$listUser = new smUser;
$listUser = $listUser->GetAll(2, $membersearch);

if(empty($_REQUEST['action'])){	// view all property list
	
?>
<div class="leftblock vertsortable">
	<!-- gadget left 1 -->
	<div class="gadget">
		<div class="titlebar vertsortable_head">
			<!--<a href="#" class="hidegadget" rel="hide_block"><img src="<?//=_URL_;?>styles/images/spacer.gif" alt="picture" width="19" height="33" /></a>-->
			<h3>Search Member</h3>
		</div>
		<div class="gadgetblock">
			<form id="memberSearchForm" method="post" action="<?=$site_admin; ?>admin_member" enctype="multipart/form-data" style="float:left;">
				<input type="text" id="searchmembername" name="searchmembername" value="" placeholder="first name" />

				<input type="text" id="searchsurname" name="searchsurname" value="" placeholder="surname" />

				<input type="text" id="searchpostcode" name="searchpostcode" value="" placeholder="post code" />

				<input type="hidden" id="memberSearchFormSubmitted" name="memberSearchFormSubmitted" value="true" />

				<input type="submit" value="Search" class="button" style="cursor:pointer;" />
				
				<select id="searchtotalspend" name="searchtotalspend" onchange="this.form.submit();">
					<option value="0">Total Spend</option>
					<option value="100">less than &pound;100</option>
					<option value="200">&pound;100 - &pound;200</option>
					<option value="300">&pound;201 - &pound;300</option>
					<option value="400">&pound;301 - &pound;400</option>
					<option value="500">&pound;401 - &pound;500</option>
					<option value="999">more than &pound;500</option>
				</select>
				
				<select id="searchhowmanyorder" name="searchhowmanyorder" onchange="this.form.submit();">
					<option value="">How many order</option>
					<option value="1">1 order</option>
					<option value="2">2 orders</option>
					<option value="3">3 orders</option>
					<option value="4">4 orders</option>
					<option value="5">5 orders</option>
					<option value="6">6 orders</option>
					<option value="7">7 orders</option>
					<option value="8">8 orders</option>
					<option value="9">9 orders</option>
					<option value="10">10 orders</option>
					<option value="99">more than 10 orders</option>
				</select>
			</form>
			
			<?php  /*
			<form id="memberSearchForm" method="post" action="<?=$site_admin; ?>admin_member_extract_new2" enctype="multipart/form-data" tarfet="_blank" style="float:right;">
				<input type="hidden" id="memberReportFormSubmitted" name="memberReportFormSubmitted" value="true" />
				<input type="hidden" id="memberFillter" name="memberFillter" value="<?=$membersearch;?>" />
				<input type="submit" value="Make Emails list report" class="button" style="cursor:pointer;" />
			</form>
			
			
			
			
			<form id="memberExtractForm" method="post" action="<?=$site_admin; ?>admin_member_extract_new2" enctype="multipart/form-data" tarket="_blank" style="float:right;">
				<input type="hidden" id="memberReportFormSubmitted" name="memberReportFormSubmitted" value="true" />
				<input type="hidden" id="memberFillter" name="memberFillter" value="<?=$membersearch;?>" />
				<input type="submit" value="Make Emails list report" class="button" style="cursor:pointer;" />
			</form>

			<p style="float:right;margin-left:2em;	"><a href="<?=$site_admin; ?>admin_member_extract_new" target="_blank">Print Address (All)</a></p>

*/ ?>
			<fieldset style="width:400px;float:right;margin-top:-4em;"><legend>Print email address</legend>
			<form id="memberExtractForm" method="post" action="<?=$site_admin; ?>admin_member_extract_date" enctype="multipart/form-data" tarket="_blank" style="float:right;" target="_blank">
				<input type="hidden" id="memberReportFormSubmitted" name="memberReportFormSubmitted" value="true" />
				<input type="date" id="dateStart" name="dateStart" value="" class="datepicker" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" />
				<input type="date" id="dateEnd" name="dateEnd" value="" class="datepicker" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" />
				<label style="float:right;margin-left:1em;">Lists:<input type="radio" id="asList" name="list_or_label" value="1" checked></label>
				<label style="float:right;">Lables:<input type="radio" id="asLabel" name="list_or_label" value="2" /></label>
				<input type="submit" value="Print" class="button" style="cursor:pointer;" />
			</form>
			</fieldset>

			


			<script>
  $( function() {
    
      //$( "#dateStart,#dateEnd" ).datepicker( "option", "dateFormat", "yyyy-mm-dd" );
    
  } );
  </script>
			<br/>
		</div>
	</div>
	
	<div class="gadget">
		<div class="titlebar vertsortable_head">
			<!--<a href="#" class="hidegadget" rel="hide_block"><img src="<?//=_URL_;?>styles/images/spacer.gif" alt="picture" width="19" height="33" /></a>-->
			<h3>Member</h3>
		</div>
		<div class="gadgetblock">
			
			<div id="selectDelete">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="gwlines">
					<tr>
						<th style="width:3%;">&nbsp;</th>
						<th style="width:12%;">Member Name</th>
						<th style="width:15%; text-align:center;">Email</th>
						<th style="width:19%;">Shipping Address</th>
						<th style="width:9%; text-align:center;">Telephone</th>
						<th style="width:10%; text-align:center;">How many order</th>
						<th style="width:8%; text-align:center;">Total Spend</th>
						<th style="width:8%; text-align:center;">Measurement</th>
						<th style="width:8%; text-align:center;">Order history</th>
						<!--<th style="width:7%; text-align:center;">LastActivity</th>-->
						<th style="width:7%; text-align:center;">&nbsp;</th>
					</tr>
					
					<?php
					$k = 0;
					foreach ($listUser as $userDel){
						$k++;
						if($k % 2 == 0){
							$trstyle = " style='background:#FFF;' ";
						}else{
							$trstyle = "";
						}
						/*
						$memberSpend = smOrder::GetAll(" AND shopUserId = '{$userDel->usId}' ");
						$totalspend = 0;
						$counter = 0;
						if(!empty($memberSpend)){
							foreach($memberSpend as $item){
								$counter++;
								$totalspend += $item->shopPriceValue;
							}
						}*/
						/*
						$updeteuser = "UPDATE ex_users set ";
						$updeteuser .="usTotalSpend = '$totalspend' , ";
						$updeteuser .="usHowmanyOrder = '$counter' ";
						$updeteuser .="WHERE usId = '".$userDel->usId."' ";
						mysql_query($updeteuser);
						*/
						
						if(!empty($userDel->usCountry)){
							$mcountry = smSetting::getCountry($userDel->usCountry);
							$shocountry = $mcountry->countryName;
						}
					?>

					<tr <?=$trstyle; ?>>
						<td>
							<form id="memberVisible" method="post" action="<?=$site_admin; ?>admin_member">
								<input type="hidden" id="memberVisibleSubmitted" name="memberVisibleSubmitted" value="true" />
								<input type="hidden" id="usId" name="usId" value="<?php echo($userDel->usId); ?>" />
								<?php if($userDel->usAuthorised != 1){ ?>
								<input id="Select" name="Select" value="Select" type="image" title="Visible" src="<?=_URL_; ?>styles/images/set_home_featured.gif" alt="Visible" class="button" />
								<?php }else{ ?>
								<input id="Select" name="Select" value="Select" type="image" title="Remove visible" src="<?=_URL_; ?>styles/images/is_home_featured.gif" alt="Remove visible" class="button" />
								<?php } ?>
							</form>
						</td>
						<td><?=$userDel->usFirstname ." ". $userDel->usLastname; ?></td>
						<td style="text-align:center;"><?=$userDel->usEmail; ?></td>
						<td><?=$userDel->usAddress." ".$userDel->usAddress2." ".$userDel->usAddress3." ".$userDel->usCity." ".$userDel->usPostcode." ".$shocountry; ?></td>
						<td style="text-align:center;"><?=$userDel->usTelephone; ?></td>
						<td style="text-align:center;"><?=$userDel->usHowmanyOrder; ?></td>
						<td style="text-align:center;">&pound;<?=number_format($userDel->usTotalSpend,2); ?></td>
						<td><button onclick="window.location='admin_body_measurements/?usId=<?=$userDel->usId; ?>'; " style="width:100%; height:40px; cursor:pointer;">Edit measurement</button></td>
						<td style="text-align:center;"><a href="<?=_URL_;?>admin_order/?usId=<?=$userDel->usId; ?>" target="_blank"><img src="<?=_URL_;?>styles/images/magnifier.png" alt="View order history" title="View order history" /></a></td>
						<!--<td style="text-align:center;"><?php //echo date("Y-m-d",$userDel->usLastActivity); ?></td>-->
						<td>
							<form id="userDelete" method="post" action="<?=$site_admin; ?>admin_member">
								<input type="hidden" id="memberDeleteSubmitted" name="memberDeleteSubmitted" value="true" />
								<input type="hidden" id="usId" name="usId" value="<?php echo($userDel->usId); ?>" />
								<input id="Delete" name="Delete" value="<?php echo($userDel->usId); ?>" title="Delete user" type="image" src="<?=_URL_; ?>styles/images/cross.png" alt="Delete" class="button" onclick="javascript:return confirm('Are you sure...?')" />	
							</form> 
							<form id="userSelect" method="post" action="<?=$site_admin; ?>admin_member">
								<input type="hidden" id="memberSelectSubmitted" name="memberSelectSubmitted" value="true" />
								<input type="hidden" id="usId" name="usId" value="<?php echo($userDel->usId); ?>" />
								<input type="hidden" id="action" name="action" value="edit" />
								<input id="Select" name="Select" value="Select" type="image" title="Edit user" src="<?=_URL_; ?>styles/images/pencil.png" alt="Edit" class="button" />
							</form>
						</td>
					</tr>
					<?php } ?>
				</table>
				
			</div>	<!-- n selectDelete -->
		</div>	<!-- n gadgetblock -->
	</div>	<!-- n gadget -->
</div>	<!-- n leftblock vertsortabl -->

<?php }else{ ?>

<div class="vertsortable" style="width:40%; margin: 0 auto;">
	<!-- gadget left 1 -->
	<div class="gadget">
		<div class="titlebar vertsortable_head">
			<!--<a href="#" class="hidegadget" rel="hide_block"><img src="<?//=_URL_;?>styles/images/spacer.gif" alt="picture" width="19" height="33" /></a>-->
			<h3>Add / Edit Member</h3>
		</div>
		<div class="gadgetblock">
                        <form id="addEditForm" method="post" action="<?=$site_admin; ?>admin_member" enctype="multipart/form-data">
				<?php if (!$userErrorMessage == ""){ echo ("<p class='validationError'>".$userErrorMessage."</p>"); } ?>

				<?php smControls::smTextBox("Email address", "usEmail", $MEMBERS->usEmail); ?><br />
				<?php smControls::smTextBox("Username", "usUsername", $MEMBERS->usUsername); ?><br />
				<?php //smControls::smPasswordBox("Password", "usPassword", $MEMBERS->usPassword); ?>
				<?php smControls::smTextBox("Password", "usPassword", $MEMBERS->usPassword); ?><br />
				<?php smControls::smTextBox("Firstname", "usFirstname", $MEMBERS->usFirstname); ?><br />
				<?php smControls::smTextBox("Lastname", "usLastname", $MEMBERS->usLastname); ?><br />
				<?php smControls::smTextBox("Company/Apartment/P.O Box", "usCompany", stripcslashes($MEMBERS->usCompany)); ?><br />
				<?php smControls::smTextBox("Address", "usAddress", stripcslashes($MEMBERS->usAddress)); ?><br />
				<?php smControls::smTextBox("Address Line 2", "usAddress2", stripcslashes($MEMBERS->usAddress2)); ?><br />
				<?php smControls::smTextBox("Address Line 3", "usAddress3", stripcslashes($MEMBERS->usAddress3)); ?><br />
				<?php smControls::smTextBox("City / Town", "usCity", $MEMBERS->usCity); ?><br />
				<?php smControls::smTextBox("Postcode", "usPostcode", $MEMBERS->usPostcode); ?><br />
				
				<label>Country</label>
				<select id="usCountry" name="usCountry">
				    <?php echo memberCountryDropdownList($MEMBERS->usCountry); ?>
				</select><br/>

				<?php smControls::smTextBox("Telephone", "usTelephone", $MEMBERS->usTelephone); ?><br />
				<?php smControls::smTextBox("Fax", "usFax", $MEMBERS->usFax); ?><br /><br />
				<?php smControls::smCheckBox("Don't want to receive any info from Exact?", "usReceiveInfo", "1", $MEMBERS->usReceiveInfo); ?><br /><br />
				<?php smControls::smCheckBox("Authorize", "usAuthorised","1", $MEMBERS->usAuthorised); ?><br />
				
				<input type="hidden" id="usId" name="usId" value="<?php echo($MEMBERS->usId); ?>" />
				<input type="hidden" id="memberFormSubmitted" name="memberFormSubmitted" value="true" />
				<input type="submit" value="Save" class="button" />
			</form><br/>
		</div>	<!-- n gadgetblock -->
	</div>	<!-- n gadget -->
</div>
<?php } ?>
<br/>		<!-- n leftblock vertsortabl -->