<aside class="span3">
    <!-- <div class="product-colors"> -->
        <!-- <div class="titleHeader clearfix"> -->
            <h3 id="contactus-h1">START SHOPPING</h3>
        <!-- </div> -->

        <ul class="nav nav-sidebar">
            <?php if ($__get[1] == "how-to-order") { ?>
                <li><a href="<?= _URL_; ?>" class="invarseColor"><i class="icon-caret-right"></i>Men's Shirts</a></li>
                <li><a href="<?= _URL_; ?>" class="invarseColor"><i class="icon-caret-right"></i>Men's Trousers</a></li>
                <li><a href="<?= _URL_; ?>" class="invarseColor"><i class="icon-caret-right"></i>Men's Dress Shirts</a></li>
                <li><a href="<?= _URL_; ?>" class="invarseColor"><i class="icon-caret-right"></i>Men's Pyjamas</a></li>
                <li><a href="<?= _URL_; ?>" class="invarseColor"><i class="icon-caret-right"></i>Men's Boxer Shorts</a></li>
                <li><a href="<?= _URL_; ?>style-options" class="invarseColor"><i class="icon-caret-right"></i>Style options </a></li>
                <li><a href="<?= _URL_; ?>" class="invarseColor"><i class="icon-caret-right"></i>Women's Blouses</a></li>
                <li><a href="<?= _URL_; ?>images/order-form.pdf" class="invarseColor" target="_blank"><i class="icon-caret-right"></i>Download an Order Form</a></li>

            <?php } else { ?>
                <li><a href="<?= _URL_; ?>content/how-to-order" class="invarseColor"><i class="icon-caret-right"></i>How to Order</a></li>
                <li><a href="<?= _URL_; ?>collection" class="invarseColor"><i class="icon-caret-right"></i>Start Shopping</a></li>
                <li><a href="<?= _URL_; ?>order-catalogue" class="invarseColor"><i class="icon-caret-right"></i>Order Catalogue</a></li>
                <li><a href="<?= _URL_; ?>images/order-form.pdf" class="invarseColor" target="_blank"><i class="icon-caret-right"></i>Download an Order Form</a></li>
                <li><a href="<?= _URL_; ?>promotion" class="invarseColor"><i class="icon-caret-right"></i>Promotions</a></li>
                <li><a href="<?= _URL_; ?>customer-comments" class="invarseColor"><i class="icon-caret-right"></i>Customer Comments</a></li>
                <li><a href="<?= _URL_; ?>content/guarantee" class="invarseColor"><i class="icon-caret-right"></i>Guarantee</a></li>
                <li><a href="<?= _URL_; ?>contact" class="invarseColor"><i class="icon-caret-right"></i>Contact Us</a></li>

            <?php } ?>
        </ul>

    <!-- </div> -->

    <div class="titleHeader clearfix" style="height: 20px;"></div>
    <?php /*
    <a href="<?php echo _URL_; ?>/collection/categories-mens-shirts/fabric-mauritius-">
			<img src="<?=_URL_;?>images/mauritius-montage.jpg" alt="Buy tailor made shirts online" title="Buy tailor made shirts online" style="width:100%; margin-top:10px;" />
        </a>
        */ ?>
</aside>