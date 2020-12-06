<?php
@session_start();

include_once('includes/globals.php');

if($_POST['memberloginformsubmit'] || $_POST['quickloginformsubmit']){ 
    
    if ((!empty($_POST['emaillogin'])) AND (!empty($_POST['passwordlogin']))){
	//Connect to db to see if username and pass exist
        $sql = "SELECT * FROM ex_users WHERE (usEmail='".mysql_real_escape_string($_POST['emaillogin'])."' OR usUsername='".mysql_real_escape_string($_POST['emaillogin'])."' OR usTelephone='".$_POST['emaillogin']."' OR usMobile='".$_POST['emaillogin']."') AND usPasswordHashed='".md5($_POST['passwordlogin'])."' AND usAuthorised='1' AND usRoLevel='2' ";
	
	//echo $sql."<br/>".$_POST['passwordlogin']."<br/>". md5($_POST['passwordlogin'])."<br/>".md5("12345");
	
	$query = mysql_query($sql);
	$row =mysql_fetch_array($query);
	$n = mysql_num_rows($query);

	//see if username and password vars match the embarrasingly hard coded values
	if ($n == 1){ 
	    if($row['usRoLevel']==2){   // member
		    
		$_SESSION['chklevel'] = $row['usRoLevel'];
		$_SESSION['chkmemberuser'] = $row['usId'];
		$_SESSION['membername'] = $row['usFirstname'];
		$_SESSION['memberlastactivity'] = $row['usLastActivity'];
		$_SESSION['auth'] = true;
		$_SESSION['initials'] = "";

		$updateLastActivity=mysql_query("UPDATE ex_users SET usLastActivity='".mktime()."', usLogins = usLogins + 1 , usPassword='".$_POST['passwordlogin']."' WHERE usId='".$row['usId']."' ");
		//$updateClick=mysql_query("UPDATE ex_users SET usLogins = usLogins + 1 WHERE usId='".$row['usId']."' ");

		if($_POST['followfromregis']=="true"){
			
			$createmeasurement=mysql_query("INSERT INTO ex_users_measurement SET usId='".$row['usId']."' ");
			
			echo ("<script>
				alert('To complete register please update your body measurement on \"Modify Measurement\" form');
				window.location='"._URL_."my-account';
			    </script>");
			
		}else{
			    //echo "<br/>";
			    //echo $_SESSION['chklevel']." - ".$_SESSION['chkmemberuser']." - ".$_SESSION['membername']." - ".$_SESSION['memberlastactivity'];

			echo ("<script>
				alert('Welcome back {$_SESSION['membername']}');
				window.location='"._URL_."my-account';
			    </script>");
			
			//window.location='"._URL_."my-account';
		}

	    }else{ 
		    echo ("<script>
			    alert('Your account no permition');
			    window.location='"._URL_."';
			</script>");
	    }
		
	}else{ //echo "****";
		//no match:- set auth as false and echo message to 5h1t3 h4x0r
		echo ("<script>
			alert('Incorrect username and/or password');
			window.location='"._URL_."';
		      </script>");
		
            
	} // n if n=1
        
    }
    
}

?>
