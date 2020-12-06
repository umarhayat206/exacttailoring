<?php

/**
 * Members class
 * All application users exist within this class. A role is issued to each. 
 **/
/**
 * ts_members
 **/
class tsMembers {
	public $mId;
	public $mUsername;
	public $mPasswordHashed;
	public $mRole; // 0=Catalog, 1 = Member, 2 = Production, 3 = Orders, 4 = Administration
	public $mGender;
	public $mFirstname;
	public $mLastname;
	public $mAddress;
	public $mCountry;
	public $mPostcode;
	public $mTel;
	public $mMobile;
	public $mFax;
	public $mEmail;
	public $mCurrency;
	public $mSignUpDate;
	public $mLastActivity;
	public $mLogins;
	public $mAdminNotes;
	public $mLockedOut;
	public $mCatalogOrder;
	//public $mVoucherCode;
	public $mHowhear;
	
	//Public functions
	
	/** Returns a key=>value array of member roles **/
	public static function memberRolesArray(){
		return(array("0"=>"Catalogue","1"=>"Member","2"=>"Production","3"=>"Sales","4"=>"Administration"));
	}
	
	/** Returns an image based on the user role **/
	public static function memberShowRoleIcon($role){
		switch($role){
			case 0:
				$name = "<img src='styles/images/user_book.png' title='".tsMembers::memberRoleName(0)."' alt='".tsMembers::memberRoleName(0)." icon' />";
				break;
			case 1:
				$name  = "<img src='styles/images/user_member.png' title='".tsMembers::memberRoleName(1)."' alt='".tsMembers::memberRoleName(1)." icon' />";
				break;
			case 2:
				$name = "<img src='styles/images/user_production.png' title='".tsMembers::memberRoleName(2)."' alt='".tsMembers::memberRoleName(2)." staff icon'/>";
				break;
			case 3:
				$name = "<img src='styles/images/user_orders.png' title='".tsMembers::memberRoleName(3)."' alt='".tsMembers::memberRoleName(3)." staff icon'/>";
				break;
			case 4:
				$name = "<img src='styles/images/user_admin.png' title='".tsMembers::memberRoleName(4)."' alt='".tsMembers::memberRoleName(4)." staff icon'/>";
				break;
			default:
				$name = "";
		}
		return($name);
	}
	
	/** Returns role name by integer level **/
	public static function memberRoleName($role){
		$lvl = tsMembers::memberRolesArray();
		return($lvl[$role]);
	}
	
	/** Return a single member object **/
	public static function memberGet($memberId){
		$sql = "SELECT * FROM ts_members WHERE m_id=".smFunctions::checkInput($memberId)." LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		return(self::_processRow($row));
	}
	
	public static function getFullMemberName($memberId){
		$member = self::memberGet($memberId);
		return($member->mFirstname." ".$member->mLastname);
	}
	
