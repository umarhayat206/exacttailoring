<?php

include_once('includes/globals.php');
include_once('includes/check_admin_login.php');
include_once('includes/admin_html_head.php');
include_once('forms/admin_form_head.php');

echo "<div class='content_res'>";
    
//include('forms/admin_member_code.php');    
if($_GET['requestsDeleteSubmitted']){
	$sqlDel="DELETE FROM ex_ordercatalogue WHERE id = '".$_GET['catalogueid']."' ";
	mysql_query($sqlDel);
}

if($_GET['requestsDeleteAllSubmitted']){
    //smUser::DeleteCatalogRequests();
}

function showCatalogueRequests(){
	
	//<a href='#' onclick=\"window.open('{$siteRoot}print.php','','menubar=no,scrollbars=yes,resizable=no,width=450,height=750,left='+ ((screen.width-1600) / 2) +',top=20') ; return false\"  shape='RECT' target='_blank'>
	
	echo("<p style='padding:10px; margin:0px;'>
            <a href='{$siteRoot}print-details.php' target='_blank'>Print all details</a>
	    
	     <!--<a href='admin-requests-old-data' target='_blank' style='margin-left:25px;'>View old lists</a>-->
            
            <a href='admin_cataloguerequests?requestsDeleteAllSubmitted=yes' style='margin-left:25px;' onclick=\"javascript:return confirm('Are you sure...?')\" >Delete all details</a>
            </p>");
        
	echo("<ul style='margin-left:15px; display:inline; float:left; width:100%; list-style:none;'>");
	$list = smUser::catalogRequests();
	if(count($list)>0){
                $cnt=0;
		foreach($list as $catalogue){
            $cnt++;
            if($cnt % 5 == 1){
                $cl=" clear:both; ";
            }else{
                $cl="";
            }
			
			$countryname=smSetting::getCountry($catalogue->country);
			
			echo "<li style='float:left; width:18%; margin-bottom:10px; padding-right:8px; $cl'>";
			//echo stripcslashes($catalogue->customerdetails);
			echo "<b>".$catalogue->name ." ".$catalogue->surname ."</b><br/>". $catalogue->address."<br/>". $catalogue->city."<br/>". $countryname->countryName ."<br/>". $catalogue->postcode."<br/>";
			                        
			//echo("<br /><br /></li>");
			echo "<br /><a href='' onclick=\"window.open('{$siteRoot}print.php?id={$catalogue->catalogueid}','','menubar=no,scrollbars=yes,resizable=no,width=450,height=300,left='+ ((screen.width-1600) / 2) +',top=20') ; return false\"  shape='RECT' target='_blank'><img src='{$siteRoot}styles/images/printer.png' alt='Print details' title='Print details' /></a>";

			echo "<a href='admin_cataloguerequests?requestsDeleteSubmitted=yes&catalogueid={$catalogue->catalogueid}'>
			<img src='{$siteRoot}styles/images/delete.gif' alt='Delete record' title='Delete record' onclick=\"javascript:return confirm('Are you sure...?')\" style='margin-left:10px;' /></a>
			<br /><br /></li>";
		}
	}
	echo("</ul>");
}

echo showCatalogueRequests();

echo "</div><br/>"; 

include_once('forms/admin_form_end.php');

?>