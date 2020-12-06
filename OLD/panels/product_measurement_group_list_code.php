<?php

if($_GET['delPmgId']!="" && $_SESSION['auth']!="false"){
	tsProductMeasurmentGroup::pmgDelete($_GET['delPmgId']);
}

function productMGList(){
	$list = tsProductMeasurmentGroup::pmgGetCollection();
	if(count($list)>0){
		foreach($list as $group){
			echo("<li>");
			echo("	
					<a href='admin-product-measurements?delPmgId=".$group->pmgId."' title='Delete group' class='action' onclick='javascript:return confirm(\"Are you sure you want to delete this group?\")' >
						<img src='styles/images/cross.png' alt='Delete measurements' />
					</a>");
			echo("
					<a href='admin-product-measurements?pmgId=".$group->pmgId."' title='Edit group' class='action' >
						<img src='styles/images/pencil.png' alt='Edit measurements' />
					</a>");	
			echo($group->pmgName."
			</li>");
		}
	}
}

?>