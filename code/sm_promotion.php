<?php

class smPromotion {

	function GetAllPromotion($status){
		if($status==true){
			$sql = "SELECT * FROM ex_promotion WHERE promotionType2 = '1' ORDER BY promotionId DESC";
		}else{
			$sql = "SELECT * FROM ex_promotion WHERE promotionVisible='1' AND promotionType2 = '1' AND promotionHidden !='1' ORDER BY promotionId DESC";
		}

		$query = mysql_query($sql);
		$counter = 0;
		$menuItems = array();
		while($row = mysql_fetch_array($query)){
			$menuItems[$counter]=smPromotion::_processRow($row);
			$counter++;
		}
		return($menuItems);
	}

	public function GetPromotion($id){
		$sql = mysql_query("SELECT * FROM ex_promotion WHERE promotionId = '$id' ");
		$row=mysql_fetch_array($sql);
		$counter = 0;
		$items = array();
		$items=smPromotion::_processRow($row);
		return $items;	
	}
	/*
	public function countComment(){
		$sql = mysql_query("SELECT * FROM ex_promotion WHERE promotionVisible='1' ");
		$row=mysql_num_rows($sql);
		return $row;	
	}
	*/
	function Update($promotion){		
		$sql = "UPDATE ex_promotion SET ";
		$sql .="promotionTitle='".$promotion->promotionTitle."', ";
		$sql .="promotionBanner='".$promotion->promotionBanner."', ";
		$sql .="promotionType='".$promotion->promotionType."', ";
		$sql .="promotionItemType='".$promotion->promotionItemType."', ";
		$sql .="promotionDiscount='".$promotion->promotionDiscount."', ";
		$sql .="promotionGetfreeItem='".$promotion->promotionGetfreeItem."', ";
		$sql .="promotionStart='".$promotion->promotionStart."', ";
		$sql .="promotionUntill='".$promotion->promotionUntill."', ";
		$sql .="promotionVisible='".$promotion->promotionVisible."', ";
		$sql .="promotionType2='1', ";
		$sql .="promotionFreeShipping='".$promotion->promotionFreeShipping."', ";
		$sql .="promotionHidden='".$promotion->promotionHidden."', ";
		$sql .="promotionCode='".$promotion->promotionCode."' ";
		$sql .="WHERE promotionId='".$promotion->promotionId."'";
		mysql_query($sql);
		return $promotion->promotionId;
	}

	function Insert($promotion){	
		$sql = "INSERT INTO ex_promotion SET ";
		$sql .="promotionTitle='".$promotion->promotionTitle."', ";
		$sql .="promotionBanner='".$promotion->promotionBanner."', ";
		$sql .="promotionType='".$promotion->promotionType."', ";
		$sql .="promotionItemType='".$promotion->promotionItemType."', ";
		$sql .="promotionDiscount='".$promotion->promotionDiscount."', ";
		$sql .="promotionGetfreeItem='".$promotion->promotionGetfreeItem."', ";
		$sql .="promotionStart='".$promotion->promotionStart."', ";
		$sql .="promotionUntill='".$promotion->promotionUntill."', ";
		$sql .="promotionVisible='".$promotion->promotionVisible."', ";
		$sql .="promotionType2='1', ";
		$sql .="promotionFreeShipping='".$promotion->promotionFreeShipping."', ";
		$sql .="promotionHidden='".$promotion->promotionHidden."', ";
		$sql .="promotionCode='".$promotion->promotionCode."' ";
		mysql_query($sql);
		return mysql_insert_id();
	}

