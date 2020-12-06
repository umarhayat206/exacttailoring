<?php

include_once('includes/globals.php');
include_once('includes/check_admin_login.php');
include_once('includes/admin_html_head.php');
//include_once('forms/admin_form_head.php');

/*
echo "<div class='content_res'>
    <div class='leftblock vertsortable'>
        <div class='gadget'>
            <div class='titlebar vertsortable_head'>
                <h3>Subscriber List</h3>
            </div>
            <div class='gadgetblock'>";
*/
?>
<style>
body,html{color:#000 !important;background:white !important;}
</style>
<?php 

//include('forms/admin_member_code.php');    
$sql="SELECT * FROM ex_subscriber WHERE sub_title = 'Tape Measure' ORDER BY sub_dateadd DESC";
$query=mysql_query($sql);

echo "<table id='subTable'><tr><th>Full name</th><th>Email</th><th>Address</th><th>Post code</th><th>Telephone</th><th>Date added</th></tr>";

while($row=mysql_fetch_array($query)){

     echo "<tr><td>".$row["sub_fullname"]."</td><td>".$row["sub_email"]."</td><td>".$row["sub_address"]."</td><td>".$row["sub_postcode"]."</td><td>".$row["sub_telephone"]."</td><td>".$row["sub_dateadd"]."</td></tr>";
   
}

echo "<tr><td colspan='6'><hr></td></tr>";

$sql="SELECT * FROM ex_users GROUP BY  `usEmail` HAVING  `usEmail` <>  ''  ORDER BY usSignupdate DESC";
$query=mysql_query($sql);


while($row=mysql_fetch_array($query)){
    if (filter_var($row['usEmail'], FILTER_VALIDATE_EMAIL)) {
     echo "<tr><td>".$row["usFirstname"] . "  " .$row["usLastname"]."</td><td>".$row["usEmail"]."</td><td >".$row["usAddress"]."</td><td>".$row["usPostcode"]."</td><td>".$row["usTelephone"]."</td><td>".$row["usSignupdate"]."</td></tr>";
    }
   
}



echo "</table>";
/*
echo "
    
</div>
    </div>
</div><div style='clear:both;'></div>"; 

include_once('forms/admin_form_end.php');
*/
?>
<script type="text/javascript">window.print();window.close();</script>