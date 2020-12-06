<?php

class smUser{

	function GetAll($adminlevel, $search){
		/*
		if(empty($page)){
			$sql="select * from ex_users where usRoLevel = '$adminlevel' order by usUsername asc limit 0,25";
		}else{
			$sql="select * from ex_users where usRoLevel = '$adminlevel' order by usUsername asc limit ".(($page-1)*25).",25" ;
		}
		*/
		
		$sql="select * from ex_users where usRoLevel = '$adminlevel' $search order by usSignupdate desc LIMIT 200";
		
		$query=mysql_query($sql);
		$listUser = array();
		$counter = 0;
		while ($row = mysql_fetch_array($query)){
		 	$listUser[$counter]=smUser::_processRow($row);
			$counter++;
		}
		return $listUser;			
	}
	
	function GetAllList(){		//dependant for tasks
		$query = mysql_query("SELECT * FROM ex_users");	
		$listUser = array();
		$counter = 0;
		while ($row = mysql_fetch_array($query)){
			$listUser[$counter]=smUser::_processRow($row);
			$counter++;
		}
		return $listUser;	
	}
	
	public function getRoleName($role){
		if($role==1){
			$roleName="Administrator";
		}elseif($role==2){
			$roleName="Member";
		}
		return $roleName;
	}

	public function GetIndividual($usId){
		$query = mysql_query("SELECT * FROM ex_users WHERE usId='$usId' ");
		$row = mysql_fetch_array($query);
		$theUser = array();
		$theUser=smUser::_processRow($row);
		return $theUser;
	}
	
	public function setVisible($id){
		$sql = mysql_query("SELECT usAuthorised FROM ex_users WHERE usId = '$id' ");
		$row = mysql_fetch_array($sql);
		$status = $row['usAuthorised'];

		if($status==1){		// remove visible
			$sqlUpdate = "UPDATE ex_users SET prop_visible='0' WHERE usId='$id' ";
			mysql_query($sqlUpdate);
		}else{	// set visible
			$sqlUpdate = "UPDATE ex_users SET prop_visible='1' WHERE usId='$id' ";
			mysql_query($sqlUpdate);
		}
	}
	
	public function Add($newUser){
		$sqlInsert = "INSERT INTO ex_users SET ";
		$sqlInsert .="usFirstname='".$newUser->usFirstname."',";
		$sqlInsert .="usLastname='".$newUser->usLastname."',";
		$sqlInsert .="usPassword='".$newUser->usPassword."',";
		$sqlInsert .="usEmail='".$newUser->usEmail."',";
		$sqlInsert .="usCompany='".$newUser->usCompany."',";
		$sqlInsert .="usAddress='".$newUser->usAddress."',";
		$sqlInsert .="usAddress2='".$newUser->usAddress2."',";
		$sqlInsert .="usAddress3='".$newUser->usAddress3."',";
		$sqlInsert .="usCity='".$newUser->usCity."',";
		$sqlInsert .="usTelephone='".str_replace(array(" ","-"),"",$newUser->usTelephone)."',";
		$sqlInsert .="usMobile='".str_replace(array(" ","-"),"",$newUser->usMobile)."',";
		$sqlInsert .="usLastActivity='".mktime()."',";
		$sqlInsert .="usAuthorised='".$newUser->usAuthorised."',";
		$sqlInsert .="usPasswordHashed='".$newUser->usPasswordHashed."', " ;
		$sqlInsert .="usGender='".$newUser->usGender."', " ;
		$sqlInsert .="usCountry='".$newUser->usCountry."', " ;
		$sqlInsert .="usPostcode='".$newUser->usPostcode."', " ;
		$sqlInsert .="usFax='".$newUser->usFax."', " ;
		$sqlInsert .="usLogins='".$newUser->usLogins."', " ;
		$sqlInsert .="usTotalSpend='".$newUser->usTotalSpend."', " ;
		$sqlInsert .="usHowmanyOrder='".$newUser->usHowmanyOrder."', " ;
		$sqlInsert .="usRoLevel='".$newUser->usRoLevel."' ";
		mysql_query($sqlInsert);	
	}
	
