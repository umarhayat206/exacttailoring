<?php

//header("HTTP/1.1 301 Moved Permanently");
//header("Location: https://exacttailoring.com/");
//exit();
include_once('includes/globals.php');
include_once('includes/check_admin_login.php');
include_once('includes/admin_html_head.php');
?>
<style>body,html{background:white;color:#000;}</style>
<?php
$dStart = mysql_real_escape_string($_POST['dateStart']) ;
$dEnd = mysql_real_escape_string($_POST['dateEnd']) ;
$sql = "SELECT ex_users.* FROM ex_users 
                LEFT JOIN ex_shoppingcart
                ON ex_users.usId=ex_shoppingcart.shopUserId
        

WHERE 

(ex_users.usRoLevel = 2 AND ex_users.usAddress !='' AND ex_users.usPostcode !='' AND ex_users.usCountry = '183' AND ex_users.usReceiveInfo !='1' )
AND (ex_shoppingcart.shopDateadded BETWEEN '{$dStart}' AND '{$dEnd}' ) AND ex_shoppingcart.shopConfirmOrder = 1

GROUP BY ex_users.usEmail 


ORDER BY ABS(ex_users.usHowmanyOrder) DESC, ex_users.usId DESC";


$query = mysql_query($sql);
//echo $sql;
$totalOrdered = 0;
$totalCustomers = 0;
$htmlOutput = '';
if($_POST['list_or_label']==1){

    
    $htmlOutput .= "<table id='subTable'><tr><th>Full name</th><th>Email</th><th>Address</th><th>Post code</th><th>Telephone</th><th id='orderNum_header'>Order count</th></tr>";

    while($row=mysql_fetch_array($query)){

        $sql2 = "SELECT COUNT(*) OrderNum FROM `ex_shoppingcart` WHERE `shopUserId`={$row['usId']} AND (`shopDateordered` BETWEEN '{$dStart}' AND '{$dEnd}' ) AND `shopConfirmOrder`=1";
        $query2 = mysql_query($sql2);

        //echo $sql2 . "<br/>";
        $orderNum =0;
        while($row2=mysql_fetch_array($query2)){
            $orderNum = $row2['OrderNum'];
        }
        $totalOrdered+=$orderNum;
        $totalCustomers ++;
        $htmlOutput .= "<tr><td>".$row["usFullname"]. "  " . $row["usLastname"] . "</td><td>".$row["usEmail"]."</td><td>".$row["usAddress"]. " " . $row["usAddress2"]. " " . $row["usAddress3"]. "</td><td>".$row["usPostcode"]."</td><td>".$row["usTelephone"]."</td><td>".$orderNum."</td>  </tr>";
    
    }
    $htmlOutput = "<h4 style='text-align:center;'>Date: " . date("d M y",strtotime($dStart)) . " - " . date("d M y",strtotime($dEnd)) . "</h4>" . 
    "<h4 style='text-align:center;'> " . $totalCustomers . " Customers / " . $totalOrdered . " Ordered</h4>" .
    $htmlOutput . "</table>";
    echo $htmlOutput ;

    

}elseif($_POST['list_or_label']==2){


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
            $cl2 = "<p style='page-break-after: always;'></p>
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

        $showdetails .= "<div style='width:63.5mm; height: 38.1mm; margin:0px 0; padding: 0px; font-size:16px; line-height:18px; border:solid 1px #eee; $cl'>
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


}


?><script type="text/javascript">window.print();
//window.close();

function sortTable() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("subTable");
  switching = true;
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[5];
      y = rows[i + 1].getElementsByTagName("TD")[5];
      //check if the two rows should switch place:
      if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
        //if so, mark as a switch and break the loop:
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}

sortTable();

</script>