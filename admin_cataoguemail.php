<?php

include_once('includes/globals.php');
include_once('includes/check_admin_login.php');
include_once('includes/admin_html_head.php');
//include_once('forms/admin_form_head.php');
?>
<style>
    body,
    html {
        background: white;
        color: #000;
    }
</style>

<?php

function getCountryName($id)
{
    $query = mysql_query("SELECT * FROM iso_countries WHERE rowId='$id' ");
    $row = mysql_fetch_array($query);

    return $row['countryName'];
}

//$list = smUser::catalogRequests();
$query = mysql_query("SELECT * FROM ex_ordercatalogue ORDER BY id DESC");
$returnList = array();
$counter = 0;





$showdetails = "<div style='width:198mm; padding:15.5mm 7.25mm; margin:0 auto;'>";

$cnt = 0;
$cnt2 = 0;

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
    $cl2 = "<p style='page-break-after: always;'></p>
            <div style='height:15.5mm;'><br style:'clear:both;'/></div>";
} else {
    $cl2 = "";
}





while ($row = mysql_fetch_array($query)) {

    if ($cnt % 3 == 0) {
        $cl = " clear:both; float:left;";
        $pd = "padding:10px 0 0 12px;";
    } else if ($cnt % 3 == 1) {
        $cl = " float:left; margin:0 2.5mm; ";
        $pd = "padding:10px 0 0 12px;";
    } else {
        $cl = " float:left; ";
        $pd = "padding:10px 0 0 12px;";
    }
    $countryname = getCountryName($row['country']);

    $cl2 = "";


    $showdetails .= "<div style='width:63.5mm; height: 38.1mm; margin:0px 0; padding: 0px; font-size:16px; line-height:18px; border:solid 1px #eee; $cl'>
            <div style='$pd'>
                <b>" . ucwords(strtolower($row['name']) . " " . ucwords(strtolower($row['surname']) . "</b>
                $a1
                <br/>" . ucwords(strtolower(stripcslashes($row['address']))) . "
                $a2 $a3
                <br/>" . ucwords(strtolower(stripcslashes($row['city']))) . "
                <br/>" . strtoupper($row['postcode']) . "
                <br/>" . ucwords($countryname) . "
            ")) . "
            </div>
        </div>" . $cl2;
    if ($cnt % 20 == 0 && $cnt > 0) {
        $showdetails .= "<p style='page-break-after: always;'></p>
        <div style='height:15.5mm;'><br style:'clear:both;'/></div>";
    }
    //". $countryname->countryName ."<br/>
    $cnt++;
    $cnt2++;
}
$showdetails .= "<br style='clear:both;'/></div>";

echo $showdetails;







?><script type="text/javascript">
    window.print();
    //window.close();
</script>