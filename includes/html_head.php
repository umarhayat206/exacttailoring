<!DOCTYPE html>

<html lang="en">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<base href="<?=_URL_;?>"/>
<meta name="description" content="<?=$siteDescription;?>" />
<meta name="keywords" content="<?=$siteKeywords;?>" />
<title><?=$siteBasicTitle;?></title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />

<link rel="icon" href="<?=_URL_; ?>images/rel.gif" type="image/x-icon" />

<meta name="author" content="Ahmed Saeed">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

<!-- JS
================================================== -->
<script src="<?=_URL_;?>js/jquery-1.8.1.js"></script>
<script src="<?=_URL_;?>js/jquery-migrate-1.2.1.min.js"></script>
<script src="<?=_URL_;?>js/jquery-2.1.4.min.js"></script>

<script src="<?=_URL_;?>js/jquery-ui-1.10.3.custom.js"></script>

<script type="text/javascript" src="<?=_URL_;?>js/postcodes.min.js"></script>

<!-- CSS
================================================== -->
<!-- <link rel="stylesheet" href="<?=_URL_;?>styles/bootstrap.min.css" media="screen" /> -->
<!-- <link rel="stylesheet" href="<?=_URL_;?>styles/css/jquery-ui-1.10.3.custom.css" /> -->
<!-- <link rel="stylesheet" href="<?=_URL_;?>styles/customize.css" /> -->
 <link rel="stylesheet" href="<?=_URL_;?>styles/font-awesome.css" /> 
<!-- <link rel="stylesheet" href="<?=_URL_;?>styles/style.css" /> -->
<!-- <link rel="stylesheet" href="<?=_URL_;?>styles/prettyPhoto.css" /> -->

<!-- <link rel="stylesheet" href="<?=_URL_;?>styles/jquery.fancybox.css" /> -->

<!-- <link rel="stylesheet" href="<?=_URL_;?>styles/"> -->
<!-- Mine work  -->

<link  rel="stylesheet" href="<?=_URL_;?>styles/bootstrap1/css/bootstrap.css">
<script src="<?=_URL_;?>styles/bootstrap1/js/jquery-3.2.0.js"></script>
<script src="<?=_URL_;?>styles/bootstrap1/js/bootstrap.js"></script>
<script type="text/javascript" src="<?=_URL_;?>styles/newjavascript.js"></script>

<link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.min.js"></script>
 <!-- end here -->
<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<link rel="stylesheet" href="<?=_URL_;?>styles/font-awesome-ie7.css" />
<![endif]-->

<link rel="stylesheet" id="active-bg" href="<?=_URL_;?>styles/bgnoise_lg.css">
    
	
<script type="text/javascript">
(function(a,e,c,f,g,b,d){var  
h={ak:"919188432",cl:"U5PoCIDptmUQ0OemtgM"};a[c]=a[c]|| 
function(){(a[c].q=a[c].q||[]).push(arguments)};a[f]|| 
(a[f]=h.ak);b=e.createElement(g);b.async=1;b.src="//www.gstatic.com/wcm/loader.js";d=e.getElementsByTagName(g)[0];d.parentNode.insertBefore(b,d);a._googWcmGet=function(b,d,e){a[c](2,b,h,d,null,new  
Date,e)}})(window,document,"_googWcmImpl","_googWcmAk","script");
</script>


<style>
	body {
	font-family: 'Poppins', sans-serif;

	overflow-x:hidden;
	
}
.btn-responsive {
    white-space: normal !important;
    word-wrap: break-word;
}
.topHeader select {
		display: none;
	}
.upper-nav select
{
	display:none;
}
.navbar select
{
	display:none;
}
header .carousel-inner .item {
	height: 100vh;
}
.carousel-margin
{
	margin-top:-75px;
}
#navbar-margin
{
	margin-top:0px;
}
/*.navbar-inverse {
	background-color: transparent;
	border-color: transparent;
}*/
/*.navbar-inverse .navbar-brand {
	color: #fff;
	font-size: 40px;
	padding: 40px 15px;
	font-weight: 900;
}*/
.nav.navbar-nav {
	margin: 15px 0;
}
.navbar-default .navbar-nav>li>a {
	color: black;
	/*text-transform: uppercase;*/
	font-weight:bold;
}
.banner {
	-webkit-background-size: cover;
	background-size: cover;
	background-position: center center;
	background-repeat: no-repeat;
	height: 100vh;

}
.carousel-caption {
	padding-bottom: 200px;
	font-family: poppins;
}
.carousel-caption h2 {
	font-size: 50px;
	text-transform: uppercase;
	font-weight: bold;
	color:black;
}
/*.carousel-caption h2 span {
	color: #EDBB00;
}*/
.panel-default .panel-heading
{
	background-color:black;
	color:white;

}
.carousel-caption a {
	/*background: #EDBB00;*/
	background:black;
	padding: 15px 35px;
	display: inline-block;
	margin-top: 15px;
	color: #fff;
	text-transform: uppercase;
	border-radius: 25px;
}

