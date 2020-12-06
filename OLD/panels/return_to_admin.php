<?php

if($_SESSION['backToAdminUser']->mId>0 && $_SESSION['backToAdminUser']->mRole>1){
	?>
		<a id="backToAdmin" href='index.php?backToAdmin=true' title='Back to Admin'><img src='styles/images/backtoadmin.gif' alt='Return to admin button' /></a>
	<?php
}
?>