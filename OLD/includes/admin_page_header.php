<body id="administration">
	<div id="adminHeader">
		<h3 class="silvermover">Powered by <a href="http://www.silvermover.com" title="Building better web businesses">Silvermover</a></h3>
		<h2>Exact Administration</h2>
		<div id="logout"><a href="logout.php" title="Logout from Exact Administration">Logout</a></div>
		<p class="loginInfo">
			Currently logged in as <?php echo($_SESSION['auth']->mUsername);?> 
			(<?php echo(tsMembers::memberRoleName($_SESSION['auth']->mRole));?>) | 
			You last logged in on <?php echo(date("d M Y H:m:s", strtotime($_SESSION['auth']->mLastActivity)));?>
		</p>
	</div>
	<div id="adminNavigation">
		<?php include($siteRoot."includes/admin_navigation_menu.php"); ?>
	</div>
	<div id="adminContent">