.carousel-caption>p>a:hover {
	text-decoration:none;
	/*background: #EDBB00;*/
	/*background:black;
	padding: 15px 35px;
	display: inline-block;
	margin-top: 15px;
	color: #fff;
	text-transform: uppercase;
	border-radius: 25px;*/
}
.carousel-control.right {
	background-image: none;
}
.carousel-control.left {
	background-image: none;
}
.carousel-indicators .active {
	/*background-color: #EDBB00;*/
	background-color: black;
	/*border-color: #EDBB00;*/
	border-color: white;
}
@media only screen and (min-width: 768px) and (max-width: 991px) {
	.carousel-caption {
		padding-bottom: 350px;
	}
	.carousel-caption h2 {
		font-size: 50px;
	}
	
}
@media only screen and (max-width: 767px) {
	.navbar-default .navbar-brand {
		font-size: 30px;
		padding: 20px 15px;
	}

	.navbar-collapse {
		/*background: rgba(0, 0, 0, 0.5);*/
	}
	.carousel-caption {
		padding-bottom: 120px;
	}
	.carousel-caption h2 {
		font-size: 25px;
	}
	.carousel-caption h3 {
		font-size: 18px;
	}
	.carousel-caption a {
		padding: 10px 25px;
	}
	
}

.aftercarousel-div
{
	background-color: #efefef;
	height:200px;
	width:100%

}

#aftercarousel-h1
{
	padding-top:70px;
	font-family: "Playfair Display", serif;
  font-weight:bold;
 	text-transform:uppercase;
 	
}

#aftercarousel-p
{

  font-size:20px;
    line-height: 32px;
    color: #7f7f7f;
    font-weight: 400;

}


#mainpage-aboutus
{
	/*padding-top:70px;*/
	font-family: "Playfair Display", serif;
  font-weight:bold;
 	text-transform:uppercase;
 	
}
#mainpage-aboutus-p
{

  font-size:16px;
    line-height: 32px;
    /*color: #7f7f7f;*/
    font-weight: 400;

}
.banner-1
	{
		width:100%;
		height:100vh;
		overflow:hidden;
		display:flex;
		justify-content:center;
		align-items:center;
	}
	.banner-1 video
	{
		position: absolute;
    height:100%;
    width:98%;
    object-fit:cover;
    opacity:1;

	}
	.video-content
	{
		position:relative;
		z-index:1;
		margin:0 auto;
	}
	.content-h1
	{
		color:white;
		margin-top:;
		font-weight:bold;
		letter-spacing:10px;
	}
	.content-h3
	{
		color:white;
		text-transform:uppercase;
		letter-spacing:5px;
		word-spacing:10px;
		text-align:center;
	}
	
	.video-div
	{
		background: rgba(0, 0, 0, 0.5);
		height:150px;
		border-radius:130px;
		width:150px;
		margin-bottom:20px;
		border:1px solid white;
	} 
	.num-2
	{
      color:white;
      text-align: center;
      font-weight:bold;
      padding-top:40px; 
	}

#services-div
{
	/*height:450px;*/
	overflow: hidden;
	border-bottom-color:rgb(255, 209, 175);
border-bottom-style:solid;
border-bottom-width:1px;

border-left-color:rgb(255, 209, 175);
border-left-style:solid;
border-left-width:1px;
border-right-color:rgb(255, 209, 175);
border-right-style:solid;
border-right-width:1px;
border-top-color:rgb(33, 37, 41);
border-top-style:none;
border-top-width:0px;
margin-bottom: 20px;
}
#services-div:hover
{
	box-shadow: 0 0 15px 5px rgba(0,0,0,0.5);
}
#about-us-h1
{
  font-family: "Playfair Display", serif;
  font-weight:550; 
}

.product-name
{
  font-family: "Playfair Display", serif;
  font-weight:300; 
}
.product-name a:hover
{
	text-decoration:none;
}
#about-us-p
{
  font-size:13px;
    line-height: 32px;
    color: #7f7f7f;
    font-weight: 400;
}
.price
{
  font-size: 16px;
    font-weight:bold;
}
.all-icon
{
	font-size:20px;
	font-weight:bold;
}

