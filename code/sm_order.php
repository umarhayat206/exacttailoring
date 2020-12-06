<?php

class smOrder{

    /* ----- Cart -----*/
    public function GetAll($search){
        $sql="SELECT * FROM ex_shoppingcart WHERE shopConfirmOrder='1' $search ORDER BY shopDateadded DESC";
        $query=mysql_query($sql);
        $listOrder = array();
	$counter = 0;
        while ($row = mysql_fetch_array($query)){
            $orderAddToList[] = smOrder::_processRow($row);
	    $counter++;
        }
        return $orderAddToList;
    }
    
    public function GetAbortedOrder(){
        $sql="SELECT * FROM ex_shoppingcart WHERE shopConfirmOrder != '1' AND shopId > '5709' OR shopCompleted = '5' ORDER BY shopDateadded DESC";
        $query=mysql_query($sql);
        $listOrder = array();
	$counter = 0;
        while ($row = mysql_fetch_array($query)){
            $orderAddToList[] = smOrder::_processRow($row);
	    $counter++;
        }
        return $orderAddToList;
    }

    public function GetIndividual($id){
    	$sqlSelect = "SELECT * FROM ex_shoppingcart WHERE shopId='$id' ";
    	$query = mysql_query($sqlSelect);
    	$row = mysql_fetch_array($query);
    	$theProduct=smOrder::_processRow($row);
    	return $theProduct;
    }
        
    public function GetStatusTitle($id){
        if($id==1){
            $status="Payment awaiting confirmation";
        }elseif($id==2){
            $status="Order is now in production";
        }elseif($id==3){
            $status="Order shipped";
        }elseif($id==4){    
            $status="Order completed";
	}elseif($id==5){    
            $status="Aborted";
        }else{
            $status="Order completed";
        }
        return $status;
    }
    
    public function GetBulletStatus($id){
        if($id==1){
            $image="<img alt='Confirmation of Payment icon' title='Confirmation of Payment' src='"._URL_."styles/images/status_h1.gif' style='margin-right:5px;'/>";
        }elseif($id==2){
            $image="<img alt='In Production icon' title='In Production' src='"._URL_."styles/images/status_h3.gif' style='margin-right:5px;'/>";
        }elseif($id==3){
            $image="<img alt='Order shipped icon' title='Order shipped' src='"._URL_."styles/images/status_h4.gif' style='margin-right:5px;'/>";
        }elseif($id==4){    
            $image="<img alt='Completed icon' title='Completed' src='"._URL_."styles/images/status_h5.gif' style='margin-right:5px;'/>";
	}elseif($id==5){    
            $image="<img alt='Aborted sales icon' title='Aborted sales' src='"._URL_."styles/images/status_h6.gif' style='margin-right:5px;'/>";
        }else{
            $image="<img alt='Completed icon' title='Completed' src='"._URL_."styles/images/status_h5.gif' style='margin-right:5px;'/>";
        }
        return $image;
    }
    
    function statusUpdate($order){
        $sqlUpdate = "UPDATE ex_shoppingcart SET ";
        $sqlUpdate .="shopCompleted='".$order->shopCompleted."' ";
	//$sqlUpdate .="shopDatecompleted='".mktime()."' ";
        $sqlUpdate .="WHERE shopId='".$order->shopId."' ";
        mysql_query($sqlUpdate) or die(mysql_error());
        //echo $sqlUpdate."<br />";
	
    }
    
    function orderDelete($id){
        $sqlDelete = "DELETE FROM ex_shoppingcart WHERE shopId='$id' ";
	//mysql_query($sqlDelete);
        
        $sqlDeleteItem = "DELETE FROM ex_shoppingcart_items WHERE shopId='$id' ";
        //mysql_query($sqlDeleteItem);
    }
    
    function _processRow($row){
	$item = new smOrder;
	$item->shopId = $row['shopId'];
	$item->shopDateadded = $row['shopDateadded'];
	//$item->shopDateordered =$row['shopDateordered'];
	$item->shopCompleted = $row['shopCompleted']; 	// status
	$item->shopDatecompleted = $row['shopDatecompleted'];
	$item->shopGateway = $row['shopGateway'];
	$item->shopPriceValue = $row['shopPriceValue'];
	$item->shopReturnedValue = $row['shopReturnedValue'];
	$item->shopDeliveryAddress =$row['shopDeliveryAddress'];
	$item->shopAdminnotes = $row['shopAdminnotes'];
	$item->shopPromotionCode = $row['shopPromotionCode'];
	$item->shopUserId = $row['shopUserId'];
	return($item);
    }

    /* ----------Cart item---------- */
    
    public function GetAllItems($id){
        $sql="SELECT * FROM ex_shoppingcart_items WHERE shopId=".$id." AND itemComplete='1' AND vouchersId='0' ";
        $query=mysql_query($sql);
        $listItems = array();
	$counter = 0;
        while($row=mysql_fetch_array($query)){
	    $listItems[] = smOrder::_itemProcessRow($row);
	    $counter ++;
        }
        return $listItems;
    }
    
    public function GetAllVoucherItems($id){
        $sql="SELECT * FROM ex_shoppingcart_items WHERE shopId=".$id." AND itemComplete='1' AND productId='0' ";
        $query=mysql_query($sql);
        $listItems = array();
	$counter = 0;
        while($row=mysql_fetch_array($query)){
	    $listItems[] = smOrder::_itemProcessRow($row);
	    $counter ++;
        }
        return $listItems;
    }
    
