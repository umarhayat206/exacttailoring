<?php 

class getOrder{
    var $orderId;
    
    public function GetAll($id){
        $sql="SELECT * FROM pt_shoppingcart WHERE shopUserId='$id' ORDER BY shopDateadded DESC";
        $query=mysql_query($sql);
        $listOrder = array();
	$counter = 0;
        while ($row = mysql_fetch_array($query)){
            $orderAddToList[] = getOrder::_processRow($row);
	    $counter++;
        }
        return $orderAddToList;
    }
    
    public function GetMyOrder(){
	$sql="SELECT * FROM pt_shoppingcart WHERE shopUserId ='".$_SESSION['ChkMemId']."' AND shopConfirmOrder = '1'  ORDER BY shopDateadded DESC ";
        $query=mysql_query($sql);
	$listOrder = array();
	$counter = 0;
        while($row = mysql_fetch_array($query)){
	    $listOrder[] = getOrder::_processRow($row);
	    $counter++;
	}
        return $listOrder;
    }
    
    public function GetOrderDetail(){
	$sql="SELECT * FROM pt_shoppingcart WHERE shopId ='".$_SESSION['currentOrder']."' ";
        $query=mysql_query($sql);
        $row = mysql_fetch_array($query);
        $theOrder = getOrder::_processRow($row);

        return $theOrder;
    }
    
    public function GetAllItems($id){
        $sql="SELECT * FROM pt_shoppingcart_items WHERE shopId='$id' ";
        $query=mysql_query($sql);
        $listItems = array();
	$counter = 0;
        while($row=mysql_fetch_array($query)){
                $listItems[] = getOrder::_itemProcessRow($row);
		$counter ++;
        }
        return $listItems;
    }
    
    public function GetStatusTitle($id){
        if($id==1){
            $status="รอการชำระเงิน";
        }elseif($id==2){
            $status="รวบรวมสินค้า";
        }elseif($id==3){
            $status="จัดส่งสินค้า";
        }elseif($id==4){    
            $status="ปิดการสั่งซื้อ/ส่งสินค้าแล้ว";
        }else{
            $status="ปิดการสั่งซื้อ/ส่งสินค้าแล้ว";
        }
        return $status;
    }
    
    public function GetBulletStatus($id){
        if($id==1){
            $image="<img alt=\"Confirmation of Payment icon\" title=\"Confirmation of Payment\" src='"._URL_."styles/images/status_h1.gif' style=\"margin-right:5px;\"/>";
        }elseif($id==2){
            $image="<img alt=\"In Production icon\" title=\"In Production\" src='"._URL_."styles/images/status_h3.gif' style=\"margin-right:5px;\"/>";
        }elseif($id==3){
            $image="<img alt=\"Order shipped icon\" title=\"Order shipped\" src='"._URL_."styles/images/status_h4.gif' style=\"margin-right:5px;\"/>";
        }elseif($id==4){    
            $image="<img alt=\"Completed icon\" title=\"Completed\" src='"._URL_."styles/images/status_h5.gif' style=\"margin-right:5px;\"/>";
        }else{
            $image="<img alt=\"Completed icon\" title=\"Completed\" src='"._URL_."styles/images/status_h5.gif' style=\"margin-right:5px;\"/>";
        }
        return $image;
    }
    
    public function orderPriceValueUpdate($price){
	$updeteorder = "UPDATE pt_shoppingcart SET ";
	$sqlUpdate .="shopPriceValue = shopPriceValue - $price ";
	$sqlUpdate .="WHERE shopId = '".$_SESSION['currentOrder']."' ";
	//mysql_query($sqlUpdate) or die(mysql_error());
    }
    
    function statusUpdate($id, $status){
        $sqlUpdate = "UPDATE pt_shoppingcart SET ";
        $sqlUpdate .="shopCompleted='".$status."' ";
        $sqlUpdate .="WHERE shopId='".$id."' ";
        mysql_query($sqlUpdate) or die(mysql_error());
    }
    
    function orderDelete($id){
        $sqlDelete = "DELETE FROM pt_shoppingcart WHERE shopId='".$id."' ";
	mysql_query($sqlDelete);
        
        $sqlDeleteItem = "DELETE FROM pt_shoppingcart_items WHERE shopId='".$id."' ";
        mysql_query($sqlDeleteItem);
    }
    
    function _processRow($row){
            $item = new getOrder;
            $item->shopId = $row['shopId'];
            $item->shopDateadded = $row['shopDateadded'];
            $item->shopDateordered =$row['shopDateordered'];
            $item->shopCompleted = $row['shopCompleted'];
            $item->shopDatecompleted = $row['shopDatecompleted'];
            $item->shopGateway = $row['shopGateway'];
            $item->shopPriceValue = $row['shopPriceValue'];
            $item->shopReturnedValue = $row['shopReturnedValue'];
            $item->shopDeliveryAddress =$row['shopDeliveryAddress'];
            $item->shopAdminnotes = $row['shopAdminnotes'];
            $item->shopUserId = $row['shopUserId'];	
            return($item);
    }
    
    function _itemProcessRow($row){
            $items = new getOrder;
            $items->itemId = $row['itemId'];
            $items->productId = $row['productId'];
            $items->itemPrice = $row['itemPrice'];
            $items->itemQty = $row['itemQty'];
	    $items->item = $row['item'];
            return($items);
    }
    
}
?>