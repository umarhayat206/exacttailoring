<form id="loginForm" method="post" action="<?php echo($_SERVER['PHP_SELF']);?>">
	<fieldset>
		<legend>Login</legend>
		Please log in to access your information and measurements. 
		<?php echo($loginError);?>
		<?php smControls::smTextBox("Username","mUsername");?><br />
		<?php smControls::smPasswordBox("Password","mPassword");?><br />
		<?php smControls::smButton("Login","mLogin");?>
		<?php
		//See if in store
		if($_GET['purchase']!=""){ 
			smControls::smHiddenText("purchase",$_GET['purchase']);
		}
		?>
		<br />
		No account yet? <a href="register" title="Register with Exact Tailoring">Register here.</a>
	</fieldset>
</form>