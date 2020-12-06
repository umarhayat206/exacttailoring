<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
	$("#sFit").change(function(){
		//if($("#sFit").val()=="1" ){		// edit 01-11-11
		if($("#sFit").val()=="1" || $("#sFit").val()=="4"){
			$("#shirtBody").css({"background":"url('images_shirt/body_normal.gif')"});
		}else if($("#sFit").val()=="2" || $("#sFit").val()=="5"){
			$("#shirtBody").css({"background":"url('images_shirt/body_slim.gif')"});
		}else if($("#sFit").val()=="3" || $("#sFit").val()=="6"){
			$("#shirtBody").css({"background":"url('images_shirt/body_loose.gif')"});
		}
	})
	$("#sCollar").change(function(){
		if($("#sCollar").val()=="1"){
			$("#shirtCollars").css({"background":"url('images_shirt/collars_classic.gif')"});
		}else if($("#sCollar").val()=="2"){
			$("#shirtCollars").css({"background":"url('images_shirt/collars_business.gif')"});
		}else if($("#sCollar").val()=="3"){
			$("#shirtCollars").css({"background":"url('images_shirt/collars_full_spread.gif')"});
		}else if($("#sCollar").val()=="4"){
			$("#shirtCollars").css({"background":"url('images_shirt/collars_cut_away.gif')"});
		}else if($("#sCollar").val()=="5"){
			$("#shirtCollars").css({"background":"url('images_shirt/collars_long.gif')"});
		}else if($("#sCollar").val()=="6"){
			$("#shirtCollars").css({"background":"url('images_shirt/collars_button_down.gif')"});
		}else if($("#sCollar").val()=="7"){
			$("#shirtCollars").css({"background":"url('images_shirt/collars_mao.gif')"});
		}else if($("#sCollar").val()=="8"){
			$("#shirtCollars").css({"background":"url('images_shirt/collars_rounded.gif')"});
		}else if($("#sCollar").val()=="9"){
			$("#shirtCollars").css({"background":"url('images_shirt/collars_hawaiian.gif')"});
		/*}else if($("#sCollar").val()=="10"){	// Soft Collar
			$("#shirtCollars").css({"background":"url('images_shirt/collars_hawaiian.gif')"});	*/
		}
	})
	$("#sSleeve").change(function(){
		if($("#sSleeve").val()=="1"){
			$("#shirtArms").css({"background":"url('images_shirt/arms_long.gif')"});
		}else if($("#sSleeve").val()=="2"){
			$("#shirtArms").css({"background":"url('images_shirt/arms_short.gif')"});
		}else if($("#sSleeve").val()=="3"){
			$("#shirtArms").css({"background":"url('images_shirt/arms_short_cuff.gif')"});
		}else if($("#sSleeve").val()=="4"){
			$("#shirtArms").css({"background":"url('images_shirt/arms_roll_up.gif')"});
		}
		if($("#sSleeve").val()!="1"){
			$("#shirtPlacketButton").css({"display":"none"});
			$("#shirtCuffs").css({"display":"none"});
		}else{
			$("#shirtPlacketButton").css({"display":"block"});
			$("#shirtCuffs").css({"display":"block"});
		}
	})
	$("#sCuff").change(function(){
		if($("#sCuff").val()=="1"){
			$("#shirtCuffs").css({"background":"url('images_shirt/cuffs_single_button.gif')"});		//
		}else if($("#sCuff").val()=="2"){
			$("#shirtCuffs").css({"background":"url('images_shirt/cuffs_double_button.gif')"});	//
		}else if($("#sCuff").val()=="3"){
			$("#shirtCuffs").css({"background":"url('images_shirt/cuffs_triple.gif')"});	
		}else if($("#sCuff").val()=="4"){
			$("#shirtCuffs").css({"background":"url('images_shirt/cuffs_convertable.gif')"});	
		}else if($("#sCuff").val()=="5"){
			$("#shirtCuffs").css({"background":"url('images_shirt/cuffs_french.gif')"});	//
		}else if($("#sCuff").val()=="6"){
			$("#shirtCuffs").css({"background":"url('images_shirt/cuffs_french_rounded.gif')"});	//
		}else if($("#sCuff").val()=="7"){
			$("#shirtCuffs").css({"background":"url('images_shirt/cuffs_angled.gif')"});	//
		}
	})
	$("#sFastening").change(function(){
		if($("#sFastening").val()=="1"){
			//$("#shirtButtons").css({"background":"url('images_shirt/buttons.gif')"});
			//$("#shirtPlackets").css({"background":"url('images_shirt/plackets.gif')"});
			$("#shirtButtons").css({"background":"url('images_shirt/buttons.gif')"});
			$("#shirtPlackets").css({"background":"none"});
		}else if($("#sFastening").val()=="2"){
			//$("#shirtButtons").css({"background":"url('images_shirt/buttons.gif')"});
			//$("#shirtPlackets").css({"background":"none"});
			$("#shirtButtons").css({"background":"url('images_shirt/buttons.gif')"});
			$("#shirtPlackets").css({"background":"url('images_shirt/plackets.gif')"});
		}else if($("#sFastening").val()=="3"){
			$("#shirtButtons").css({"background":"none"});
			$("#shirtPlackets").css({"background":"none"});
		}
	})
	$("#sPocket").change(function(){
		if($("#sPocket").val()=="1"){
			$("#shirtPockets").css({"background":"none"});
		}else if($("#sPocket").val()=="2"){
			$("#shirtPockets").css({"background":"url('images_shirt/pockets_straight.gif')"});
		}else if($("#sPocket").val()=="3"){
			$("#shirtPockets").css({"background":"url('images_shirt/pockets_vshape.gif')"});
		}else if($("#sPocket").val()=="4"){
			$("#shirtPockets").css({"background":"url('images_shirt/pockets_straight_2.gif')"});
		}else if($("#sPocket").val()=="5"){
			$("#shirtPockets").css({"background":"url('images_shirt/pockets_vshape_2.gif')"});
		}else if($("#sPocket").val()=="6"){
			$("#shirtPockets").css({"background":"url('images_shirt/pockets_inverted.gif')"});
		}else if($("#sPocket").val()=="7"){
			$("#shirtPockets").css({"background":"url('images_shirt/pockets_inverted_2.gif')"});
		}else if($("#sPocket").val()=="8"){
			$("#shirtPockets").css({"background":"url('images_shirt/pockets_box.gif')"});
		}else if($("#sPocket").val()=="9"){
			$("#shirtPockets").css({"background":"url('images_shirt/pockets_box_2.gif')"});
		}
		$("#sPocketFlaps").removeAttr("checked");
		$("#shirtFlaps").css({"background":"none"});
	})
	$("#sPocketFlaps").change(function(){
		if(($("#sPocketFlaps").attr("checked") && $("#sPocket").val()=="2")||
		   ($("#sPocketFlaps").attr("checked") && $("#sPocket").val()=="3")||
		   ($("#sPocketFlaps").attr("checked") && $("#sPocket").val()=="6")||
		   ($("#sPocketFlaps").attr("checked") && $("#sPocket").val()=="8")){
			$("#shirtFlaps").css({"background":"url('images_shirt/pocket_flap.gif')"});
		}else if(($("#sPocketFlaps").attr("checked") && $("#sPocket").val()=="4")||
				 ($("#sPocketFlaps").attr("checked") && $("#sPocket").val()=="5")||
				 ($("#sPocketFlaps").attr("checked") && $("#sPocket").val()=="7")||
				 ($("#sPocketFlaps").attr("checked") && $("#sPocket").val()=="9")){
			$("#shirtFlaps").css({"background":"url('images_shirt/pocket_flaps_2.gif')"});
		}else{
			$("#shirtFlaps").css({"background":"none"});
		}
	})
	$("#sPlacketButton").change(function(){
		if($("#sPlacketButton").attr("checked")){
			$("#shirtPlacketButton").css({"background":"url('images_shirt/placket_buttons.gif')"});
		}else{
			$("#shirtPlacketButton").css({"background":"none"});
		}
	})
	$("#sEpaulettes").change(function(){
		if($("#sEpaulettes").attr("checked")){
			$("#shirtEpaulettes").css({"background":"url('images_shirt/epaulettes.gif')"});
		}else{
			$("#shirtEpaulettes").css({"background":"none"});
		}
	})
})
//]]>
</script>

