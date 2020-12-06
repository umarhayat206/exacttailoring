<?php
include("code/application_code_includes_and_globals_file.php");

include($siteRoot."forms/member_code.php");
include($siteRoot."panels/member_list_code.php");

include($siteRoot."includes/html_head.php");
include($siteRoot."includes/admin_page_header.php");



?>
<div>
	<?php include($siteRoot."forms/member_form.php");?>
	<?php include($siteRoot."panels/member_list_panel.php");?>
</div>	


<?php include($siteRoot."includes/admin_page_footer.php");?>


