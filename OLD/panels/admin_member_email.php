<?php

$sql="SELECT DISTINCT m_email FROM ts_members WHERE m_role < 2 ORDER BY m_email";
//$sql="SELECT DISTINCT m_email, m_address FROM ts_members WHERE m_role < 2 AND m_email LIKE '%.com%' ORDER BY m_email";
$query=mysql_query($sql);

echo "<ul style='margin-left:15px; display:inline; float:left;'>";

while($row=mysql_fetch_array($query)){
    $m_email=$row['m_email'];
    //$m_address=$row['m_address'];
    //$findme = "@";
   $pos = strpos($m_email, ".");
    
    if(!empty($m_email) && $pos!==false){
        echo "<li style='float:left; width:33%;'>{$m_email};</li>";
        //echo "<li style='float:left; clear:both;'>$m_email - $m_address</li>";
    }
}

echo "</ul>";

?>