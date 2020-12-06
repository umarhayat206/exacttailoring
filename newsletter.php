<?php

include_once('includes/globals.php');
include_once('includes/html_head.php');
include_once("forms/form_head.php");

$getOurNewsletter = smCatalogue::GetMenuAndPages("", false); // status = Live

$i=0;
$newsletterPhoto="";
foreach($getOurNewsletter as $item){
    $i++;

    $newslettertitle = strtolower(str_replace(array(" - ", " "),"-", $item->catalogueName));
    $newsletterPhoto .= "<a href='"._URL_."upload_pictures/{$item->catalogueImage}' rel='prettyPhoto'>
            <img src='"._URL_."upload_pictures/{$item->catalogueImage}' class='banner' alt='{$item->catalogueName}' title='{$item->catalogueName}' style='width:23.5%; height:282px; margin:10px 5px;' />
        </a>";

}
 
?>

<div class="row">
	<div class="span12">
            <div class='titleHeader clearfix'>
		<h3>Recent Newsletter</h3>
	    </div><br/>
	    
	    <?php echo $newsletterPhoto; ?>
        </div>
</div>

<?php include_once('forms/form_end.php'); ?>