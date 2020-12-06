<?php

class smProduct{
	
	public function countProductLists(){
		$sqlSelect = "SELECT * FROM ex_product_details WHERE productVisibleFlag='1' ";
		$query = mysql_query($sqlSelect);
		$row = mysql_num_rows($query);
		//$row = mysql_fetch_array($query);
		return $row;
	}

	public function GetAll($page,$search,$sort,$sorttype){
		if($sort == "ref"){
			$s = " productRefCode ".$sorttype;
		}else if($sort == "cate"){
			$s = " productCategoryId ".$sorttype;
		}else if($sort == "price"){
			$s = " productPrice ".$sorttype;
		}else{
			$s = " productDateAdded DESC";
		}
		
		if(!isset($page)){
			$sql="select * from ex_product_details where productId !='' $search order by $s limit 0,100";
		}else{
			$sql="select * from ex_product_details where productId !='' $search order by $s limit ".(($page-1)*100).",100";
		}
		
		//echo $sql."<br/>";
		
		$rs=mysql_query($sql);
		$listProduct = array();
		while ($row = mysql_fetch_array($rs)){
			$listProduct[]=self::_processRow($row);
		}
		return $listProduct;			
	}	

	public function GetIndividual($id){
		$sqlSelect = "SELECT * FROM ex_product_details WHERE productId='$id' ";
		$query = mysql_query($sqlSelect);
		$row = mysql_fetch_array($query);
		$theProduct=self::_processRow($row);
		return $theProduct;
	}

	public function searchQuickLink($order){
		$sql="select * from ex_product_details where productVisibleFlag='1' order by $order";	
		
		$rs=mysql_query($sql);
		$listProduct = array();
		while ($row = mysql_fetch_array($rs)){
			$listProduct[]=self::_processRow($row);
		}
		return $listProduct;			
	}
	
	public function searchProduct($search, $limit, $page){
		if(empty($limit)){$limit=20;}

		if(empty($page)){
			$sql="select * from ex_product_details where productVisibleFlag='1' $search order by productDateAdded DESC LIMIT $limit";	
		}else{
			$sql="select * from ex_product_details where productVisibleFlag='1' $search order by productDateAdded DESC LIMIT ".(($page-1)*$limit).",$limit";	
		}
		//echo $sql;
		
		$rs=mysql_query($sql);
		$listProduct = array();
		while ($row = mysql_fetch_array($rs)){
			$listProduct[]=self::_processRow($row);
		}
		return $listProduct;			
	}
	
	function GetAllVisible(){  
		$sql="select * from ex_product_details where productVisibleFlag='1'";
		$rs=mysql_query($sql);
		$listProduct = array();
		while ($row = mysql_fetch_array($rs)){
			$listProduct[]=self::_processRow($row);
		}
		return $listProduct;			
	}

	public function GetCutPage($search,$limit){
		$sqlResult="select * from ex_product_details where productVisibleFlag='1' ". $search;
		$rsResult=mysql_query($sqlResult);
		$rowResult=mysql_fetch_array($rsResult);

		$listResult = array();
		$counter = 0;

		$propSearch = new smProduct;
		if(!empty($limit)){
			$propSearch->forCut = $limit;
		}else{
			$propSearch->forCut = 20;
		}
		
		$propSearch->cntPage = mysql_num_rows($rsResult)/$propSearch->forCut;
		$propSearch->cntList = mysql_num_rows($rsResult);
		$propSearch->cntMod = mysql_num_rows($rsResult)%$propSearch->forCut;
		
		if($propSearch->cntMod==0){ $propSearch->cntMod = $propSearch->forCut; }

		$listResult=$propSearch;
		return $listResult;
	}
	
	/*
	public function GetCountPropery($type){
		$sql = mysql_query("SELECT * FROM ex_product_details WHERE productVisibleFlag = '1' $type ");
		$row = mysql_num_rows($sql);
		return $row;
	}
	*/
	
	public function setVisible($id){
		$sql = mysql_query("SELECT productVisibleFlag FROM ex_product_details WHERE productId = '$id' ");
		$row = mysql_fetch_array($sql);
		$status = $row['productVisibleFlag'];

		if($status==1){		// remove visible
			$sqlUpdate = "UPDATE ex_product_details SET productVisibleFlag='0' WHERE productId='$id' ";
			mysql_query($sqlUpdate);
		}else{	// set visible
			$sqlUpdate = "UPDATE ex_product_details SET productVisibleFlag='1' WHERE productId='$id' ";
			mysql_query($sqlUpdate);
		}
	}
	
