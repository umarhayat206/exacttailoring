<?php

include_once('includes/globals.php');
include_once('includes/html_head.php');
include_once("forms/form_head.php");

if(empty($_SESSION['chkmemberuser'])){ // member not login 
    echo "<script language='javascript' type='text/javascript'>
            alert('You are not login. Please login to your account.');
        </script>";
        //window.location='"._URL_."gift-vouchers';
}

?>

<div class="row">

    <div class="span9">
        <div class="register">

            <div class="titleHeader clearfix">
                <h3>Create Gif Voucher</h3>
            </div>

            <form method="post" action="<?=_URL_; ?>addcart.php" class="form-horizontal" enctype="multipart/form-data">
                <div class="legend">&nbsp;&nbsp;Give the gift of Custom. Send a personalized Gift Card to anyone, anywhere in the world.</div>

                <div class="control-group">
                    <label class="control-label" for="inputEMAdd">Recipient's E-Mail: <span class="text-error">*</span></label>
                    <div class="controls">
                        <input type="text" id="recipientEmail" name="recipientEmail" placeholder="E-Mail" class="required email" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="inputTele">Recipient's Name: <span class="text-error">*</span></label>
                    <div class="controls">
                        <input type="text" id="recipientName" name="recipientName" placeholder="Name" class="required" />
                    </div>
                </div>

                <div class="control-group">
                    <div class="control-label">Amount: <span class="text-error">*</span></div>
                    <div class="controls">
                      <select name="vouchersValue" id="vouchersValue">
                        <option value="10">&pound;10</option>
                        <option value="20">&pound;20</option>
                        <option value="30">&pound;30</option>
                        <option value="40">&pound;40</option>
                        <option value="50">&pound;50</option>
                        <option value="60">&pound;60</option>
                        <option value="70">&pound;70</option>
                        <option value="80">&pound;80</option>
                        <option value="90">&pound;90</option>
                        <option value="100">&pound;100</option>
                        <option value="150">&pound;150</option>
                        <option value="200">&pound;200</option>
                      </select>
                    </div>
                </div>
                                
                <div class="control-group">
                    <label class="control-label" for="inputTele">Message: </label>
                    <div class="controls">
                        <textarea id="message" name="message" placeholder="Message"></textarea>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <input type="hidden" id="hiddenvouchers" name="hiddenvouchers" value="true" />
                        <input type="submit" class="btn btn-primary" id="" name="" value="Purchase Gift Voucher" />
                    </div>
                </div>
            </form>

        </div><!--end register-->
    </div><!--end span9-->

    <div class="span3">
        <div class="titleHeader clearfix">
            <h3>Account</h3>
        </div>
        
        <ul class="unstyled my-account">
            <?php if(empty($_SESSION['chkmemberuser'])){ // member not login ?>
                <li><a class="invarseColor loginclick" href="<?=_URL_;?>memberlogout"><i class="icon-caret-right"></i> Member Login</a></li>
                <li class="changeoassword"><a class="invarseColor regisclick" href="#"><i class="icon-caret-right"></i> Register</a></li>
                <li><a class="invarseColor" href="<?=_URL_; ?>customer-comments"><i class="icon-caret-right"></i> Leave Comment</a></li>
                <li><a class="invarseColor" href="<?=_URL_; ?>newsletter"><i class="icon-caret-right"></i> Newsletter</a></li>
            <?php }else{ ?>
                <li><a class="invarseColor" href="<?=_URL_;?>memberlogout"><i class="icon-caret-right"></i> Logout</a></li>
                <li class="changeoassword"><a class="invarseColor" href="#"><i class="icon-caret-right"></i> Change Password</a></li>
                <li class="editaccountinfo"><a class="invarseColor" href="#"><i class="icon-caret-right"></i> My Account</a></li>
                <!--<li><a class="invarseColor" href="#"><i class="icon-caret-right"></i> My wishlist</a></li>-->
                <li class="orderhistory"><a class="invarseColor" href="#"><i class="icon-caret-right"></i> Order History</a></li>
                <li><a class="invarseColor" href="<?=_URL_; ?>customer-comments"><i class="icon-caret-right"></i> Leave Comment</a></li>
                <li><a class="invarseColor" href="<?=_URL_; ?>newsletter"><i class="icon-caret-right"></i> Newsletter</a></li>
            <?php } ?>
        </ul>
    </div>

</div>

<?php include_once('forms/form_end.php'); ?>