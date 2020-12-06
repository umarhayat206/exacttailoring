<h4>Body/Shirt measurement profiles</h4>
<p>Enter your complete measurements for the most accurate results.</p>
<?php //if(stristr($_SERVER['PHP_SELF'],"member-measurements") || stristr($_SERVER['PHP_SELF'],"order-a-shirt-step-3")) { ?>
<?php if(stristr($_SERVER['PHP_SELF'],"member-measurements") || stristr($_SERVER['PHP_SELF'],"tailor-made-shirts-measurements")) { ?>
<div id="addNewBM" class="addNew">Add new</div><br />
<?php } ?>
<ul id="bodyMeasurementProfiles">
	<?php showBmProfiles($_SESSION['auth']->mId);?>
</ul>