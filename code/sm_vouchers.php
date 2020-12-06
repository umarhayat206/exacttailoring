<?php

class smVouchers{

    public function GetAll($user){
        $sql="SELECT * FROM ex_vouchers WHERE usId='$user' ORDER BY vouchersOrderDate DESC";
        $query=mysql_query($sql);
        $listOrder = array();
	$counter = 0;
        while ($row = mysql_fetch_array($query)){
            $orderAddToList[] = smVouchers::_processRow($row);
	    $counter++;
        }
        return $orderAddToList;
    }

    public function GetIndividual($id){
	$sqlSelect = "SELECT * FROM ex_vouchers WHERE vouchersId='$id' ";
	$query = mysql_query($sqlSelect);
	$row = mysql_fetch_array($query);
	$theVoucher=smVouchers::_processRow($row);
	return $theVoucher;
    }
    
    public function checkVoucherAvailable($code){
	$sqlSelect = "SELECT * FROM ex_vouchers WHERE vouchersCode='$code' AND vouchersStatus='2' ";
	$query = mysql_query($sqlSelect);
	$row = mysql_fetch_array($query);
	$theVoucher=smVouchers::_processRow($row);
	return $theVoucher;
    }
    
    public function GetStatusTitle($id){
        if($id==1){
            $status="Payment awaiting confirmation";
        }elseif($id==2){
            $status="Available to use";
        }elseif($id==3){
            $status="Already used";
        }else{
            $status="Already used";
        }
        return $status;
    }
    
    public function GetBulletStatus($id){
        if($id==1){
            $image="<img alt='Confirmation of Payment icon' title='Confirmation of Payment' src='"._URL_."styles/images/status_h1.gif' style='margin-right:5px;'/>";
        }elseif($id==2){
            $image="<img alt='Available to use icon' title='Available to use' src='"._URL_."styles/images/status_h5.gif' style='margin-right:5px;'/>";
        }elseif($id==3){
            $image="<img alt='Already Used icon' title='Already Used' src='"._URL_."styles/images/status_h3.gif' style='margin-right:5px;'/>";
        }else{
            $image="<img alt='Already Used icon' title='Already Used' src='"._URL_."styles/images/status_h1.gif' style='margin-right:5px;'/>";
        }
        return $image;
    }
    
    function statusUpdate($vouchers, $status){
        $sqlUpdate = "UPDATE ex_vouchers SET ";
        $sqlUpdate .="vouchersStatus='$status' ";
        $sqlUpdate .="WHERE vouchersId='$vouchers' ";
        mysql_query($sqlUpdate) or die(mysql_error());
        //echo $sqlUpdate."<br />";
    }
    
    function orderDelete($id){
        $sqlDelete = "DELETE FROM ex_vouchers WHERE vouchersId='$id' ";
	mysql_query($sqlDelete);
    }
    
    function _processRow($row){
	$item = new smVouchers;
	$item->vouchersId = $row['vouchersId'];
	$item->vouchersCode = $row['vouchersCode'];
	$item->vouchersValue =$row['vouchersValue'];
	$item->vouchersOrderDate = $row['vouchersOrderDate']; 
	$item->vouchersStatus = $row['vouchersStatus'];
	$item->usId = $row['usId'];
	$item->recipientName = $row['recipientName'];
	$item->recipientEmail = $row['recipientEmail'];
	$item->message =$row['message'];
	return($item);
    }

    public function getVoucherOnCart($cartId){
	$sql="SELECT * FROM ex_shoppingcart_items WHERE shopId = ".$cartId." AND vouchersId > '0' ";
        $query=mysql_query($sql);
        $listItems = array();
	$counter = 0;
        while($row=mysql_fetch_array($query)){
	    $listItems[] = smOrder::_itemProcessRow($row);
	    $counter ++;
        }
        return $listItems;
    }

}
?>