<?php

/*$host = 'localhost';
$use = 'root';
$pwd = '1234';
$dbname = 'db_exact';*/      

$host = 'localhost';
$use = 'exacttai_exact';
$pwd = 'uSqwsL%te.s';
$dbname = 'exacttai_oldweb';

$conn=mysql_connect($host,$use,$pwd);
$db=mysql_select_db($dbname,$conn);

?>