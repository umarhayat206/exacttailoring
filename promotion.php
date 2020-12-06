<?php

include_once('includes/globals.php');
include_once('includes/html_head.php');
include_once("forms/form_head.php");

$getOurPromotion = smPromotion::GetAllPromotion(false); // status = Live

$i=0;
$promotionMainPhoto="";
foreach($getOurPromotion as $item){
    $i++;
    
    if($i % 2 == 0){
        $float="right";
    }else{
        $float="left";
    }
    
    $promotiontitle = strtolower(str_replace(array(" - ", " "),"-", $item->promotionTitle));
    $promotiontitle = strtolower(str_replace("%","percen", $promotiontitle));
    $promotionMainPhoto .= "<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12'>
    <a href='"._URL_."product-on-promotion/{$item->promotionId}/$promotiontitle'>
            <img src='"._URL_."upload_pictures/{$item->promotionBanner}' class='$float img-thumbnail' alt='{$item->promotionTitle}' title='{$item->promotionTitle}' height='250px' width='100%' />
        </a>
        </div><br>";
    
}
 
?>
<div class="container">

<div class="row">
	
            <?php echo $promotionMainPhoto; ?>
       <br><br><br> 
</div>
</div>

<?php include_once('forms/form_end.php'); ?>