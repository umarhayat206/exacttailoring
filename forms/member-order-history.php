
    <h3 id="contactus-h1">My Orders History</h3>


    <div class="account-a-div">
    <a href="javascript:void(0);" class="order-history account-a"><i class="icon-caret-right"></i> View Order History</a><br>
    </div>
    
        <div class="order-history-div" style="display:none;">

            <center>
                <img alt="Payment awaiting confirmation icon" title="Payment awaiting confirmation" src="<?php echo _URL_;?>styles/images/status_h1.gif" style="margin:0 5px;"/>Payment awaiting confirmation
                <img alt="In Production icon" title="In Production" src="<?php echo _URL_;?>styles/images/status_h3.gif" style="margin:0 5px;"/>In Production
                <img alt="Order shipped icon" title="Order shipped" src="<?php echo _URL_;?>styles/images/status_h4.gif" style="margin:0 5px;"/>Order shipped
                <img alt="Completed icon" title="Completed" src="<?php echo _URL_;?>styles/images/status_h5.gif" style="margin:0 5px;"/>Completed
                <img alt="Aborted sales icon" title="Aborted" src="<?php echo _URL_;?>styles/images/status_h6.gif" style="margin:0 5px;"/>Aborted
            </center><br/>

            <table width="100%"  class="gwlines table table-bordered table-hover">
                <tr>
                    <th style="width:18%;">Order Id</th>
                    <th style="width:22%; text-align:center;">Order Date</th>
                    <th style="width:20%; text-align:right;">Value</th>
                    <th style="width:30%; text-align:center;">Payment Method</th>
                    <th style="width:10%;text-align:center;">Options</th>
                </tr>
            
                <?php
                $listOrder = smOrder::GetAll(" AND shopUserId = '{$_SESSION['chkmemberuser']}' AND shopId > 5396 ");
                
                if(!empty($listOrder)){
                
                    $i=0;
                    foreach ($listOrder as $order){
                        $i++;    
                    ?>
                    <script type="text/javascript">
                    <!--
                    $(document).ready(function(){
                        $('#showItemsClick<?php  echo $i; ?>').click(function(){
                            $('#hiddenOrderItems<?php  echo $i; ?>').slideToggle();
                        });
                    });
                    //-->
                    </script>
                    
                    <?php
                    
                    $DIVID="hiddenOrderItems".$i;
                    $ITEMSCLICK="showItemsClick".$i;
                    $DROPDOWNSTATUS="shopCompleted".$i;
                    $ORDERID="ORDERID".$i;
                    $CUSTOMERNAME="CUSTOMERNAME".$i;
                    $SHIPPINGCODE="SHIPPINGCODE".$i;
                    $SHIPPINGDATE="SHIPPINGDATE".$i;
                    
                    $memberDetails=smUser::GetIndividual($order->shopUserId);
                    $Y=substr($order->shopDateadded,0,4);
                    $M=substr($order->shopDateadded,5,2);
                    $MM=smSetting::changeMonth($M);
                    $D=substr($order->shopDateadded,8,2);

                    echo "<tr>
                        <td>".smOrder::GetBulletStatus($order->shopCompleted)."ID{$order->shopId}</td>
                        <td style='text-align:center;'>".$D." ".$MM." ".$Y."</td>
                        <td style='text-align:right;' class='textblue'>&pound;".number_format($order->shopPriceValue,2)."</td>
                        <td style='text-align:center;'>{$order->shopGateway}</td>
                        <td style='text-align:center;'>
                            <a href='javascript:void(0);' id='{$ITEMSCLICK}'><img src='"._URL_."styles/images/magnifier.png' alt='' /></a>
                            <a href='"._URL_."print-order-details?orderId={$order->shopId}' title='Print order details' target='_blank'><img src='"._URL_."styles/images/printer.png' alt='Print order details' title='Print order details' /></a>
                        </td>
                    </tr>";
                
                    $listItems = new smOrder;
                    $listItems = $listItems->GetAllItems($order->shopId);
                    echo "<tr>
                        <td colspan='7' style='border:none;'>
                        
                        <div id='$DIVID' style='display:none; clear:both; margin:10px auto; padding:0 10px 10px 10px; width:97%; border:solid 1px #CCC; border-top:none;'>
                            <table width='100%' border='0' cellspacing='0' cellpadding='0' class='gwlines'>
                                <tr>
                                    <th style='width:70%; text-align:left;'>Item</th>
                                    <th style='width:10%; text-align:center;'>Qty</th>
                                    <th style='width:10%; text-align:right;'>Price</th>
                                    <th style='width:10%; text-align:right;'>Total</th>
                                </tr>";
                        
                        foreach($listItems as $items){
                            $productitem = smProduct::GetIndividual($items->productId);
                            
                            if(empty($items->itemOnPromotion) || $items->itemOnPromotion==0){
                                $sPrice1="&pound;".number_format($items->itemPrice,2);
                                $sPrice2="&pound;".number_format($items->itemPrice * $items->itemQty, 2);
                            }else{
                                $sPrice1="Free";
                                $sPrice2="Free";
                            }
                            
                            echo "<tr>
                                    <td>".$productitem->productRefCode.":: ".$productitem->productTitle."</td>
                                    <td style='text-align:center;'>{$items->itemQty}</td>
                                    <td style='text-align:right;'>$sPrice1</td>
                                    <td style='text-align:right;'>$sPrice2</td>
                                </tr>";
                            
                        } // n foreach $listItems
                        
                        $getVoucherOnCart = smVouchers::getVoucherOnCart($order->shopId);
                    
                        if(!empty($getVoucherOnCart)){
                            foreach($getVoucherOnCart as $item){
                                $voucherdetails = smVouchers::GetIndividual($item->vouchersId);
                                echo "<tr>
                                    <td>Gif Voucher (Code - <span class='textblue'>{$voucherdetails->vouchersCode})</span></td>
                                    <td style='text-align:center;'>1</td>
                                    <td style='text-align:right;'>&pound;".number_format($voucherdetails->vouchersValue, 2)."</td>
                                    <td style='text-align:right;'>&pound;".number_format($voucherdetails->vouchersValue, 2)."</td>
                                </tr>";
                            }
                        }
                        
                        echo "</table></div>
                            </td></tr>";
                            
                        echo "<input type='hidden' id='$ORDERID' name='$ORDERID' value='{$order->shopId}' />";
                        
                    }   // n foreach $listOrder
                }   // n if(!empty($listOrder))
                ?>
            </table>
            
        </div><br>
    
    
    <?php include_once('forms/member-voucher-history.php'); ?>
