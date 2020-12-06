<?php

//print_r($_POST);
//print_r($_FILES);

if($_GET['delfId']!="" && $_SESSION['auth']!='false'){
	tsFabrics::fDelete($_GET['delfId']);
}

$fabrics = new tsFabrics;
if($_REQUEST['ftId']!=""){	
	$fType = $fabrics->ftDetails($_REQUEST['ftId']);
}

if($_POST['ftName']!=""){ //Save measurements
	$numFabrics = (count($_POST) - 3) / 4; //Deduct 3 from the total count, then divide by 5 to get number of loops required
	//Save collection first to ensure id is available
	$fType = new tsFabricType;
	$fType->ftId = $_REQUEST['ftId'];
	$fType->ftName = $_POST['ftName'];
	$fType->ftId = $fType->fabricTypeSave($fType);
	for($i=0;$i<=$numFabrics;$i++){
		if($_POST['fName'.$i]!=""){
			$fabric = new tsFabrics;
			$fabric->ftId = $fType->ftId;
			$fabric->fId = $_POST['fId'.$i];
			$fabric->fName = $_POST['fName'.$i];
			$fabric->fCode = $_POST['fCode'.$i];
			$fabric->fPricePerShirt = $_POST['fPrice'.$i];
			$fabric->fImage = smImages::Upload($_FILES['fImage'.$i]['name'],$_FILES['fImage'.$i]['tmp_name'],160);
			$fabric->fabricSave($fabric);
			$fabric = null;
		}
	}
	$fType = null; //Successful save *supposedly* Null to move on
}

function addFabrics($ftId){
	$fabrics = tsFabrics::fabricList($ftId);
	if(count($fabrics)>0){
		$countTo = count($fabrics)-1;
	}else{
		$countTo = 0;
	}
	for($i=0;$i<=$countTo;$i++){
		if($fabrics[$i]->fId>0){
			$delButton = "<a title='Delete single fabric' href=".($_SERVER['PHP_SELF']."?ftId=".$_GET['ftId']."&delfId=".$fabrics[$i]->fId)." class='fabricDelete' onclick='javascript:return confirm(\"Are you sure you want to delete this fabric?\")'>X</a>";
		}else{
			$delButton = "";
		}
		?>
			<fieldset>
				<legend>Fabric <?php echo($i+1);?> <?php echo($delButton);?></legend>
				<?php smControls::smHiddenText("fId".($i+1),$fabrics[$i]->fId);?>
				<?php smControls::smTextBox("Name","fName".($i+1),$fabrics[$i]->fName);?><br />
				<?php smControls::smTextBox("Code","fCode".($i+1),$fabrics[$i]->fCode);?><br />
				<?php smControls::smTextBox("Price (&pound;)","fPrice".($i+1),$fabrics[$i]->fPricePerShirt);?><br />
				<?php smImages::showThumb($fabrics[$i]->fImage,$fabrics->ftName,180);?>
				<?php smControls::smFileUpload("Swatch image","fImage".($i+1),$fabrics[$i]->fImage);?><br />
			</fieldset>		
		<?php
	}
	return($i);
}

?>