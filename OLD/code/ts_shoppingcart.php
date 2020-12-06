<?php
/**
 * Shopping cart class with the cart items class below
 */
/**
 * ts_shoppingcart
 */
class tsShoppingCart {
    public $scId;
    /** Origianl creation date **/
    public $scDateAdded;
    /** Date customer clicked to pay via paypal (or order taken manually via sales) **/
    public $scDateOrdered;
    /** STATUS - InProgress, PendingConfirmation, Processing, InProduction, Shipped, Completed **/
    public $scCompleted; 
    /** Incremented at each stage of order (and containing the date the order was set at completed) **/
    public $scDateCompleted;
    public $scSysRef;
    public $scGateway;
    public $scGatewayRef;
    public $scCalculatedValue;
    public $scReturnedValue;
    public $scDeliveryAddress;
    public $scAdminNotes;
    public $scMId;

    //Public functions
    
    /** Returns an array of available statuses **/
    public static function getStatuses($role){
    	if($role==2){ //Production
 			return(array(
				"Processing"=>self::scConvertStatus("Processing"),
				"InProduction"=>self::scConvertStatus("InProduction"),
				"Shipped"=>self::scConvertStatus("Shipped")));   		
    	}elseif($role==3){ //Sales
			return(array(//"InProgress"=>self::scConvertStatus("InProgress"),
				
				"PendingConfirmation"=>self::scConvertStatus("PendingConfirmation"),
				"Processing"=>self::scConvertStatus("Processing"),
				"InProduction"=>self::scConvertStatus("InProduction"),
				"Shipped"=>self::scConvertStatus("Shipped"),
				"Completed"=>self::scConvertStatus("Completed")));		
		}elseif($role==4){ //Administration   		
			return(array(//"InProgress"=>self::scConvertStatus("InProgress"),
				
				"PendingConfirmation"=>self::scConvertStatus("PendingConfirmation"),
				"Processing"=>self::scConvertStatus("Processing"),
				"InProduction"=>self::scConvertStatus("InProduction"),
				"Shipped"=>self::scConvertStatus("Shipped"),
				"Completed"=>self::scConvertStatus("Completed")));
		}
	}

    /** Get code term and return 'nice' phrase **/
    public static function scConvertStatus($scCompleted){
		switch($scCompleted){
			case "InProgress":
				return("Awaiting checkout");
				break;
			case "PendingConfirmation":
				return("Payment awaiting confirmation");
				break;
			case "Processing":
				return("Order confirmed and is now being processed");
				break;
			case "InProduction":
				return("Order is now in production");
				break;
			case "Shipped":
				return("Order is complete and has been shipped");
				break;
			case "Completed":
				return("Order completed");
				break;
			default:
				return("Oops. System error");
		}
	}
	
    /** Get code term and return 'nice' phrase **/
    public static function scConvertStatusForMember($scCompleted){
		switch($scCompleted){
			case "InProgress":
				return("Awaiting checkout");
				break;
			case "PendingConfirmation":
				return("Payment awaiting confirmation");
				break;
			case "Processing":
			case "InProduction":
			case "Shipped":
				return("Payment approved. Order in production.");
				break;
			case "Completed":
				return("Order shipped.");
				break;
			default:
				return("Oops. System error");
		}
	}
	
	/** return status image based on text or code entry **/
    public static function scStatusImage($scCompleted){
		switch($scCompleted){
			case "InProgress":
			case 1:
				return("status_1.gif");
				break;
			case "PendingConfirmation":
			case 2:
				return("status_2.gif");
				break;
			case "Processing":
			case 3:
				return("status_3.gif");
				break;
			case "InProduction":
			case 4:
				return("status_4.gif");
				break;
			case "Shipped":
			case 5:
				return("status_5.gif");
				break;
			case "Completed":
			case 6:
				return("status_6.gif");
				break;
			default:
				return("");
		}
	}	

	/** Return count of orders (not InProgress shopping carts) by member id **/
	public static function scGetOrderCount($mId){
		$sql = "
			SELECT count(sc_id) FROM ts_shoppingcart 
			WHERE sc_completed<>'InProgress' AND sc_m_id=".smFunctions::checkInput($mId);
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		return($row[0]);		
	}
	
	/** Return Total sales (completed orders) by member id **/
	public static function scGetSalesTotal($mId){
		$sql = "
			SELECT sum(sc_calculated_value) FROM ts_shoppingcart
			WHERE sc_completed='Completed' AND sc_m_id=".smFunctions::checkInput($mId);
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		return($row[0]);
	}
	
	/**
	 * Given scId create a table of all products with details
	 */
	public static function getDetails($scId){
		$outputString = "
			<table class='cartItemDetails' summary='Order details'>
				<thead>
					<tr>
						<th class='description'>Description</th>
						<th>Price</th>
						<th>Qty</th>
						<th>Total</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th class='description'>Description</th>
						<th>Price</th>
						<th>Qty</th>
						<th>Total</th>
					</tr>
				</tfoot>
				<tbody>
			";
		$cartItems = self::scListItems($scId);
		$numShirts = 0;
		
		//print_r($cartItems);
		
		//if(is_array($cartItems)){	// new check have to delete if not working
			foreach($cartItems as $item){
				//Get name/description of item
				if($item->sciFId>0){ //SHIRT
					$numShirts += $item->sciQty;
				}
				
				// edit 25-10-11
				/*
				$fabric = tsFabrics::fabricGetOne($item->sciFId);
				$outputString.= ("<tr>");
				$outputString.= ("<td class='description'>".self::getItemNameDescription($item)."</td>");
				$outputString.= ("<td>&pound; ".$fabric->fPricePerShirt."</td>");
				$outputString.= ("<td>".$item->sciQty."</td>");
				$outputString.= ("<td>&pound; ".($fabric->fPricePerShirt * $item->sciQty)."</td>");
				$outputString.= ("</tr>");
				*/
				$outputString.= ("<tr>");
				$outputString.= ("<td class='description'>".self::getItemNameDescription($item)."</td>");
				$outputString.= ("<td>&pound; ".$item->sciPrice."</td>");
				$outputString.= ("<td>".$item->sciQty."</td>");
				$outputString.= ("<td>&pound; ".($item->sciPrice * $item->sciQty)."</td>");
				$outputString.= ("</tr>");
				
			}
		//}
		/*
		if($numShirts<2){
			$outputString.= "
						<tr>
							<td>Delivery charge</td>
							<td></td>
							<td></td>
							<td>&pound; 4.95</td>
						</tr>";
		}
		*/
		$outputString.= "</tbody>
			</table>
			";
		return($outputString);		
	}
	
