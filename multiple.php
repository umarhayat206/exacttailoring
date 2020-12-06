<?php
include_once('includes/globals.php');

$sql="select * from ex_users_measurement where measurementShirtStomach > 1";
$query=mysql_query($sql);

while($row=mysql_fetch_array($query)){
    
    if($row['measurementShirtStomach'] > 80){
        $sql = "UPDATE ex_users_measurement SET ";
        $sql .="measurementMetric='1' ";
        $sql .="WHERE measurementId='".$row['measurementId']."' ";
        //mysql_query($sql);
        
    }else{
        $sql = "UPDATE ex_users_measurement SET ";
        $sql .="measurementMetric='0' ";
        $sql .="WHERE measurementId='".$row['measurementId']."' ";
        //mysql_query($sql);
    }
    
}


?>