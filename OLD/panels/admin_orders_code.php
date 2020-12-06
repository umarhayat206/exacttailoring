<?php

function email($scId,$status){
	global $siteProductionEmail;
	global $siteSalesEmail;
	global $siteGuvnerEmail;
	$sendMail = false;
	if($status=="PendingConfirmation"){

	}elseif($status=="Processing"){
		//$to = $siteProductionEmail.'; jhonour@gmail.com';	// $siteGuvnerEmail; anand@indrafashion.com, anand@exacttailoring.com
		$to = $siteProductionEmail;
		$sendMail = true;
	}elseif($status=="InProduction"){

	}elseif($status=="Shipped"){
		$to = $siteSalesEmail;	// orders@exacttailoring.com
		$sendMail = true;
	}elseif($status=="Completed"){

	}

	$subject = "Action required on an order - ref number ".$scId;
	$message = "
		Please login to Exact tailoring to view the details of order id - ".$scId." (".$status.")\n\r
		Or click here to see a printable view <a href='http://www.exacttailoring.com/print-order-details.php?orderId=".$scId."' >www.exacttailoring.com/print-order-details.php?orderId=".$scId."</a>	
	";
	if($sendMail==true){
		//@mail($to,$subject,$message);
		$mail = new PHPMailer();
		$mail->From = "no-reply@exacttailoring.com";
		$mail->FromName = "Exact Personal Tailoring Services";
		$mail->AddAddress($to, $to);
		$mail->Subject = $subject;
		$mail->MsgHTML($message);
		//$mail->Send();
	}
}


if($_POST['saveChanges']=="Save changes"){
	foreach($_POST as $key=>$value){
		$scId = str_replace("statusFor","",$key);
		$status = $value;
		$date = date("Y-m-d H:i:s");
		if(is_numeric($scId)){
			tsShoppingCart::scUpdateStatus($scId,$status,$date);
			email($scId,$status);
		}
	}
}

if($_GET['delId']!="" && $_SESSION['auth']->mRole==4){
	tsShoppingCart::scDeleteCart($_GET['delId']);
}

