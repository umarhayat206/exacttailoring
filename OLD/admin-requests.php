<?php
include("code/application_code_includes_and_globals_file.php");
include($siteRoot."includes/html_head.php");
include($siteRoot."includes/admin_page_header.php");

if($_POST['requestsDeleteSubmitted']){
	$sqlDel="DELETE FROM ts_members WHERE m_id = '".$_POST['memberid']."' AND m_role = '0' ";
	mysql_query($sqlDel);
}

function showCatalogueRequests(){
	echo("<p style='padding:10px; margin:0px;'><a href='#' onclick=\"window.open('{$siteRoot}print.php','','menubar=no,scrollbars=yes,resizable=no,width=450,height=750,left='+ ((screen.width-1600) / 2) +',top=20') ; return false\"  shape='RECT' target='_blank'>Print all details</a></p>");
	echo("<ul id='catRequests'>");
	$list = tsMembers::catalogList("m_id DESC");
	if(count($list)>0){
		foreach($list as $member){
			echo("<li>");
			echo("
				 <strong>".$member->mFirstname." ".$member->mLastname."</strong><br />
				 ".str_replace(array("\n",","),"<br />",$member->mAddress)."<br />
				 ".$member->mPostcode."<br />
				 ".smCountries::countryById($member->mCountry)."<br/>
				 ".$member->mEmail."
			");
			//echo("<br /><br /></li>");
			echo "<br /><label style='float:left;'><a href='' onclick=\"window.open('{$siteRoot}print.php?id={$member->mId}','','menubar=no,scrollbars=yes,resizable=no,width=450,height=300,left='+ ((screen.width-1600) / 2) +',top=20') ; return false\"  shape='RECT' target='_blank'>Print details</a></label>";
			echo "<form id='requestsDelete' method='post' action='admin-requests.php' style='margin-left:10px; border:none; background:#FFF; width:20px; float:left;'>
			<input type='hidden' id='requestsDeleteSubmitted' name='requestsDeleteSubmitted' value='true' />
			<input type='hidden' id='memberid' name='memberid' value='{$member->mId}' />
			<input id='Delete' name='Delete' value='{$member->mId}' style='width:16px; float:left' title='Delete record' type='image' src='http://www.exacttailoring.com/styles/images/delete.gif' alt='Delete record' onclick=\"javascript:return confirm('Are you sure...?')\" />	
			<br /></form><br /><br /></li>";
		}
	}
	echo("</ul>");
}
?>

<h2>Catalogue Requests</h2>
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

<?php include($siteRoot."includes/admin_page_footer.php");?>
