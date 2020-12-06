<body>
	<div id="wrapper">
		<div id="header">
			<?php include("panels/return_to_admin.php");?>
			<?php include($siteRoot."panels/shopping_cart.php");?>
			<h1 title="Exact Personal Tailoring Services UK">Exact Tailor Store</h1>
			
		</div>
		<div id="strapline">
			<h2>Hand finished made to measure shirts from just <span class="money">&pound;49.99</span> - Your style, your size, perfect fit</h2>
		</div>
		<div id="content">
			<div id="navigationMenu">
				<?php include($siteRoot."includes/navigation_menu.php");?>
				<?php include($siteRoot."includes/logged_in_panel.php");?>
				<a href="example-shirts" title="See example shirts" id="samplesButton">
					<img src="<?php echo($siteLocalRoot);?>styles/images/see-example-shirts.jpg" alt="Sample shirts button" />
				</a>
				<div style="clear:both; width:auto; height:auto; color:#15428B; margin:5px auto 10px; padding:5px;">
					<!--<center>
						<a href="http://storezone.co.uk" target="_blank" >
							<img border="0" src="http://storezone.co.uk/sz.gif" alt="Shopping Directory"/><br/>Review our shop
						</a><br style="clear:both;"/>
					</center>-->
					
					<h4 style="text-align:center;">Customer Letters</h4>
					<!--<p style="font-size:12px;"><i>
						"If YOU value a quality product and excellent customer service (as I do), then you should consider Exact Personal Tailoring.
						I found Mo to be most helpful &amp; efficient - she even spotted a measurement which I had clearly got horribly wrong, and brought it to my attention! The shirts are lovely.
						Well done - I will certainly be back" <br/>From R.W.S. Melton Mowbray
					</i></p>-->
					<!--
					<p style="font-size:12px;"><i>
						"Good morning Rozy &amp; Mo,<br/>
						Thank you so much the shirt which arrived today it is perfect, especially as it was such a small piece of material that I had sent you. My husband will now be able to take it on holiday along with the 2 others that you made for him. <br/>
						I will not hesitate to recommend you, such excellent service <br/>
						May I wish you both a Merry Christmas and a Healthy New Year New.
						<br/>Kindest regards </p>
					
					<p style="font-size:12px;"><i>To Mo, shirt delivered to hotel - very pleased. Many thanks for all your efforts. Kind Regards,<br/>Peter Mounsey</i></p>
					-->
					<p style="font-size:12px;"><i>
						Sir, For over 20years I had shirts made by Seymours of Bradford before they disappeared off the map(No idea what happened to them!) When I found your firm I tinkered about trying different materials with varied success until I returned to my fist love..Egyptian Cotton for my most recent order.<br/>
						The 3 shirts came on Friday and WOW they are fantastic!!! They cost more of course, but they're worth every penny. <br/>
						Thankyou very much.<br/>
						DK</i></p>
					
					<p style="font-size:12px;"><i>
						Shirts arrived yesterday look and fit great.<br/>
						Many thanks<br/>
						Mike</i></p>
				</div>

				<!--<div style="width:150px; padding:5px; color:#15428B; margin:5px auto 10px; line-height:14px;">
					
				</div>-->
			</div>
			<div id="innerContent">
<?
if($_GET['product']==41 || $_GET['purchase']==22){ 	// localhost is 22 , online is 41
	echo "<h3 style='color:red;'>BUY TWO PAIRS OF BOXER SHORTS AND GET A THIRD PAIR FOR HALF PRICE</h3>";
}else{
	echo "<h3 style='color:red;'>Sensational Savings - save up to 25%</h3>";
}
?>

<!--$_SESSION['ORDERVALUE']=$total;-->


