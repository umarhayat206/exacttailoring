<?php
$PRODUCTID=0;
$PRODUCT = new smProduct;

if ($_POST['productDeleteSubmitted']){ $PRODUCT->Delete($_POST['productId']); }

if($_POST['productVisibleSubmitted']){
	$PRODUCT->setVisible($_POST['productId']);
	//echo "<script>history.go(-1);</script>";
}

if (!empty($_REQUEST['adminSearchSubmit'])){
	if(!empty($_REQUEST['searchrefcode'])){ $sqladminsearch .= " AND productRefCode LIKE '%".$_REQUEST['searchrefcode']."%'"; }
	
}

if(!empty($_REQUEST['searchcategory'])){ $sqladminsearch .=" AND productCategoryId = '".$_REQUEST['searchcategory']."' "; }

if ($_POST['productId']!="" || $_GET['productId']!=""){	
	$PRODUCT = $PRODUCT->GetIndividual($_REQUEST['productId']);
	//$listFeature = smIndexFeature::GetAll($_REQUEST['productId']);
}

//Move up
if($_GET['pictureUpSelected']=='true'){
	$MOVEPICTURE->MoveUp($_GET['imId'], $_GET['propertyId'], $_GET['imType']);
}

//Move down
if($_GET['pictureDownSelected']=='true'){
	$MOVEPICTURE->MoveDown($_GET['imId'], $_GET['propertyId'], $_GET['imType']);
}

