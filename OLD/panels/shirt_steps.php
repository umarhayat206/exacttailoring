<?php

$page = $_SERVER['FULL_URL'];

?>
<ol id="shirtSteps">
	<li<?php echo(stristr($page,"tailor-made-shirts1")?" class='currentStep'":"");?>>Choose your fabric</li>
	<li<?php echo(stristr($page,"tailor-made-shirts-designer")?" class='currentStep'":"");?>>Create your design</li>
	<li<?php echo(stristr($page,"tailor-made-shirts-measurements")?" class='currentStep'":"");?>>Enter your measurements</li>
	<li class="finalStep<?php echo(stristr($page,"tailor-made-shirts-review")?" currentStep":"");?>">Review your choices</li>
</ol>
<!--
<ol id="shirtSteps">
	<li<?php //echo(stristr($page,"order-a-shirt-step-1")?" class='currentStep'":"");?>>Choose your fabric</li>
	<li<?php //echo(stristr($page,"order-a-shirt-step-2")?" class='currentStep'":"");?>>Create your design</li>
	<li<?php //echo(stristr($page,"order-a-shirt-step-3")?" class='currentStep'":"");?>>Enter your measurements</li>
	<li class="finalStep<?php //echo(stristr($page,"order-a-shirt-step-4")?" currentStep":"");?>">Review your choices</li>
</ol>
-->