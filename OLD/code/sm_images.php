<?php
/**
 * smImages class document
 * To use simply call "UPLOAD" function with desired parameters
 * Returns the new file name 
 * Or to display a thumbnail image simply call showThumb
 **/  
/**
 * 
 **/ 
class smImages {

	public static function Upload($imageName, $tempName, $imageWidth = 600, $folder = "images/"){
	 	$uploadsDirectory = $folder;
		$now = time();
		$newFileName = "";
		//Create a new name for the file - Keep trying if the name already exists
		while (file_exists($newFileName = $uploadsDirectory.$now.'-'.$imageName)){
		 	$now++;
		}
		$imageName = $newFileName;
		$maxImageSize = $imageWidth;
		$resizedImage = smImages::thumbnail($tempName, $maxImageSize);		
		if (smImages::imageToFile($resizedImage, $newFileName)){
		 	return($newFileName);
		}	 	
	}
	
	public static function UploadPreserveName($imageName, $tempName, $imageWidth = 600, $folder = "images/"){
	 	$uploadsDirectory = $folder;
		$now = time();
		$newFileName = $folder.$imageName;
		$maxImageSize = $imageWidth;
		$resizedImage = smImages::thumbnail($tempName, $maxImageSize);

		if (smImages::imageToFile($resizedImage, $newFileName,80, $suppressFileNameCheck=true)){
		 	return($newFileName);
		}	 	
	}
	
/*	function Showthumb($physicalPath, $thumbFolder = "./temp", $sizeToDisplay = 100){
		$pathToCheck = substr(strrchr($physicalPath, "/"), 1);
		if (!file_exists($thumbFolder."/".$pathToCheck)){ //The image to display exists 
			$newThumb = smImages::thumbnail($physicalPath, $sizeToDisplay);        
	    	smImages::imageToFile($newThumb, $thumbFolder."/".$pathToCheck);
	    }				
	    return($thumbFolder."/".$pathToCheck);
	}*/
	
	function prepThumbName($imagePath){
		$lft = substr($imagePath,0,strrpos($imagePath,"."));
		$rgt = substr($imagePath,strrpos($imagePath,"."));
		return($lft."_T".$rgt);
	}
	
	public static function showThumb($imagePath, $title, $sizeToDisplay = 180){
		if($imagePath!=""){
			$thumb = self::prepThumbName($imagePath);
			if(!file_exists($thumb) && file_exists($imagePath)){
				$newThumb = smImages::thumbnail($imagePath,$sizeToDisplay);
				smImages::imageToFile($newThumb,$thumb);
			}
			echo("<img src='".$thumb."' title='".$title."' alt='".$title."' />");
		}
	}
	
	/* ***** PRIVATE IMAGE FUNCTIONS ***** */	
	
	function thumbnail($inputFileName, $maxSize = 180){
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
        return $thumb;
    }

    function imageToFile($im, $fileName, $quality = 80,$suppressFileNameCheck=false){
    	if($suppressFileNameCheck==false){
	        if (!$im || file_exists($fileName)) {
	            //return false;
	        }
        }
        $ext = strtolower(substr($fileName, strrpos($fileName, '.')));
        switch ($ext) {
            case '.gif':
                imagegif($im, $fileName);
                break;
            case '.jpg':
            case '.jpeg':
                imagejpeg($im, $fileName, $quality);
                break;
            case '.png':
                imagepng($im, $fileName);
                break;
            case '.bmp':
                imagewbmp($im, $fileName);
                break;
            default:
                return false;
        }
		chmod($fileName,0755);
        return true;
    }    
}

?>