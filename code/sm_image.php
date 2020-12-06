<?php

class smImage{
	
/* ***** PAGE ORDERING ***** */

	function GetNextOrderNumber($productid){
		if(!empty($productid)){
			$sql = "SELECT order_number FROM ex_images WHERE imObjectId = '$productid' AND imType = '1' ORDER BY order_number DESC LIMIT 1";
		}else{
			$sql = "SELECT order_number FROM ex_images ORDER BY order_number DESC LIMIT 1";
		}
		
		$query = mysql_query($sql);
		$row = mysql_fetch_row($query);	
		return($row[0] + 1);
	}
	
	function MoveUp($imageId, $objectId, $imageType){
		//Loop through all the pages of the same root type 
		//compare the page above, if any, then swap numbers		
		$previousLinksOrderNumber = "";
		$previousLinksId = "";		
		$sql = "SELECT imId, order_number FROM ex_images WHERE imObjectId='$objectId' AND imType='$imageType' ORDER BY order_number";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			//Check to see if this is the link to move
			if($row['imId']==$imageId){
				if($previousLinksId!=""){ 		//Link is already at the top - "they built a better imIdiot"
					//Change me
					smImage::SetOrderNumber($imageId, $previousLinksOrderNumber);	
					
					//Change other
					smImage::SetOrderNumber($previousLinksId, $row['order_number']);
				}	
			}			
			$previousLinksId = $row['imId'];
			$previousLinksOrderNumber = $row['order_number'];
		}		
	}
	
	function MoveDown($imageId, $objectId, $imageType){
		//Loop through all the pages of the same root type 
		//compare the page above, if any, then swap numbers		
		$previousLinksOrderNumber = "";
		$previousLinksId = "";		
		$sql = "SELECT imId, order_number FROM ex_images WHERE imObjectId='$objectId' AND imType='$imageType' ORDER BY order_number DESC";
		$query = mysql_query($sql);
		//echo('adf');
		while($row = mysql_fetch_array($query)){
			//Check to see if this is the link to move
			if($row['imId']==$imageId){
				if($previousLinksId!=""){ 		//Link is already at the bottom - "they built a better imIdiot"
					//Change me
					smImage::SetOrderNumber($imageId, $previousLinksOrderNumber);	
					
					//Change other
					smImage::SetOrderNumber($previousLinksId, $row['order_number']);
				}	
			}			
			$previousLinksId = $row['imId'];
			$previousLinksOrderNumber = $row['order_number'];
		}		
	}
	
	function SetOrderNumber($imageId, $newNumber){
		$sql = "UPDATE ex_images SET ";
		$sql .="order_number='".$newNumber."' ";
		$sql .="WHERE imId='$imageId'";
		mysql_query($sql);
		
		//echo $sql."<br/>";
	}
