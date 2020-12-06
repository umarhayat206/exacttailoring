<script type="text/javascript">
	$(document).ready(function(){
		$('.tinymce').tinymce({
			// Location of TinyMCE script
			script_url : '<?=_URL_;?>tinymce/jscripts/tiny_mce/tiny_mce.js',
			skin:"o2k7",
			// General options
			theme : "advanced",
			
			// save,
			plugins : "pagebreak,style,layer,table,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options save,newdocument,|,
			theme_advanced_buttons1 : "",
			//theme_advanced_buttons2 : "",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			// Example content CSS (should be your site CSS)
			content_css : "<?=_URL_;?>styles/tiny.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js"
		});
	});
</script>