<?php

include_once('includes/globals.php');
include_once('includes/check_admin_login.php');
include_once('includes/admin_html_head.php');
include_once('forms/admin_form_head.php');

echo "<div class='content_res'>
    <div class='leftblock vertsortable'>
        <div class='gadget'>
            <div class='titlebar vertsortable_head'>
                <h3>Tape measure offer List</h3>
            </div>
            <div class='gadgetblock'>
            
            ";

$_getMonth = $_GET['searchmonth'];
$_getYear = $_GET['searchyear'];

$where = "";
if(!empty($_getMonth) AND !empty($_getYear)) {
    $where = " AND sub_dateadd LIKE '%{$_getYear}-{$_getMonth}%'";
}elseif(empty($_getMonth) AND !empty($_getYear)){
    $where = " AND sub_dateadd LIKE '%{$_getYear}%'";
}

//include('forms/admin_member_code.php');    
$sql="SELECT * FROM ex_subscriber WHERE sub_title = 'Tape Measure' {$where} ORDER BY sub_dateadd DESC";
$query=mysql_query($sql);
$numrows = mysql_num_rows($query);

$_startYear = 2015;
$_endYear = date('Y');
$_optionsMonth = "";
$_optionsYear = "";

$_arMonth = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December');
foreach($_arMonth as $k=>$v) {
    $_selected = ($_getMonth==$k)?'selected':'';
    $_optionsMonth .= "<option value='".$k."' {$_selected}>".$v."</option>";
}

for($i=$_startYear;$i<=$_endYear;$i++) {
    $_selectedY = ($_getYear==$i)?'selected':'';
    $_optionsYear .= "<option value='".$i."' {$_selectedY}>".$i."</option>";
}

echo "<div style='width:50%;float:left;text-align:center;margin:0 0 10px 0;'>Showing rows ".number_format($numrows)." total.</div>
<div style='width:50%;float:right;text-align:center;margin:0 0 10px 0;'>


<form id=\"productCategorySearch\" method=\"get\" action=\""._URL_."admin_tapemeasureoffer\" style=\"float:left; padding:0px 5px;\">
    <select name=\"searchmonth\">
    <option value=''>-Month-</option>
    ".$_optionsMonth."
    </select>
    <select name=\"searchyear\">
        <option value=''>-Year-</option>
        ".$_optionsYear."
    </select>    
    <input id=\"search\" name=\"search\" value=\"Search\" style=\"cursor:pointer;\" type=\"submit\">
</form>


</div>";
echo "<table id='subTable'><tr><th>Full name</th><th>Email</th><th>Address</th><th>Post code</th><th>Telephone</th><th>Date added</th></tr>";

while($row=mysql_fetch_array($query))
{
    $date_uub = date("d F Y", strtotime($row["sub_dateadd"]));
     echo "<tr><td>".$row["sub_fullname"]."</td><td>".$row["sub_email"]."</td><td>".$row["sub_address"]."</td><td>".$row["sub_postcode"]."</td><td>".$row["sub_telephone"]."</td><td>".$date_uub."</td></tr>";
   
}

echo "</table>";

echo "
    
</div>
    </div>
</div><div style='clear:both;'></div>"; 

include_once('forms/admin_form_end.php');

?>