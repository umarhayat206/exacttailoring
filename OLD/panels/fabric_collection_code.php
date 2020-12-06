<?php

if($_GET['delFtId']!="" && $_SESSION['auth']!='false'){
	tsFabricType::ftDelete($_GET['delFtId']);
}

function fabricCollectionList(){
	$types = new tsFabricType;
	$types = $types->ftList();
	if(count($types)>0){
		foreach($types as $type){
			echo("<li>");
			echo("	
					<a href='admin-fabrics?delFtId=".$type->ftId."' title='Delete collection' class='action' onclick='javascript:return confirm(\"Are you sure you want to delete this fabric collection?\")' >
						<img src='styles/images/cross.png' alt='Delete collection' />
					</a>");
			echo("
					<a href='admin-fabrics?ftId=".$type->ftId."' title='Edit fabric collection' class='action' >
						<img src='styles/images/pencil.png' alt='Edit collection' />
					</a>");	
			echo($type->ftName."
			</li>");
		}
	}
}
?>