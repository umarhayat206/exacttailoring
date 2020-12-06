<?php

if($_GET['ftId']!=""){
	$ftId = $_GET['ftId'];
	$curFabType = tsFabricType::ftDetails($ftId);
}

function fabricList($ftId){
	$collection = tsFabrics::fabricGetFilteredCollection($ftId);
	if(count($collection)>0){
		$counter = 0;
		foreach($collection as $fabric){
			echo("<li>");
			//smControls::smImageOptional($fabric->fImage,$fabric->ftName.", ".$fabric->fName,$fabric->ftName.", ".$fabric->fName);
			smImages::showThumb($fabric->fImage,$fabric->ftName.", ".$fabric->fName,160);
			echo("<br />".$fabric->ftName."<br />".$fabric->fName." <span class='smallText'>(".$fabric->fCode.")</span>");
			echo("<br />&pound;".$fabric->fPricePerShirt);
			//echo("<br /><a href='order-a-shirt-step-2?fId=".$fabric->fId."' title='Choose this fabric' class='fabricChoice'>Select this fabric</a>");
			echo("<br /><a href='tailor-made-shirts-designer?fId=".$fabric->fId."' title='Choose this fabric' class='fabricChoice'>Select this fabric</a>");
			echo("</li>");
			$counter++;
			if($counter>=4){
				echo("<br />");
				$counter = 0;
			}
		}
	}
}

?>