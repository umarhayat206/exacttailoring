<?php
//$folderName = "/RTCL";
//$folderName = "";

#echo '<hr/>'.str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']).'<hr/>';
#/RTCL/tinymce/jscripts/tiny_mce/plugins/images/connector/php/
$scriptName = str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
$expScriptNameRoot = explode("/",$scriptName);
/*
echo "<pre>";
print_r($expScriptNameRoot);
echo "</pre>";
*/
if(array_key_exists(1,$expScriptNameRoot))
{
    $folderName = "/".$expScriptNameRoot[0];
    //$folderName = "/".$expScriptNameRoot[1];    // localhost
}else{
    $folderName = "";
}


//Site root dir
//define('DIR_ROOT',		$_SERVER['DOCUMENT_ROOT']);
define('DIR_ROOT',		$_SERVER['DOCUMENT_ROOT']);

//Images dir (root relative)
define('DIR_IMAGES',	$folderName.'/storage/images');

//Files dir (root relative)
define('DIR_FILES',		$folderName.'/storage/files');


//Width and height of resized image
define('WIDTH_TO_LINK', 500);
define('HEIGHT_TO_LINK', 500);

//Additional attributes class and rel
define('CLASS_LINK', 'lightview');
define('REL_LINK', 'prettyPhoto');//lightbox

//date_default_timezone_set('Asia/Yekaterinburg');

?>