	public function getOrderItems($scId){
		$outputString = "
			<table class='cartItemDetails' summary='Order details' style='width:100%;'>
				<thead>
					<tr>
						<th class='description'>Description</th>
						<th style='text-align:right;'>Qty</th>
					</tr>
				</thead>
				<tbody>
			";
		$cartItems = self::scListItems($scId);
		$numShirts = 0;
		$i=0;
		foreach($cartItems as $item){
			$i++;
			//echo $item->sciPoId;
			$ITEMOTY="editItemOty".$i;
			$ITEMDETAIL="editItemsDetail".$i;
			$ITEMID="editItemId".$i;
			echo "<input type='hidden' id='$ITEMID' name='$ITEMID' value='".$item->sciId."' />";
			//echo "<input type='hidden' id='$ITEMID' name='$ITEMID' value='".$item->sciId."' />";

			//Get name/description of item
			if($item->sciFId>0){ //SHIRT
				$numShirts += $item->sciQty;
			}
			$outputString.= ("<tr>");
			$outputString.= ("<td class='description'><span class='txtProduct'>".self::getItemNameDescription($item)."</span><br />");
			if(!empty($item->sciPoId)){
			    $outputString.= ("<textarea id='$ITEMDETAIL' name='$ITEMDETAIL' style='width:80%; float:left; height:80px;'>".self::getItemsSizeDetails($item->sciPoId)."</textarea>");
			}
			$outputString.= ("</td>");
			$outputString.= ("<td><input type='text' id='$ITEMOTY' name='$ITEMOTY' value='".$item->sciQty."' style='width:50px; text-align:right;' /></td>");
			$outputString.= ("</tr>");
			
			$outputString.= ("<tr>");
			$outputString.= ("<td colspan='6'>");
			
			//echo $item->sciBmId."----";
			$measurements=measurementsOrder($item->sciBmId);
			foreach($measurements as $measurements2){
			    $bm_metric = "bm_metric".$i;
			    $bm_metric1 = "bm_metric1".$i;
			    $bm_metric2 = "bm_metric2".$i;
			    
			    $bm_type = "bm_type".$i;
			    $bm_type1 = "bm_type1".$i;
			    $bm_type2 = "bm_type2".$i;
			    
			    $bm_neck = "bm_neck".$i;
			    $bm_chest = "bm_chest".$i;
			    $bm_waist = "bm_waist".$i;
			    $bm_seat = "bm_seat".$i;
			    $bm_back = "bm_back".$i;
			    $bm_arm = "bm_arm".$i;
			    $bm_arm_short = "bm_arm_short".$i;
			    $bm_cuff = "bm_cuff".$i;
			    $bm_bicep = "bm_bicep".$i;
			    $bmShoulder ="bmShoulder".$i;
			    $bmSpecial ="bmSpecial".$i;
			    $bmFit = "bmFit".$i;
			    $bmSoftCollar = "bmSoftCollar".$i;
			    $bm_height = "bm_height".$i;
			    $bm_weight = "bm_weight".$i;
			    $measurementsId = "measurementsId".$i;
			    
			    $designId = "designId".$i;
			    $bm_color = "bm_color".$i;
			    $bm_collar = "bm_collar".$i;
			    $bm_whitecollar = "bm_whitecollar".$i;
			    $bm_sleeves = "bm_sleeves".$i;
			    $bm_cuffs = "bm_cuffs".$i;
			    $bm_whitecuffs = "bm_whitecuffs".$i;
			    $bm_placketbuttons = "bm_placketbuttons".$i;
			    $bm_fastening = "bm_fastening".$i;
			    $bm_pockets = "bm_pockets".$i;
			    $bm_flaps = "bm_flaps".$i;
			    $bm_epaulettes = "bm_epaulettes".$i;
			    $bm_embroiderytext = "bm_embroiderytext".$i;
			    $bm_embroiderycolour = "bm_embroiderycolour".$i;
			    $bm_backpleats = "bm_backpleats".$i;
			    $bm_bottomcut = "bm_bottomcut".$i;

			    $outputString.= "<div id='measurementsorder'>
				<p>Measurements order</p>";
				
				
			    $collar7="";
			    $collar6="";
			    $collar5="";
			    $collar4="";
			    $collar3="";
			    $collar2="";
			    $collar1="";
			    $sleeve4="";
			    $sleeve3="";
			    $sleeve2="";
			    $sleeve1="";
			    $cuffs8="";
			    $cuffs7="";
			    $cuffs6="";
			    $cuffs5="";
			    $cuffs4="";
			    $cuffs3="";
			    $cuffs2="";
			    $cuffs1="";
			    $fastening3="";
			    $fastening2="";
			    $fastening1="";
			    $pockets9="";
			    $pockets8="";
			    $pockets7="";
			    $pockets6="";
			    $pockets5="";
			    $pockets4="";
			    $pockets3="";
			    $pockets2="";
			    $pockets1="";
			    $embroiderycolour7="";
			    $embroiderycolour6="";
			    $embroiderycolour5="";
			    $embroiderycolour4="";
			    $embroiderycolour3="";
			    $embroiderycolour2="";
			    $embroiderycolour1="";
			    $backpleats3="";
			    $backpleats2="";
			    $backpleats1="";
			    $bottomcut2="";
			    $bottomcut1="";
				
			     //smControls::smCheckBox("Letted", "pdLetFlag", "1","$CHPROP->pdLetFlag","");	
			    $design = tsShirtDesign::sdGetOne($item->sciSId);
			    //print_r($design);

			    $sqlFabricTypeID=mysql_query("SELECT f_ft_id FROM ts_fabrics WHERE f_id=".$item->sciFId);
			    $rowFabricTypeID=mysql_fetch_array($sqlFabricTypeID);
			    $ft_ID=$rowFabricTypeID['f_ft_id'];
			    
			    $sqlFabricTypeName=mysql_query("SELECT ft_name FROM ts_fabric_type WHERE ft_id=".$ft_ID);
			    $rowFabricTypeName=@mysql_fetch_array($sqlFabricTypeName);
			    $ft_name=$rowFabricTypeName['ft_name'];
			    //echo $ft_name."-*-*-";
			    
			    if($ft_name=="Pyjamas" || $ft_name=="Ladies Shirts"){
				$outputString.= "<label>Color</label>
				<select id='$bm_color' name='$bm_color'>
				    <option value=''></option>";
				    $sqlColor=mysql_query("SELECT * FROM ts_color");
				    while($rowColor=mysql_fetch_array($sqlColor)){
					if($design->sCollar==$rowColor['c_id']){
					    $outputString .= "<option value='{$rowColor['c_id']}' selected='selected'>{$rowColor['c_name']} ({$rowColor['c_code']})</option>";	
					}else{
					    $outputString .= "<option value='{$rowColor['c_id']}'>{$rowColor['c_name']} ({$rowColor['c_code']})</option>";	
					}
				    }
				$outputString.= "</select><br/>";
			    }
			    
			    if($design->sCollar==10){
				$collar7=" selected='selected' ";
			    }else if($design->sCollar==9){
				$collar6=" selected='selected' ";
			    }else if($design->sCollar==8){
				$collar5=" selected='selected' ";
			    }else if($design->sCollar==7){
				$collar4=" selected='selected' ";
			    }else if($design->sCollar==6){
				$collar3=" selected='selected' ";
			    }else if($design->sCollar==4){
				$collar2=" selected='selected' ";
			    }else{
				$collar1=" selected='selected' ";
			    }
			    $outputString.= "<label>Collar</label>
			    <select id='$bm_collar' name='$bm_collar'>
				<option value=''>-Select-</option>
				<option value='10' $collar7>Collar: Soft Collar</option>
				<option value='9' $collar6>Collar: Hawaiian</option>
				<option value='8' $collar5>Collar: Rounded</option>
				<option value='7' $collar4>Collar: Mandarin</option>
				<option value='6' $collar3>Collar: Button down</option>
				<option value='4' $collar2>Collar: Italian (Cut away)</option>
				<option value='1' $collar1>Collar: Classic</option>
			    </select><br />";
			    
			    if($design->sCollarWhite==1){
				$whitecollar="checked='checked'";
			    }else{
				$whitecollar="";
			    }
			    $outputString.= "<label>White collar</label><input type=\"checkbox\" name=\"$bm_whitecollar\" id=\"$bm_whitecollar\" value=\"1\" $whitecollar /><br />";
			
			    if($design->sSleeve==4){
				$sleeve4=" selected='selected' ";
			    }else if($design->sSleeve==3){
				$sleeve3=" selected='selected' ";
			    }else if($design->sSleeve==2){
				$sleeve2=" selected='selected' ";
			    }else{
				$sleeve1=" selected='selected' ";
			    }
			    
			    $outputString.= "<label>Sleeves</label>
			    <select id='$bm_sleeves' name='$bm_sleeves'>
				<option value=''>-Select-</option>
				<option value='4' $sleeve4>Sleeve: Roll up</option>
				<option value='3' $sleeve3>Sleeve: Short with cuff</option>
				<option value='2' $sleeve2>Sleeve: Short</option>
				<option value='1' $sleeve1>Sleeve: Long</option>
			    </select><br />";
			    
			    if($design->sCuff==8){
				$cuffs8=" selected='selected' ";
			    }else if($design->sCuff==7){
				$cuffs7=" selected='selected' ";
			    }else if($design->sCuff==6){
				$cuffs6=" selected='selected' ";
			    }else if($design->sCuff==5){
				$cuffs5=" selected='selected' ";
			    }else if($design->sCuff==4){
				$cuffs4=" selected='selected' ";
			    }else if($design->sCuff==3){
				$cuffs3=" selected='selected' ";
			    }else if($design->sCuff==2){
				$cuffs2=" selected='selected' ";
			    }else{
				$cuffs1=" selected='selected' ";
			    }
			    $outputString.= "<label>Cuffs</label>
			    <select id='$bm_cuffs' name='$bm_cuffs'>
				<option value=''>-Select-</option>
				<option value='8' $cuffs8>Cuff Style: Single Rounded</option>
				<option value='7' $cuffs7>Cuff Style: Angled</option>
				<option value='6' $cuffs6>Cuff Style: French Rounded</option>
				<option value='5' $cuffs5>Cuff Style: French</option>
				<option value='4' $cuffs4>Cuff Style: Single Cufflink</option>
				<option value='3' $cuffs3>Cuff Style: Triple button</option>
				<option value='2' $cuffs2>Cuff Style: Two button</option>
				<option value='1' $cuffs1>Cuff Style: Single button</option>
			    </select><br />";
			    
			    if($design->sCuffWhite==1){
				$whitecuffs="checked='checked'";
			    }else{
				$whitecuffs="";
			    }
			    $outputString.= "<label>White cuffs</label><input type=\"checkbox\" name=\"$bm_whitecuffs\" id=\"$bm_whitecuffs\" value=\"1\" $whitecuffs /><br />";
			    
			    if($design->sPlacketButton==1){
				$placketbuttons="checked='checked'";
			    }else{
				$placketbuttons="";
			    }
			    $outputString.= "<label>Placket buttons</label><input type=\"checkbox\" name=\"$bm_placketbuttons\" id=\"$bm_placketbuttons\" value=\"1\" $placketbuttons /><br />";
			    
			    if($design->sFastening==3){
				$fastening3=" selected='selected' ";
			    }else if($design->sFastening==2){
				$fastening2=" selected='selected' ";
			    }else{
				$fastening1=" selected='selected' ";
			    }
			    $outputString.= "<label>Fastening</label>
			    <select id='$bm_fastening' name='$bm_fastening'>
				<option value=''>-Select-</option>
				<option value='3' $fastening3>Fastening: Fly</option>
				<option value='2' $fastening2>Fastening: Plackett</option>
				<option value='1' $fastening1>Fastening: French</option>
			    </select><br />";
			    
			    if($design->sPocket==9){
				$pockets9=" selected='selected' ";
			    }else if($design->sPocket==8){
				$pockets8=" selected='selected' ";
			    }else if($design->sPocket==7){
				$pockets7=" selected='selected' ";
			    }else if($design->sPocket==6){
				$pockets6=" selected='selected' ";
			    }else if($design->sPocket==5){
				$pockets5=" selected='selected' ";
			    }else if($design->sPocket==7){
				$pockets4=" selected='selected' ";
			    }else if($design->sPocket==3){
				$pockets3=" selected='selected' ";
			    }else if($design->sPocket==2){
				$pockets2=" selected='selected' ";
			    }else{
				$pockets1=" selected='selected' ";
			    }
			    $outputString.= "<label>Pockets</label>
			    <select id='$bm_pockets' name='$bm_pockets'>
				<option value=''>-Select-</option>
				<option value='9' $pockets9>Pockets: 2 box pleat pockets</option>
				<option value='8' $pockets8>Pockets: Box pleat pocket</option>
				<option value='7' $pockets7>Pockets: 2 inverted pleat pockets</option>
				<option value='6' $pockets6>Pockets: Inverted pleat pocket</option>
				<option value='5' $pockets5>Pockets: 2 v-shaped pockets</option>
				<option value='4' $pockets4>Pockets: 2 classic pockets</option>
				<option value='3' $pockets3>Pockets: V-shaped pocket</option>
				<option value='2' $pockets2>Pockets: Classic pocket</option>
				<option value='1' $pockets1>Pockets: No pockets</option>
			    </select><br />";
			    
			    if($design->sPocketFlaps==1){
				$flaps="checked='checked'";
			    }else{
				$flaps="";
			    }
			    $outputString.= "<label>Flap/s</label><input type=\"checkbox\" name=\"$bm_flaps\" id=\"$bm_flaps\" value=\"1\" $flaps /><br />";
			    
			    if($design->sEpaulettes==1){
				$epaulettes="checked='checked'";
			    }else{
				$epaulettes="";
			    }
			    $outputString.= "<label>Epaulettes</label><input type=\"checkbox\" name=\"$bm_epaulettes\" id=\"$bm_epaulettes\" value=\"1\" $epaulettes /><br />";
			    
			    $outputString.= "<label>Embroidery text (3 chars)</label><input type='text' id='$bm_embroiderytext' name='$bm_embroiderytext' value='$design->sEmbroideryText' /><br/>";
			    
			    if($design->sEmbroideryColor==7){
				$embroiderycolour7=" selected='selected' ";
			    }else if($design->sEmbroideryColor==6){
				$embroiderycolour6=" selected='selected' ";
			    }else if($design->sEmbroideryColor==5){
				$embroiderycolour5=" selected='selected' ";
			    }else if($design->sEmbroideryColor==4){
				$embroiderycolour4=" selected='selected' ";
			    }else if($design->sEmbroideryColor==3){
				$embroiderycolour3=" selected='selected' ";
			    }else if($design->sEmbroideryColor==2){
				$embroiderycolour2=" selected='selected' ";
			    }else if($design->sEmbroideryColor==1){
				$embroiderycolour1=" selected='selected' ";
			    }else{
				$embroiderycolour0=" selected='selected' ";
			    }
			    $outputString.= "<label>Embroidery colour</label>
			    <select id='$bm_embroiderycolour' name='$bm_embroiderycolour'>
				<option value=''>-Select-</option>
				<option value='7' $embroiderycolour7>Same as shirt</option>
				<option value='6' $embroiderycolour6>pink</option>
				<option value='5' $embroiderycolour5>white</option>
				<option value='4' $embroiderycolour4>yellow</option>
				<option value='3' $embroiderycolour3>red</option>
				<option value='2' $embroiderycolour2>green</option>
				<option value='1' $embroiderycolour1>blue</option>
				<option value='0' $embroiderycolour0>black</option>
			    </select><br />";
			    
			    if($design->sBackPleats==2){	// no pleat
				$backpleats3=" selected='selected' ";
			    }else if($design->sBackPleats==1){	// side pleat
				$backpleats2=" selected='selected' ";
			    }else{	// center
				$backpleats1=" selected='selected' ";
			    }
			    $outputString.= "<label>Back pleats</label>
			    <select id='$bm_backpleats' name='$bm_backpleats'>
				<option value=''>-Select-</option>
				<option value='0' $backpleats1>Back: Center</option>
				<option value='1' $backpleats2>Back: Side pleats</option>
				<option value='2' $backpleats3>Back: No pleats</option>
			    </select><br />";
			    
			    if($design->sBottomCut==1){
				$bottomcut2=" selected='selected' ";
			    }else{
				$bottomcut1=" selected='selected' ";
			    }
			    $outputString.= "<label>Bottom cut</label>
			    <select id='$bm_bottomcut' name='$bm_bottomcut'>
				<option value=''>-Select-</option>
				<option value='1' $bottomcut2>Hem: Straight</option>
				<option value='0' $bottomcut1>Hem: Fishtail</option>
			    </select><br /><br />";

			    $outputString.= "<label>Metric</label>";
//print_r($measurements2);
				if($measurements2->bm_metric==0){$metric1=" checked='checked' ";}                 
				if($measurements2->bm_metric==1){$metric2=" checked='checked' ";}
//echo $measurements2->bm_metric."-*-";
			    $outputString.= "<span style='float:right;'>Centimeters (Decimal)</span><input type='radio' id='$bm_metric1' name='$bm_metric' value='0' $metric1 />
				<span style='float:right;'>Inches (Imperial)</span><input type='radio' id='{$bm_metric2}' name='$bm_metric' value='1' $metric2 /><br/>
				<label>Measurement taken from</label>";

//echo $measurements2->bm_type."-*-";
			    if($measurements2->bm_type=="Shirt"){ $ty1=" checked='checked' "; $ty2=""; $dis="display:none;";}                 
			    if($measurements2->bm_type=="Body"){ $ty2=" checked='checked' "; $ty1=""; $dis="display:run-in;";}
			    
			    $fit="fit".$i;
			    
			    ?>
			    <script  type="text/javascript">
				    $(document).ready(function(){
					    $('#<?=$bm_type1;?>').click(function(){
						    $('#<?=$fit;?>').slideToggle();
					    });
					    $('#<?=$bm_type2;?>').click(function(){
						    $('#<?=$fit;?>').slideToggle();
					    });
				    });
			    </script>
			    <?

			    $outputString.= "<span style='float:right;'>Shirt</span><input type='radio' id='$bm_type1' name='$bm_type' value='Shirt' $ty1 />
				<span style='float:right;'>Body</span><input type='radio' id='$bm_type2' name='$bm_type' value='Body' $ty2 /><br/>";
	    
			    $outputString.= "<label>Neck (Measure Length required from button to centre of button hole)</label><input type='text' id='$bm_neck' name='$bm_neck' value='$measurements2->bm_neck' /><br/>
				<label>Chest (Measure around body well up under arm holes )</label><input type='text' id='$bm_chest' name='$bm_chest' value='$measurements2->bm_chest' /><br/>
				<label>Stomach (Measure around stomach line)</label><input type='text' id='$bm_waist' name='$bm_waist' value='$measurements2->bm_waist' /><br/>
				<label>Hips (Measure around hips at widest point of seat but not tight. )</label><input type='text' id='$bm_seat' name='$bm_seat' value='$measurements2->bm_seat' /><br/>
				<label>Back (Measure from small bone at back of neck to length required )</label><input type='text' id='$bm_back' name='$bm_back' value='{$measurements2->bm_back}' /><br/>
				<label>Sleeve length (Measure from shoulder to length desired - around elbow for long sleeve)</label><input type='text' id='$bm_arm' name='$bm_arm' value='{$measurements2->bm_arm}' /><br/>
				<label>Short sleeve (Measure from shoulder to length required)</label><input type='text' id='$bm_arm_short' name='$bm_arm_short' value='{$measurements2->bm_arm_short}' /><br/>
				<label>Cuff (Measure length required from button to centre button hole)</label><input type='text' id='$bm_cuff' name='$bm_cuff' value='{$measurements2->bm_cuff}' /><br/>
				<label>Upper arm (Measure around upper arm)</label><input type='text' id='$bm_bicep' name='$bm_bicep' value='{$measurements2->bm_bicep}' /><br/>
				<label>Shoulder (Measure back at end of shoulder)</label><input type='text' id='$bmShoulder' name='$bmShoulder' value='{$measurements2->bmShoulder}' /><br/>
				<label>Special Details</label><textarea id='$bmSpecial' name='$bmSpecial'>{$measurements2->bmSpecial}</textarea><br/>";
				// $measurements2->bmSpecial ,$item->sciSpecial
				    
			    // edit 01-11-11
			    if($measurements2->bmFit=="Standard Fit" || $measurements2->bmFit=="Mens Standard Fit"){$fit1=" selected='selected' "; }                 
			    if($measurements2->bmFit=="Slim Fit" || $measurements2->bmFit=="Mens Slim Fit"){$fit2=" selected='selected' "; }
			    if($measurements2->bmFit=="Full Cut" || $measurements2->bmFit=="Mens Full Fit"){$fit3=" selected='selected' "; }
			    if($measurements2->bmFit=="Ladies Standard Fit"){$fit4=" selected='selected' "; }                 
			    if($measurements2->bmFit=="Ladies Slim Fit"){$fit5=" selected='selected' "; }
			    if($measurements2->bmFit=="Ladies Full Cut"){$fit6=" selected='selected' "; }
			    $outputString.= "<div id='$fit' style='$dis'>";
			    $outputString.= "<label>Fit</label>
				<select id='$bmFit' name='$bmFit'>
				    <option value='Mens Standard Fit' $fit1>Mens Standard Fit</option>
				    <option value='Mens Slim Fit' $fit2>Mens Slim Fit</option>
				    <option value='Mens Full Cut' $fit3>Mens Full Cut</option>
				    <option value='Ladies Standard Fit' $fit4>Ladies Standard Fit</option>
				    <option value='Ladies Slim Fit' $fit5>Ladies Slim Fit</option>
				    <option value='Ladies Full Cut' $fit6>Ladies Full Cut</option>
				</select><br/>";
			    $outputString.= "</div>";
			    
			    //echo $measurements2->bmSoftCollar."-*-";
			    if($measurements2->bmSoftCollar==1){
				$bm_softcollar=" checked='checked' ";
			    }else{
				$bm_softcollar="";
			    }
			    
			    $outputString.= "<label>Collar size</label><input type='checkbox' name='$bmSoftCollar' id='$bmSoftCollar' value='1' $bm_softcollar /><br/>
				    <label>Height</label><input type='text' id='$bm_height' name='$bm_height' value='{$measurements2->bm_height}' /><br/>
				    <label>Weight</label><input type='text' id='$bm_weight' name='$bm_weight' value='{$measurements2->bm_weight}' /><br/>
				</div>
				<input type='hidden' name='cntnum' id='cntnum' value='$i' />
				<input type='hidden' name='$measurementsId' id='$measurementsId' value='{$measurements2->bm_id}' />
				<input type='hidden' name='$designId' id='$designId' value='{$item->sciSId}' />";
			} //n foreach
			
			$outputString.= ("<hr/></td>");
			$outputString.= ("</tr>");
			
			// onchange=\"this.form.submit();\"
		}
		/*if($numShirts<2){
			$outputString.= "
			<tr>
				<td>Delivery charge</td>
				<td></td>
				<td></td>
				<td>&pound; 4.95</td>
			</tr>";
		}	*/		
		$outputString.= "</tbody>
			</table>
			<input type='hidden' name='countItem' id='countItem' value='$i' />";
		return($outputString);		
	}
	
