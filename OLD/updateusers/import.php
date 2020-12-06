<?php

/*$host = 'localhost';
$use = 'root';
$pwd = 'root';
$dbname = 'db_exact';*/

$host = '192.168.0.200';
$use = 'exaUser';                
$pwd = 'tcaxe428';
$dbname = 'exact2db';

$conn=mysql_connect($host,$use,$pwd);
$db=mysql_select_db($dbname,$conn);

$sql="SELECT * FROM ts_members WHERE m_id > 674 ";
$query=mysql_query($sql);
while($row=mysql_fetch_array($query)){
    $MID=$row['m_id'];
    $MPASS=$row['m_password_hashed'];
    
    $sqlUpdate = "UPDATE ts_members SET ";
    $sqlUpdate .="m_password_hashed='".md5($MPASS)."' ";
    $sqlUpdate .="WHERE m_id='".$MID."' ";
    
    //echo $sqlUpdate;
    mysql_query($sqlUpdate) or die(mysql_error());	

}

?>