.socials {
	margin:0;
	padding:0;
	list-style: none;
}
	.socials li {
		float:left;
		padding:0;
		margin:0;
		margin-right:1px;
		font-size:18px;
		width:32px;
		height:34px;
		text-align: center;
		line-height:34px;
	}
	.socials li:last-child {
		margin-right:0;
	}
	.socials li a i {
		-webkit-text-shadow:inset 0 -1px 0 rgba(0,0,0,.5);
		-moz-text-shadow:inset 0 -1px 0 rgba(0,0,0,.5);
		text-shadow:inset 0 -1px 0 rgba(0,0,0,.5);
	}
	.socials li a {
		color:#a9a9a9;
		display: block;
		background-color: #e0e0e0;
		-webkit-transition:background-color .2s linear;
		-moz-transition:background-color .2s linear;
		transition:background-color .2s linear;
	}
	.socials li a:hover {
		text-decoration: none;
		color:#fff;
	}
	/*facebook*/
	.socials li a.social-facebook:hover {
		background-color:#266aa8;
	}
	/*twitter*/
	.socials li a.social-twitter:hover {
		background-color:#00aec8;
	}
	/*gooleplus*/
	.socials li a.social-gooleplus:hover {
		background-color:#484544;
	}
	/*linkedin*/
	.socials li a.social-linkedin:hover {
		background-color:#009640;
	}
	/*github*/
	.socials li a.social-github:hover {
		background-color:#e81962;
	}
	/*pinterest*/
	.socials li a.social-pinterest:hover {
		background-color:#e12531;
	}

/*conatact us css*/

#contactus-background-1
{
	background-image: url("images/slider/img3.jpeg");
	height: 500px; 
  background-position: center; 
  background-repeat: no-repeat; 
  background-size: cover; 
  overflow: hidden;
  margin-top: -55px;
  opacity: 0.9;
}
#div-background-h1
{
	color: #ffffff;
    font-family: "Playfair Display", serif;
    font-size: 6vw;
    text-transform: capitalize;
    letter-spacing: 2px;
    font-weight: 900;
    margin-bottom: 4px;
    margin: 20px 0 16px 0;
    line-height: 90px;
    color:black;
}
#contactus-h1
{
	font-family: "Playfair Display", serif;
	font-size:30px;
  font-weight:600;
}

#contactus-info-div
{
	height:auto;
	background-color:white;
	padding:50px;
	margin-bottom:20px;
}
.contactus-input
{
	height:50px;
  border-radius: 0px;
}
.register-span
{
	color:red;
	/*font-size:20px;*/
}

.btn-default
{
	/*background-color: rgb(74, 54, 0);*/
	background-color: rgb(33, 37, 41);
	border: 2px solid white;
	color: white;
	margin-top: 4px;
	padding:10px;
	border-radius:0px; 
	width:100%; 

}
.btn-default:hover
{
	/*background-color: rgb(74, 54, 0);*/
	background-color: rgb(33, 37, 41);
	border: 2px solid white;
	color: white;
	margin-top: 4px;
	padding:10px;
	border-radius:0px;  

}
.btn-default-shop
{
	/*background-color: rgb(74, 54, 0);*/
	background-color: rgb(33, 37, 41);
	border: 2px solid white;
	color: white;
	margin-top: 4px;
	padding:10px;
	border-radius:0px; 
	width:50%; 

}
.btn-default-shop:hover
{
	/*background-color: rgb(74, 54, 0);*/
	background-color: rgb(33, 37, 41);
	border: 2px solid white;
	color: white;
	margin-top: 4px;
	padding:10px;
	border-radius:0px; 
	width:50%; 

}

/*testinomials*/
.testimonials
 {
 	margin:50px auto;
 }
 .testimonials h1
 {
 	text-align: center;
 	font-weight: bold;
 	/*color: #ff9800;*/
 	padding-bottom:10px;
 	text-transform:uppercase;
 	font-family: "Playfair Display", serif;
 }
 .testimonials h1::after
 {
    content:'';
    background :black;
    display:block;
    height: 3px;
    width: 170px;
    margin:20px auto 5px;
 }