    public static function getItemsSizeDetails($item){
	    $sql="SELECT po_measurements FROM ts_product_order WHERE po_id ='$item' ";
	    $query=mysql_query($sql);
	    $row=mysql_fetch_array($query);
	    
	    $itemreturn = $row['po_measurements'];
	    return($itemreturn);
    }
    
    /** Get cart item name/description **/
    public static function getItemNameDescription($item){
		if($item->sciFId>0){ //SHIRT
			$fabric = tsFabrics::fabricGetCompleteCollection($item->sciFId);
			$fabric = $fabric[0];
			if($item->sciSpecial2==1){
			    $name = "Custom tailored shirt with ".$fabric->ftName.", ".$fabric->fName." fabric (Special Offer - two silky ties)";
			}else{
			    $name = "Custom tailored shirt with ".$fabric->ftName.", ".$fabric->fName." fabric";
			}
		}else{ //OTHER PRODUCT
			$productOrder = tsProductOrder::poGetOne($item->sciPoId);
			$product = tsProductTypes::productTypeGetOne($productOrder->poPtId);
			$name = $product->ptName." (".$product->pcName.")";
		}
		return($name);
	}
	
	/** Update the status of a cart **/
	public static function scUpdateStatus($scId, $scStatus, $date){
		if(self::_hasStatusChanged($scId,$scStatus)){
			$sql = "
				UPDATE ts_shoppingcart SET sc_completed=".smFunctions::checkInput($scStatus).", 
				sc_datecompleted=".smFunctions::checkInput($date)." 
				WHERE sc_id=".smFunctions::checkInput($scId)." LIMIT 1";
			mysql_query($sql)or die(mysql_error());		
		}
	}
	
