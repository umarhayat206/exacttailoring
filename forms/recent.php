<?php

function RecentthisWeek(){
        $htmltoreturn = "";

        $today=mktime();
        $todaylastweek = 86400 * 7;
        $lastweek = $today - $todaylastweek;
        
        $sql ="SELECT * FROM property WHERE prop_lastdate > '$lastweek' ORDER BY prop_lastdate DESC"; 
        $query=mysql_query($sql);
        while($row=mysql_fetch_array($query)){
                $htmltoreturn .= "<form id='propertySelect' method='post' action='{$site_admin}admin_property_list' style='float:left;'>
                        <input type='hidden' id='propertySelectSubmitted' name='propertySelectSubmitted' value='true' />
                        <input type='hidden' id='prop_id' name='prop_id' value='".$row['prop_id']."' />
                        <input type='hidden' id='action' name='action' value='editdata' />
                        <input id='Select' name='Select' value='Select' type='image' title='Edit - ".$row['prop_ref']."' alt='Edit ".$row['prop_ref']."' src='"._URL_."styles/images/select.gif' class='button' />
                </form>
                <label style='margin:2px 0 0 5px;'>Ref no: ".$row['prop_ref']." - ".date('j/m/Y',$row['prop_lastdate'])."</label><br />";
        }      

        return $htmltoreturn;
}

function RecentLastMonth(){
        $htmltoreturn = "";
        
        $today=mktime();
        $todaylastmonth = 86400 * 30;
        $lastmonth = $today - $todaylastmonth;
        
        $sql ="SELECT * FROM property WHERE prop_lastdate > '$lastmonth' ORDER BY prop_lastdate DESC";  
        $query=mysql_query($sql);
        $cnt=mysql_num_rows($query);
        
        if($cnt>0){
                while($row=mysql_fetch_array($query)){
                        $htmltoreturn .= "<form id='propertySelect' method='post' action='{$site_admin}admin_property_list' style='float:left;'>
                                <input type='hidden' id='propertySelectSubmitted' name='propertySelectSubmitted' value='true' />
                                <input type='hidden' id='prop_id' name='prop_id' value='".$row['prop_id']."' />
                                <input type='hidden' id='action' name='action' value='editdata' />
                                <input id='Select' name='Select' value='Select' type='image' title='Edit - ".$row['prop_ref']."' alt='Edit ".$row['prop_ref']."' src='"._URL_."styles/images/select.gif' class='button' />
                        </form>
                        <label style='margin:2px 0 0 5px;'>Ref no: ".$row['prop_ref']." - ".date('j/m/Y',$row['prop_lastdate'])."</label><br />";
                }
        }else{
                $htmltoreturn = "No data add/update on ".date('j/m/Y',$lastmonth);
        }

        return $htmltoreturn;
}

$recentweek = RecentthisWeek(); 
$recentmonth = RecentLastMonth();

echo "<div style='width:45%; float:right; padding-left:2px;'>
                <h1>Recent 7 days</h1>
                <div style='font-size:15px;'>$recentweek</div><br/>
                
                <h1>Recent last month</h1>
                <div style='font-size:15px;'>$recentmonth</div>
        </div><br/>";

?>