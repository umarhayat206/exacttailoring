<?php

include_once('includes/globals.php');
include_once('includes/check_admin_login.php');
include_once('includes/admin_html_head.php');
include_once('forms/admin_form_head.php');

echo "<div class='content_res'>
    <div class='leftblock vertsortable'>
        <div class='gadget'>
            <div class='titlebar vertsortable_head'>
                <h3>Emails List</h3>
            </div>
            <div class='gadgetblock'>";

//include('forms/admin_member_code.php');    
$sql="SELECT DISTINCT usEmail FROM ex_users WHERE usRoLevel = 2 ORDER BY usEmail";
$query=mysql_query($sql);

echo "<ul style='margin-left:15px; display:inline; float:left; width:100%; list-style:none;'>";

while($row=mysql_fetch_array($query)){
    $m_email=$row['usEmail'];
    //$m_address=$row['m_address'];
    //$findme = "@";
   $pos = strpos($m_email, ".");
    
    if(!empty($m_email) && $pos!==false){
        echo "<li style='float:left; width:20%;'>{$m_email};</li>";
    }
}

echo "</ul>";

echo "<br/></div>
        </div>
    </div>
</div><br/>"; 

include_once('forms/admin_form_end.php');

?>