    public function GetItemsIndividual($id){
	$sqlSelect = "SELECT * FROM ex_shoppingcart_items WHERE itemId='$id' ";
	$query = mysql_query($sqlSelect);
	$row = mysql_fetch_array($query);
	$theProduct=smOrder::_itemProcessRow($row);
	return $theProduct;
    }
    
    function _itemProcessRow($row){
	$items = new smOrder;
	$items->itemId = $row['itemId'];
	$items->productId = $row['productId'];
	$items->vouchersId = $row['vouchersId'];
	$items->itemPrice = $row['itemPrice'];
	$items->itemQty = $row['itemQty'];
	$items->shopId = $row['shopId'];
	$items->itemDetails = $row['itemDetails'];
	$items->itemMeasurementType = $row['itemMeasurementType'];
	$items->itemmeasurementType2 = $row['itemmeasurementType2'];
	$items->itemComplete = $row['itemComplete'];
	$items->itemmeasurementMetric = $row['itemmeasurementMetric'];
	$items->itemmeasurementShirtNeck = $row['itemmeasurementShirtNeck'];
	$items->itemmeasurementShirtChest = $row['itemmeasurementShirtChest'];
	$items->itemmeasurementShirtStomach = $row['itemmeasurementShirtStomach'];
	$items->itemmeasurementShirtHips = $row['itemmeasurementShirtHips'];
	$items->itemmeasurementShirtLenght = $row['itemmeasurementShirtLenght'];
	$items->itemmeasurementShirtSleeveLength = $row['itemmeasurementShirtSleeveLength'];
	$items->itemmeasurementShirtShortSleeve = $row['itemmeasurementShirtShortSleeve'];
	$items->itemmeasurementShirtCuff = $row['itemmeasurementShirtCuff'];
	$items->itemmeasurementShirtUpperarm = $row['itemmeasurementShirtUpperarm'];
	$items->itemmeasurementShirtShoulder = $row['itemmeasurementShirtShoulder'];
	$items->itemmeasurementTrousersA = $row['itemmeasurementTrousersA'];
	$items->itemmeasurementTrousersB = $row['itemmeasurementTrousersB'];
	$items->itemmeasurementTrousersC = $row['itemmeasurementTrousersC'];
	$items->itemmeasurementTrousersD = $row['itemmeasurementTrousersD'];
	$items->itemmeasurementTrousersE = $row['itemmeasurementTrousersE'];
	$items->itemmeasurementTrousersF = $row['itemmeasurementTrousersF'];
	$items->itemmeasurementTrousersG = $row['itemmeasurementTrousersG'];
	$items->itemmeasurementBoxersWaist = $row['itemmeasurementBoxersWaist'];
	$items->itemmeasurementBoxersTopofLeg = $row['itemmeasurementBoxersTopofLeg'];
	$items->itemmeasurementBoxersLength = $row['itemmeasurementBoxersLength'];
	$items->itemmeasurementBoxersHip = $row['itemmeasurementBoxersHip'];
	$items->itemmeasurementBoxersInsideLeg = $row['itemmeasurementBoxersInsideLeg'];
	$items->itemSpecialDetails = $row['itemSpecialDetails'];
	$items->itemInitials = $row['itemInitials'];
	$items->itemInsideCollarCuff = $row['itemInsideCollarCuff'];
	$items->itemOnPromotion = $row['itemOnPromotion'];
	return($items);
    }
    
    public function itemDelete($cartid, $productid, $itemid){
	// remove main item
	mysql_query("DELETE FROM ex_shoppingcart_items WHERE shopId = '$cartid' AND productId = '$productid' ");
	
	// remove on promotion get free item
	mysql_query("DELETE FROM ex_shoppingcart_items WHERE shopId = '$cartid' AND itemOnPromotion = '$productid' ");
	
	// remon item design
	mysql_query("DELETE FROM ex_item_details_index WHERE itemId = '$itemid' ");	
    }
    
    public function voucherDelete($voucherid, $itemid){
	mysql_query("DELETE FROM ex_shoppingcart_items WHERE itemId = '$itemid' ");
	
	mysql_query("DELETE FROM ex_vouchers WHERE vouchersId = '$voucherid' ");	
    }
    
    /* ---------- Item Design ---------- */
    
    public function getItemDesignDetails($item){
	$sql="SELECT * FROM ex_item_details_index WHERE itemId='$item' ORDER BY id ASC" ;
        $query=mysql_query($sql);
        $listItems = array();
	$counter = 0;
        while($row=mysql_fetch_array($query)){
	    $listItems[] = smOrder::_itemDesignProcessRow($row);
	    $counter ++;
        }
        return $listItems;
    }
    
    function _itemDesignProcessRow($row){
	$items = new smOrder;
	$items->id = $row['id'];
	$items->itemId = $row['itemId'];
	$items->optionId = $row['optionId'];
	$items->optionValue = $row['optionValue'];
	return($items);
    }

    //----------12-Oct-2016----------------------------
    public function CheckOrderOfUser(){
        $sqlSelect = "SELECT * FROM ex_shoppingcart WHERE shopId='".$_SESSION['currentOrder']."' AND shopUserId='".$_SESSION['chkmemberuser']."' LIMIT 1 ";
        $query = mysql_query($sqlSelect);
        $row = mysql_fetch_array($query);
        $theOrder=smOrder::_processRow($row);

        if($theOrder->shopId == $_SESSION['currentOrder'] AND $theOrder->shopUserId == $_SESSION['chkmemberuser']) {
            $return = TRUE;
        }else{
            $return = FALSE;
        }
        return $return;
    }
    
}
?>