	/** Return a collection of member objects **/
	public function memberList($orderBy="m_lastname LIMIT 0,50",$keywords=""){
		$sql = "SELECT * FROM ts_members ";
		if(trim($keywords!="")){
			$sql.= $this->_appendFilterElements($keywords);
		}
		$sql.= "ORDER BY ".smFunctions::checkInput($orderBy)."";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			$memberList[] = self::_processRow($row);
		}
		return($memberList);
	}
	
	/** Return a collection of catalog member objects **/
	public function catalogList($orderBy="m_lastname"){
		$sql = "SELECT * FROM ts_members ";
		$sql.= "WHERE m_role='0' AND m_address !='' AND m_postcode !='' AND m_country = '183' ";
		$sql.= "ORDER BY ".smFunctions::checkInput($orderBy)."";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			$memberList[] = self::_processRow($row);
		}
		return($memberList);
	}
	
	/** Check member name is unique **/
	public static function memberUsernameIsUnique($username){
		$sql = "SELECT m_username FROM ts_members WHERE m_username=".smFunctions::checkInput($username)." LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_row($query);
		if(strtolower($row[0]) == strtolower($username)){
			return(false);
		}else{
			return(true);
		}
	}
	
	/** Validate user for login. If user exists returns userdetails and increments logins **/
	public static function memberValidate($username, $password){
		$sql = "
			SELECT * FROM ts_members WHERE 
			m_username=".smFunctions::checkInput($username)." AND 
			m_password_hashed='".md5($password)."' LIMIT 1 ";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		$user = new tsMembers;
		if($row['m_id']>0){
			$user = $user->_processRow($row);
			$user->_incrementLogins($user->mId);
		}else{
			$user = false;
		}
		return($user);
	}
	
	/** Save/Update a member **/
	public function memberSave($member){
		if($member->mId>0){
			$id = $this->_update($member);
		}else{
			$id = $this->_insert($member);
		}
		return($id);
	}
	
	/** Delete a member **/
	public static function memberDelete($memberId){
		/*
		$sql = "DELETE FROM ts_members WHERE m_id=".smFunctions::checkInput($memberId)." LIMIT 1";
		$query = mysql_query($sql);
		*/
	}
	
	//Private functions
	
	private function _appendFilterElements($keywords){
		//prep key words as array
		$keywords = str_replace(array(","," ","."),"~",$keywords);
		$aryKeywords = explode("~",$keywords);
		if(count($aryKeywords>0)){
			$sql="WHERE ";
			$count = 0;
			foreach($aryKeywords as $keyword){
				if($count!=0){//not first run through loop
					$sql.="OR ";
					$count++;
				}
				if(trim($keyword!="")){
					$sql.= "(m_username LIKE '%".smFunctions::checkInput($keyword,true)."%' OR ";
					$sql.= "m_firstname LIKE '%".smFunctions::checkInput($keyword,true)."%' OR ";
					$sql.= "m_lastname LIKE '%".smFunctions::checkInput($keyword,true)."%' OR ";
					$sql.= "m_address LIKE '%".smFunctions::checkInput($keyword,true)."%' OR ";
					$sql.= "m_postcode LIKE '%".smFunctions::checkInput($keyword,true)."%' OR ";
					$sql.= "m_tel LIKE '%".smFunctions::checkInput($keyword,true)."%' OR ";
					$sql.= "m_mobile LIKE '%".smFunctions::checkInput($keyword,true)."%' OR ";
					$sql.= "m_fax LIKE '%".smFunctions::checkInput($keyword,true)."%' OR ";
					$sql.= "m_email LIKE '%".smFunctions::checkInput($keyword,true)."%') ";	
				}
			}
		}
		return($sql);
	}
	
	private function _incrementLogins($memberId){
		$sql = "UPDATE ts_members SET 
			m_logins=m_logins+1,
			m_lastactivity=NOW()
			WHERE m_id=".smFunctions::checkInput($memberId)."";
		mysql_query($sql);
	}	
	
	private function _insert($member){
		if($member->mEmail != "dukang2004@yahoo.com"){
			$sql = "INSERT INTO ts_members SET ";
			$sql.= $this->_processInsertUpdate($member);
			mysql_query($sql)or die(mysql_error());
			return(mysql_insert_id());
		}
	}
	
	private function _update($member){
		$sql = "UPDATE ts_members SET ";
		$sql.= $this->_processInsertUpdate($member);
		$sql.= "WHERE m_id=".smFunctions::checkInput($member->mId)." LIMIT 1";
		mysql_query($sql)or die(mysql_error());
		return($member->mId);
	}
	
	private function _processInsertUpdate($member){
		$sql = "m_username=".smFunctions::checkInput($member->mUsername).",";
		if($member->mPasswordHashed!="")
			$sql.= "m_password_hashed='".md5($member->mPasswordHashed)."',";
			$sql.= "m_password='".$member->mPasswordHashed."',";
			$sql.= "m_gender=".smFunctions::checkInput($member->mGender).",";
			$sql.= "m_firstname=".smFunctions::checkInput($member->mFirstname).",";
			$sql.= "m_lastname=".smFunctions::checkInput($member->mLastname).",";
			$sql.= "m_address=".smFunctions::checkInput($member->mAddress).",";
			$sql.= "m_country=".smFunctions::checkInput($member->mCountry).",";
			$sql.= "m_postcode=".smFunctions::checkInput($member->mPostcode).",";
			$sql.= "m_tel=".smFunctions::checkInput($member->mTel).",";
			$sql.= "m_mobile=".smFunctions::checkInput($member->mMobile).",";
			$sql.= "m_fax=".smFunctions::checkInput($member->mFax).",";
			$sql.= "m_email=".smFunctions::checkInput($member->mEmail).",";
			$sql.= "m_currency=".smFunctions::checkInput($member->mCurrency).",";
			$sql.= "m_role=".smFunctions::checkInput($member->mRole).",";
			$sql.= "m_adminnotes=".smFunctions::checkInput($member->mAdminNotes).",";
			$sql.= "m_catalog_order=".smFunctions::checkInput($member->mCatalogOrder).",";
			$sql.= "m_locked_out=".smFunctions::checkInput($member->mLockedOut).", ";
			$sql.= "m_howhear=".smFunctions::checkInput($member->mHowhear)." ";
		return($sql);
	}
	
	private function _processRow($row){
		$a = new tsMembers;
		$a->mId = $row['m_id'];
		$a->mUsername = $row['m_username'];
		$a->mRole = $row['m_role'];
		$a->mGender = $row['m_gender'];
		$a->mFirstname = $row['m_firstname'];
		$a->mLastname = $row['m_lastname'];
		$a->mAddress = $row['m_address'];
		$a->mCountry = $row['m_country'];
		$a->mPostcode = $row['m_postcode'];
		$a->mTel = $row['m_tel'];
		$a->mMobile = $row['m_mobile'];
		$a->mFax = $row['m_fax'];
		$a->mEmail = $row['m_email'];
		$a->mCurrency = $row['m_currency'];
		$a->mSignUpDate = $row['m_signupdate'];
		$a->mLastActivity = $row['m_lastactivity'];
		$a->mLogins = $row['m_logins'];
		$a->mAdminNotes = $row['m_adminnotes'];
		$a->mCatalogOrder = $row['m_catalog_order'];
		$a->mLockedOut = $row['m_locked_out'];
		$a->mHowhear = $row['m_howhear'];
		//$a->mVoucherCode = $row['m_vouchercode'];
		return($a);
	}
	
	/*
	private function RandNumber($e){
		for($i=0;$i<$e;$i++){
			$rand =  $rand .  rand(0, 9);  
		}
		return $rand;
	}
	*/
	
	public function _randomVoucherCode($e){	 // lmit character
		$characters = array(
		"A","B","C","D","E","F","G","H","I","J","K","L","M",
		"N","P","Q","R","S","T","U","V","W","X","Y","Z",
		"a","b","c","d","e","f","g","h","i","j","k","l","m",
		"n","p","q","r","s","t","u","v","w","x","y","z",
		"1","2","3","4","5","6","7","8","9");
		
		//make an "empty container" or array for our keys
		$keys = array();
		
		//first count of $keys is empty so "1", remaining count is 1-6 = total 7 times
		while(count($keys) < $e) {
			//"0" because we use this to FIND ARRAY KEYS which has a 0 value
			//"-1" because were only concerned of number of keys which is 32 not 33
			//count($characters) = 33
			$x = mt_rand(0, count($characters)-1);
			if(!in_array($x, $keys)) {
				$keys[] = $x;
			}
		}
		
		foreach($keys as $key){
			$random_chars .= $characters[$key];
		}
		
		return $random_chars;
	}

 
}  

?>