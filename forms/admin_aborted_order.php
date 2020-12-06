<?php
$ORDERS = new smOrder;
$listOrder = new smOrder;
$listOrder = $listOrder->GetAbortedOrder();
?>

<div class="leftblock vertsortable" style="width:100%;">
    <!-- gadget left 1 -->
    <div class="gadget" id="orders">
        <div class="titlebar vertsortable_head">
                <h3>Aborted Orders</h3>
        </div>
	<div class="gadgetblock">
            <div id="orderList">
                <form id="orderListForm" method="post" action="<?=_URL_;?>admin_order">
                    
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="gwlines">
                        <tr>
                            <th style="width:10%;">Order Id</th>
                            <th style="width:14%; text-align:center;">Order Date</th>
                            <th style="width:20%; text-align:center;">Member</th>
                            <th style="width:10%; text-align:center;">Email</th>
                            <th style="width:15%; text-align:center;">Telephone / Mobile</th>
                            <th style="width:15%; text-align:center;">Status</th>
                        </tr>
                        
                    <?php 
                    if(!empty($listOrder)){

                        foreach ($listOrder as $orderDel){

                            $memberDetails=smUser::GetIndividual($orderDel->shopUserId);
                            $Y=substr($orderDel->shopDateadded,0,4);
                            $M=substr($orderDel->shopDateadded,5,2);
                            $MM=smSetting::changeMonth($M);
                            $D=substr($orderDel->shopDateadded,8,2);
			    
			    if(!empty($memberDetails->usId)){
				$n="<a href='"._URL_."admin_member?member={$memberDetails->usId}' target='_blank' title='view member details'>".$memberDetails->usFirstname." ".$memberDetails->usLastname ."</a>";
			    }else{
				$n="<span style='color:#FF0000;'>No details<span>";
			    }
			    
			    if(!empty($memberDetails->usEmail)){
				$e=$memberDetails->usEmail;
			    }else{
				$e="<span style='color:#FF0000;'>No details<span>";
			    }
			    
			    if(!empty($memberDetails->usTelephone) || !empty($memberDetails->usMobile)){
				$tm=$memberDetails->usTelephone ." / ". $memberDetails->usMobile;
			    }else{
				$tm="<span style='color:#FF0000;'>No details <span>";
			    }
			    
			    if($orderDel->shopCompleted==5){
				$orderstatus="Aborted";
			    }else{
				$orderstatus="Order Incomplete";
			    }
			    
                            echo "<tr>
                                <td><img alt='Aborted sales icon' title='Aborted sales' src='"._URL_."styles/images/status_h6.gif' style='margin-right:5px;'/> ID{$orderDel->shopId}</td>
                                <td style='text-align:center;'>".$D." ".$MM." ".$Y."</td>
                                <td style='text-align:center;'>$n</td>
                                <td style='text-align:center;'>$e</td>
				<td style='text-align:center; color:#355F94;'>$tm</td>
                                <td style='text-align:center;'>$orderstatus</td>
                            </tr>";
  
                            }   // n foreach $listOrder
                        }   // n if(!empty($listOrder))
                        ?>
                    </table><br />

                </form><br />
            </div>  <!-- div order list -->

        </div>	<!-- n gadgetblock -->
    </div>	<!-- n gadget -->
</div><br/>	<!-- n leftblock vertsortabl -->

