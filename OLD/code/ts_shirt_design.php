<?php

/** ts_shirt_design **/
class tsShirtDesign {
	public $sId, $sFit, $sCollar, $sCollarWhite, $sSleeve, $sCuff, $sCuffWhite,
		$sFastening, $sPocket, $sEpaulettes, $sPocketFlaps, $sBackPleats,
		$sCollarHeight, $sBottomCut, $sCuffStyle, $sSleeveWidth, $sPlacketButton,
		$sButton, $sContrastButtonHoleTread, $sRemovableCollarStays,
		$sContrastCollarCuffFabric, $sEmbroideryPosition, $sEmbroideryFont,
		$sEmbroideryColor, $sEmbroideryText, $sMId;
	
	// Public functions
	
	public static function sdPut($str){
		echo("<li style='list-style:none;'>".$str."</li>");
	}
	
	/** Lists chosen shirt design options **/
	public static function sdPutDesignDetails($sd){
		?>
		<ul style=" padding-left:10px;">
			<?php
				//Fit edit 01-11-11
				/*if($sd->sFit=="3"){
					self::sdPut("Fit: Mens Loose Fit");
				}else if($sd->sFit=="2"){
					self::sdPut("Fit: Mens Slim fit");
				}else if($sd->sFit=="1"){
					self::sdPut("Fit: Mens Normal fit");
				}else if($sd->sFit=="6"){
					self::sdPut("Fit: Ladies Loose fit");
				}else if($sd->sFit=="4"){
					self::sdPut("Fit: Ladies Normal fit");
				}else if($sd->sFit=="5"){
					self::sdPut("Fit: Ladies Slim fit");
				}*/
				
				//Color
				if(!empty($sd->sColor)){
					$sqlColor=mysql_query("SELECT * FROM ts_color WHERE c_id=".$sd->sColor);
					$rowColor=mysql_fetch_array($sqlColor);
					self::sdPut("Color: ".$rowColor['c_name']." (".$rowColor['c_code'].")");
				}
				
				//White collar
				//$whiteCollar = " collar";
				$whiteCollar = "";
				if($sd->sCollarWhite=="1"){
					//$whiteCollar .= " (White fabric)";
					$whiteCollar = " (White collar)";
				}
				
				//Collar
				switch ($sd->sCollar){
					case 10:
						self::sdPut("Collar: Soft Collar".$whiteCollar);
						break;
					case 9:
						self::sdPut("Collar: Hawaiian".$whiteCollar);
						break;
					case 8:
						self::sdPut("Collar: Rounded".$whiteCollar);
						break;
					case 7:
						self::sdPut("Collar: Mandarin".$whiteCollar);
						break;
					case 6:
						self::sdPut("Collar: Button down".$whiteCollar);
						break;
					/*case 5:
						self::sdPut("Collar: Long".$whiteCollar);
						break;*/
					case 4:
						self::sdPut("Collar: Italian (Cut away)".$whiteCollar);
						break;
					/*case 3:
						self::sdPut("Collar: Full spread".$whiteCollar);
						break;
					case 2:
						self::sdPut("Collar: Business".$whiteCollar);
						break;*/
					default:
						self::sdPut("Collar: Classic".$whiteCollar);
				}
				
				//Sleeves
				$sleeves = " sleeves";
				switch ($sd->sSleeve){
					case 4:
						self::sdPut("Sleeve: Roll up".$sleeves);
						break;
					case 3:
						self::sdPut("Sleeve: Short with cuff".$sleeves);
						break;
					case 2:
						self::sdPut("Sleeve: Short".$sleeves);
						break;
					default:
						self::sdPut("Sleeve: Long".$sleeves);
				}

				//Cuffs
				if($sd->sSleeve<2){ // Long sleeves selected, find out cuff type
					$placketButton = " ";
					if($sd->sPlacketButton==1){
						$placketButton = " with placket buttons";
					}
					$whiteCuff = "";
					if($sd->sCuffWhite==1){
						$whiteCuff = " (White cuff)";
					}
					switch ($sd->sCuff){
						case 8:
							self::sdPut("Cuff Style: Single Rounded".$placketButton.$whiteCuff);
							break;
						case 7:
							self::sdPut("Cuff Style: Angled".$placketButton.$whiteCuff);
							break;
						case 6:
							self::sdPut("Cuff Style: French Rounded".$placketButton.$whiteCuff);
							break;
						case 5:
							self::sdPut("Cuff Style: French".$placketButton.$whiteCuff);
							break;
						case 4:
							self::sdPut("Cuff Style: Single Cufflink".$placketButton.$whiteCuff);
							break;
						case 3:
							self::sdPut("Cuff Style: Triple button".$placketButton.$whiteCuff);
							break;
						case 2:
							self::sdPut("Cuff Style: Two button".$placketButton.$whiteCuff);
							break;
						default:
							self::sdPut("Cuff Style: Single button".$placketButton.$whiteCuff);
					}
				}

				//Fastening
				switch ($sd->sFastening){
					case 3:
						self::sdPut("Fastening: Fly");
						break;
					case 2:
						self::sdPut("Fastening: Plackett");
						break;
					default:
						self::sdPut("Fastening: French");
				}

				//Pockets
				if($sd->sPocket>0){
					$flaps = " without flap";
					if($sd->sPocketFlaps==1){
						$flaps = " with flap";
					}
					switch($sd->sPocket){
						case 9:
							self::sdPut("Pockets: 2 box pleat pockets".$flaps."s");
							break;
						case 8:
							self::sdPut("Pockets: Box pleat pocket".$flaps."");
							break;
						case 7:
							self::sdPut("Pockets: 2 inverted pleat pockets".$flaps."s");
							break;
						case 6:
							self::sdPut("Pockets: Inverted pleat pocket".$flaps."");
							break;
						case 5:
							self::sdPut("Pockets: 2 v-shaped pockets".$flaps."s");
							break;
						case 4:
							self::sdPut("Pockets: 2 classic pockets".$flaps."s");
							break;
						case 3:
							self::sdPut("Pockets: V-shaped pocket".$flaps);
							break;
						case 2:
							self::sdPut("Pockets: Classic pocket".$flaps);
							break;
						default:
							self::sdPut("Pockets: No pockets");
					}
				}

				//Epaulettes
				if($sd->sEpaulettes==1){
					self::sdPut("Epaulettes");
				}

				//Embroidery text
				if($sd->sEmbroideryText!=""){
					$embroidery = $sd->sEmbroideryText." embroidered in ";
					switch($sd->sEmbroideryColor){
						case 7:
							self::sdPut("Embroidery: ".$embroidery."black");
							break;
						case 6:
							self::sdPut("Embroidery: ".$embroidery."pink");
							break;
						case 5:
							self::sdPut("Embroidery: ".$embroidery."white");
							break;
						case 4:
							self::sdPut("Embroidery: ".$embroidery."yellow");
							break;
						case 3:
							self::sdPut("Embroidery: ".$embroidery."red");
							break;
						case 2:
							self::sdPut("Embroidery: ".$embroidery."green");
							break;
						case 1:
							self::sdPut("Embroidery: ".$embroidery."blue");
							break;
						default:
							self::sdPut("Embroidery: ".$embroidery."Same as shirt");
					}
				}

				//Back pleats
				switch($sd->sBackPleats){
					case 2:
						self::sdPut("Back: No pleats");
						break;
					case 1:
						self::sdPut("Back: Side pleats");
						break;
					default:
						self::sdPut("Back: Center");
						
					/*case 2:
						self::sdPut("Side Pleats: Side pleats on back");
						break;
					case 1:
						self::sdPut("Side Pleats: Center pleats on back");
						break;
					default:
						self::sdPut("Side Pleats: No pleats on back");*/	
				}

				//Bottom cut
				switch($sd->sBottomCut){
					case 1:
						self::sdPut("Hem: Straight");
						break;
					/*case 2:
						self::sdPut("Hem cut: Straight");
						break;*/
					default:
						self::sdPut("Hem: Fishtail");
						
					/*case 1:
						self::sdPut("Hem cut: Fishtail hem bottom cut");
						break;
					case 2:
						self::sdPut("Hem cut: Plain hem with side vent");
						break;
					case 3:
						self::sdPut("Hem cut: Fishtail hem with side vent");
						break;
					default:
						self::sdPut("Hem cut: Plain hem bottom cut");	*/
				}
			?>
			</ul>
		<?php		
	}
	
