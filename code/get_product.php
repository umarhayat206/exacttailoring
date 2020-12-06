<?php 

class smProduct{
	var $pdId;
	var $pdRefCode;
	var $pdTitle;
	var $pdDescription;
	var $pdPrice;
	var $pdPromotion;
	var $pdPromotionPrice;
	var $pdVisibleFlag;
	var $pdDateAdded;
	var $pdCilcks;
	var $pdBestSale;
	var $pdCaId;
	var $pdSetHomepage;
	
	public function getData($where,$page){
		//if(!empty($_SESSION['productstyle'])){ $style=" AND pdStyleId='".$_SESSION['productstyle']."' "; }
		
		if(empty($page)){
			$sql="SELECT * FROM pt_product_details WHERE pdVisibleFlag = '1' $where ORDER BY pdLastUpdate DESC, pdId DESC LIMIT 30";
		}else{
			$sql="SELECT * FROM pt_product_details WHERE pdVisibleFlag = '1' $where ORDER BY pdLastUpdate DESC, pdId DESC LIMIT ".(($page-1)*30).",30";
		}
	//echo $sql;
		
		$query=mysql_query($sql);
		$items = array();
		$counter=1;
		while($row=mysql_fetch_array($query)){
			$items[]=smProduct::_processRow($row);
			/*
			$itemsAddTolist = new smSetting;
			$itemsAddTolist->pdId = $row['pdId'];
			$itemsAddTolist->pdTitle = $row['pdTitle'];
			$itemsAddTolist->pdPrice = $row['pdPrice'];
			$itemsAddTolist->pdCate = $row['pdCaId'];
			$itemsAddTolist->pdPromotion = $row['pdPromotion'];
			$itemsAddTolist->pdPromotionPrice = $row['pdPromotionPrice'];
			$itemsAddTolist->pdSetHomepage = $row['pdSetHomepage'];
			$itemsAddTolist->pdBestSale = $row['pdBestSale'];
			$items[] = $itemsAddTolist;
			*/
			$counter++;
		}
		return $items;			
	}
	
	public function GetDetails($id){
		$sql="SELECT * FROM pt_product_details WHERE pdId = '$id' ";
		$query=mysql_query($sql);
		$row=mysql_fetch_array($query);
		$items = smProduct::_processRow($row);
		return $items;
	}

	public function CountFav($id){
		$sql="SELECT * FROM ch_user_favourites WHERE ufUsId= ".$id;
		$rs=mysql_query($sql);
		$cnt=mysql_num_rows($rs);
		return $cnt;
	}
	
	public function similarProduct($id){
		$sql="SELECT * FROM pt_product_details WHERE pdId != '$id' AND pdVisibleFlag='1' AND pdSetHomepage='0' AND pdSoldFlag='0' ORDER BY RAND() LIMIT 4";
		$query=mysql_query($sql);
		$theSimilar = array();
		$counter = 0;
		while($row=mysql_fetch_array($query)){
			$theSimilar[] = smProduct::_processRow($row);
			$counter++;
		}
		return $theSimilar;
	}
	
	public function GetCutPage($where){
		$sql="select * from pt_product_details where pdVisibleFlag='1' $where";
		$query=mysql_query($sql);
		$row=mysql_fetch_array($query);
		$result = array();
		
		$C = new smProduct;
		$C->forCut = 30;
		$C->cntPage = mysql_num_rows($query)/$C->forCut;
		$C->cntList = mysql_num_rows($query);
		$C->cntMod = mysql_num_rows($query)%$C->forCut;
		
		if($C->cntMod==0){ $C->cntMod = $C->forCut; }

		$result=$C;
		return $result;
	}
	
	public function GetCutFavPage($id, $sortlimit){
		$sql="SELECT * FROM ch_user_favourites WHERE ufUsId='".$id."' ORDER BY ufId DESC";
		$rsResult=mysql_query($sql);
		$rowResult=mysql_fetch_array($rsResult);
		$listResult = array();

		$fav = new getProperty;
		if(!empty($sortlimit)){
			$fav->forCut = $sortlimit;
		}else{
			$fav->forCut = 5;
		}
		$fav->cntPage = mysql_num_rows($rsResult)/$fav->forCut;
		$fav->cntList = mysql_num_rows($rsResult);
		$fav->cntMod = mysql_num_rows($rsResult)%$fav->forCut;
		
		if($fav->cntMod==0){ $fav->cntMod = $fav->forCut; }

		$result=$fav;
		return $result;
	}
	
	public function _processRow($row){
		$item = new smProduct;
		$item->pdId = $row['pdId'];
		$item->pdRefCode = $row['pdRefCode'];
		$item->pdTitle =$row['pdTitle'];
		$item->pdDescription = $row['pdDescription'];
		$item->pdKeyword = $row['pdKeyword'];
		$item->pdPrice = $row['pdPrice'];
		$item->pdPromotion = $row['pdPromotion'];
		$item->pdPromotionPrice = $row['pdPromotionPrice'];
		$item->pdVisibleFlag =$row['pdVisibleFlag'];
		$item->pdSoldFlag = $row['pdSoldFlag'];
		$item->pdSetHomepage = $row['pdSetHomepage'];
		$item->pdBestSale = $row['pdBestSale'];
		$item->pdRentBook = $row['pdRentBook'];
		$item->pdRareBook = $row['pdRareBook'];
		$item->pdOneBook = $row['pdOneBook'];
		$item->pdCilcks = $row['pdCilcks'];
		$item->pdCaId = $row['pdCaId'];
		$item->pdDateAdded = $row['pdDateAdded'];
		$item->pdAdminNotes = $row['pdAdminNotes'];
		$item->pdItem = $row['pdItem'];
		$item->pdLastUpdate = $row['pdLastUpdate'];
		return($item);
	}
	
	public function cartUpdateItems($id, $size, $qty){
		$sqlUpdate = "UPDATE pt_shoppingcart_items SET ";
		//$sqlUpdate .="sizeId='".$size."',";
		$sqlUpdate .="itemQty='".$qty."' ";
		$sqlUpdate .="WHERE itemId='".$id."' AND shopId='".$_SESSION['currentOrder']."' ";
		//echo $sqlUpdate;
		mysql_query($sqlUpdate) or die(mysql_error());	
	}
	
	public function updateCurrentOrder($price){
		$sqlUpdate = "UPDATE pt_shoppingcart SET ";
		$sqlUpdate .="shopPriceValue='".$price."' ";
		$sqlUpdate .="WHERE shopId='".$_SESSION['currentOrder']."' ";
		mysql_query($sqlUpdate) or die(mysql_error());	
	}
	//***   Private functions         **//
}
?>
