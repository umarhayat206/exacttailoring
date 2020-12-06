<div class="account-a-div">
<a href="javascript:void(0)" class="voucher-history account-a"><i class="icon-caret-right"></i> View Vouchers History</a>
</div>

    <div class="voucher-history-div"style="display: none;">
        <center>
            <img alt="Payment awaiting confirmation icon" title="Payment awaiting confirmation" src="<?php echo _URL_;?>styles/images/status_h1.gif" style="margin:0 5px 0 15px;"/>Payment awaiting confirmation
            <img alt="Available to use icon" title="Available to use" src="<?php echo _URL_;?>styles/images/status_h5.gif" style="margin:0 5px 0 15px;"/>Available to use
            <img alt="Already Used icon" title="Already Used" src="<?php echo _URL_;?>styles/images/status_h3.gif" style="margin:0 5px 0 15px;"/>Already Used
        </center><br />

        <table width="100%"  class="gwlines table table-bordered table-hover">
            <tr>
                <th style="width:5%;">&nbsp;</th>
                <th style="width:35%;">Vouchers Code</th>
                <th style="width:20%; text-align:right;">Value</th>
                <th style="width:20%; text-align:center;">Create Date</th>
                <th style="width:20%; text-align:center;">Expire Date</th>
            </tr>
            
            <?php
            $listVoucher = smVouchers::GetAll($_SESSION['chkmemberuser']);
                
            if(!empty($listVoucher)){
                foreach($listVoucher as $item){
                    $voucherdetails = smVouchers::GetIndividual($item->vouchersId);
                    
                    $voucherStatusIcon = smVouchers::GetBulletStatus($item->vouchersStatus);
                    //$voucherStatusTitle = smVouchers::GetStatusTitle($item->vouchersStatus);

                    $exdate = explode("-",$item->vouchersOrderDate);
                    $exmonth = smSetting::changeMonth($exdate[1]);
                    $k=$exdate[0]+1;

                    if($item->vouchersStatus==2){
                        $printvoucher = "<a href='#' target='_blank' style='width:auto;'>
                            <span>{$item->vouchersCode}</span>
                            <img src='"._URL_."styles/images/printer.png' alt='Print voucher' title='Print voucher' style='margin:0 4px; float:none;' /></a>";

                    }else{
                        $printvoucher = $item->vouchersCode; 
                    } 
                    
                    echo "<tr>
                        <td>$voucherStatusIcon</td>
                        <td>$printvoucher</td>
                        <td style='text-align:right;'>".number_format($item->vouchersValue, 2)."</td>
                        <td style='text-align:center;'>{$exdate[2]} $exmonth {$exdate[0]}</td>
                        <td style='text-align:center;'>{$exdate[2]} $exmonth $k</td>
                    </tr>";
                } 
                
            }
            ?>
           
        </table>
        
    </div>
