<?php

$ORDERS = new smOrder;

$FILTER = " AND shopCompleted != '4' AND shopCompleted != '5' ";

if ($_POST['orderListFilterSubmitted']) {
    if ($_POST['searchFilter']) {
        $FILTER = " AND shopCompleted = '" . $_POST['searchFilter'] . "' ";
    }
}

if ($_GET['usId']) {
    $FILTER = " AND shopUserId = '" . $_GET['usId'] . "' ";
}

if ($_GET['delOrderId']) {
    smOrder::orderDelete($_GET['delOrderId']);
}

// if($_GET['printOrderId']){ }
// if($_GET['editOrderId']){ }

if ($_POST['orderlistFormSubmitted']) {
    for ($p = 0; $p <= $_POST['cntOrdersList']; $p++) :            //search branch
        $SHOPOPINGSTATUS = "shopCompleted" . $p;
        $SHOPOPINGORDERID = "ORDERID" . $p;

        if ($_POST[$SHOPOPINGSTATUS] != "") {
            $ORDERS->shopId = $_POST[$SHOPOPINGORDERID];
            $ORDERS->shopCompleted = $_POST[$SHOPOPINGSTATUS];
            smOrder::statusUpdate($ORDERS);

            /*
	    if($_POST[$SHOPOPINGSTATUS] != 1){	// if order is not "Payment awaiting confirmation" 
		$voucher = smOrder::GetAllVoucherItems($ORDERS->shopId);
		foreach($voucher as $item){	// Update vouchersStatus = Available to use
		    mysql_query("UPDATE ex_vouchers SET vouchersStatus = '2' WHERE vouchersStatus = '1' AND vouchersId = '{$item->vouchersId}' ");
		}
	    }else{
		$voucher = smOrder::GetAllVoucherItems($ORDERS->shopId);
		foreach($voucher as $item){ // Update vouchersStatus = Payment awaiting confirmation 
		    mysql_query("UPDATE ex_vouchers SET vouchersStatus = '1' WHERE vouchersStatus != '3' AND vouchersId = '{$item->vouchersId}' ");
		}
	    }
	    */
        }
    endfor;
}

function statusDropdown($id)
{
    if ($id == 1) {
        $chk1 = " selected='selected' ";
    } elseif ($id == 2) {
        $chk2 = " selected='selected' ";
    } elseif ($id == 3) {
        $chk3 = " selected='selected' ";
    } elseif ($id == 4) {
        $chk4 = " selected='selected' ";
    } elseif ($id == 5) {
        $chk5 = " selected='selected' ";
    }

    $htmlReturn = "<option value='1' $chk1 >Payment awaiting confirmation</option>
        <option value='2' $chk2 >Order is now in production</option>
        <option value='3' $chk3 >Order shipped</option>
        <option value='4' $chk4 >Order completed</option>
	<option value='5' $chk5 >Aborted sales</option>";


    return $htmlReturn;
}

?>
<script type="text/javascript">
    <!--
    $(document).ready(function() {
        $('body').append('<div id="dialog" title="Shipping address"><\/div>');
        $('#dialog').dialog({
            width: 300,
            autoOpen: false,
            modal: true
        });
        $('.openInfo').click(function() {
            var text = $(this).parent().parent().next().html();
            $('#dialog').dialog('open');
            $('.ui-dialog-content').html(text);
            return false;
        });
    });
    //
    -->
</script>