if ($_POST['productFormSubmitted']){	
	$PRODUCT->productId = $_POST['productId'];
        $PRODUCT->productRefCode = $_POST['productRefCode'];
	$PRODUCT->productTitle = $_POST['productTitle'];
	$PRODUCT->productDescription = mysql_real_escape_string($_POST['productDescription']);
	$PRODUCT->productKeyword = $_POST['productKeyword'];
        $PRODUCT->productPrice = str_replace(",","",$_POST['productPrice']);
	$PRODUCT->productVisibleFlag = $_POST['productVisibleFlag'];
        $PRODUCT->productSetHomepage = $_POST['productSetHomepage'];
        $PRODUCT->productCilcks = $_POST['productCilcks'];
	$PRODUCT->productBestSale = $_POST['productBestSale'];
	$PRODUCT->productAdminNotes = $_POST['productAdminNotes'];
	$PRODUCT->productCategoryId = $_POST['productCategoryId'];
	$PRODUCT->productFabricId = $_POST['productFabricId'];
	$PRODUCT->productPatternId = $_POST['productPatternId'];
	$PRODUCT->productColorId = $_POST['productColorId'];
	$PRODUCT->productRating = $_POST['productRating'];
	$PRODUCT->productFabricComposition = $_POST['productFabricComposition'];
	$PRODUCT->productFabricYarn = $_POST['productFabricYarn'];
	$PRODUCT->productFabricWeaving = $_POST['productFabricWeaving'];
	$PRODUCT->productFabricWeigth = $_POST['productFabricWeigth'];
	$PRODUCT->productFabricColorInfo = $_POST['productFabricColorInfo'];
	
	$IMAGES = new smImage;
	$uploaddir1 = "upload_pictures/";
	//$uploaddir2 = "upload_thumbs/";
	$limitSize=1024000;		//1mb
	$tt = mktime();
	
	$uploadmainimg= $tt."-product-".$_FILES['productMainPicture']['name'];
	$filename_tmp1 = $_FILES['productMainPicture']['name'];
	if($filename_tmp1!=""){      // upload main picture
		if(copy($_FILES['productMainPicture']['tmp_name'], $uploaddir1.$uploadmainimg)){
			$PRODUCT->productMainPicture = $uploadmainimg;
		}else{
			$PRODUCT->productMainPicture = $_POST['hiddenMainPicture'];
		}
	}else{
		$PRODUCT->productMainPicture = $_POST['hiddenMainPicture'];
		//echo "<script>alert('Your picture size more than 1mb ....... please try again!!!.');</script>";
	}
	
	$uploadfabricimg= $tt."-product-fabric-".$_FILES['productFabricPicture']['name'];
	$filename_tmp2 = $_FILES['productFabricPicture']['name'];
	if($filename_tmp2!=""){      // upload main picture
		if(copy($_FILES['productFabricPicture']['tmp_name'], $uploaddir1.$uploadfabricimg)){
			$PRODUCT->productFabricPicture = $uploadfabricimg;
		}else{
			$PRODUCT->productFabricPicture = $_POST['hiddenFabricPicture'];
		}
	}else{
		$PRODUCT->productFabricPicture = $_POST['hiddenFabricPicture'];
		//echo "<script>alert('Your picture size more than 1mb ....... please try again!!!.');</script>";
	}

	if ($_POST['productId']==""){	echo "-1-";
		$PRODUCTID=$PRODUCT->Add($PRODUCT);
	}else{		echo "-2-";
		$PRODUCT->productId = $_POST['productId'];
		$PRODUCTID=$PRODUCT->Update($PRODUCT);
	}
	
	if ($_POST['productId']==""){
		if($_POST['saveoption']==1){
			echo ("<script>window.location='"._URL_."admin_product';</script>");
			//echo ("<script>window.close();</script>");
		}else{
			echo ("<script>window.location='"._URL_."admin_product/?productId=$PRODUCTID&action=editdata';</script>");
		}
	}else{
		if($_POST['saveoption']==1){
			echo ("<script>window.location='"._URL_."admin_product';</script>");
			//echo ("<script>window.close();</script>");
		}else{
			echo ("<script>window.location='"._URL_."admin_product/?productId=$PRODUCTID&action=editdata';</script>");
		}
	}
	
	/*
	include_once('Thumbnail.class.php');		// water mark
	
	$IMAGES = new smImage;
	$uploaddir1 = "upload_pictures/";
	//$uploaddir2 = "upload_thumbs/";
	$limitSize=1024000;		//1mb
	$tt=mktime();
	
	$IMAGES->imObjectId = $PRODUCTID;
	$IMAGES->imType = 1;
	
	//$g_watermark_image = $_SERVER['DOCUMENT_ROOT']."/images/watermark.png";
	for($i=1;$i<5;$i++){
		$uploadimg= $tt."-".$PRODUCTID."-product-".$i."-".$_FILES['productPicture'.$i]['name'];
		$filename_tmp = $_FILES['productPicture'.$i]['tmp_name'];

		if($filename_tmp!=""){      // upload main picture
			$IMAGES->imPhysicalPath = $uploadimg;
			if(filesize($filename_tmp)<=$limitSize){				
				
				//$filename_new = $uploaddir1.$uploadimg;
				//$size = @getimagesize($filename_tmp);
				//
				//$saveWaterMark=new Thumbnail($filename_tmp);
				//$saveWaterMark->quality=100; 
				//$saveWaterMark->img_watermark=$g_watermark_image;
				//$saveWaterMark->size($size[0],$size[1]);
				//$saveWaterMark->process();
				////$filename=$thumb->unique_filename ( '.' , $nameReturn , ''); 
				//$status=$saveWaterMark->save($filename_new);
				//
				//$thumb = $uploaddir2.$uploadimg;
				//$status=$saveWaterMark->save($thumb);   
				
				
				if(copy($_FILES['productPicture'.$i]['tmp_name'], $uploaddir1.$uploadimg)){
				//if(move_uploaded_file($_FILES['pdImg'.$i]['tmp_name'], $uploaddir1.$uploadimg)){
					$IMAGES->imPhysicalPath = $uploadimg;
					//chmod($root."pictures/".$uploadimg,0644);
				}else{
					$IMAGES->imPhysicalPath = "";
				}
				//$IMAGES->thumbnail($_FILES['productPicture'.$i]['tmp_name'], 190,$uploaddir2,$uploadimg);

			}else{
				echo "<script>alert('Your picture size more than 1mb ....... please try again!!!.');</script>";
			}
			$IMAGES->Add($IMAGES);
		}
	}
	*/
	// ----------- n save images -----------
	
	/*
	$INDEXFEAT = new smIndexFeature;
	$INDEXFEAT->pfPdId = $PRODUCTID;
	
	$sqlDelete = "DELETE FROM pt_feature_index WHERE pfPdId='".$INDEXFEAT->pfPdId."'";
	mysql_query($sqlDelete);
	
	for($j=0;$j<=$_POST['featNum'];$j++):		
		if($_POST['feat'.$j]!=""){
			$INDEXFEAT->pfFeId = $_POST['feat'.$j];	
			$INDEXFEAT->Add($INDEXFEAT);
		}
	endfor;
	*/
	// ----------- n save feature ------------
	/*
	if ($_POST['productId']==""){
		if($_POST['saveoption']==1){
			echo ("<script>window.location='"._URL_."admin_product';</script>");
			//echo ("<script>window.close();</script>");
		}else{
			echo ("<script>window.location='"._URL_."admin_product/?productId={$_REQUEST['productId']}&action=editdata';</script>");
		}
	}else{
		if($_POST['saveoption']==1){
			echo ("<script>window.location='"._URL_."admin_product';</script>");
			//echo ("<script>window.close();</script>");
		}else{
			echo ("<script>window.location='"._URL_."admin_product/?productId={$_REQUEST['productId']}&action=editdata';</script>");
		}
	}
	*/
	
	//echo $_POST['lat']."---".$_POST['lng'];
}	// n save
/*
if($_GET['imageDeleteAll']==true){
	$listOfImage = smImage::GetAllProperty($_GET['productId']);
	foreach ($listOfImage as $image){
		smImage::Delete($image->imId,$image->imPhysicalPath);
	}
}

if ($_GET['imageDeleteSubmitted']==true){
	$IMAGES = new smImage;
 	$IMAGES->Delete($_GET['imId'],$_GET['imName']);
	echo "<script language='javascript' type='text/javascript'>
                        history.go(-2);
                </script>";
}

if ($_GET['imagePrimarySubmitted']==true){
	$IMAGES = new smImage;
	$IMAGES->imObjectId = $_GET['productId'];
        $IMAGES->imId = $_GET['imId'];
	$IMAGES->imType = 1;
	$IMAGES->Update($IMAGES);
}

function showImageList($id){			//show images list
	global $site_admin;
	$imageList = new smImage;
	$image = new smImage;
	$htmlToReturn = "";

	$image->imObjectId = $id;
	$image->imType = 1;
	
	if(!empty($id)){
		$listOfImage=$imageList->GetAllImages($image);
		$counter=0;
		foreach ($listOfImage as $image){
			if($image->imPrimaryFlag==1){	
				$htmlToReturn .= "<div class='listImg'><img src='{$site_admin}upload_pictures/{$image->imPhysicalPath}' alt='{$image->imId}' width='100' height='75'  style='border:solid 2px #FF0000;'  />
				<a href='{$site_admin}admin_product/?productId={$id}&amp;imId={$image->imId}&amp;imagePrimarySubmitted=true&amp;action=save'><img src='"._URL_."styles/images/primary.gif' alt='Set Primary' title='Set Primary' style='border:none;' /></a>
				<a href='{$site_admin}admin_product/?productId={$id}&amp;imId={$image->imId}&amp;imageDeleteSubmitted=true&amp;imName={$image->imPhysicalPath}&amp;action=save'><img src='"._URL_."styles/images/delete2.gif' style='border:none;' alt='Delete' title='Delete' /></a>
				</div>";
			}else{
				$htmlToReturn .= "<div class='listImg'><img src='{$site_admin}upload_pictures/{$image->imPhysicalPath}' alt='{$image->imId}' width='100' height='75' />
				<a href='{$site_admin}admin_product/?productId={$id}&imId={$image->imId}&imagePrimarySubmitted=true&action=save'><img src='"._URL_."styles/images/primary.gif' alt='Set Primary' title='Set Primary' style='border:none;' /></a>
				<a href='{$site_admin}admin_product/?productId={$id}&imId={$image->imId}&imageDeleteSubmitted=true&imName={$image->imPhysicalPath}&amp;action=save'><img src='"._URL_."styles/images/delete2.gif' style='border:none;' alt='Delete' title='Delete' /></a>
				<a href='{$site_admin}admin_property/?propertyId={$id}&imId={$image->imId}&imType=1&pictureUpSelected=true&action=save'><img src='"._URL_."styles/images/up.gif' style='margin:0px 0 0 5px;' alt='Up' title='Up' /></a>
				<a href='{$site_admin}admin_property/?propertyId={$id}&imId={$image->imId}&imType=1&pictureDownSelected=true&action=save'><img src='"._URL_."styles/images/down.gif' style='margin:0px 0 0 3px;' alt='Down' title='Down' /></a>
				</div>";
			}
		} 	//n foreach
	} // n if !empty $imPdId
	return $htmlToReturn;
}
*/

