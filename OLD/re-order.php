<?php
include("code/application_code_includes_and_globals_file.php");

//echo $_GET['order']."-*-<br/>";
// what to do: select old order, insert item to new order, update new order

$sqlnewshoppingcart = "SELECT * FROM ts_shoppingcart WHERE sc_m_id=".smFunctions::checkInput($_SESSION['auth']->mId)." AND sc_completed='InProgress' ";
$querynewshoppingcart = mysql_query($sqlnewshoppingcart);
if(mysql_num_rows($querynewshoppingcart)==0){ 		//No cart available
    $cart2 = new tsShoppingCart;
    $cart2->scMId = $_SESSION['auth']->mId;
    $cart2->scId = tsShoppingCart::scSave($cart2);
    
    echo "<script language='javascript' type='text/javascript'>window.location='re-order.php?order={$_GET['order']}';</script>";
    
}else{
    $rownewshoppingcart=mysql_fetch_array($querynewshoppingcart);
    $sc_id = $rownewshoppingcart['sc_id'];
}

//echo $sc_id."-*-".$_SESSION['auth']->mId."-*-<br/>";

$sqlpreviousitems = "SELECT * FROM ts_shopping_cart_items WHERE sci_sc_id = ".smFunctions::checkInput($_GET['order']);
$querypreviousitems = mysql_query($sqlpreviousitems);
while($rowpreviousitems=mysql_fetch_array($querypreviousitems)){
    
    $fabric = tsFabrics::fabricGetOne($rowpreviousitems['sci_f_id']);
    $fabric->fPricePerShirt;
    
    $sci_id = $rowpreviousitems['sci_id'];
    $sci_measurement_type = $rowpreviousitems['sci_measurement_type'];
    
    //$sci_price = $rowpreviousitems['sci_price'];
    $sci_price = $fabric->fPricePerShirt;
    
    $sci_qty = $rowpreviousitems['sci_qty'];
    $sci_s_id = $rowpreviousitems['sci_s_id'];
    $sci_f_id = $rowpreviousitems['sci_f_id'];
    $sci_sm_id = $rowpreviousitems['sci_sm_id'];
    $sci_bm_id = $rowpreviousitems['sci_bm_id'];
    $sci_sc_id = $sc_id;     // 
    $sci_po_id = $rowpreviousitems['sci_po_id'];
    
// insert item to new order    
    $sql = "INSERT INTO ts_shopping_cart_items SET ";
    $sql.= "sci_measurement_type=".$sci_measurement_type.","; 
    $sql.= "sci_price=".$sci_price.",";
    $sql.= "sci_qty=".$sci_qty.",";
    $sql.= "sci_s_id=".$sci_s_id.",";
    $sql.= "sci_f_id=".$sci_f_id.",";
    $sql.= "sci_sm_id=".$sci_sm_id.",";
    $sql.= "sci_bm_id=".$sci_bm_id.",";
    $sql.= "sci_sc_id=".$sci_sc_id.",";
    $sql.= "sci_po_id=".$sci_po_id." ";
    mysql_query($sql);
    //echo $sql."<br>";
}

// update new order 

echo "<script language='javascript' type='text/javascript'>window.location='member-checkout';</script>";


?>