	function Delete($promotion){
		mysql_query("DELETE FROM ex_promotion WHERE promotionId='$promotion' ");
		mysql_query("DELETE FROM ex_promotion_index WHERE promotionId='$promotion' ");
	}

/* ***** SQL ROW PRCESSING ***** */
	function _processRow($row){
		$item = new smPromotion;
		$item->promotionId = $row['promotionId'];
		$item->promotionTitle = $row['promotionTitle'];
		$item->promotionBanner = $row['promotionBanner'];
		$item->promotionType = $row['promotionType'];
		$item->promotionItemType = $row['promotionItemType'];	// all product or select product
		$item->promotionDiscount = $row['promotionDiscount'];
		$item->promotionGetfreeItem = $row['promotionGetfreeItem'];
		$item->promotionStart = $row['promotionStart'];
		$item->promotionUntill = $row['promotionUntill'];
		$item->promotionVisible = $row['promotionVisible'];
		$item->promotionHidden = $row['promotionHidden'];
		$item->promotionCode = $row['promotionCode'];
		$item->promotionType2 = $row['promotionType2']; // coupon
		$item->promotionFreeShipping = $row['promotionFreeShipping'];
		return($item);
	}
	
	
	function _processIndexRow($row){
		$item = new smPromotion;
		$item->id = $row['id'];
		$item->promotionId = $row['promotionId'];
		$item->productId = $row['productId'];
		$item->type = $row['type'];
		return($item);
	}
/* ***** END ROW PROCESSING ***** */

	public function GetAllIndex($promotion, $type){
		$sqlSelectCutPages="select * from ex_promotion_index where promotionId ='$promotion' and type = '$type' ";
		//echo $sqlSelectCutPages."<br/>";
		$rsSelectCutPages=mysql_query($sqlSelectCutPages);
		$test=array();
		while ($row = mysql_fetch_array($rsSelectCutPages)){
			$test[]= $row['productId'];
		}
		return $test;	
	}
	
	public function GetIndividualPromotionIndex($id){
		$sqlSelect = "SELECT * FROM ex_promotion_index WHERE id='$id' ";
		$query = mysql_query($sqlSelect);
		$thePromotionIndex = new smPromotion;
		$row = mysql_fetch_array($query);
		
		$thePromotionIndex->indexid = $row['id'];
		$thePromotionIndex->indexpromotionId = $row['promotionId'];
		$thePromotionIndex->indexproductId = $row['productId'];
		$thePromotionIndex->indextype = $row['type']; // 1 main - 2 for free
		
		return $thePromotionIndex;
	}
	
	public function AddPromotionIndex($new){	
		$sqlInsert = "INSERT INTO ex_promotion_index SET ";	
		$sqlInsert .= "promotionId='".$new->promotionId."', ";	
		$sqlInsert .= "productId='".$new->productId."', ";
		$sqlInsert .= "type='".$new->type."' ";	
		mysql_query($sqlInsert);	
	}
	
	public function DeletePromotionIndex($id){
		$sqlDelete = "DELETE FROM ex_promotion_index WHERE id='$id' ";
		mysql_query($sqlDelete);
	}
	
	public function checkDiscountPromotion($code){
		$promotion = mysql_query("SELECT * FROM ex_promotion WHERE promotionCode = '$code' AND promotionVisible = '1' ORDER BY promotionId DESC LIMIT 1");
		$rowpromotion = mysql_fetch_array($promotion);
		
		$theIndex = new smPromotion;
		$theIndex->promotionId = $rowpromotion['promotionId'];
		$theIndex->promotionDiscount = $rowpromotion['promotionDiscount'];
		
		return $theIndex;
	}
	
	public function checkProductOnPromotion($product){ 
		$looppromotion = mysql_query("SELECT * FROM ex_promotion WHERE promotionVisible = '1' AND promotionType = '2' ORDER BY promotionId DESC");
		// promotionType 1 = discount, 2 = get free product
		// promotionType2 -  1 = nothing ,2 = coupon
		
		$theIndex = new smPromotion;
		
		while($rowpromotion = mysql_fetch_array($looppromotion)){
			$looppromotionitem = mysql_query("SELECT * FROM ex_promotion_index WHERE productId = '$product' AND promotionId = '{$rowpromotion['promotionId']}' AND type = '1' ORDER BY promotionId DESC LIMIT 1");
			// type 1=main product , 2=for free
			
			$countItem = mysql_num_rows($looppromotionitem);
			if($countItem >=1){
				while($rowitem = mysql_fetch_array($looppromotionitem)){
					$theIndex->promotionId = $rowitem['promotionId'];
					$theIndex->productId = $rowitem['productId'];
					//$theIndex[]=$theIndex;
				}
			}
		}
		
		return $theIndex;
	}
	
