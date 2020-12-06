<?php

header("HTTP/1.1 301 Moved Permanently");
header("Location: https://exacttailoring.com/");
exit();

include_once 'includes/globals.php';

$sql = "SELECT * FROM ex_users WHERE usRoLevel = 2 AND usAddress !='' AND usPostcode !='' AND usCountry = '183' AND usReceiveInfo !='1' ORDER BY usId DESC";
$query = mysql_query($sql);
//echo $sql;

$showdetails .= "<div style='width:566px; padding:43px 21px; margin:0 auto; border:solid 1px #eee;'>";

$cnt = 0;
$cnt2 = 0;

while ($row = mysql_fetch_array($query)) {
    $cnt++;
    $cnt2++;

    if ($cnt % 3 == 1) {
        $cl = " clear:both; float:left;";
        $pd = "padding:4px 10px;";

    } else if ($cnt % 3 == 2) {
        $cl = " float:left; margin:0 10px; ";
        $pd = "padding:4px 10px;";

    } else {
        $cl = " float:right; ";
        $pd = "padding:4px 10px;";
    }

    if ($cnt2 % 21 == 0) {
        $cl2 = "<div style='page-break-before: always;'></div>
			<div style='height:43px;'><br style:'clear:both;'/></div>";
    } else {
        $cl2 = "";
    }

    if (!empty($row['usCompany'])) {
        $a1 = "<br/>" . ucwords(strtolower(stripcslashes($row['usCompany'])));
    }

    if (!empty($row['usAddress2'])) {
        $a2 = "<br/>" . ucwords(strtolower(stripcslashes($row['usAddress2'])));
    }
    if (!empty($row['usAddress3'])) {
        $a3 = "<br/>" . ucwords(strtolower(stripcslashes($row['usAddress3'])));
    }

    $countryname = smSetting::getCountry($row['usCountry']);

    $showdetails .= "<div style='width:180px; height: 108px; margin:0; padding:0px; font-size:12px; line-height:13px; border:solid 1px #eee; $cl'>
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
