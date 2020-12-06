<?php
//echo($_SERVER['FULL_URL']);

$list = tsProductCategory::productCategoryTree();
//print_r($list);
if(count($list)>0){
	echo("<ul id='productTree'>");
	for($x=0;$x<=count($list)-1;$x++){
		echo("<li>");
		for($i=1;$i<=$list[$x][2];$i++){
			echo("<span class='catSpacer'>&nbsp;</span>");
		}
		$count = tsProductCategory::pcCountProducts($list[$x][0]);
		if($count>0){
			echo(" 
					<a href='".$siteLocalRoot."product/".$list[$x][0]."/".smFunctions::makeSef($list[$x][1])."' title='View these products'>".$list[$x][1]."</a> <span class='smallText'>(".$count.")</span>
				</li>");
		}else{
			echo($list[$x][1]);
		}			
	}
	echo("</ul>");
}

?>