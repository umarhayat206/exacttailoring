<?php
session_start();
include_once('includes/globals.php');
include_once('includes/html_head.php');
include_once("forms/form_head.php");


if($_POST['submitinfoform']){
    $updatememberinfo=mysql_query("
        UPDATE ex_users SET
        usFirstname='".$_POST['membersavefirstname']."', 
        usLastname='".$_POST['membersavelastname']."', 
        usTelephone='".$_POST['membersavetelephone']."', 
        usGender='".$_POST['membersavegender']."', 
        usMobile='".$_POST['membersavemobile']."', 
        usFax='".$_POST['membersavefax']."'
        WHERE usId='".$_SESSION['chkmemberuser']."'
        ");
}

if($_POST['submitsavepasswordform']){
    $updatememberpassword=mysql_query("
        UPDATE ex_users SET
        usUsername='".$_POST['membersaveusername']."', 
        usEmail='".$_POST['membersaveemail']."', 
        usPassword='".$_POST['membersavepassword']."', 
        usPasswordHashed='".md5($_POST['membersavepassword'])."'
        WHERE usId='".$_SESSION['chkmemberuser']."'
        ");
}

if($_POST['submitaddressform']){
    $updatememberaddress=mysql_query("
        UPDATE ex_users SET
        usCompany='".$_POST['membercompany']."',
        usAddress='".$_POST['membersaveaddress']."',
        usAddress2='".$_POST['membersaveaddress2']."',
        usAddress3='".$_POST['membersaveaddress3']."',
        usCity='".$_POST['membersavecity']."',
        usPostcode='".$_POST['membersavepostcode']."', 
        usCountry='".$_POST['membersavecountry']."'
        WHERE usId='".$_SESSION['chkmemberuser']."'
        ");
}

if($_POST['submitmeasurement']){
    $MEASUREMENT = new smMeasurement;
    $MEASUREMENT->measurementId = $_POST['measurementId'];
    $MEASUREMENT->usId = $_SESSION['chkmemberuser'];
    $MEASUREMENT->measurementMetric = $_POST['membermeasurementMetric'];
    $MEASUREMENT->measurementType = $_POST['membermeasurementType'];
    $MEASUREMENT->measurementShirtNeck = str_replace(",","",$_POST['membermeasurementShirtNeck']);
    $MEASUREMENT->measurementShirtChest = str_replace(",","",$_POST['membermeasurementShirtChest']);
    $MEASUREMENT->measurementShirtStomach = str_replace(",","",$_POST['membermeasurementShirtStomach']);
    $MEASUREMENT->measurementShirtHips = str_replace(",","",$_POST['membermeasurementShirtHips']);
    $MEASUREMENT->measurementShirtLenght = str_replace(",","",$_POST['membermeasurementShirtLenght']);
    $MEASUREMENT->measurementShirtSleeveLength = str_replace(",","",$_POST['membermeasurementShirtSleeveLength']);
    $MEASUREMENT->measurementShirtShortSleeve = str_replace(",","",$_POST['membermeasurementShirtShortSleeve']);
    $MEASUREMENT->measurementShirtCuff = str_replace(",","",$_POST['membermeasurementShirtCuff']);
    $MEASUREMENT->measurementShirtUpperarm = str_replace(",","",$_POST['membermeasurementShirtUpperarm']);
    $MEASUREMENT->measurementShirtShoulder = str_replace(",","",$_POST['membermeasurementShirtShoulder']);
    $MEASUREMENT->measurementTrousersA = str_replace(",","",$_POST['membermeasurementTrousersA']);
    $MEASUREMENT->measurementTrousersB = str_replace(",","",$_POST['membermeasurementTrousersB']);
    $MEASUREMENT->measurementTrousersC = str_replace(",","",$_POST['membermeasurementTrousersC']);
    $MEASUREMENT->measurementTrousersD = str_replace(",","",$_POST['membermeasurementTrousersD']);
    $MEASUREMENT->measurementTrousersE = str_replace(",","",$_POST['membermeasurementTrousersE']);
    $MEASUREMENT->measurementTrousersF = str_replace(",","",$_POST['membermeasurementTrousersF']);
    $MEASUREMENT->measurementTrousersG = str_replace(",","",$_POST['membermeasurementTrousersG']);
    $MEASUREMENT->measurementBoxersWaist = str_replace(",","",$_POST['membermeasurementBoxersWaist']);
    $MEASUREMENT->measurementBoxersTopofLeg = str_replace(",","",$_POST['membermeasurementBoxersTopofLeg']);
    $MEASUREMENT->measurementBoxersLength = str_replace(",","",$_POST['membermeasurementBoxersLength']);
    $MEASUREMENT->measurementBoxersHip = str_replace(",","",$_POST['membermeasurementBoxersHip']);
    $MEASUREMENT->measurementBoxersInsideLeg = str_replace(",","",$_POST['membermeasurementBoxersInsideLeg']);
    $MEASUREMENT->measurementSpecialDetails = mysql_real_escape_string($_POST['measurementSpecialDetails']);
    
    $checkmeasurement = smMeasurement::checkAddEdit($_SESSION['chkmemberuser']);
    
    if($checkmeasurement=="update"){
	$MEASUREMENTID=$MEASUREMENT->Update($MEASUREMENT);
    }else{
	$MEASUREMENTID=$MEASUREMENT->Add($MEASUREMENT);
    }

}

function statusDropdown($id){
    if($id==1){
        $chk1=" selected='selected' ";
    }elseif($id==2){
        $chk2=" selected='selected' ";
    }elseif($id==3){
        $chk3=" selected='selected' ";
    }elseif($id==4){    
        $chk4=" selected='selected' ";
    }elseif($id==5){    
        $chk5=" selected='selected' ";
    }
    $htmlReturn="<option value='1' $chk1 >Payment awaiting confirmation</option>
        <option value='2' $chk2 >Order is now in production</option>
        <option value='3' $chk3 >Order shipped</option>
        <option value='4' $chk4 >Order completed</option>
        <option value='5' $chk5 >Aborted</option>";
    
    return $htmlReturn;
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

if(empty($_SESSION['chkmemberuser'])){ // member not login 
    
    echo "<script language='javascript' type='text/javascript'>
            alert('You are not login. Please login to your account.');
            window.location='"._URL_."';
        </script>";
    
	//echo $_SESSION['chklevel'] ." - ". $_SESSION['chkmemberuser'] ." - ". $_SESSION['membername']  ." - ".  $_SESSION['memberlastactivity'] = $row['usLastActivity'];;

}else{
    
    //echo $_SESSION['chklevel'] ." - ". $_SESSION['chkmemberuser'] ." - ". $_SESSION['membername']  ." - ".  $_SESSION['memberlastactivity'] = $row['usLastActivity'];;

    $_SESSION['memberDetails'] = smUser::GetIndividual($_SESSION['chkmemberuser']);
    $memberMeasurement = smMeasurement::GetIndividual($_SESSION['chkmemberuser']);
    
    //print_r($memberMeasurement);
    //echo $memberMeasurement->measurementId;

?>

<script type="text/javascript">
<!--
function chkMemberConfirmPassword() {
	var errorMsg = "";
	var frmsavepassword=document.getElementById('editmemberpasswordform');
        var _returnsavepasswordform = true ;

	if(frmsavepassword.membersaveconfirmpassword.value != frmsavepassword.membersavepassword.value){
		alert("Please correct confirm password.");
		frmsavepassword.membersaveconfirmpassword.select();
		_returnsavepasswordform =  false;
	}	

        return _returnsavepasswordform;
}		




//-->
</script>
<div class="container-fluid">


<div class="row row-offcanvas row-offcanvas-left">
    <div class="col-sm-3 col-md-2 sidebar-offcanvas" id="sidebar" role="navigation">
        
        
            <h1 style="margin-top:-30px;" class="text-center" id="contactus-h1">Account</h1>
        
        
        <ul class="nav nav-sidebar">
            <li><a href="javascript:void(0);" class="account"><i class="icon-caret-right"></i>  My Account</a></li>
            
            <li><a href="javascript:void(0);" class="login-detail"><i class="icon-caret-right"></i> Change Password</a></li>
           
           <li><a href="javascript:void(0);" class="order-history"><i class="icon-caret-right"></i> View Order History</a></li>
            <!--<li><a class="invarseColor" href="#"><i class="icon-caret-right"></i> My Fabric</a></li>-->
            <li><a  href="<?=_URL_; ?>my-designs"><i class="icon-caret-right"></i> My Designs</a></li>
            <li><a  href="<?=_URL_; ?>customer-comments"><i class="icon-caret-right"></i> Leave Comment</a></li>
            <li><a  href="<?=_URL_; ?>newsletter"><i class="icon-caret-right"></i> Newsletter</a></li>
            <li class=""><a  href="<?=_URL_;?>memberlogout"><i class="icon-caret-right"></i> Logout</a></li>
        </ul>
       
    </div>
    <div class="col-sm-9 col-md-10">
    <div class="memberpanel-div">
        
        <p class="visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas"><i class="glyphicon glyphicon-chevron-left"></i></button>
          </p>
            
         <h1 id="contactus-h1">Member Panel</h1>
            

            <div class="account-a-div">
        <a href="javascript:void(0);" class="account account-a"><i class="icon-caret-right"></i> Edit Account Information</a>
               </div> 
        <div class="memberpanelhiddenbox" style="display:none;">
         
         
        <form id="editmemberinfoform" class="" method="post" action="<?=_URL_;?>my-account" enctype="multipart/form-data">
        <div class="row">
        <div class="col-lg-6">   
        <fieldset style="">
        <h3 id="account-h1" class="text-center">Personal information</h3>
        
        <label>Firstname</label><input type="text" id="membersavefirstname" name="membersavefirstname" value="<?=$_SESSION['memberDetails']->usFirstname; ?>" class="form-control account-input" /><br/>
        <label>Lastname</label><input type="text" id="membersavelastname" name="membersavelastname" value="<?=$_SESSION['memberDetails']->usLastname; ?>" class="form-control account-input"/><br/>
        <label>Gender</label>
        <select id="membersavegender" name="membersavegender" class="form-control account-input">
            <?php
            if($_SESSION['memberDetails']->usGender == 1){
                $gendeselect1 =" selected='selected' ";
            }else{
                $gendeselect2 =" selected='selected' ";
            }
            ?>
            <option value="1" <?=$gendeselect1;?>>Male</option>
            <option value="2" <?=$gendeselect2;?>>Female</option>
        </select>
       </fieldset><br>
       </div>
       <div class="col-lg-6"> 

       <fieldset style="">
        <h4 id="account-h1" class="text-center">Contact details</h4><br>
        <label>Telephone</label><input type="text" id="membersavetelephone" name="membersavetelephone" value="<?=$_SESSION['memberDetails']->usTelephone; ?>"class="form-control account-input" /><br/>
        <label>Mobile</label><input type="text" id="membersavemobile" name="membersavemobile" value="<?=$_SESSION['memberDetails']->usMobile; ?>" class="form-control account-input" /><br/>
        <label>Fax</label><input type="text" id="membersavefax" name="membersavefax" value="<?=$_SESSION['memberDetails']->usFax; ?>" class="form-control account-input"  />

        </fieldset>
      </div>
      </div>
        <input type="hidden" id="submitinfoform" name="submitinfoform" value="true" />
        <center><button type="submit" class="btn btn-default-shop">Save</button></center>
      <input type="hidden" id="memberregisformsubmit" name="memberregisformsubmit" value="true" />
      </form>
       
       </div><br>
                
               <div class="account-a-div"> 
            <a href="javascript:void(0);" class="login-detail account-a"><i class="icon-caret-right"></i> Change Login Details</a>
        </div>
                
        <div class="login-detail-div" style="display:none;">
                       
        <form id="editmemberpasswordform" class="" method="post" action="<?=_URL_;?>my-account" enctype="multipart/form-data" onsubmit="return chkMemberConfirmPassword()">
        
        <fieldset>
        <h4 id="account-h1" class="text-center">Preffered login details</h4>
        <label>Username</label><input type="text" id="membersaveusername" name="membersaveusername" value="<?=$_SESSION['memberDetails']->usUsername; ?>" class="form-control account-input" /><br/>
        <label>Email address *</label><input type="text" id="membersaveemail" name="membersaveemail" value="<?=$_SESSION['memberDetails']->usEmail; ?>" class="required email form-control account-input" /><br/>
        <label>Password *</label><input type="password" id="membersavepassword" name="membersavepassword" value="<?=$_SESSION['memberDetails']->usPassword; ?>" class="required form-control account-input"  /><br>
        <label>Confirm Password *</label><input type="password" id="membersaveconfirmpassword" name="membersaveconfirmpassword" value="<?=$_SESSION['memberDetails']->usPassword; ?>" class="required form-control account-input" /><br/>
        </fieldset>

    
         <input type="hidden" id="submitsavepasswordform" name="submitsavepasswordform" value="true" /><br><br>
        <center><button type="submit" class="btn btn-default-shop">Save</button></center>
        </form>
                         
        </div><br>
                
    <div class="account-a-div">
    <a href="javascript:void(0);" class="Modify-shipping account-a"><i class="icon-caret-right"></i> Modify Shipping Address</a>
    </div>
               
    <div class="Modify-shipping-address" style="display:none;">

        <form id="editmemberaddressform" class="" method="post" action="<?=_URL_;?>my-account" enctype="multipart/form-data">
         <fieldset>
        <h4 id="account-h1" class="text-center">Shipping Address</h4>

        <label>Organisation Name</label>
        <input type="text" id="membercompany" name="membercompany" value="<?=$_SESSION['memberDetails']->usCompany; ?>" placeholder="Organisation Name" class="form-control account-input" /><br/>

        <label>Address Line One</label>
        <input type="text" id="membersaveaddress" name="membersaveaddress" value="<?=$_SESSION['memberDetails']->usAddress; ?>" placeholder="" class="form-control account-input"/><br/>

        <label>Address Line Two</label>
        <input type="text" id="membersaveaddress2" name="membersaveaddress2" value="<?=$_SESSION['memberDetails']->usAddress2; ?>" placeholder="" class="form-control account-input"/><br/>

        <label>Address Line Three</label>
        <input type="text" id="membersaveaddress3" name="membersaveaddress3" value="<?=$_SESSION['memberDetails']->usAddress3; ?>" placeholder="" class="form-control account-input"/><br/>

        <label>City / Town</label>
        <input type="text" id="membersavecity" name="membersavecity" value="<?=$_SESSION['memberDetails']->usCity; ?>" placeholder="City / Town" class="form-control account-input" /><br/>

        <label>Postcode</label><input type="text" id="membersavepostcode" name="membersavepostcode" value="<?=$_SESSION['memberDetails']->usPostcode; ?>" class="account-input form-control" /><br/>

	    <label>Country</label>
	    <select id="membersavecountry" name="membersavecountry" class="form-control account-input">
            <?php echo memberCountryDropdownList($_SESSION['memberDetails']->usCountry); ?>
        </select><br/>
        </fieldset>
    
       <input type="hidden" id="submitaddressform" name="submitaddressform" value="true" />
        <center><button type="submit" class="btn btn-default-shop">Save</button></center>
        </form>
                        
        </div><br>
                
                 <div class="account-a-div">
                <a href="javascript:void(0)" class="modify-measurement account-a"><i class="icon-caret-right"></i> Modify Measurement</a>
                </div>
                
                    <div class="modify-measurement-div"style="display:none;">
                        <?php include_once('forms/member-measurement-form.php'); ?>
                    </div>
                
           

            <?php include_once('forms/member-order-history.php'); ?>
            <?php include_once('forms/member-voucher-history.php'); ?>

    
    </div> <!-- end span9--> 
     </div>
    
    

</div><!--end row--><br><br><br><br><br>
</div>

<?php

}   // n check customer login

include_once('forms/form_end.php');
?>