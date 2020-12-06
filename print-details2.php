<?php

include("includes/globals.php"); 

if(!empty($_GET['id'])){
	$sql = "SELECT * FROM ex_ordercatalogue WHERE id = ".$_GET['id'];
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
	//echo(stripcslashes($row['customerdetails'])."<br/><hr style='border:dashed 1px; clear:both; margin:25px auto;' />");
	$showdetails = "<b>".$row['name']."</b><br/>".$row['address']."<br/><hr style='border:dashed 1px; clear:both; margin:30px auto;' />";

}else{
	
	$showdetails .= "<div style='width:198mm; padding:15.5mm 7.25mm; margin:0 auto;'>";
	
	$sql = "SELECT * FROM ex_ordercatalogue WHERE address !='' AND city !='' AND country ='183' ";
	$query = mysql_query($sql);
	
	$cnt = 0;
	$cnt2 = 0;
	while($row = mysql_fetch_array($query)){
		
		$cnt++;
		$cnt2++;
		
		if($cnt % 3 == 1){
			$cl=" clear:both; float:left;";
			$pd="padding:8px 0 0 12px";

		}else if($cnt % 3 == 2){
			$cl=" float:left; margin:0 10px; ";
			$pd="padding:8px 0 0 12px;";
			
		}else{
			$cl=" float:left; ";
			$pd="padding:8px 0 0 12px;";
		}
		    
		if($cnt2 % 21 == 0){
			$cl2 = "<div style='page-break-before: always;'></div>
		<div style='height:15.5mm;'><br style:'clear:both;'/></div>";
		}else{
			$cl2 = "";
		}
		
		$countryname=smSetting::getCountry($row['country']);
		
		if(!empty($row['company'])){
			$a1="<br/>".ucwords(strtolower(stripcslashes($row['company'])));
		}
		
		if(!empty($row['address2'])){
			$a2="<br/>".ucwords(strtolower(stripcslashes($row['address2'])));
		}

		if(!empty($row['address3'])){
			$a3="<br/>".ucwords(strtolower(stripcslashes($row['address3'])));
		}
		
		//echo(stripcslashes($row['customerdetails'])."<br/><hr style='border:dashed 1px; clear:both; margin:25px auto;' />");
		$showdetails .= "<div style='width:63.5mm; height: 38.1mm; margin:0; padding:0px; font-size:15px; line-height:16px; $cl'>
			<div style='{$pd}'>
				<b>". ucwords(strtolower($row['name'])) ." ". ucwords(strtolower($row['surname'])) ."</b>
				$a1
				<br/>". ucwords(strtolower(stripcslashes($row['address']))) ."
				$a2 $a3
				<br/>". ucwords(strtolower(stripcslashes($row['city']))) ."
				<br/>". strtoupper($row['postcode']) ."
			</div>
		</div>".$cl2;
			
			//<br/>".$countryname->countryName."
	}
	
	$showdetails .= "<br style='clear:both;'/></div>";
}


echo $showdetails;

?>

