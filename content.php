<?php

include_once('includes/globals.php');
include_once('includes/html_head.php');
include_once("forms/form_head.php");

$pagename = str_replace("-"," ",$__get[1]);
$pageid = smContent::GetContentID($pagename);

//echo $__get[1] ." - ". $pageid;

$pagedetails = smContent::GetIndividual($pageid);
?>
<div class="container-fluid">
   <div id="contactus-background-1">
    <br><br><br><br><br><br><br>
     
     <h1 id="div-background-h1" class="text-center animate__animated animate__bounceInRight" style="animation-delay: 1s"><?php echo $pagedetails->pageName ?></h1>
        
   </div><br><br>

    <div class="container-fluid">
	<div class="row row-offcanvas row-offcanvas-left">
		<diV class="col-lg-3 col-md-3 sidebar-offcanvas"id="sidebar" role="navigation">
			<!-- <div class="animate__animated animate__bounceInLeft content-left-div" style="animation-delay: 1s;height:500px;" id=""> -->
			<?php include_once('includes/content-left-column.php');?>
		    <!-- </div> -->
		</diV>
		<div class="col-lg-9 col-md-9" style="margin-top:25px">
			<div class="memberpanel-div">
			<p class="visible-xs">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="offcanvas"><i class="glyphicon glyphicon-chevron-left"></i></button>
          </p>
			<div class="animate__animated animate__bounceInRight"style="animation-delay: 1s;height:auto">
			<h2 id="contactus-h1" class="text-center"><?php echo $pagedetails->pageName ?></h2>
			<br>
			<p id="aftercarousel-p"><?php echo stripcslashes($pagedetails->content)?></p>
		    </div>
		</div>
	</div>
		
	</div><br><br><br><br><br>
    </div>
	

</div>


<!-- echo "<div class='span9'>
        <div class='titleHeader clearfix'>
            
        </div><br/> -->
        <!-- .stripcslashes($pagedetails->content)." -->
    <!-- </div> -->
<!-- </div>"; -->
<?php
include_once('forms/form_end.php');

?>