	public function Add($new){
		$sqlInsert = "INSERT INTO ex_product_details SET ";
                $sqlInsert .="productRefCode='".$new->productRefCode."', ";
		$sqlInsert .="productTitle='".$new->productTitle."', ";
		$sqlInsert .="productDescription='".$new->productDescription."', ";
		$sqlInsert .="productKeyword='".$new->productKeyword."', ";
                $sqlInsert .="productPrice='".$new->productPrice."', ";
                $sqlInsert .="productVisibleFlag='".$new->productVisibleFlag."', ";
                //$sqlInsert .="productDateAdded='".$new->productDateAdded."', ";
                //$sqlInsert .="productSetHomepage='".$new->productSetHomepage."', ";
		$sqlInsert .="productCilcks='".$new->productCilcks."', ";
                $sqlInsert .="productBestSale='".$new->productBestSale."', ";
                $sqlInsert .="productAdminNotes='".$new->productAdminNotes."', ";
		$sqlInsert .="productCategoryId='".$new->productCategoryId."', ";
		$sqlInsert .="productFabricId='".$new->productFabricId."', ";
		$sqlInsert .="productPatternId='".$new->productPatternId."', ";
		$sqlInsert .="productColorId='".$new->productColorId."', ";
		$sqlInsert .="productUserUpdate='".$_SESSION['username'] ."', ";
		$sqlInsert .="productRating='".$new->productRating."', ";
		$sqlInsert .="productMainPicture='".$new->productMainPicture."', ";
		$sqlInsert .="productFabricPicture='".$new->productFabricPicture."', ";
		$sqlInsert .="productFabricComposition='".$new->productFabricComposition."', ";
		$sqlInsert .="productFabricYarn='".$new->productFabricYarn."', ";
		$sqlInsert .="productFabricWeaving='".$new->productFabricWeaving."', ";
		$sqlInsert .="productFabricWeigth='".$new->productFabricWeigth."', ";
		$sqlInsert .="productFabricColorInfo='".$new->productFabricColorInfo."', ";
		$sqlInsert .="productLastdate='".mktime()."' ";
		
		//echo $sqlInsert;
		mysql_query($sqlInsert);
                return mysql_insert_id();
	}
	
	public function Update($update){		
		$sqlUpdate = "UPDATE ex_product_details SET ";
		$sqlUpdate .="productRefCode='".$update->productRefCode."', ";
		$sqlUpdate .="productTitle='".$update->productTitle."', ";
		$sqlUpdate .="productDescription='".$update->productDescription."', ";
		$sqlUpdate .="productKeyword='".$update->productKeyword."', ";
                $sqlUpdate .="productPrice='".$update->productPrice."', ";
                $sqlUpdate .="productVisibleFlag='".$update->productVisibleFlag."', ";
                //$sqlUpdate .="productDateAdded='".$update->productDateAdded."', ";
                //$sqlUpdate .="productSetHomepage='".$update->productSetHomepage."', ";
		$sqlUpdate .="productCilcks='".$update->productCilcks."', ";
                $sqlUpdate .="productBestSale='".$update->productBestSale."', ";
                $sqlUpdate .="productAdminNotes='".$update->productAdminNotes."', ";
		$sqlUpdate .="productCategoryId='".$update->productCategoryId."', ";
		$sqlUpdate .="productFabricId='".$update->productFabricId."', ";
		$sqlUpdate .="productPatternId='".$update->productPatternId."', ";
		$sqlUpdate .="productColorId='".$update->productColorId."', ";
		$sqlUpdate .="productUserUpdate='".$_SESSION['username'] ."', ";
		$sqlUpdate .="productRating='".$update->productRating."', ";
		$sqlUpdate .="productMainPicture='".$update->productMainPicture."', ";
		$sqlUpdate .="productFabricPicture='".$update->productFabricPicture."', ";
		$sqlUpdate .="productFabricComposition='".$update->productFabricComposition."', ";
		$sqlUpdate .="productFabricYarn='".$update->productFabricYarn."', ";
		$sqlUpdate .="productFabricWeaving='".$update->productFabricWeaving."', ";
		$sqlUpdate .="productFabricWeigth='".$update->productFabricWeigth."', ";
		$sqlUpdate .="productFabricColorInfo='".$update->productFabricColorInfo."', ";
		$sqlUpdate .="productLastdate='".mktime()."' ";
		$sqlUpdate .="WHERE productId='".$update->productId."' ";
		
		//echo $sqlUpdate;
		mysql_query($sqlUpdate) or die(mysql_error());
		return($update->productId);
	}
	