/*
function featureList($checkedId){			//show fertures list
	$featureList = new smFeature;
	$listOfFeature = $featureList->GetMenuAndPages(null, true);
	$htmlToReturn = "";
	$counter=0;

	$newArray=array();
	for($i=0;$i<count($checkedId);$i++){
		$newArray[$checkedId[$i]]=" checked=\"checked\" ";		
	}

	$htmlToReturn .= "<ul>";
	foreach ($listOfFeature as $feature){
		$counter++;
		$feName="feat".$counter;
		
		if($feature->parent_node>0){
			$htmlToReturn .= "<li style='width:25%; float:left; list-style:none;'>";
			$htmlToReturn .= "<input style='width:auto; float:left;' type='checkbox' name='".$feName."' ";
			$htmlToReturn .= $newArray[$feature->feId];
			$htmlToReturn .= " id='".$feName."' value='".$feature->feId."' />";
			$htmlToReturn .= "<label>".$feature->feName."</label>";
			$htmlToReturn .= "</li>";
			
		}else{
			$htmlToReturn .= "<li style='width:100%; float:left; list-style:none; clear:both; font-weight:bold; margin-top:10px; '>";
			$htmlToReturn .= $feature->feName;
			$htmlToReturn .= "</li>";
			
		}
	}
	$htmlToReturn .="</ul>";

	$htmlToReturn .="<input type='hidden' value='".$counter."' name='featNum' id='featNum' />";
	
	return $htmlToReturn;	
}
*/

