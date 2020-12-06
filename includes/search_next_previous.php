<?php

$getsearchurl = $_GET;
unset($getsearchurl['get0']);

//--------------------- Separate search page ------------------

$cutpage = new smProduct;
/*$cutpage = $cutpage->GetCutPage($sqlsearch,$_SESSION['sortlimit']);
if($cutpage->cntPage>((int) $cutpage->cntPage)){ $cutpage->cntPage=((int) $cutpage->cntPage)+1; }
*/

$cutpage->cntPage = 12;
$cutpage->cntList = 165;

if(empty($_REQUEST['page'])){ 
	$here=1;
	$previous=1;
	$next=$here+1;
}else{
	$here=$_REQUEST['page'];
	if($here==$cutpage->cntPage){
		$next=$cutpage->cntPage+1;
	}else{
		$next=$here+1;
	}
	
	if($_REQUEST['page']==1 || (empty($_REQUEST['page']))){
		$previous=1;
	}else{
		$previous=$here-1;
	}
}

if(empty($_REQUEST['page'])){ $page = 1; }

if($cutpage->cntList >0){	
	if(!empty($_REQUEST['page']) && $cutpage->cntPage > 5){
		$jj=$_REQUEST['page']-2;
		
		if($_REQUEST['page'] == $cutpage->cntPage){
			$kk=$_REQUEST['page'];
			//echo "-1-";
		}else{
			if($_REQUEST['page']+5 <= $cutpage->cntPage){
				if($_REQUEST['page'] < 4){
					$kk=5;
				}else if($_REQUEST['page'] == 4){
					$kk=6;
				}else{
					$kk=$_REQUEST['page']+2;
				}
				//echo "-2-";
				
			}else if($_REQUEST['page']+5 > $cutpage->cntPage){
				$ccpage = $cutpage->cntPage - $_REQUEST['page'];
				$kk=$_REQUEST['page']+$ccpage-3;
				//echo "-3-";
				
			}else{
				$kk=$_REQUEST['page']+1;
				//echo "-4-";
			}				
		}	
            
	}else if(!empty($_REQUEST['page']) && $cutpage->cntPage < 5){	
		$jj=1;
		$kk=$cutpage->cntPage;
		//echo "-5-";
		
	}else if($cutpage->cntPage < 5){
		$jj=1;
		$kk=$cutpage->cntPage;
		//echo "-6-";
		
	}else{
		$jj=1;
		$kk=5;
		//echo "-7-";
	}

	if(!empty($cutpage->cntList)){
		
		$getnexturl = $getsearchurl;
		$getnexturl['page'] = $next;
		
		$getpreviousurl = $getsearchurl;
		$getpreviousurl['page'] = $previous;
		
		if($previous==1 && $here==1 && $cutpage->cntPage!=$here){ 			//for next record
			$P="";
			$N=" <li><a class='invarseColor' href='collection?".http_build_query($getnexturl,'','&amp;')."'>Next</a></li>";
		}else if($previous==1 && $here==1 && $cutpage->cntPage==$here){  
			$P="";
			$N="";
		}else if($next>$cutpage->cntPage){ 		//for previous record
			$P="<li><a class='invarseColor' href='collection?".http_build_query($getpreviousurl,'','&amp;')."'>Prev</a></li>";
			$N="";
		}else{ 
			$P="<li><a class='invarseColor' href='collection?".http_build_query($getpreviousurl,'','&amp;')."'>Prev</a></li>";
			$N=" <li><a class='invarseColor' href='collection?".http_build_query($getnexturl,'','&amp;')."'>Next</a></li>";
		} 
		
	}else{ 
		$P="";
		$N="";
	}

	for($j=$jj;$j<=$kk;$j++){
		if($j > 0){
			$getsearchurl['page'] = $j;
			
			if($_GET['page']!=$j){	
				if(empty($_GET['page']) && $j==1){
					$searchpage.="<li class='active'><a class='invarseColor' href='collection?".http_build_query($getsearchurl,'','&amp;')."'>$j</a></li>";
				}else{
					$searchpage.="<li><a class='invarseColor' href='collection?".http_build_query($getsearchurl,'','&amp;')."'>$j</a></li>";
				}
			}else{
				$searchpage.="<li class='active'><a class='invarseColor' href='collection?".http_build_query($getsearchurl,'','&amp;')."'>$j</a></li>";
			}
		}
	}	// close for 
}	

$searchnextpage = "<div class='pagination pagination-right right'>
	<ul>
	    $P
	    $searchpage
	    $N
	</ul>
</div>";

?>