<form id="shirtDesignerForm" method="post" action="<?php echo($_SERVER['PHP_SELF']);?>">
	<h3>Shirt designer</h3>
	<div id="shirtView">
		<div id="shirtBody" style="background: url('images_shirt/body_normal.gif')">
		<div id="shirtArms" style="background: url('images_shirt/arms_long.gif')">
		<div id="shirtPlackets" style="background: url('images_shirt/plackets.gif')">
		<div id="shirtPockets">
		<div id="shirtPocketFlaps">
		<div id="shirtButtons" style="background: url('images_shirt/buttons.gif')">
		<div id="shirtCollars" style="background: url('images_shirt/collars_classic.gif')">
		<div id="shirtTopButton" style="background: url('images_shirt/top_button.gif')">
		<div id="shirtEpaulettes">
		<div id="shirtFlaps">
		<div id="shirtPlacketButton">
		<div id="shirtCuffs" style="background: url('images_shirt/cuffs_angled.gif')">
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
	</div>
	
	<?
	$sqlFabricTypeID=mysql_query("SELECT f_ft_id FROM ts_fabrics WHERE f_id=".$_GET['fId']);
	$rowFabricTypeID=mysql_fetch_array($sqlFabricTypeID);
	$ft_ID=$rowFabricTypeID['f_ft_id'];
	
	$sqlFabricTypeName=mysql_query("SELECT ft_name FROM ts_fabric_type WHERE ft_id=".$ft_ID);
	$rowFabricTypeName=mysql_fetch_array($sqlFabricTypeName);
	$ft_name=$rowFabricTypeName['ft_name'];
	
	if($ft_name=="Pyjamas" || $ft_name=="Ladies Shirts"){
	?>
	<fieldset>
		<label>Color</label>
		<select id="sColor" name="sColor">
			<option value=""></option>
			<?php
			$sqlColor=mysql_query("SELECT * FROM ts_color");
			while($rowColor=mysql_fetch_array($sqlColor)){
				echo "<option value='{$rowColor['c_id']}'>{$rowColor['c_name']} ({$rowColor['c_code']})</option>";	
			}
			?>
		</select>
	</fieldset>
	<? } ?>
	
	<fieldset>
		<?php smControls::smDropDownList("Fit","sFit",array(
			"1"=>"Mens Normal",
			"2"=>"Mens Slim",
			"3"=>"Mens Loose",
			"4"=>"Ladies Normal",
			"5"=>"Ladies Slim",
			"6"=>"Ladies Loose"	
			));?><br />
	</fieldset>
	<fieldset>
		<?php
		/*
		array(
			"1"=>"Classic",
			"2"=>"Business",
			"3"=>"Full spread",
			"4"=>"Italian (Cut Away)",
			"5"=>"Long",
			"6"=>"Button down",
			"7"=>"Mandarin")
		*/
		?>
		<?php smControls::smDropDownList("Collar","sCollar",array(
			"1"=>"Classic",
			"8"=>"Rounded",
			"9"=>"Hawaiian",
			"4"=>"Italian (Cut Away)",
			"6"=>"Button down",
			"7"=>"Mandarin",
			"10"=>"Soft Collar"));
		
			/*"1"=>"Classic",
			"8"=>"Rounded",
			"9"=>"Hawaiian",
			"4"=>"Italian (Cut Away)",
			"6"=>"Button down",
			"7"=>"Mandarin"));*/
		?><br />
		<?php smControls::smCheckBox("White collar","sCollarWhite","1");?><br />
	</fieldset>
	<fieldset>
		<?php smControls::smDropDownList("Sleeves","sSleeve",array(
			"1"=>"Long",
			"2"=>"Short"));
		//Following removed - Not in catalogue
		//,
		//	"3"=>"Short with cuff",
		//	"4"=>"Roll up"
		
		?><br />
		<?php smControls::smDropDownList("Cuffs","sCuff",array(
			"7"=>"Angled",
			"1"=>"Single Button",
			"2"=>"Two Button",
			"4"=>"Single Cufflink",
			"5"=>"French",
			"6"=>"French Rounded",
			"8"=>"Rounded"));?><br />
		<?php smControls::smCheckBox("White cuffs","sCuffWhite","1");?><br />
		<?php smControls::smCheckBox("Placket buttons","sPlacketButton","1");?><br />
	</fieldset>
	<fieldset>
		<?php smControls::smDropDownList("Fastening","sFastening",array(
			"2"=>"Plackett",
			"1"=>"French",
			"3"=>"Fly"));
		
			//"1"=>"With placket",
			//"2"=>"Without placket",
			//"3"=>"Hidden buttons"));
			?><br />
	</fieldset>
	<fieldset>
		<?php smControls::smDropDownList("Pockets","sPocket",array(
			/*"1"=>"None",
			"2"=>"Classic",
			"4"=>"2 Classic",
			"3"=>"V-Shaped",
			"5"=>"2 V-Shaped",
			"6"=>"Inverted Pleat",
			"7"=>"2 Inverted Pleat",
			"8"=>"Box Pleat",
			"9"=>"2 Box Pleat"));*/
		
			"1"=>"None",
			"2"=>"Classic",
			"4"=>"2 Classic",
			"3"=>"Dress",
			"5"=>"2 Dress",
			"6"=>"Inverted Pleat",
			"7"=>"2 Inverted Pleat",
			"8"=>"Box Pleat",
			"9"=>"2 Box Pleat"));?><br />
		<?php smControls::smCheckBox("Flap/s","sPocketFlaps","1");?><br />
	</fieldset>
	<fieldset>
		<?php smControls::smCheckBox("Epaulettes","sEpaulettes","1");?><br />
		<?php smControls::smTextBox("Embroidery text <span class='smallText'>(3 chars)</span>","sEmbroideryText","","maxlength='3'");?><br />
		<?php smControls::smDropDownList("Embroidery colour","sEmbroideryColor",array("Same as shirt","Blue","Green","Red","Yellow","White","Pink","Black"));?><br />
		<?php smControls::smDropDownList("Back pleats","sBackPleats",array("Center pleat","Side pleat","No pleat"));?><br />
		<?php smControls::smDropDownList("Bottom cut","sBottomCut",array("Fishtail","Straight"));?><br />
		<?php //smControls::smDropDownList("Bottom cut","sBottomCut",array("Plain hem","Fishtail hem","Plain hem with side vent","Fishtail hem with side vent"));?>
		<?php smControls::smButton("Save","sSave");?>
	</fieldset>
</form>