	/** Return details of a shirt design by Id **/
	public static function sdGetOne($sId){
		$sql = "SELECT * FROM ts_shirt_design WHERE s_id=".smFunctions::checkInput($sId)." ";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		return(self::_processRow($row));
	}
	
	/** Save the design **/
	public function sdSave($shirtDesign){
		if($shirtDesign->sId>0){
			$id = $shirtDesign->_update($shirtDesign);
		}else{
			$id = $shirtDesign->_insert($shirtDesign);
		}
		return($id);
	}
	
	// Private functions
	
	private function _update($sd){
		$sql = "UPDATE ts_shirt_design SET ";
		$sql.= $sd->_processInsertUpdate($sd);
		$sql.= "WHERE s_id=".smFunctions::checkInput($sd->sId);
		mysql_query($sql);
		return($sd->sId);
	}
	
	private function _insert($sd){
		$sql = "INSERT INTO ts_shirt_design SET ";
		$sql.= $sd->_processInsertUpdate($sd);
		mysql_query($sql);
		return(mysql_insert_id());
	}
	
	private function _processInsertUpdate($sd){
		$sql = "s_fit=".smFunctions::checkInput($sd->sFit).",";
		$sql.= "s_color=".smFunctions::checkInput($sd->sColor).",";
		$sql.= "s_collar=".smFunctions::checkInput($sd->sCollar).",";
		$sql.= "s_collar_white=".smFunctions::checkInput($sd->sCollarWhite).",";
		$sql.= "s_sleeve=".smFunctions::checkInput($sd->sSleeve).",";
		$sql.= "s_cuff=".smFunctions::checkInput($sd->sCuff).",";
		$sql.= "s_cuff_white=".smFunctions::checkInput($sd->sCuffWhite).",";
		$sql.= "s_fastening=".smFunctions::checkInput($sd->sFastening).",";
		$sql.= "s_pocket=".smFunctions::checkInput($sd->sPocket).",";
		$sql.= "s_epaulettes=".smFunctions::checkInput($sd->sEpaulettes).",";
		$sql.= "s_pocket_flaps=".smFunctions::checkInput($sd->sPocketFlaps).",";
		$sql.= "s_back_pleats=".smFunctions::checkInput($sd->sBackPleats).",";
		$sql.= "s_collar_height=".smFunctions::checkInput($sd->sCollarHeight).",";
		$sql.= "s_bottom_cut=".smFunctions::checkInput($sd->sBottomCut).",";
		$sql.= "s_cuff_style=".smFunctions::checkInput($sd->sCuffStyle).",";
		$sql.= "s_sleeve_width=".smFunctions::checkInput($sd->sSleeveWidth).",";
		$sql.= "s_placket_button=".smFunctions::checkInput($sd->sPlacketButton).",";
		$sql.= "s_button=".smFunctions::checkInput($sd->sButton).",";
		$sql.= "s_contrast_button_hole_thread=".smFunctions::checkInput($sd->sContrastButtonHoleTread).",";
		$sql.= "s_removable_collar_stays=".smFunctions::checkInput($sd->sRemovableCollarStays).",";
		$sql.= "s_contrast_collar_cuff_fabric=".smFunctions::checkInput($sd->sContrastCollarCuffFabric).",";
		$sql.= "s_embroidery_position=".smFunctions::checkInput($sd->sEmbroideryPosition).",";
		$sql.= "s_embroidery_font=".smFunctions::checkInput($sd->sEmbroideryFont).",";
		$sql.= "s_embroidery_color=".smFunctions::checkInput($sd->sEmbroideryColor).",";
		$sql.= "s_embroidery_text=".smFunctions::checkInput($sd->sEmbroideryText).",";
		$sql.= "s_m_id=".smFunctions::checkInput($sd->sMId)." ";
		return($sql);
	}
	