	public function checkProductOnPromotion1($product){
		$looppromotion = mysql_query("SELECT * FROM ex_promotion WHERE promotionVisible = '1' AND promotionType = '1' AND promotionType2 = '1' ORDER BY promotionId DESC");
		// promotionType - 1 = discount, 2 = get free product
		// promotionType2 -  1 = nothing ,2 = coupon

		$theIndex = new smPromotion;
		
		while($rowpromotion = mysql_fetch_array($looppromotion)){
			$looppromotionitem = mysql_query("SELECT * FROM ex_promotion_index WHERE productId = '$product' AND promotionId = '{$rowpromotion['promotionId']}' AND type = '1' ORDER BY promotionId DESC LIMIT 1");
			// type 1=main product , 2=for free
		
			$countItem = mysql_num_rows($looppromotionitem);
			if($countItem >=1){
				while($rowitem = mysql_fetch_array($looppromotionitem)){
					$theIndex->promotionId = $rowitem['promotionId'];
					$theIndex->productId = $rowitem['productId'];
					//$theIndex[]=$theIndex;
				}
			}
		}
		return $theIndex;
	}
	
	public function checkProductOnPromotion2($promotion, $product, $type){
		$sql = mysql_query("SELECT * FROM ex_promotion_index WHERE promotionId = '$promotion' AND productId = '$product' AND type = '$type' ");
		// type 1=main product , 2=for free
		$rowitem = mysql_fetch_array($sql);
		$theIndex=smPromotion::_processIndexRow($rowitem);
		return $theIndex;
	}
	
	
	/* ------------------------- */
	
	function GetAllCoupon(){
		$sql = "SELECT * FROM ex_promotion WHERE promotionType2 = '2' ORDER BY promotionId DESC";
		$query = mysql_query($sql);
		$counter = 0;
		$menuItems = array();
		while($row = mysql_fetch_array($query)){
			$menuItems[$counter]=smPromotion::_processRow($row);
			$counter++;
		}
		return($menuItems);
	}

	/*
	public function countComment(){
		$sql = mysql_query("SELECT * FROM ex_promotion WHERE promotionVisible='1' ");
		$row=mysql_num_rows($sql);
		return $row;	
	}
	*/
	function UpdateCoupon($promotion){		
		$sql = "UPDATE ex_promotion SET ";
		$sql .="promotionTitle='".$promotion->promotionTitle."', ";
		$sql .="promotionDiscount='".$promotion->promotionDiscount."', ";
		$sql .="promotionStart='".$promotion->promotionStart."', ";
		$sql .="promotionUntill='".$promotion->promotionUntill."', ";
		$sql .="promotionVisible='".$promotion->promotionVisible."', ";
		$sql .="promotionType2='2', ";
		$sql .="promotionFreeShipping='".$promotion->promotionFreeShipping."', ";
		$sql .="promotionCode='".$promotion->promotionCode."' ";
		$sql .="WHERE promotionId='".$promotion->promotionId."' ";
		mysql_query($sql);
		//return $promotion->promotionId;
	}

	function InsertCoupon($promotion){	
		$sql = "INSERT INTO ex_promotion SET ";
		$sql .="promotionTitle='".$promotion->promotionTitle."', ";
		$sql .="promotionDiscount='".$promotion->promotionDiscount."', ";
		$sql .="promotionStart='".$promotion->promotionStart."', ";
		$sql .="promotionUntill='".$promotion->promotionUntill."', ";
		$sql .="promotionVisible='".$promotion->promotionVisible."', ";
		$sql .="promotionType2='2', ";
		$sql .="promotionFreeShipping='".$promotion->promotionFreeShipping."', ";
		$sql .="promotionCode='".$promotion->promotionCode."' ";
		mysql_query($sql);
		//return mysql_insert_id();
	}

	function DeleteCoupon($promotion){
		mysql_query("DELETE FROM ex_promotion WHERE promotionId='$promotion' ");
	}
	
	public function checkCouponAvailable($code){
		$sqlSelect = "SELECT * FROM ex_promotion WHERE promotionCode='$code' AND promotionVisible='1' AND ( now() between `promotionStart` and `promotionUntill` ) ";
		$query = mysql_query($sqlSelect);
		$row = mysql_fetch_array($query);
		$theCoupon=smPromotion::_processRow($row);
		return $theCoupon;
	}
	

}

?>