	private static function _hasStatusChanged($scId, $scStatus){
		$sql = "SELECT sc_completed FROM ts_shoppingcart WHERE sc_id=".smFunctions::checkInput($scId)." LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		if($scStatus==$row['sc_completed']){
			return false;
		}else{
			return true;
		}
	}
	
	/** Delete cart **/
	public static function scDeleteCart($scId){
		//TODO: delete corresponding product orders, etc
		/*
		$sql = "DELETE FROM ts_shoppingcart WHERE sc_id=".smFunctions::checkInput($scId)." LIMIT 1";
		mysql_query($sql);
		$sql = "DELETE FROM ts_shopping_cart_items WHERE sci_sc_id=".smFunctions::checkInput($scId);
		mysql_query($sql);
		*/
	}
    
    /** Add item to shopping cart **/
    public function scAddItem($item){
		$item->sciSave($item);	
	}
    
    /** Remove item from shopping cart **/
    public static function scRemoveItem($itemId){
		tsShoppingCartItems::sciDelete($itemId);
	}
    
    /** 
	 * Number of items and total cost of cart 
	 * Vals returned are array("value"=>XX,"quantity"=>XX)
	 **/
    public static function scTotals($scId){
		$items = self::scListItems($scId);
		$value = 0;	
		$quantity = 0;
		$numShirts = 0;
		if(count($items)>0){
			foreach($items as $item){
				$value += $item->sciPrice * $item->sciQty;
				$quantity = $quantity + ($item->sciQty==""?1:$item->sciQty);
				if($item->sciFId>0){ //SHIRT
					$numShirts += $item->sciQty;
				}
				
				// TODO:: PROMOTION -----------
				$boxeritems=0;
				$sql1="SELECT * FROM ts_shopping_cart_items WHERE sci_sc_id=".$item->sciScId;
				$query1=mysql_query($sql1);
				while($row1=mysql_fetch_array($query1)){
		
					$sql2="SELECT * FROM ts_product_order WHERE po_id=".$row1['sci_po_id'];
					$query2=mysql_query($sql2);
					while($row2=mysql_fetch_array($query2)){
						
						if($row2['po_pt_id']=="22"){	// localhost is 22 , online is 41
							$sql3="SELECT * FROM ts_shopping_cart_items WHERE sci_sc_id='".$item->sciScId."' AND sci_po_id='".$row2['po_id']."' ";
							$query3=mysql_query($sql3);
							while($row3=mysql_fetch_array($query3)){
								$boxeritems += $row3['sci_qty'];
								$boxerprice = $row3['sci_price'];
							}
						}
						
					}
					
				}
				
				$bprice=0;
				if($boxeritems>2){
					for($j=1;$j<=$boxeritems;$j++){
						if($j%3==0){
							$bprice+=$boxerprice/2;
						}else{
							$bprice+=$boxerprice;
						}
					}
					$bprice = number_format($bprice,2);
					$bprice2 = number_format($boxerprice * $boxeritems,2);
				}
				// --------------------------- edit 07-01-2012
			}
		}
		
		// --------------------------- edit 07-01-2012
		if($boxeritems>2){ 
			$promotionPrice=$value-$bprice2;
		}else{ 
			$promotionPrice=$value;
		}
		
		if($promotionPrice <= 100){
			$value -= ($promotionPrice * 10) / 100;
		}else if($promotionPrice > 100 && $promotionPrice < 300){
			$value -= ($promotionPrice * 15) / 100;
		}else if($promotionPrice >= 300){
			$value -= ($promotionPrice * 25) / 100;
		}
		
		if($boxeritems>2){
			$value -= $boxerprice/2;
		}

		$value += $shippingHandlingCharge;		// totals + shipping
		
		// n to do promotion
		// --------------------------- edit 07-01-2012
		
		//$returnVals['quantity'] = count($items); //Returns num rows
		$returnVals['value'] = $value;
		$returnVals['quantity'] = $quantity;
		$returnVals['numShirts'] = $numShirts;
		return($returnVals);
	}
	
	/** Get a list of completed carts **/
	public static function scListCompletedCarts(){
		$sql = "SELECT * FROM ts_shoppingcart WHERE sc_completed='Completed'";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			$collection[] = self::_processRow($row);
		}
		return($collection);
	}
	
	/** Get member history carts **/
	public static function scListInProgressCarts($mId){
		$sql = "SELECT * FROM ts_shoppingcart WHERE sc_completed<>'InProgress' ";
		$sql.= " AND sc_m_id=".smFunctions::checkInput($mId)." ";
		$sql.= "ORDER BY sc_dateordered DESC";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			$collection[] = self::_processRow($row);
		}
		return($collection);
	}
	
	/** Get all member carts **/
	public static function scListOrders($filter="",$status="",$limit="",$role){
		$sql = "
			SELECT * FROM ts_shoppingcart AS sc 
			INNER JOIN ts_members AS mem ON sc.sc_m_id=mem.m_id ";
		if($role==4){
			$sql.= "WHERE sc.sc_completed<>'InProgress' ";
		}elseif($role==3){
			$sql.= "WHERE sc.sc_completed<>'InProgress' ";	
		}else{
			$sql.= "WHERE sc.sc_completed='Processing' OR sc.sc_completed='InProduction' OR sc.sc_completed='Shipped' ";	
		}
		if($filter!=""){
			$sql.="AND (";
			$aryKeywords = explode(" ",$filter);
			$counter = 0;
			foreach($aryKeywords as $keyword){
				if($counter>0)
					$sql.= " OR ";
				$sql.="(mem.m_username LIKE '%".smFunctions::checkInput(trim($keyword),true)."%' OR ";
				$sql.="mem.m_firstname LIKE '%".smFunctions::checkInput(trim($keyword),true)."%' OR ";
				$sql.="mem.m_lastname LIKE '%".smFunctions::checkInput(trim($keyword),true)."%' OR ";
				$sql.="mem.m_address LIKE '%".smFunctions::checkInput(trim($keyword),true)."%' OR ";
				$sql.="mem.m_email LIKE '%".smFunctions::checkInput(trim($keyword),true)."%')";	
				$counter++;
			}
			$sql.=")";
		}
		if($status!="" && $status!="0"){
			$sql.="AND sc.sc_completed LIKE '".smFunctions::checkInput(trim($status),true)."' ";
		}else{
			$sql.="AND sc.sc_completed NOT LIKE 'Completed' ";
		}
		$sql.= "ORDER BY sc.sc_dateordered DESC ";
		if($limit!="")
			$sql.= "LIMIT ".$limit;
		$query = mysql_query($sql)or die(mysql_error());
		while($row = mysql_fetch_array($query)){
			$collection[] = self::_processRow($row);		
		}
		return($collection);
	}
	    
    /** Get collection of items in shopping cart **/
    public static function scListItems($scId){
		$items = new tsShoppingCartItems;
		return($items->sciGetCartItems($scId));
	}
    
    /**
     * Get a members incomplete cart
	 * If none available, then create one
	 */
	public static function scGetInProgressMemberCart($scMId){
		$cart = new tsShoppingCart;
		$sql = "SELECT * FROM ts_shoppingcart WHERE sc_m_id=".smFunctions::checkInput($scMId)." 
				AND sc_completed='InProgress'";
		$query = mysql_query($sql);
		if(mysql_num_rows($query)==0){ //No cart available
			$cart->scMId = $scMId;
			$cart->scId = self::scSave($cart);
		}else{
			$row = mysql_fetch_array($query);
			$cart = self::_processRow($row);
		}
		return($cart);
	}    
    
    /** Get all carts by member id **/
    public function scGetCartsByMemberId($scMId){
		$sql = "SELECT * FROM ts_shoppingcart WHERE sc_m_id=".smFunctions::checkInput($scMId)." ";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			$collection[] = $this->_processRow($row);
		}
		return($collection);
	}
    
    /** Return shopping cart details **/
    public static function scGetDetails($scId){
		$sql = "SELECT * FROM ts_shoppingcart WHERE sc_id=".smFunctions::checkInput($scId)." ";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		return(self::_processRow($row));
	}

    /** Save a shopping cart object **/
    public function scSave($shoppingCart){
        if($shoppingCart->scId>0){
            $id = $shoppingCart->_update($shoppingCart);
        }else{
            $shoppingCart->scCompleted = "InProgress"; //Set new cart as InProgress
            $id = $shoppingCart->_insert($shoppingCart);
        }
        return($id);
    }

    //Private functions

    private function _insert($sc){
        $sql = "INSERT INTO ts_shoppingcart SET ";
        $sql.= self::_processInsertUpdate($sc);
        mysql_query($sql);
        return(mysql_insert_id());
    }

    private function _update($sc){
        $sql = "UPDATE ts_shoppingcart SET ";
        $sql.= self::_processInsertUpdate($sc);
        $sql.= "WHERE sc_id=".smFunctions::checkInput($sc->scId);
        mysql_query($sql);
        return($sc->scId);
    }

    private static function _processInsertUpdate($sc){
    	$sql = "sc_dateordered=".smFunctions::checkInput($sc->scDateOrdered).","; 
        $sql.= "sc_completed=".smFunctions::checkInput($sc->scCompleted).",";
        $sql.= "sc_datecompleted=".smFunctions::checkInput($sc->scDateCompleted).",";
        $sql.= "sc_sys_ref=".smFunctions::checkInput($sc->scSysRef).",";
        $sql.= "sc_gateway=".smFunctions::checkInput($sc->scGateway).",";
        $sql.= "sc_gateway_ref=".smFunctions::checkInput($sc->scGatewayRef).",";
        $sql.= "sc_calculated_value=".smFunctions::checkInput($sc->scCalculatedValue).",";
        $sql.= "sc_returned_value=".smFunctions::checkInput($sc->scReturnedValue).",";
        $sql.= "sc_delivery_address=".smFunctions::checkInput($sc->scDeliveryAddress).",";
	$sql.= "sc_special_details=".smFunctions::checkInput($sc->scSpecialDetails).",";
        $sql.= "sc_adminnotes=".smFunctions::checkInput($sc->scAdminNotes).",";
        $sql.= "sc_m_id=".smFunctions::checkInput($sc->scMId)." ";
        return($sql);
    }

    private static function _processRow($row){
        $sc = new tsShoppingCart;
        $sc->scId = $row['sc_id'];
        $sc->scDateAdded = $row['sc_dateadded'];
        $sc->scDateOrdered = $row['sc_dateordered'];
        $sc->scCompleted = $row['sc_completed'];
        $sc->scDateCompleted = $row['sc_datecompleted'];
        $sc->scSysRef = $row['sc_sys_ref'];
        $sc->scGateway = $row['sc_gateway'];
        $sc->scGatewayRef = $row['sc_gateway_ref'];
        $sc->scCalculatedValue = $row['sc_calculated_value'];
        $sc->scReturnedValue = $row['sc_returned_value'];
        $sc->scDeliveryAddress = $row['sc_delivery_address'];
	$sc->scSpecialDetails = $row['sc_special_details'];
        $sc->scAdminNotes = $row['sc_adminnotes'];
        $sc->scMId = $row['sc_m_id'];
        return($sc);
    }
    
    public function editThisOrders($id){
	$sql = "SELECT * FROM ts_shoppingcart WHERE sc_id = '$id' ";
	$query = mysql_query($sql)or die(mysql_error());
	$row = mysql_fetch_array($query);
	$items = self::_processRow($row);		
	return $items;
    }
}