	private static function _processRow($row){
		$sd = new tsShirtDesign;
		$sd->sId = $row['s_id'];
		$sd->sFit = $row['s_fit'];
		$sd->sColor = $row['s_color'];
		$sd->sCollar = $row['s_collar'];
		$sd->sCollarWhite = $row['s_collar_white'];
		$sd->sSleeve = $row['s_sleeve'];
		$sd->sCuff = $row['s_cuff'];
		$sd->sCuffWhite = $row['s_cuff_white'];
		$sd->sFastening = $row['s_fastening'];
		$sd->sPocket = $row['s_pocket'];
		$sd->sEpaulettes = $row['s_epaulettes'];
		$sd->sPocketFlaps = $row['s_pocket_flaps'];
		$sd->sBackPleats = $row['s_back_pleats'];
		$sd->sCollarHeight = $row['s_collar_height'];
		$sd->sBottomCut = $row['s_bottom_cut'];
		$sd->sCuffStyle = $row['s_cuff_style'];
		$sd->sSleeveWidth = $row['s_sleeve_width'];
		$sd->sPlacketButton = $row['s_placket_button'];
		$sd->sButton = $row['s_button'];
		$sd->sContrastButtonHoleTread = $row['s_contrast_button_hole_thread'];
		$sd->sRemovableCollarStays = $row['s_removable_collar_stays'];
		$sd->sContrastCollarCuffFabric = $row['s_contrast_collar_cuff_fabric'];
		$sd->sEmbroideryPosition = $row['s_embroidery_position'];
		$sd->sEmbroideryFont = $row['s_embroidery_font'];
		$sd->sEmbroideryColor = $row['s_embroidery_color'];
		$sd->sEmbroideryText = $row['s_embroidery_text'];
		$sd->sMId = $row['s_m_id'];
		return($sd);
	}
}

?>