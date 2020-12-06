<?php
function GetSummary(){
        $htmltoreturn = "";
        
        $sqlPropertyTotal = "SELECT * FROM property";
        $queryPropertyTotal = mysql_query($sqlPropertyTotal);
        $rowPropertyTotal=mysql_num_rows($queryPropertyTotal);
        $htmltoreturn .= "<p>Property: <b>$rowPropertyTotal records</b></p>";
        
        $sqlHidden ="SELECT * FROM property WHERE prop_visible !='1' "; 
        $queryHidden=mysql_query($sqlHidden);
        $rowHidden=mysql_num_rows($queryHidden);
        $htmltoreturn .= "<p>Hidden: <b>$rowHidden records</b></p>";
        
        /*
        $sqlSold ="SELECT * FROM pt_property_details WHERE pdSoldFlag='1' "; 
        $querySold=mysql_query($sqlSold);
        $rowSold=mysql_num_rows($querySold);
        $htmltoreturn .= "<p>Sold: <b>$rowSold records</b></p>";
        */
        
        
        $sqlSale ="SELECT * FROM property WHERE prop_sale_price > '0' AND prop_rental_price = '0' ";
        $rsSale=mysql_query($sqlSale);
        $rowSale=mysql_num_rows($rsSale);
        $htmltoreturn .= "<span>Property for sale: <b>$rowSale records</b></span><br />";

        $sqlRent ="SELECT * FROM property WHERE prop_rental_price > '0' AND prop_sale_price = '0' ";
        $rsRent=mysql_query($sqlRent);
        $rowRent=mysql_num_rows($rsRent);
        $htmltoreturn .= "<span>Property for rent: <b>$rowRent records</b></span><br />";
        
        $sqlSaleLet ="select *  from property WHERE prop_sale_price > '0' AND prop_rental_price > '0' ";
        $rsSaleLet=mysql_query($sqlSaleLet);
        $rowSaleLet=mysql_num_rows($rsSaleLet);
        $htmltoreturn .= "<span>Property for sale and for rent: <b>$rowSaleLet records</b></span><br /><br />";

        for($i=1;$i<=4;$i++){
            $sqlType ="SELECT * FROM property WHERE prop_type='$i' ";
            $rsType=mysql_query($sqlType);
            $rowType=mysql_num_rows($rsType);
            $typeName = smSetting::propertyTypeName($i);
            $htmltoreturn .= "<span>{$typeName[0]}: <b>$rowType records</b></span><br />";

            $sqlSale2 ="SELECT * FROM property WHERE prop_sale_price > '0' AND prop_rental_price = '0' AND prop_type='$i' ";
            $rsSale2=mysql_query($sqlSale2);
            $rowSale2=mysql_num_rows($rsSale2);
            $htmltoreturn .= "<span>{$typeName[0]} for sale: <b>$rowSale2 records</b></span><br />";
            
            $sqlRent2 ="SELECT * FROM property WHERE prop_rental_price > '0' AND prop_sale_price = '0' AND prop_type='$i' ";
            $rsRent2=mysql_query($sqlRent2);
            $rowRent2=mysql_num_rows($rsRent2);
            $htmltoreturn .= "<span>{$typeName[0]} for rent: <b>$rowRent2 records</b></span><br />";
            
            $sqlSaleLet2 ="select *  from property WHERE prop_sale_price > '0' AND prop_rental_price > '0' AND prop_type='$i' ";
            $rsSaleLet2=mysql_query($sqlSaleLet2);
            $rowSaleLet2=mysql_num_rows($rsSaleLet2);
            $htmltoreturn .= "<span>{$typeName[0]} for sale and for rent: <b>$rowSaleLet2 records</b></span><br /><br />";
        }
        
        $sqlAdmin="SELECT * FROM adminuser WHERE user_level = '1' ";
        $reAdmin=mysql_query($sqlAdmin);
        $adminuser =mysql_num_rows($reAdmin);

        $sqlMember = "SELECT * FROM adminuser WHERE user_level = '2' ";
        $reMember=mysql_query($sqlMember);
        $user =mysql_num_rows($reMember);

        return $htmltoreturn;
}

$summary = GetSummary();
echo "<div style='width:50%; float:left;'>
                <h1>Summary</h1>
                <div style='font-size:15px;'>$summary</div>
        </div>";

?>