<div class="leftblock vertsortable" style="width:100%;">
    <!-- gadget left 1 -->
    <div class="gadget" id="orders">
        <div class="titlebar vertsortable_head">
            <h3>Orders</h3>
        </div>
        <div class="gadgetblock">
            <center>
                <img alt="Confirmation of Payment icon" title="Confirmation of Payment" src="<?php echo _URL_; ?>styles/images/status_h1.gif" style="margin:0 5px 0 15px;" />Confirmation of Payment
                <img alt="In Production icon" title="In Production" src="<?php echo _URL_; ?>styles/images/status_h3.gif" style="margin:0 5px 0 15px;" />In Production
                <img alt="Order shipped icon" title="Order shipped" src="<?php echo _URL_; ?>styles/images/status_h4.gif" style="margin:0 5px 0 15px;" />Order shipped
                <img alt="Completed icon" title="Completed" src="<?php echo _URL_; ?>styles/images/status_h5.gif" style="margin:0 5px 0 15px;" />Completed
                <img alt="Aborted sales icon" title="Aborted sales" src="<?php echo _URL_; ?>styles/images/status_h6.gif" style="margin:0 5px 0 15px;" />Aborted
            </center>

            <div id="orderSearch">
                <form id="orderListFilter" action="<?= _URL_; ?>admin_order" method="post" enctype="multipart/form-data">
                    <label><b>Filter by</b></label>
                    <label>Status ::</label>
                    <select name="searchFilter" id="searchFilter">
                        <option value="">Show all incomplete orders</option>
                        <option value="1">Payment awaiting confirmation</option>
                        <option value="2">Order is now in production</option>
                        <option value="3">Order shipped</option>
                        <option value="4">Order completed</option>
                        <option value="5">Aborted sales</option>
                    </select>
                    <input type="hidden" name="orderListFilterSubmitted" id="orderListFilterSubmitted" value="true" />
                    <input type="submit" name="submit" id="submit" value="Filter" />
                </form>
                <p>The order page shows orders once they have been approved by the member. Please ensure that a payment of the correct amount for the corresponding ID number has been made. Order status can be set to keep the customer informed via their member page of the current progress of their order. </p><br />
            </div>

            <?php
            $listOrder = new smOrder;
            $listOrder = $listOrder->GetAll($FILTER);
            ?>
            <div id="orderList">
                <form id="orderListForm" method="post" action="<?= _URL_; ?>admin_order">

                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="gwlines">
                        <tr>
                            <th style="width:10%;">Order Id</th>
                            <th style="width:10%; text-align:center;">Promotional Code</th>
                            <th style="width:13%; text-align:center;">Order Date</th>
                            <th style="width:18%; text-align:center;">Member</th>
                            <th style="width:10%; text-align:right;">Value</th>
                            <th style="width:12%; text-align:center;">Payment Method</th>
                            <th style="width:15%; text-align:center;">Status</th>
                            <th style="width:12%;text-align:center;">Options</th>
                        </tr>

                        <?php
                        if (!empty($listOrder)) {

                            $i = 0;
                            foreach ($listOrder as $orderDel) {
                                $i++;
                        ?>
                                <script type="text/javascript">
                                    <!--
                                    $(document).ready(function() {
                                        $('#showItemsClick<?php echo $i; ?>').click(function() {
                                            $('#hiddenOrderItems<?php echo $i; ?>').slideToggle();
                                        });


                                    });
                                    //
                                    -->
                                </script>

                        <?php

                                $DIVID = "hiddenOrderItems" . $i;
                                $ITEMSCLICK = "showItemsClick" . $i;
                                $DROPDOWNSTATUS = "shopCompleted" . $i;
                                $ORDERID = "ORDERID" . $i;
                                $CUSTOMERNAME = "CUSTOMERNAME" . $i;
                                $SHIPPINGCODE = "SHIPPINGCODE" . $i;
                                $SHIPPINGDATE = "SHIPPINGDATE" . $i;

                                $memberDetails = smUser::GetIndividual($orderDel->shopUserId);
                                $Y = substr($orderDel->shopDateadded, 0, 4);
                                $M = substr($orderDel->shopDateadded, 5, 2);
                                $MM = smSetting::changeMonth($M);
                                $D = substr($orderDel->shopDateadded, 8, 2);

                                if ($orderDel->shopId < 5739) {
                                    $option = "<a href='" . _URL_ . "OLD/admin-print-order-details?orderId={$orderDel->shopId}' title='Print order details' target='_blank'><img src='" . _URL_ . "styles/images/printer.png' alt='Print order details' title='Print order details' style='margin:0 4px;'></a>";
                                } else {

                                    if ($orderDel->shopCompleted == 4) {
                                        $option = "<a href='" . _URL_ . "admin-print-order-details?orderId={$orderDel->shopId}' title='Print order details' target='_blank'><img src='" . _URL_ . "styles/images/printer.png' alt='Print order details' title='Print order details' style='margin:0 4px;'></a>";
                                    } else {
                                        $option = "<a href='javascript:void(0);' id='{$ITEMSCLICK}'><img src='" . _URL_ . "styles/images/magnifier.png' alt='' style='margin:0 4px;' /></a>
                                    <a href='" . _URL_ . "admin-edit-order?orderId={$orderDel->shopId}&amp;usId={$orderDel->shopUserId}' target='_blank'><img src='styles/images/pencil.png' alt=Edit order' title='Edit order' style='margin:0 4px;'></a>
                                    <a href='" . _URL_ . "admin-print-order-details?orderId={$orderDel->shopId}' title='Print order details' target='_blank'><img src='" . _URL_ . "styles/images/printer.png' alt='Print order details' title='Print order details' style='margin:0 4px;'></a>";
                                    }
                                }

                                if (!empty($orderDel->shopPromotionCode)) {
                                    $promotioncode = $orderDel->shopPromotionCode;
                                } else {
                                    $promotioncode = "-";
                                }

                                $orderChangeStatus = '';

                                if ($orderDel->shopCompleted != 2) {
                                    $orderChangeStatus = "<a href='" . _URL_ . "admin_orderstatus?id={$orderDel->shopId}' title='Change this order to (ORDER NOW IN PRODUCTION) - ( Send email to customer: Inprogress )' class='ttip' style='height: 30px;width: 30px;display: block;float: left;' onclick=\"javascript:return confirm('Change status & send email for ORDER ID:{$orderDel->shopId} ?')\">
                                    <img  src='" . _URL_ . "styles/images/icon_3.jpg' style='margin:0;width:30px;'/>
                                    </a>";
                                }

                                echo "<tr>
                                <td>" . smOrder::GetBulletStatus($orderDel->shopCompleted) . "ID{$orderDel->shopId}</td>
				<td style='text-align:center;'>" . strtoupper($promotioncode) . "</td>
                                <td style='text-align:center;'>" . $D . " " . $MM . " " . $Y . "</td>
                                <td style='text-align:center;'><a href='" . _URL_ . "admin_member?member={$memberDetails->usId}' target='_blank' title='view member details'>" . $memberDetails->usFirstname . " " . $memberDetails->usLastname . "</a></td>
                                <td style='text-align:right; font-size:15px; color:#355F94;'>&pound;" . number_format($orderDel->shopPriceValue, 2) . "</td>
                                <td style='text-align:center;'>{$orderDel->shopGateway}</td>
                                <td>
                                    <select name='$DROPDOWNSTATUS' id='$DROPDOWNSTATUS'>
                                        <option value=''></option>
                                        " . statusDropdown($orderDel->shopCompleted) . "
                                    </select>
                                    
                                </td>
                                <td style='text-align:center;'>{$orderChangeStatus}{$option} 
                                </td>
                            </tr>";
                                /*
                        <a href='"._URL_."admin_order?delOrderId={$orderDel->shopId}'  onclick=\"javascript:return confirm('Are you sure...?')\"><img src='"._URL_."styles/images/cross.png' alt='' style='margin:0 4px;' /></a>*/

                                $listItems = new smOrder;
                                $listItems = $listItems->GetAllItems($orderDel->shopId);
                                echo "<tr>
                                <td colspan='7' style='border:none;'>
                                
                                <div id='$DIVID' style='display:none; clear:both; margin:10px auto; padding:0 10px 10px 10px; width:60%; border:solid 1px #CCC; border-top:none;'>
                                    <table width='100%' border='0' cellspacing='0' cellpadding='0' class='gwlines'>
                                        <tr>
                                            <th style='width:70%; text-align:left;'>Item</th>
                                            <th style='width:10%; text-align:center;'>Qty</th>
                                            <th style='width:10%; text-align:right;'>Price</th>
                                            <th style='width:10%; text-align:right;'>Total</th>
                                        </tr>";

                                foreach ($listItems as $items) {
                                    $productitem = smProduct::GetIndividual($items->productId);

                                    if (empty($items->itemOnPromotion) || $items->itemOnPromotion == 0) {
                                        $sPrice1 = "&pound;" . number_format($items->itemPrice, 2);
                                        $sPrice2 = "&pound;" . number_format($items->itemPrice * $items->itemQty, 2);
                                    } else {
                                        $sPrice1 = "Free";
                                        $sPrice2 = "Free";
                                    }

                                    echo "<tr>
					<td>" . $productitem->productRefCode . ":: " . $productitem->productTitle . "</td>
					<td style='text-align:center;'>{$items->itemQty}</td>
					<td style='text-align:right;'>$sPrice1</td>
					<td style='text-align:right;'>$sPrice2</td>
				    </tr>";
                                } // n foreach $listItems

                                $getVoucherOnCart = smVouchers::getVoucherOnCart($orderDel->shopId);

                                if (!empty($getVoucherOnCart)) {
                                    foreach ($getVoucherOnCart as $item) {
                                        $voucherdetails = smVouchers::GetIndividual($item->vouchersId);
                                        echo "<tr>
					    <td>Gif Voucher (Code - <span style='color:#355F94;'>{$voucherdetails->vouchersCode})</span></td>
					    <td style='text-align:center;'>1</td>
					    <td style='text-align:right;'>&pound;" . number_format($voucherdetails->vouchersValue, 2) . "</td>
					    <td style='text-align:right;'>&pound;" . number_format($voucherdetails->vouchersValue, 2) . "</td>
					</tr>";
                                    }
                                }

                                echo "</table></div>
                                    </td></tr>";

                                echo "<input type='hidden' id='$ORDERID' name='$ORDERID' value='{$orderDel->shopId}' />";
                            }   // n foreach $listOrder
                        }   // n if(!empty($listOrder))
                        ?>
                    </table><br />

                    <input type="hidden" id="cntOrdersList" name="cntOrdersList" value="<?= $i; ?>" />
                    <input type="hidden" id="orderlistFormSubmitted" name="orderlistFormSubmitted" value="true" />
                    <input id="saveChanges" class="button" type="submit" value="Save changes" name="saveChanges" style="float:right; cursor:pointer;" />

                </form><br />
            </div> <!-- div order list -->

        </div> <!-- n gadgetblock -->
    </div> <!-- n gadget -->
</div><br /> <!-- n leftblock vertsortabl -->

<script type="text/javascript">
    jQuery(function() {
        jQuery('.ttip').tooltip();
    });
</script>