	public function Update($userUpdate){		
		$sqlUpdate = "UPDATE ex_users SET ";
		$sqlUpdate .="usFirstname='".$userUpdate->usFirstname."', " ;
		$sqlUpdate .="usLastname='".$userUpdate->usLastname."',";
		$sqlUpdate .="usUsername='".$userUpdate->usUsername."', " ;
		$sqlUpdate .="usPassword='".$userUpdate->usPassword."', " ;
		$sqlUpdate .="usEmail='".$userUpdate->usEmail."', " ;
		$sqlUpdate .="usCompany='".$userUpdate->usCompany."',";
		$sqlUpdate .="usAddress='".$userUpdate->usAddress."',";
		$sqlUpdate .="usAddress2='".$userUpdate->usAddress2."',";
		$sqlUpdate .="usAddress3='".$userUpdate->usAddress3."',";
		$sqlUpdate .="usCity='".$userUpdate->usCity."',";
		$sqlUpdate .="usTelephone='".str_replace(array(" ","-"),"",$userUpdate->usTelephone)."', " ;
		$sqlUpdate .="usMobile='".str_replace(array(" ","-"),"",$userUpdate->usMobile)."', " ;
		//$sqlUpdate .="usLastActivity='".mktime()."', " ;
		$sqlUpdate .="usAuthorised='".$userUpdate->usAuthorised."', " ;
		$sqlUpdate .="usPasswordHashed='".$userUpdate->usPasswordHashed."', " ;
		//$sqlUpdate .="usGender='".$userUpdate->usGender."', " ;
		$sqlUpdate .="usCountry='".$userUpdate->usCountry."', " ;
		$sqlUpdate .="usPostcode='".$userUpdate->usPostcode."', " ;
		$sqlUpdate .="usFax='".$userUpdate->usFax."', " ;
		$sqlUpdate .="usReceiveInfo='".$userUpdate->usReceiveInfo."' " ;
		//$sqlUpdate .="usTotalSpend='".$userUpdate->usTotalSpend."', " ;
		//$sqlUpdate .="usHowmanyOrder='".$userUpdate->usHowmanyOrder."', " ;
		//$sqlUpdate .="usRoLevel='".$userUpdate->usRoLevel."' " ;
		$sqlUpdate .="WHERE usId='".$userUpdate->usId."' ";
		mysql_query($sqlUpdate) or die(mysql_error());
	}
	
	public function Delete($usId){
		$sqlDelete = "DELETE FROM ex_users WHERE usId='$usId' ";
		mysql_query($sqlDelete);
	}
	
	function _processRow($row){
		$item = new smUser;
		$item->usId = $row['usId'];
		$item->usUsername = $row['usUsername'];
		$item->usFirstname = $row['usFirstname'];
		$item->usLastname = $row['usLastname'];
		$item->usPassword = $row['usPassword'];
		$item->usEmail = $row['usEmail'];
		$item->usCompany = $row['usCompany'];
		$item->usAddress = $row['usAddress'];
		$item->usAddress2 = $row['usAddress2'];
		$item->usAddress3 = $row['usAddress3'];
		$item->usCity = $row['usCity'];
		$item->usTelephone = $row['usTelephone'];
		$item->usMobile = $row['usMobile'];
		//$item->usDateAdded = $row['usDateAdded'];
		$item->usLastActivity = $row['usLastActivity'];
		$item->usAuthorised = $row['usAuthorised'];
		$item->usRoLevel = $row['usRoLevel'];
		$item->usPasswordHashed = $row['usPasswordHashed'];
		$item->usGender = $row['usGender'];
		$item->usCountry = $row['usCountry'];
		$item->usPostcode = $row['usPostcode'];
		$item->usFax = $row['usFax'];
		$item->usSignupdate = $row['usSignupdate'];
		$item->usLogins = $row['usLogins'];
		$item->usTotalSpend = $row['usTotalSpend'];
		$item->usHowmanyOrder = $row['usHowmanyOrder'];
		$item->usReceiveInfo = $row['usReceiveInfo'];
		return($item);
	}
	
	//--------------------------
	
	public function catalogRequests(){
		$query = mysql_query("SELECT * FROM ex_ordercatalogue ORDER BY id DESC");	
		$returnList = array();
		$counter = 0;
		while ($row = mysql_fetch_array($query)){
			$listcatalogue = new smUser;
			$listcatalogue->catalogueid=$row['id'];
			$listcatalogue->customerdetails=$row['customerdetails'];
			$listcatalogue->name=$row['name'];
			$listcatalogue->surname=$row['surname'];
			$listcatalogue->address=$row['address'];
			$listcatalogue->city=$row['city'];
			$listcatalogue->country=$row['country'];
			$listcatalogue->postcode=$row['postcode'];
			$listcatalogue->telephone=$row['telephone'];
			$listcatalogue->email=$row['email'];
			$returnList[$counter] = $listcatalogue;
			$counter++;
		}
		return $returnList;	
	}
	
	public function DeleteCatalogRequests(){
		$sqlDelete = mysql_query("DELETE FROM ex_ordercatalogue");
	}
	
}
?>
