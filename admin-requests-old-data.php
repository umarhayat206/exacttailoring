<?php
include("OLD/code/application_code_includes_and_globals_file.php");

if($_POST['requestsDeleteSubmitted']){
	$sqlDel="DELETE FROM ts_members WHERE m_id = '".$_POST['memberid']."' AND m_role = '0' ";
	mysql_query($sqlDel);
}

function showCatalogueRequests(){
	//echo("<p style='padding:10px; margin:0px;'><a href='#' onclick=\"window.open('{$siteRoot}print.php','','menubar=no,scrollbars=yes,resizable=no,width=450,height=750,left='+ ((screen.width-1600) / 2) +',top=20') ; return false\"  shape='RECT' target='_blank'>Print all details</a></p>");
	echo("<div style='width:760px; padding:0; margin:0 auto;'>");
	$list = tsMembers::catalogList("m_id DESC");
	if(count($list)>0){
		$cnt = 0;
		$cnt2 = 0;
		
		foreach($list as $member){
			
			$cnt++;
			$cnt2++;
			
                        if($cnt % 3 == 1){
				$cl=" clear:both; float:left; ";
			}else if($cnt % 3 == 2){
				$cl=" float:left; ";
			}else{
				$cl=" float:right; ";
			}
			
			if($cnt2 % 21 == 0){
				$cl2 = "<div style='page-break-before: always; clear:both; '/></div>";
			}else{
				$cl2 = "";
			}
			
			echo("<div style='width:233px; height: 140px; margin:0; padding:10px; font-size:15px; $cl'>");
			echo("<b>". strtoupper($member->mFirstname." ".$member->mLastname)."</b><br />
				 ".stripcslashes($member->mAddress)."<br />
				 ".(strtoupper($member->mPostcode))
				 );
			//<br/>".smCountries::countryById($member->mCountry)."
			//<br/>".$member->mEmail."
			
			echo "</div>".$cl2;
		}
	}
	echo("</div>");
}
?>

<!--<h2>Catalogue Requests</h2>-->
<?php //echo"<p style='padding:10px; margin:0px;'><a href='#' onclick=\"window.open('{$siteRoot}print.php','','menubar=no,scrollbars=yes,resizable=no,width=450,height=300,left='+ ((screen.width-1600) / 2) +',top=20') ; return false\"  shape='RECT' target='_blank'>Print all details</a></p>"; ?>

<?php

$list2 = tsMembers::catalogList();
if(count($list2)>0){
	foreach($list2 as $member2){
		$txt = "<b>".$member2->mFirstname." ".$member2->mLastname."</b><br/>
			".str_replace(array("\n",","),"<br />",$member2->mAddress)."<br />
			".$member2->mPostcode."<br />
			".smCountries::countryById($member2->mCountry)."<br/>
			".$member2->mEmail."<br/>
			";

		$drump .= "<p>INSERT INTO ex_ordercatalogue SET customerdetails ='$txt'; </p><br/>";
	}
}

//echo $drump;
	
?>

<?php showCatalogueRequests();?>


