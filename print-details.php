<?php

include("includes/globals.php"); 

if(!empty($_GET['id'])){
	$sql = "SELECT * FROM ex_ordercatalogue WHERE id = ".$_GET['id'];
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
	//echo(stripcslashes($row['customerdetails'])."<br/><hr style='border:dashed 1px; clear:both; margin:25px auto;' />");
	$showdetails = "<b>".$row['name']."</b><br/>".$row['address']."<br/><hr style='border:dashed 1px; clear:both; margin:30px auto;' />";

}else{
	
	$showdetails .= "<div style='width:760px; padding:0; margin:0 auto;'>";
	
	$sql = "SELECT * FROM ex_ordercatalogue WHERE address !='' AND city !='' AND country ='183' ";
	$query = mysql_query($sql);
	
	$cnt = 0;
	$cnt2 = 0;
	while($row = mysql_fetch_array($query)){
		
		$cnt++;
		$cnt2++;
		
		if($cnt % 3 == 1){
			$cl=" clear:both; float:left; ";
			$pd="padding:30px 20px 0 10px;";
		}else if($cnt % 3 == 2){
			$cl=" float:left; ";
			$pd="padding:30px 0 0 20px;";
			
		}else{
			$cl=" float:right; ";
			$pd="padding:30px 0 0 40px;";
		}
		    
		if($cnt2 % 21 == 0){
			$cl2 = "<div style='page-break-before: always;'><br/></div>";
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
		$showdetails .= "<div style='width:233px; height: 145px; margin:0; padding:10px; font-size:13px; line-height:17px; border:solid:1px #ccc; $cl'>
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
	
	$showdetails .= "</div>";
}


echo $showdetails;

?>

