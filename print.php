<?php include("includes/globals.php"); ?>
<style type="text/css">
	h1{ font-size:15px; font-family:Arial; color:#1a265b;}
	span {font-family:Arial; font-size:140%;}
	span strong{font-size:165%;}
</style>

<script type="text/javascript">
<!--
	function printpage(){
		<?php if(!empty($_GET['id'])){ ?>
		window.outerWidth = 450;
		window.outerHeight = 300;
		<?php }else{ ?>
		window.outerWidth = 450;
		window.outerHeight = 750;
		<?php } ?>
		var vertScroll = self.pageXOffset;
		var vertScroll = self.pageYOffset;
		window.print();
		window.close();
	}
//-->	
</script>
<?php

if(!empty($_GET['id'])){
	$sql = "SELECT * FROM ex_ordercatalogue WHERE id = ".$_GET['id'];
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
	//echo(stripcslashes($row['customerdetails'])."<br/><hr style='border:dashed 1px; clear:both; margin:25px auto;' />");
	echo "<b>".$row['name']."</b><br/>".$row['address']."<br/><hr style='border:dashed 1px; clear:both; margin:30px auto;' />";

}else{
	$sql = "SELECT * FROM ex_ordercatalogue ";
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query)){
		//echo(stripcslashes($row['customerdetails'])."<br/><hr style='border:dashed 1px; clear:both; margin:25px auto;' />");
		echo "<b>".$row['name']."</b><br/>".$row['address']."<br/><hr style='border:dashed 1px; clear:both; margin:30px auto;' />";
	}
}

?>
<script type="text/javascript">	
	var a = printpage();
</script>