/**
 * ts_shopping_cart_items
 */
class tsShoppingCartItems {
    public $sciId;
    public $sciMeasurementType;
    public $sciPrice;
    public $sciQty;
    public $sciSId;
    public $sciFId;
    public $sciSmId;
    public $sciBmId;
    public $sciScId;
    public $sciPoId;

    //Public functions
  
    //TODO:: Edit Order
    /** Return index of all items by shopping cart Id **/
    public function sciGetCartItems($scId){
		$sql = "SELECT * FROM ts_shopping_cart_items WHERE sci_sc_id=".smFunctions::checkInput($scId)." ORDER BY sci_id ASC ";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			$collection[] = $this->_processRow($row);
		}
		return($collection);
	}
    
    /** Delete item from shopping cart **/
	public static function sciDelete($sciId){
	    /*
		$sql = "DELETE FROM ts_shopping_cart_items WHERE sci_id=".smFunctions::checkInput($sciId)." LIMIT 1";
		//TODO: Check if cart item has product order id and delete from po table aswell
		//echo($sql);
		mysql_query($sql)or die(mysql_error());
	    */
	}

	/** Add item to shopping cart **/
    public function sciSave($shoppingCartItem){
        if($shoppingCartItem->sciId>0){
            $id = $this->_update($shoppingCartItem);
        }else{
            $id = $this->_insert($shoppingCartItem);
        }
        return($id);
    }

    //Private functions

    private function _insert($sci){
        $sql = "INSERT INTO ts_shopping_cart_items SET ";
        $sql.= $this->_processInsertUpdate($sci);
        mysql_query($sql);
        return(mysql_insert_id());
    }

    private function _update($sci){
        $sql = "UDPATE ts_shopping_cart_items SET ";
        $sql.= $this->_processInsertUpdate($sci);
        $sql.= "WHERE sci_id=".smFunctions::checkInput($sci->sciId);
        mysql_query($sql);
        return($sci->sciId);
    }

    private function _processInsertUpdate($sci){
        $sql = "sci_measurement_type=".smFunctions::checkInput($sci->sciMeasurementType).",";
	
	$sql.= "sci_sm_id=".smFunctions::checkInput($sci->sciSmId).",";
        $sql.= "sci_bm_id=".smFunctions::checkInput($sci->sciBmId).",";
	
	//if($_SESSION['affilate']){	price discount 50% both order
	//if($_SESSION['affilate']){	    // price discount 50% only order by Measurements
	//    $sql.= "sci_price=".smFunctions::checkInput($sci->sciPrice/2).",";
	//}else{
	    $sql.= "sci_price=".smFunctions::checkInput($sci->sciPrice).",";
	//}
	$sql.= "sci_special2=".smFunctions::checkInput($sci->sciSpecial2).",";
        $sql.= "sci_qty=".smFunctions::checkInput($sci->sciQty).",";
        $sql.= "sci_s_id=".smFunctions::checkInput($sci->sciSId).",";
        $sql.= "sci_f_id=".smFunctions::checkInput($sci->sciFId).",";
        
        $sql.= "sci_sc_id=".smFunctions::checkInput($sci->sciScId).",";
        $sql.= "sci_po_id=".smFunctions::checkInput($sci->sciPoId)." ";
        return($sql);
    }

    private static function _processRow($row){
        $sci = new tsShoppingCartItems;
        $sci->sciId = $row['sci_id'];
        $sci->sciMeasurementType = $row['sci_measurement_type'];
        $sci->sciPrice = $row['sci_price'];
        $sci->sciQty = $row['sci_qty'];
        $sci->sciSId = $row['sci_s_id'];
        $sci->sciFId = $row['sci_f_id'];
        $sci->sciSmId = $row['sci_sm_id'];
        $sci->sciBmId = $row['sci_bm_id'];
        $sci->sciScId = $row['sci_sc_id'];
        $sci->sciPoId = $row['sci_po_id'];
	$sci->sciSpecial = $row['sci_special'];
	$sci->sciSpecial2 = $row['sci_special2'];
        return($sci);
    }
}

