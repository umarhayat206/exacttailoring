<?php

if($_GET['delSmId']!="" && $_SESSION['auth']!='false'){
	tsShirtMeasurements::smDelete($_GET['delSmId'],$_SESSION['auth']->mId);
}

function showSmProfiles($memberId){
	$smCol = tsShirtMeasurements::smGetCollection($memberId);
	if(count($smCol)>0){
		foreach($smCol as $sm){
			echo("<li>");
				echo("	
					<a href='".$_SERVER['PHP_SELF']."?delSmId=".$sm->smId."' title='Delete profile' class='action' onclick='javascript:return confirm(\"Are you sure you want to delete this profile?\")' >
						<img src='styles/images/cross.png' alt='Delete profile' />
					</a>");
			echo("
					<a href='".$_SERVER['PHP_SELF']."?smId=".$sm->smId."' title='Edit profile' class='action' >
						<img src='styles/images/pencil.png' alt='Edit profile' />
					</a>");	
			//Show a button to select this profile IF in shirt builder process
			if($_SESSION['fId']>0 && isset($_SESSION['shirtDesign'])){ //Fabric and shirt chosen
				/*echo("
					<a href='order-a-shirt-step-4?smId=".$sm->smId."' title='Select profile' class='action' >
						<img src='styles/images/but_use_profile.gif' alt='Edit profile' />
					</a>");*/
				echo("
					<a href='tailor-made-shirts-review?smId=".$sm->smId."' title='Select profile' class='action' >
						<img src='styles/images/but_use_profile.gif' alt='Edit profile' />
					</a>");
			}
			
			echo($sm->smProfileName);
			echo("</li>");
		}
	}else{
		echo("<li>None created</li>"); //Fill in to avoid empty ul's
	}
}

?>