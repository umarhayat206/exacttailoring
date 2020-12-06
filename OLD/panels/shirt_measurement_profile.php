<h4>Standard shirt service</h4>
<p>Enter only a few measurements and let us accurately calculate the rest.</p>
<?php //if(stristr($_SERVER['PHP_SELF'],"member-measurements") || stristr($_SERVER['PHP_SELF'],"order-a-shirt-step-3")) { ?>
<?php if(stristr($_SERVER['PHP_SELF'],"member-measurements") || stristr($_SERVER['PHP_SELF'],"tailor-made-shirts-measurements")) { ?>
<div id="addNewSM" class="addNew">Add new</div><br />
<?php } ?>
<ul id="shirtMeasurementProfiles">
	<?php showSmProfiles($_SESSION['auth']->mId);?>
</ul>