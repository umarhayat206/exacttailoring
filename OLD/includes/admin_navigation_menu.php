<ul>
<?php if($_SESSION['auth']->mRole==3){  // may edit ?>	
	<li><a href="admin-index" title="Main administration page">Orders</a></li>
<?php }else{   // may edit ?>	
	<li><a href="admin-index" title="Main administration page">Orders</a></li>
	<li><a href="admin-contacts" title="System members and staff">Members</a></li>
	<?php if($_SESSION['auth']->mRole==4){ ?>
	<li><a href="admin-product" title="Product catalog">Products</a></li>
	<li><a href="admin-product-measurements" title="Product measurements">Measurements</a></li>
	<li><a href="admin-fabrics" title="Available fabrics">Fabrics</a></li>
	<?php } ?>
	<li><a href="admin-requests" title="Catalogue requests">Catalogue requests</a></li>
	<li><a href="member-emaillist" title="Member Email Lists">Member email lists</a></li>
	<li><a href="newsletter" title="Newsletter" target="_blank">Newsletter</a></li>
<?php }   // may edit ?>	
</ul>