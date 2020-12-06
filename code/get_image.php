<?php 
class getImage{
	var $imId;
	var $imPhysicalPath;
	var $imPrimaryFlag;
	var $imPdId;
	var $imCaId;
	var $imTitle;
	
	public function GetAll($id){
		$sql="select * from pt_images where imPdId='".$id."' order by imPrimaryFlag desc";
		$query=mysql_query($sql);
		$listImage = array();
		$counter = 0;
			
		while($row=mysql_fetch_array($query)){
			$IMGID=$row['imId'];
			$IMG=$row['imPhysicalPath'];
			$RRIMARY=$row['imPrimaryFlag'];

			$listImage[$counter]=getImage::_processRow($row);
			$counter += 1;	
		}
		return $listImage;			
	}

	public function GetCntimages($id){
		$sqlImg="select * from ch_images where imLoId='".$id."' ";
		$rsImg=mysql_query($sqlImg);
		$cntImg=mysql_num_rows($rsImg);
		
		return $cntImg;
	}

	public function GetPrimaryImg($id){
		$sql="SELECT * FROM pt_images WHERE imPdId='".$id."' AND imPrimaryFlag='1' LIMIT 1";
		$query=mysql_query($sql);
		$row=mysql_fetch_array($query);
		$image=getImage::_processRow($row);	
		return $image;			
	}
	
	public function GetMainImg($id){
		$sql="SELECT * FROM pt_images WHERE imPdId='".$id."' AND imPrimaryFlag !='1' LIMIT 1";
		
	//echo $sql."----";	
		$query=mysql_query($sql);
		$row=mysql_fetch_array($query);
		$image=getImage::_processRow($row);
		
		return $image;
	}
	
	public function GetImg($id){
		$sql="SELECT * FROM pt_images WHERE imPdId='".$id."' AND imPrimaryFlag != '1' ";
		$query=mysql_query($sql);
		$items = array();
		$counter=0;
		while($row=mysql_fetch_array($query)){
			$items[]=getImage::_processRow($row);
			$counter++;
		}
		return $items;
	}
	
	public function _processRow($row){
		$item = new getImage;
		$item->imId = $row['imId'];
		$item->imPhysicalPath = $row['imPhysicalPath'];
		$item->imPrimaryFlag = $row['imPrimaryFlag'];
		$item->imPdId = $row['imPdId'];
		return($item);
	}
}	
?>