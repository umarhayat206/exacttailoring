<?php

if($_GET['delPcId']!="" && $_SESSION['auth']!="false"){
	tsProductCategory::productCategoryDelete($_GET['delPcId']);
}

function productCategoryList(){
	$list = new tsProductCategory;
	$list = $list->productCategoryTree();
	if(count($list)>0){
		for($x=0;$x<=count($list)-1;$x++){
			echo("
				<div class='catActions'>");
			if($list[$x+1][2]<=$list[$x][2]){ //Check the category has no children...
				echo("	
					<a href='admin-product?delPcId=".$list[$x][0]."' title='Delete category' class='action' onclick='javascript:return confirm(\"Are you sure you want to delete this category?\")' >
						<img src='styles/images/cross.png' alt='Delete contact' />
					</a>");
			}
			echo("
					<a href='admin-product?pcId=".$list[$x][0]."' title='Edit category' class='action' >
						<img src='styles/images/pencil.png' alt='Edit contact' />
					</a>
				</div>");
			for($i=1;$i<=$list[$x][2];$i++){
				echo("<span class='catSpacer'>&nbsp;</span>");
			}
			echo(" ".$list[$x][1]."<br />");			
		}
	}
}

?>