<body>
<html>
<div class="container">
	<!-- HEADER -->
	<div class="header">
		<div class="header_logo">
			<img src="<?=_URL_;?>styles/images/logo.jpg" width="677" height="122" alt="Logo" class="logo" />
			<div class="right">
				<?php //if($_SESSION['chklevel']==3){ ?>
				<!--<ul class="dark">
					<li class="first"><a href="<?//=_URL_;?>admin_settings">Field settings</a></li>
				</ul>-->
				<?php //} ?>
				<div class="clr"></div>
				<ul class="light">
					<!--<li class="first"><a href="<?//=_URL_;?>"><img src="<?//=_URL_;?>styles/images/icon_email.gif" alt="picture" width="14" height="10" class="email" /></a><a href="#">37</a> incoming messages</li>-->
					<!--<li class="first">Logged in as <a href="<?//=_URL_;?>admin_user">User Name</a></li>-->
					<li class="first"><img src="<?=_URL_;?>styles/images/icon_logout.gif" alt="picture" width="16" height="16" class="logout" /><a href="<?=_URL_;?>admin_logout">Logout</a></li>
				</ul>
				<p>Logged in as <a href="<?=_URL_;?>admin_user.php"><?=$_SESSION['username'];?></a></p>
			</div>
			<div class="clr"></div>
		</div>
		<?php include_once("includes/admin_topmenu.php"); ?>
	</div>
  
	<!-- CONTENT -->
	<div class="content">
		
	