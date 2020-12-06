<?php 

class getMember{
		
	public function GetMemberDelivery(){		
		$sql="SELECT * FROM pt_users WHERE usId = '".$_SESSION['ChkMemId']."' " ;
		$query=mysql_query($sql);
		$row = mysql_fetch_array($query);
		
		$member = new getMember;
		$member->usFirstname = $row['usFirstname'];
		//$member->usLastname = $row['usLastname'];
		$member->usAddress = $row['usAddress'];

		return $member;
	}

	/*static function recursiveTree($id = "0", $tree = array(), $depth = 0){
		$sql = "SELECT * FROM ch_locations WHERE loLoId=".$id." ORDER BY loName ";
		$query = mysql_query($sql);
			if(mysql_num_rows($query)>0){
				$depth++;
				while($row = mysql_fetch_array($query)){
					$localToAddToList = new getMember;
					
					$localToAddToList->loId = $row['loId'];
					$localToAddToList->loName = $row['loName'];
					$localToAddToList->loLoId = $row['loLoId'];
					
					$tree[] = array($localToAddToList,$depth);
					$tree = self::recursiveTree($row['loId'],$tree,$depth);
				}
			}
		$depth--;
		return($tree);
	}*/
	
	public function GetMyDetails($usId){
		$sqlSelect = "SELECT * FROM pt_users WHERE usId='".$usId."' ";
		$query = mysql_query($sqlSelect);
		$theUserDetail = new getMember;
		
		$row = mysql_fetch_array($query);
		$theUserDetail->usId = $row['usId'];
		$theUserDetail->usFirstname = $row['usFirstname'];
		//$theUserDetail->usLastname = $row['usLastname'];
		//$theUserDetail->usUsername = $row['usUsername'];
		$theUserDetail->usPassword = $row['usPassword'];
		$theUserDetail->usEmail = $row['usEmail'];
		$theUserDetail->usAddress = $row['usAddress'];
		$theUserDetail->usTelephone = $row['usTelephone'];
		$theUserDetail->usMobile = $row['usMobile'];
		$theUserDetail->usDateAdded = $row['usDateAdded'];
		$theUserDetail->usLastActivity = date("Y-m-d",$row['usLastActivity']);
		$theUserDetail->usAuthorised = $row['usAuthorised'];

		return($theUserDetail);
	}

	public function GetMyWishlist(){
		$sql = "SELECT * FROM pt_user_favourites WHERE ufUsId='".$_SESSION['ChkMemId']."' ";
		$query = mysql_query($sql);
		$items = array();
		$counter=0;	
		while ($row = mysql_fetch_array($query)){
			$theWishlist = new getMember;
			$theWishlist->ufId = $row['ufId'];
			$theWishlist->ufUsId = $row['ufUsId'];
			$theWishlist->ufPdId = $row['ufPdId'];
			$items[]=$theWishlist;
			$counter++;
		}	
		return($items);
	}
	
	public function DeleteWishlist($id){
		$sql = "delete from pt_user_favourites where ufId='$id' ";
		mysql_query($sql);
	}
	
	public function DeleteAllWishlist(){
		$sql = "delete from pt_user_favourites where ufUsId='".$_SESSION['ChkMemId']."' ";
		mysql_query($sql);
	}
	
	public function deleteCartItem($id){
		$sql = "delete from pt_shoppingcart_items where itemId='$id' ";
		mysql_query($sql);
	}

}
?>
