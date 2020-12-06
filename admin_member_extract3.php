<?php

//header("HTTP/1.1 301 Moved Permanently");
//header("Location: https://exacttailoring.com/");
//exit();

include_once 'includes/globals.php';
include_once('includes/check_admin_login.php');

$sql = "SELECT * FROM ex_users WHERE usRoLevel = 2 AND usAddress !='' AND usPostcode !='' AND usCountry = '183' AND usReceiveInfo !='1' ORDER BY usId DESC";
$query = mysql_query($sql);
//echo $sql;

$showdetails .= "<div style='width:198mm; padding:15.5mm 7.25mm; margin:0 auto;'>";

$cnt = 0;
$cnt2 = 0;

while ($row = mysql_fetch_array($query)) {
    $cnt++;
    $cnt2++;

    if ($cnt % 3 == 1) {
        $cl = " clear:both; float:left;";
        $pd = "padding:10px 0 0 12px;";

    } else if ($cnt % 3 == 2) {
        $cl = " float:left; margin:0 2.5mm; ";
        $pd = "padding:10px 0 0 12px;";

    } else {
        $cl = " float:left; ";
        $pd = "padding:10px 0 0 12px;";
    }

    if ($cnt2 % 21 == 0) {
        $cl2 = "<div style='page-break-before: always;'></div>
		<div style='height:15.5mm;'><br style:'clear:both;'/></div>";
    } else {
        $cl2 = "";
    }

    if (!empty($row['usCompany'])) {
        $a1 = "<br/>" . ucwords(strtolower(stripcslashes($row['usCompany'])));
    } else {
        $a1 = "";
    }

    if (!empty($row['usAddress2'])) {
        $a2 = "<br/>" . ucwords(strtolower(stripcslashes($row['usAddress2'])));
    } else {
        $a2 = "";
    }

    if (!empty($row['usAddress3'])) {
        $a3 = "<br/>" . ucwords(strtolower(stripcslashes($row['usAddress3'])));
    } else {
        $a3 = "";
    }

    $countryname = smSetting::getCountry($row['usCountry']);

    $showdetails .= "<div style='width:63.5mm; height: 38.1mm; margin:0; padding:0px; font-size:16px; line-height:18px; border:solid 1px #eee; $cl'>
		    <div style='$pd'>
			    <b>" . ucwords(strtolower($row['usFirstname']) . " " . ucwords(strtolower($row['usLastname']) . "</b>
			    $a1
			    <br/>" . ucwords(strtolower(stripcslashes($row['usAddress']))) . "
			    $a2 $a3
			    <br/>" . ucwords(strtolower(stripcslashes($row['usCity']))) . "
			    <br/>" . strtoupper($row['usPostcode']) . "
			")) . "
		    </div>
		</div>" . $cl2;

    //". $countryname->countryName ."<br/>
}

$showdetails .= "<br style='clear:both;'/></div>";

echo $showdetails;