function listOrders($postVars,$sessionAuth,$localRoot){

	$orders = tsShoppingCart::scListOrders($postVars['filText'],$postVars['filStatus'],"",$sessionAuth->mRole);
	if(count($orders)>0){
		foreach($orders as $order){
			$detailsText=tsShoppingCart::getDetails($order->scId);
			echo("<tr>");
				echo("<td><img src='styles/images/".tsShoppingCart::scStatusImage($order->scCompleted)."' title='Status' alt='Status icon' /> ID-".$order->scId."</td>");
				echo("<td><a href='admin-contacts?mId=".$order->scMId."' title='View member details'>".tsMembers::getFullMemberName($order->scMId)."</a></td>");
				echo("<td>".date("d M Y",strtotime($order->scDateOrdered))."</td>");
				echo("<td>&pound;".$order->scCalculatedValue."</td>");
				echo("<td>".$order->scGateway."</td>");
				echo("<td>");
					smControls::smDropDownList("","statusFor".$order->scId,tsShoppingCart::getStatuses($sessionAuth->mRole),$order->scCompleted,"class='smallText'",'true');
					echo("<br /><span class='smallText'>Status changed on ".date("d M Y", strtotime($order->scDateCompleted))."</span>");
				echo("</td>");
				if($detailsText!="") // See if there are any details. If so, show the button
				echo("<td>");
					echo("<img src='styles/images/magnifier.png' alt='View details icon' title='View order details' id='".$order->scId."' class='clicker' />");
					echo("<a href='admin-edit-order?orderId=".$order->scId."&memberId=".$order->scMId."' target='_blank'><img src='styles/images/pencil.png' alt='Edit this order' title='Edit this order' /></a>");
					echo("<a href='admin-print-order-details?orderId=".$order->scId."' title='Print order details' target='_blank'><img src='styles/images/printer.png' alt='Print order details' title='Print order details' /></a>");
					if($sessionAuth->mRole==4)
						echo("<a href='admin-index?delId=".$order->scId."' onclick='javascript:return confirm(\"Are you sure you want to delete this order? This is permenant and non-reversable\")' title='Delete this order'><img src='styles/images/cross.png' alt='Delete this order' title='Delete this order' /></a>");
				echo("</td>");
			echo("</tr>");
			echo("
				<tr>
					<td colspan='6'>
						<div class='hidden' id='pane".$order->scId."'>
							".$detailsText."<br />
							");
			if(trim($order->scDeliveryAddress)!=""){
				//echo("For delivery to: <br />".$order->scDeliveryAddress);
			}
			echo("
						</div>
					</td>
				</tr>
				");
		}
	}
}

function listEditOrders($orderId,$sessionAuth){
	$orders = tsShoppingCart::editThisOrders($orderId);
	echo("<tr>");
		echo("<td><img src='styles/images/".tsShoppingCart::scStatusImage($orders->scCompleted)."' title='Status' alt='Status icon' /> ID-".$orders->scId."</td>");
		echo("<td><a href='admin-contacts?mId=".$orders->scMId."' title='View member details'>".tsMembers::getFullMemberName($orders->scMId)."</a></td>");
		echo("<td>".date("d M Y",strtotime($orders->scDateOrdered))."</td>");
		echo("<td>&pound;".$orders->scCalculatedValue."</td>");
		echo("<td>".$orders->scGateway."</td>");
		echo("<td>");
			echo($orders->scCompleted);
			echo("<br /><span class='smallText'>Status changed on ".date("d M Y", strtotime($orders->scDateCompleted))."</span>");
		echo("</td>");
	echo("</tr>");
	
	$detailsText=tsShoppingCart::getOrderItems($orders->scId);
	echo("
		<tr>
			<td colspan='6'>
				<div id='pane".$orders->scId."'>
					".$detailsText."<br />
					");
	if(trim($orders->scDeliveryAddress)!=""){
		echo("For delivery to: <br />".$orders->scDeliveryAddress);
	}
	echo("
				</div>
			</td>
		</tr>
		");
}

function measurementsOrder($memid){
	$sql="SELECT * FROM ts_body_measurements WHERE bm_id  = '$memid' ";
	$query=mysql_query($sql);
	//$count=mysql_num_rows($query);
	
	//if($count>0){
		$items = array();
		$counter =0;
		while($row=mysql_fetch_array($query)){
			$itemAddToList->bm_id = $row['bm_id'];
			//$itemAddToList->bm_profile_name = $row['bm_profile_name'];
			$itemAddToList->bm_metric = $row['bm_metric'];
			$itemAddToList->bm_type = $row['bm_type'];
			$itemAddToList->bm_neck = $row['bm_neck'];
			$itemAddToList->bm_chest = $row['bm_chest'];
			$itemAddToList->bm_waist = $row['bm_waist'];
			$itemAddToList->bm_seat = $row['bm_seat'];
			$itemAddToList->bm_back = $row['bm_back'];
			$itemAddToList->bm_arm = $row['bm_arm'];
			$itemAddToList->bm_arm_short = $row['bm_arm_short'];
			$itemAddToList->bm_cuff = $row['bm_cuff'];
			$itemAddToList->bm_bicep = $row['bm_bicep'];
			$itemAddToList->bmShoulder = $row['bmShoulder'];
			$itemAddToList->bmSpecial = $row['bmSpecial'];
			$itemAddToList->bmFit = $row['bmFit'];
			$itemAddToList->bmSoftCollar = $row['bmSoftCollar'];
			$itemAddToList->bm_length = $row['bm_length'];
			$itemAddToList->bm_height = $row['bm_height'];
			$itemAddToList->bm_weight = $row['bm_weight'];
			$itemAddToList->bm_back_type = $row['bm_back_type'];
			$itemAddToList->bm_shoulder_type = $row['bm_shoulder_type'];
			$itemAddToList->bm_m_id = $row['bm_m_id'];
			$items[$counter] = $itemAddToList;
			$counter += 1;
		}
		
		//print_r($items);
		return $items;
	//}else{
	//	return false;
	//}
}

?>
