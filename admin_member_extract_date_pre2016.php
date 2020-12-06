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
$dStart = '2011-01-01' ;
$dEnd = '2015-12-31' ;
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


    
    $htmlOutput .= "<table id='subTable'><tr><th>Full name</th><th>Email</th><th>Address</th><th>Post code</th><th>Telephone</th></tr>";

    while($row=mysql_fetch_array($query)){

        $sql2 = "SELECT ex_users.* FROM ex_users 
                LEFT JOIN ex_shoppingcart
                ON ex_users.usId=ex_shoppingcart.shopUserId
        

                WHERE 

                (ex_users.usRoLevel = 2 AND ex_users.usAddress !='' AND ex_users.usPostcode !='' AND ex_users.usCountry = '183' AND ex_users.usReceiveInfo !='1' )
                AND (ex_shoppingcart.shopDateadded > '2016-01-01' ) AND ex_shoppingcart.shopConfirmOrder = 1 AND ex_users.usId = {$row['usId']}

                GROUP BY ex_users.usEmail 


                ORDER BY ABS(ex_users.usHowmanyOrder) DESC";

        $orderedNum = 0 ;
        $query2 = mysql_query($sql2);
        if( mysql_num_rows($query2) == 0 ){
            $totalCustomers ++;
        $htmlOutput .= "<tr><td>".$row["usFullname"]. "  " . $row["usLastname"] . "</td><td>".$row["usEmail"]."</td><td>".$row["usAddress"]. " " . $row["usAddress2"]. " " . $row["usAddress3"]. "</td><td>".$row["usPostcode"]."</td><td>".$row["usTelephone"]."</td> </tr>";
        }
        
       
        //echo $sql2 . "<br/>";
    
    }
    $htmlOutput = "<h4 style='text-align:center;'>Customers ordered before 2016 and not order again.</h4>" . 
    "<h4 style='text-align:center;'> " . $totalCustomers . " Customers</h4>" .
    $htmlOutput . "</table>";
    echo $htmlOutput ;

    




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

//sortTable();

</script>