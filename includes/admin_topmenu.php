<div class="menu">
        <ul>
                <li class="first"><a href="<?= _URL_; ?>admin_order"><span><span><span>Order</span></span></span></a></li>
                <li><a href="<?= _URL_; ?>admin_aborted_order"><span><span><span>Aborted Order</span></span></span></a></li>
                <li><a><span><span><span>Product <img src="<?= _URL_; ?>styles/images/dropdown_arrow.gif" alt="picture" width="8" height="7" /></span></span></span></a>
                        <ul>
                                <li><a href="<?= _URL_; ?>admin_product/?action=addnew">Add new product</a></li>
                                <li><a href="<?= _URL_; ?>admin_product">Product Lists</a></li>
                        </ul>
                </li>

                <?php //if($_SESSION['chklevel'] == 1){ 
                ?>
                <li><a href="<?= _URL_; ?>admin_promotion"><span><span><span>Promotion</span></span></span></a>
                        <!--<ul><img src="<?= _URL_; ?>styles/images/dropdown_arrow.gif" alt="picture" width="8" height="7" />
                                <li><a href="<? //=_URL_;
                                                ?>admin_promotion">Create Promotion</a></li>
                                <li><a href="<? //=_URL_;
                                                ?>admin_coupon">Create Coupon</a></li>
                        </ul>-->
                </li>
                <!--<li><a href="<? //=_URL_;
                                        ?>admin_newsletter"><span><span><span>Newsletter</span></span></span></a></li>-->
                <li><a href="<?= _URL_; ?>admin_content"><span><span><span>Manage Content</span></span></span></a></li>
                <li><a href="<?= _URL_; ?>admin_customer_comment"><span><span><span>Testimonials</span></span></span></a></li>
                <li><a href="<?= _URL_; ?>admin_settings"><span><span><span>Field Settings</span></span></span></a></li>
                <li><a><span><span><span>Member <img src="<?= _URL_; ?>styles/images/dropdown_arrow.gif" alt="picture" width="8" height="7" /></span></span></span></a>
                        <ul>
                                <li><a href="<?= _URL_; ?>admin_member/?action=addnew">Add new Member</a></li>
                                <li><a href="<?= _URL_; ?>admin_member">Members List</a></li>
                                <li><a href="<?= _URL_; ?>admin_memberemail">Member Emails List</a></li>
                                <li><a href="<?= _URL_; ?>admin_cataloguerequests">Catalogue Requests</a></li>
                                <li><a href="<?= _URL_; ?>admin_cataoguemail" target="_blank">Catalogue Requests's Label</a></li>

                        </ul>
                </li>
                <li><a href="<?= _URL_; ?>admin_subscriber"><span><span><span>Subscriber</span></span></span></a></li>
                <li><a href="<?= _URL_; ?>admin_tapemeasureoffer"><span><span><span>Tape measure offer</span></span></span></a></li>
                <li><a href="<?= _URL_; ?>admin_user"><span><span><span>User</span></span></span></a></li>
                <?php //} 
                ?>
        </ul>
        <div class="clr"></div>
</div>