/**
 * ts_product_order
 */
class tsProductOrder {
	public $poId;
	public $poMeasurements;
	public $poOrderPrice;
	public $poPtId;
	
	//Public functions
	
	/** return details of a single product order **/
	public static function poGetOne($poId){
		$sql = "SELECT * FROM ts_product_order WHERE po_id=".smFunctions::checkInput($poId)." LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		return(self::_processRow($row));		
	}
	
	public function save($productOrder){
		if($productOrder->poId>0){
			$id = self::_update($productOrder);
		}else{
			$id = self::_insert($productOrder);
		}
		return($id);
	}
	//Private functions
	
	private function _insert($productOrder){
		$sql = "INSERT INTO ts_product_order SET ";
		$sql.= self::_processInsertUpdate($productOrder);
		mysql_query($sql);
		return(mysql_insert_id());
	}

	private function _update($productOrder){
		$sql = "UPDATE ts_product_order SET ";
		$sql.= self::_processInsertUpdate($productOrder);
		$sql.= "WHERE po_id=".smFunctions::checkInput($productOrder->poId);
		mysql_query($sql);
		return($productOrder->poId);
	}

	private static function _processInsertUpdate($productOrder){
		$sql = "po_measurements=".smFunctions::checkInput($productOrder->poMeasurements).",";
		$sql.= "po_order_price=".smFunctions::checkInput($productOrder->poOrderPrice).",";
		$sql.= "po_pt_id=".smFunctions::checkInput($productOrder->poPtId)." ";
		return($sql);
	}

	private function _processRow($row){
		$po = new tsProductOrder;
		$po->poId = $row['po_id'];
		$po->poMeasurements = $row['po_measurements'];
		$po->poOrderPrice = $row['po_order_price'];
		$po->poPtId = $row['po_pt_id'];
		return($po);	
	}
} 
?>