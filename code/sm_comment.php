<?php

class smComment {

	function GetAllComment($status){
		if($status==true){
			$sql = "SELECT * FROM ex_comment ORDER BY commentDate DESC";
		}else{
			$sql = "SELECT * FROM ex_comment WHERE commentVisible='1' ORDER BY commentDate DESC";
		}

		$query = mysql_query($sql);
		$counter = 0;
		$menuItems = array();
		while($row = mysql_fetch_array($query)){
			$menuItems[$counter]=smComment::_processRow($row);
			$counter++;
		}
		return($menuItems);
	}

	public function GetComment($id){
		$sql = mysql_query("SELECT * FROM ex_comment WHERE commentId = '$id' ");
		
		$row=mysql_fetch_array($sql);
		$counter = 0;
		$items = array();
		$items=smComment::_processRow($row);
		return $items;	
	}
	
	public function countComment(){
		$sql = mysql_query("SELECT * FROM ex_comment WHERE commentVisible='1' ");
		$row=mysql_num_rows($sql);
		return $row;	
	}

	function Update($comment){		
		$sql = "UPDATE ex_comment SET ";
		$sql .="commentName='".$comment->commentName."',";
		$sql .="commentVisible='".$comment->commentVisible."',";
		$sql .="commentDescriptions='".$comment->commentDescriptions."' ";
		$sql .="WHERE commentId='".$comment->commentId."'";
		mysql_query($sql);
		return $comment->commentId;
	}

	function Insert($comment){	
		$sql = "INSERT INTO ex_comment SET ";
		$sql .="commentName='".$comment->commentName."',";
		$sql .="commentVisible='".$comment->commentVisible."',";
		$sql .="commentDescriptions='".$comment->commentDescriptions."', ";
		$sql .="commentDate='".mktime()."' ";
		mysql_query($sql);
		return mysql_insert_id();
	}

	function Delete($comment){
		mysql_query("DELETE FROM ex_comment WHERE commentId='$comment' ");
	}

/* ***** SQL ROW PRCESSING ***** */
	function _processRow($row){
		$item = new smComment;
		$item->commentId = $row['commentId'];
		$item->commentName = $row['commentName'];
		$item->commentVisible = $row['commentVisible'];
		$item->commentDescriptions = $row['commentDescriptions'];
		$item->commentDate = $row['commentDate'];
		return($item);
	}
/* ***** END ROW PROCESSING ***** */


}

?>