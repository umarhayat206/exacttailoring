<? include("code/application_code_includes_and_globals_file.php"); ?>
<style type="text/css">
	h1{ font-size:15px; font-family:Arial; color:#1a265b;}
	span {font-family:Arial; font-size:140%;}
	span strong{font-size:165%;}
</style>

<script type="text/javascript">
<!--
	function printpage(){
		<? if(!empty($_GET['id'])){ ?>
		window.outerWidth = 450;
		window.outerHeight = 300;
		<? }else{ ?>
		window.outerWidth = 450;
		window.outerHeight = 750;
		<? } ?>
		var vertScroll = self.pageXOffset;
		var vertScroll = self.pageYOffset;
		window.print();
		window.close();
	}
//-->	
</script>
<?

if(!empty($_GET['id'])){
	$sql = "SELECT * FROM ts_members ";
	$sql.= "WHERE m_role='0' AND m_id = ".$_GET['id'];
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
	$mId = $row['m_id'];
	$mRole = $row['m_role'];
	$mFirstname = $row['m_firstname'];
	$mLastname = $row['m_lastname'];
	$mAddress = $row['m_address'];
	$mCountry = $row['m_country'];
	$mPostcode = $row['m_postcode'];
	
	echo("<span><strong>".$mFirstname." ".$mLastname."</strong><br />".str_replace(array("\n",","),"<br />",$mAddress)."<br />".$mPostcode."<br />".smCountries::countryById($mCountry)."</span>");

}else{
	$sql = "SELECT * FROM ts_members ";
	$sql.= "WHERE m_role='0' ";
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query)){
		$mId = $row['m_id'];
		$mRole = $row['m_role'];
		$mFirstname = $row['m_firstname'];
		$mLastname = $row['m_lastname'];
		$mAddress = $row['m_address'];
		$mCountry = $row['m_country'];
		$mPostcode = $row['m_postcode'];
		$mEmail = $row['m_email'];
		
		//echo $mEmail."<br/>";
		echo("<span><strong>".$mFirstname." ".$mLastname."</strong><br />".str_replace(array("\n",","),"<br />",$mAddress)."<br />".$mPostcode."<br />".smCountries::countryById($mCountry)."<br/>".$mEmail."</span><hr style='border:dashed 1px; clear:both; margin:25px auto;' />");
	}
}

?>
<script type="text/javascript">	
	var a = printpage();
</script>