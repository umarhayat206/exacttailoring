<?php

if($_GET['delBmId']!="" && $_SESSION['auth']!='false'){
	tsBodyMeasurements::bmDelete($_GET['delBmId'],$_SESSION['auth']->mId);
}

function showBmProfiles($memberId){
	$bmCol = tsBodyMeasurements::bmListByMemberId($memberId);
	if(count($bmCol)>0){
		foreach($bmCol as $bm){
			echo("<li>");
				echo("	
					<a href='".$_SERVER['PHP_SELF']."?delBmId=".$bm->bmId."' title='Delete profile' class='action' onclick='javascript:return confirm(\"Are you sure you want to delete this profile?\")' >
						<img src='styles/images/cross.png' alt='Delete profile' />
					</a>");
			echo("
					<a href='".$_SERVER['PHP_SELF']."?bmId=".$bm->bmId."' title='Edit profile' class='action' >
						<img src='styles/images/pencil.png' alt='Edit profile' />
					</a>");	
			//Show a button to select this profile IF in shirt builder process
			if($_SESSION['fId']>0 && isset($_SESSION['shirtDesign'])){ //Fabric and shirt chosen
				/*echo("
					<a href='order-a-shirt-step-4?bmId=".$bm->bmId."' title='Select profile' class='action' >
						<img src='styles/images/but_use_profile.gif' alt='Edit profile' />
					</a>");*/
				echo("
					<a href='tailor-made-shirts-review?bmId=".$bm->bmId."' title='Select profile' class='action' >
						<img src='styles/images/but_use_profile.gif' alt='Edit profile' />
					</a>");
				
			}
			
			echo($bm->bmProfileName);
			echo("</li>");
		}
	}else{
		echo("<li>None created</li>"); //Fill in to avoid blank ul's
	}
}

?>