.div-of-row
{
	margin:40px auto;
}
.profile
{
   padding: 40px 10px 10px;
   background-color: #efefef;
   border-radius:20px;
}
.profile h3
{
	font-size: 20px;
	margin-top: 15px;
	color:black;
	font-weight:bold;
}
.profile span
{
  font-size: 12px;
  color: #333;
}
blockquote
{
	font-size: 16px;
	line-height:30px;
}
blockquote::before
{
	content:'"';
	font-size: 50px;
	position:relative;
	color:black;
	line-height: 20px;
	bottom: -15px;
	right:5px;
}
blockquote::after
{
	content:'"';
	font-size: 50px;
	position:relative;
	color:black;
	line-height: 10px;
	bottom: -15px;
	left:5px;
}
.profile:hover
{
  box-shadow: 0 0 15px 5px rgba(0,0,0,0.2);
}


#startshopping
{
	font-family: "Playfair Display", serif;
	font-size:2vw;
  font-weight:600;
}
#div-footer
{
	width:100%;height:auto;
	background-color:rgb(33, 37, 41);
	color: white;
	padding: 50px;

}

#h1-footer-1
{
	font-family: "Playfair Display", serif;
}

#ul-footer
{
	list-style-type:none;
	margin:0px;
	padding:0px;
	overflow:hidden;
	line-height:35px;
}
#ul-footer li a
{
	color:white;
	text-decoration:none;
}
#logo_img-footer
{
	height:70px;
	width: 230px;
	
}
#footer-border
{
	border-top: 1px solid rgba(255, 255, 255, 0.2);
    padding-bottom:20px;
}


div.productdesign label { width:45%; float:left; margin:0 0 10px 10px; clear:both; }
div.productdesign select { width:45%; float:left; margin:0 0 10px 0px; }
div.productdesign button { margin-left:45%; }

#shirtView { float: right; }
#shirtView { width:38%; }
#shirtView div { /*width: 275px; 	height: 300px; */ width:100%; height: 300px; 	}
#opttionView { float: left; /*width: 320px; */ width:50%; }

@media (max-width: 650px) {
	#opttionView { clear:both; float: left; margin-top:15px; width:100%; }
	#shirtView { float: left; width:275px; }

	/*navbar logo for samll view*/
	/*.navbar-brand {
  padding: 0px;
}
.navbar-brand>img {
  height: 100%;
  padding: 15px;
  width:300px;
}*/
}

#trousersView { float: right; }
#trousersView, #trousersView div { width: 275px; height: 485px; }

/*my account css*/
#account-h1
{
	font-family: "Playfair Display", serif;
	font-size:25px;
  font-weight:600;
}
.account-a-div
{
	height:50px;background-color: #fff;padding:15px;
}
.account-a
{
	color:black;

}
.account-input
{
	height:40px;
  border-radius: 0px;
  width:100%;
}
.memberpanelhiddenbox
{
	background-color:  #fff;
	height:auto;
	padding:30px;
}
.login-detail-div
{
	background-color:  #fff;
	height:auto;
	padding:30px;
}
.Modify-shipping-address
{
	background-color:  #fff;
	height:auto;
	padding:30px;
}
.modify-measurement-div
{
	background-color:  #fff;
	height:auto;
	padding:30px;
}
.order-history-div
{
	background-color:  #fff;
	height:auto;
	padding:30px;
}
.voucher-history-div
{
	background-color:  #fff;
	height:auto;
	padding:30px;
}

.memberpanel-div
{
  padding: 30px;
  background-color: #f5f5f5;
  margin-top:-55px;
  

  
}
@media screen and (max-width: 768px) {
	
  .row-offcanvas {
    position: relative;
    -webkit-transition: all 0.25s ease-out;
    -moz-transition: all 0.25s ease-out;
    transition: all 0.25s ease-out;
  }

  .row-offcanvas-left
  .sidebar-offcanvas {
    left: -33%;
  }

  .row-offcanvas-left.active {
    left: 33%;
  }

  .sidebar-offcanvas {
    position: absolute;
    top: 0;
    width: 33%;
    margin-left: 10px;
    margin-bottom:100px;
  }
}


/* Sidebar navigation */
.nav-sidebar {
	background-color: #fff;
  margin-right: -15px;
  margin-bottom: 20px;
  margin-left: -15px;
  margin-top:px;
}

.nav-sidebar > li > a {
  padding-right: 20px;
  padding-left: 20px;
  color:black;

}
.row .nav-sidebar >ul> li > a .active {
  color:white;
  background-color:black;
}
/*.nav-sidebar > .active > a {
  color: #fff;
  background-color: #428bca;
}*/

/*comment page css */

.comment-h1
{
	font-family: "Playfair Display", serif;
	font-weight:bold;
}
</style>

</head>