/* ***** END PAGE ORDERING ***** */
	
	public function GetAllImages($image){
		$sql="SELECT * FROM ex_images WHERE imObjectId='".$image->imObjectId."' AND imType = '".$image->imType."' ORDER BY imPrimaryFlag DESC, order_number ASC";
		$rs=mysql_query($sql);
		$listImage = array();
		while ($row = mysql_fetch_array($rs)){
			$listImage[]=self::_processRow($row);
		}
		return $listImage;			
	}
	
	public function GetPrimaryImg($image){
		$sql="SELECT * FROM ex_images WHERE imObjectId='".$image->imObjectId."' AND imType = '".$image->imType."' AND imPrimaryFlag='1' LIMIT 1 ";
		$rs=mysql_query($sql);
		$listImage = array();
		$row = mysql_fetch_array($rs);
		$listImage=self::_processRow($row);
		return $listImage;			
	}

	private function _processRow($row){
		$image= new smImage;
		$image->imId = $row['imId'];
		$image->imPhysicalPath = $row['imPhysicalPath'];
		$image->imPrimaryFlag = $row['imPrimaryFlag'];
		$image->imObjectId = $row['imObjectId'];
		$image->imType = $row['imType'];
		$image->order_number = $row['order_number'];
		return($image);
	}

	public function thumbnail($inputFileName, $maxSize = 190,$uploadDir,$uploadFile){	
		//echo $inputFileName."----2<br>";
		$info = getimagesize($inputFileName);
		$type = isset($info['type']) ? $info['type'] : $info[2];
	
		// Check support of file type
		if (!(imagetypes() & $type)) {
			// Server does not support file type
			return false;
		}
				 
		$width = isset($info['width']) ? $info['width'] : $info[0];
		$height = isset($info['height']) ? $info['height'] : $info[1];
	
		// Calculate aspect ratio
		$wRatio = $maxSize / $width;
		$hRatio = $maxSize / $height;
	
		// Using imagecreatefromstring will automatically detect the file type
		$sourceImage = imagecreatefromstring(file_get_contents($inputFileName));
	
		// Calculate a proportional width and height no larger than the max size.
		if (($width <= $maxSize) && ($height <= $maxSize)) {
			// Input is smaller than thumbnail, do nothing
			return $sourceImage;
		} elseif (($wRatio * $height) < $maxSize) {
			// Image is horizontal
			$tHeight = ceil($wRatio * $height);
			$tWidth = $maxSize;
		} else {
			// Image is vertical
			$tWidth = ceil($hRatio * $width);
			$tHeight = $maxSize;
		}
	
		$thumb = imagecreatetruecolor($tWidth, $tHeight);
	
		if ($sourceImage === false) {
			// Could not load image
			return false;
		}
	
		// Copy resampled makes a smooth thumbnail
		imagecopyresampled($thumb, $sourceImage, 0, 0, 0, 0, $tWidth, $tHeight, $width, $height);
		imagedestroy($sourceImage);	
		//move_uploaded_file($thumb, $uploadDir.$uploadFile);
		imagejpeg($thumb, $uploadDir.$uploadFile);
	}
	
	public function Add($new){	// add main pictures, logo for project and unit
		$sqlChkPrimary="SELECT * FROM ex_images WHERE imObjectId='".$new->imObjectId."' AND imType='".$new->imType."' AND imPrimaryFlag='1' ";
		$rsChkPrimary=mysql_query($sqlChkPrimary);
		$rowChkPrimary=mysql_num_rows($rsChkPrimary);
		
		if(empty($rowChkPrimary)){
			$sqlInsert = "INSERT INTO ex_images SET ";
			$sqlInsert .="imPhysicalPath='".$new->imPhysicalPath."',";
			$sqlInsert .="imPrimaryFlag='1', ";
			$sqlInsert .="imObjectId='".$new->imObjectId."', ";
			$sqlInsert .="imType='".$new->imType."', ";
		}else{
			$sqlInsert = "INSERT INTO ex_images SET ";
			$sqlInsert .="imPhysicalPath='".$new->imPhysicalPath."', ";
			$sqlInsert .="imObjectId='".$new->imObjectId."', ";
			$sqlInsert .="imType='".$new->imType."', ";
		}
		
		if($new->imType == 1){
			$sqlInsert .="order_number='".smImage::GetNextOrderNumber($new->imObjectId)."' ";
		}else{
			$sqlInsert .="order_number='".smImage::GetNextOrderNumber("")."' ";
		}
		
		
		mysql_query($sqlInsert);	
	}
	
	public function Update($update){	// set primary picture
		$sqlUpdate = "UPDATE ex_images SET "; 		//clear primary
		$sqlUpdate .="imPrimaryFlag='0' " ;	
		$sqlUpdate .="WHERE imPrimaryFlag='1' AND imObjectId='".$update->imObjectId."' AND imType='".$update->imType."' ";
		mysql_query($sqlUpdate) or die(mysql_error());	
		//echo $sqlUpdate;
		
		$sqlUpdatePrimary = "UPDATE ex_images SET ";	// set new primary 
		$sqlUpdatePrimary .="imPrimaryFlag='1' ";	
		$sqlUpdatePrimary .="WHERE imId='".$update->imId."' ";
		mysql_query($sqlUpdatePrimary) or die(mysql_error());
	}
	
	public function Delete($imId,$imName){		// delete picture
		global $root;
		$sqlDelete = "DELETE FROM ex_images WHERE imId='$imId' ";		// delete from database
		mysql_query($sqlDelete);

		@unlink($root.'upload_pictures/'.$imName);	// remove picture in folder
		//@unlink($root.'upload_thumbs/'.$imName);
		
		//echo $sqlDelete." - ".$imName."<br/>";
	}

}

?>
