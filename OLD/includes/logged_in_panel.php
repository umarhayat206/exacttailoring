<?php
//print_r($_SESSION);
	if($_SESSION['auth'] instanceof tsMembers && $_SESSION['auth']->mId!=""){
		if($_SESSION['auth']->mLogins<1){
			echo("<p id='userLoggedInPanel'>Welcome <br />");
		}else{
			echo("<p id='userLoggedInPanel'>Welcome back<br />");
		}
		echo("<strong>".$_SESSION['auth']->mFirstname." ".$_SESSION['auth']->mLastname."</strong><br />");
		//echo("<strong>".$_SESSION['auth']->mAddress." ".$_SESSION['auth']->mPostcode." ".$_SESSION['auth']->mCountry."</strong><br />");
		if($_SESSION['auth']->mLogins>0){
			echo("You last logged in on<br /><strong>".smFunctions::displayDate($_SESSION['auth']->mLastActivity)."</strong><br />");
		}
		
		echo("<a href='".$siteLocalRoot."member-index' title='Members area'>My account</a>");
		echo("<a href='".$siteLocalRoot."logout.php' title='Log out of Exact'>Logout</a></p>");
	}else{
		include($siteRoot."forms/login_form.php");
		/*echo('
			<p id="userLoggedInPanel">
				<a href="login" title="Login to Exact">Login - Re order</a>
				<a href="register" title="Register with Exact">Register</a>
			</p>');*/
	}
?>