	public function Delete($id){
		$p = smProduct::GetIndividual($id);
		
		@unlink($root.'upload_pictures/'.$p->productMainPicture);
		@unlink($root.'upload_pictures/'.$p->productFabricPicture);
		
		$sqlDelete = "DELETE FROM ex_product_details WHERE productId ='$id' ";
		mysql_query($sqlDelete);
		
		/*
		$sqlDeleteFeature = "DELETE FROM pt_feature_index WHERE pfPdId ='$id' ";
		mysql_query($sqlDeleteFeature);

		$sql=mysql_query("SELECT * FROM pt_images WHERE imObjectId ='$id' ");
		while($row=mysql_fetch_array($sql)){
			unlink($root.'upload_pictures/'.$row['imPhysicalPath']);	// remove picture in folder
			//unlink($root.'upload_thumbs/'.$row['imPhysicalPath']);
		}
		
		$sqlDeletePicture = "DELETE FROM pt_images WHERE imObjectId ='$id' ";
		mysql_query($sqlDeletePicture);
		*/
	}
	
	private function _processRow($row){
		$product= new smProduct;
		$product->productId = $row['productId'];
                $product->productRefCode = $row['productRefCode'];
		$product->productTitle = $row['productTitle'];
		$product->productDescription = $row['productDescription'];
		$product->productPrice = $row['productPrice'];
                $product->productKeyword = $row['productKeyword'];
                $product->productVisibleFlag = $row['productVisibleFlag'];
                $product->productDateAdded = $row['productDateAdded'];
                //$product->productSetHomepage = $row['productSetHomepage'];
		$product->productCilcks = $row['productCilcks'];
                $product->productBestSale = $row['productBestSale'];
                $product->productAdminNotes = $row['productAdminNotes'];
		$product->productCategoryId = $row['productCategoryId'];
		$product->productFabricId = $row['productFabricId'];
		$product->productPatternId = $row['productPatternId'];
		$product->productColorId = $row['productColorId'];
		$product->productLastdate = $row['productLastdate'];
		$product->productUserUpdate = $row['productUserUpdate'];
		$product->productRating = $row['productRating'];
		$product->productMainPicture = $row['productMainPicture'];
		$product->productFabricPicture = $row['productFabricPicture'];
		$product->productFabricComposition = $row['productFabricComposition'];
		$product->productFabricYarn = $row['productFabricYarn'];
		$product->productFabricWeaving = $row['productFabricWeaving'];
		$product->productFabricWeigth = $row['productFabricWeigth'];
		$product->productFabricColorInfo = $row['productFabricColorInfo'];
		return($product);
	}
	
	/*
	public function CountFav($id){
		$sql="SELECT * FROM pt_user_favourites WHERE ufUsId= ".$id;
		$rs=mysql_query($sql);
		$cnt=mysql_num_rows($rs);
		return $cnt;
	}
	
	public function GetMyFavourites($memberId){			//for member favourite
		$sql="SELECT * FROM pt_user_favourites WHERE ufUsId='".$memberId."' ";	
		$query=mysql_query($sql);
		$listFav = array();
		$counter = 0;
		while($row=mysql_fetch_array($query)){
			$sqlFavourites="SELECT * FROM ex_product_details WHERE productId='".$row['ufPdId']."' ";
			$queryFavourites=mysql_query($sqlFavourites);
			$rowFavourites=mysql_fetch_array($queryFavourites);
		 	$listFav[] = smProduct::_processRow($rowFavourites);
			$counter += 1;
		}
		//print_r($listFav);
		return $listFav;
	}
	*/
	
}

?>
