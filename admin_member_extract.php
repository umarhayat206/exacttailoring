<?php

header("HTTP/1.1 301 Moved Permanently");
header("Location: https://exacttailoring.com/");
exit();

include_once 'includes/globals.php';

$sql = "SELECT * FROM ex_users WHERE usRoLevel = 2 AND usAddress !='' AND usPostcode !='' AND usCountry = '183' AND usReceiveInfo !='1' ORDER BY usId DESC";
$query = mysql_query($sql);
//echo $sql;

$showdetails .= "<div style='width:760px; padding:0; margin:0 auto;'>";

$cnt = 0;
$cnt2 = 0;

while ($row = mysql_fetch_array($query)) {
    $cnt++;
    $cnt2++;

    if ($cnt % 3 == 1) {
        $cl = " clear:both; float:left; ";
        $pd = "padding:20px 20px 0 40px;";
    } else if ($cnt % 3 == 2) {
        $cl = " float:left; ";
        $pd = "padding:20px 0 0 30px;";

    } else {
        $cl = " float:right; ";
        $pd = "padding:20px 0 0 20px;";
    }

    if ($cnt2 % 21 == 0) {
        $cl2 = "<div style='page-break-before: always;'><br/></div>";
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

    $showdetails .= "<div style='width:233px; height: 135px; margin:0; padding:10px; font-size:13px; line-height:17px; $cl'>
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

$showdetails .= "</div>";

echo $showdetails;
