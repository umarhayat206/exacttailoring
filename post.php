	<?php
	session_start();
	
	//include('dbcon.php');
	
	if(@$_REQUEST['commentverify'] || @strtolower($_REQUEST['commentverify']) == strtolower($_SESSION['random_number']))
	{
		
		// insert your name , email and text message to your table in db
		
		echo 1;// submitted 
		
	}
	else
	{
		echo 0; // invalid code
	}
	?>
