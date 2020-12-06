<?php

$selectedFabric = new tsFabrics;
$selectedFabric = $selectedFabric->fabricGetCompleteCollection($_SESSION['fId']);
if(count($selectedFabric)>0 && count($selectedFabric)<2){ //Only one fabric returned
	echo("<div id='selectedFabric'><h6>Selected fabric</h6>");
	smImages::showThumb($selectedFabric[0]->fImage,$selectedFabric[0]->ftName.", ".$selectedFabric[0]->fName,160);
	//smControls::smImageOptional($selectedFabric[0]->fImage,$selectedFabric[0]->ftName.", ".$selectedFabric[0]->fName,$selectedFabric[0]->ftName.", ".$selectedFabric[0]->fName);
	echo("<br />".$selectedFabric[0]->ftName."<br />".$selectedFabric[0]->fName);
	echo("<br />&pound;".$selectedFabric[0]->fPricePerShirt);
	//echo("<br /><a href='order-a-shirt' title='Choose a different fabric'>Select a different fabric</a>");
	echo("</div>");
}

// TODO:: PROMOTION - Show promotion banner
if($OpenPromotion == "OPEN"){	// chech promotion by promotion status = open
	//echo "<div style='margin:400px 0 0 300px; clear:both; position:absolute;'><a href='promotion'><img src='newletter_pictures/promotion_mar.jpg' alt='28 Day spring savings save up to &pound;20' title='28 Day spring savings save up to &pound;20'  /><a/></div>";
}

?>
