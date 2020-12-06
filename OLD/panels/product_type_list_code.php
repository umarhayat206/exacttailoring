<?php

if($_GET['delPtId']!="" && $_SESSION['auth']!=false){
	tsProductTypes::productTypeDelete($_GET['delPtId']);
}

function productTypeColumns(){
	echo("
		<tr>
			<th>&nbsp;</th>
			<th colspan='2'>
				Actions
			</th>
			<th>Name</th>
			<th>Category</th>
			<th>Price</th>
		</tr>
		");
}

function productTypeList($filter){
	$list = new tsProductTypes;
	$list = $list->productTypeList($filter);
	if(count($list)>0){
		foreach($list as $product){
			echo("
				<tr>
					<td>
						".($product->ptAvailable=='1'?"":"<img src='styles/images/hidden.gif' title='Product is not available' alt='Hidden icon' />")."
					</td>");
				
			echo("	
					<td class='action'>
						<a href='admin-product?delPtId=".$product->ptId."' title='Delete product' class='action' onclick='javascript:return confirm(\"Are you sure you want to delete this product?\")' >
							<img src='styles/images/cross.png' alt='Delete product' />
						</a>
					</td>
					<td class='action'>
						<a href='admin-product?ptId=".$product->ptId."' title='Edit product' class='action' >
							<img src='styles/images/pencil.png' alt='Edit product' />
						</a>
					</td>
					<td>".$product->ptName."</td>
					<td>".$product->pcName."</td>
					<td>&pound;".$product->ptPrice."</td>
				</tr>
				");
				
		}
	}
}

?>