function pdCategoryDropDownList($checkedId){	
	$currentCategory = smCategory::GetMenuAndPages(null, true);
	
	foreach($currentCategory as $cateObject){
		if($cateObject->categoryRootId>0){
			$tab = "&nbsp;&nbsp;&nbsp; - ";
			$htmlToReturn .= "<option value='".$cateObject->categoryId."'";
			$htmlToReturn .= $checkedId == $cateObject->categoryId ? " SELECTED ":"";
			$htmlToReturn .= ">".$tab.$cateObject->categoryName."</option>";
		}else{
			$tab = "";
			$htmlToReturn .= "<option disabled='disabled' value='".$cateObject->categoryId."'";
			$htmlToReturn .= $checkedId == $cateObject->categoryId ? " SELECTED ":"";
			$htmlToReturn .= ">".$tab.$cateObject->categoryName."</option>";
		}
	}
	return $htmlToReturn;
}

function pdFabricDropDownList($checkedId){		
	$currentFarbric = smFabric::GetMenuAndPages(null, true);
	
	foreach($currentFarbric as $farbricObject){
		$htmlToReturn .= "<option value='".$farbricObject->fabricId."'";
		$htmlToReturn .= $checkedId == $farbricObject->fabricId ? " SELECTED ":"";
		$htmlToReturn .= ">".$farbricObject->fabricName."</option>";
	}
	return $htmlToReturn;
}

function pdPatternDropDownList($checkedId){	
	$currentPattern = smPattern::GetMenuAndPages(null, true);
	
	foreach($currentPattern as $patternObject){
		$htmlToReturn .= "<option value='".$patternObject->patternId."'";
		$htmlToReturn .= $checkedId == $patternObject->patternId ? " SELECTED ":"";
		$htmlToReturn .= ">".$patternObject->patternTitle."</option>";
	}
	return $htmlToReturn;
}

function pdColorDropDownList($checkedId){	
	$currentColor = smColor::GetMenuAndPages(null, true);
	
	foreach($currentColor as $colorObject){
		$stylecolor=str_replace(" ","", strtolower($colorObject->colorTitle));
		
		$htmlToReturn .= "<option value='".$colorObject->colorId."'";
		$htmlToReturn .= $checkedId == $colorObject->colorId ? " SELECTED ":"";
		$htmlToReturn .= " style='background-color:$stylecolor;'>".$colorObject->colorTitle."</option>";
	}
	return $htmlToReturn;
}

function pdRatingDropDownList($checkedId){
	for($i=1;$i<6;$i++){
		$htmlToReturn .= "<option value='$i'";
		$htmlToReturn .= $checkedId == $i ? " SELECTED ":"";
		$htmlToReturn .= ">$i</option>";
	}
	return $htmlToReturn;
}

?>
