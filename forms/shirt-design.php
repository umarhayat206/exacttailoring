<script type="text/javascript">
	<!--
	$(document).ready(function() {

		$("#f-109, #f-152, #f-290").change(function() { // Fit change men=f-109 | women=f-152 | dress Shirts = f-290
			if ($("#f-109").val() == "111" || $("#f-152").val() == "163" || $("#f-290").val() == "327") {
				$("#shirtBody").css({
					"background": "url('images_shirt/body_normal.gif')"
				});
			} else if ($("#f-109").val() == "110" || $("#f-152").val() == "162" || $("#f-290").val() == "326") {
				$("#shirtBody").css({
					"background": "url('images_shirt/body_slim.gif')"
				});
			} else if ($("#f-109").val() == "112" || $("#f-152").val() == "164" || $("#f-290").val() == "328") {
				$("#shirtBody").css({
					"background": "url('images_shirt/body_loose.gif')"
				});
			}
		})
		$("#f-27, #f-153, #f-285").change(function() { // Collor change men=f-27 | women=f-153
			if ($("#f-27").val() == "31" || $("#f-153").val() == "165" || $("#f-285").val() == "299") {
				$("#shirtCollars").css({
					"background": "url('images_shirt/collars_classic.gif')"
				});
				/*}else if($("#f-27").val()=="32" || $("#f-153").val()=="152"){ 
		     $("#shirtCollars").css({"background":"url('images_shirt/collars_business.gif')"});*/
				/*}else if($("#f-27").val()=="33" || $("#f-153").val()=="152"){  
		     $("#shirtCollars").css({"background":"url('images_shirt/collars_full_spread.gif')"});*/
			} else if ($("#f-27").val() == "34" || $("#f-153").val() == "168" || $("#f-285").val() == "300") {
				$("#shirtCollars").css({
					"background": "url('images_shirt/collars_cut_away.gif')"
				});
				/*}else if($("#f-27").val()=="35" || $("#f-153").val()=="152"){ 
		     $("#shirtCollars").css({"background":"url('images_shirt/collars_long.gif')"});*/
			} else if ($("#f-27").val() == "35" || $("#f-153").val() == "169" || $("#f-285").val() == "301") {
				$("#shirtCollars").css({
					"background": "url('images_shirt/collars_button_down.gif')"
				});
			} else if ($("#f-27").val() == "36" || $("#f-153").val() == "170" || $("#f-285").val() == "302") {
				$("#shirtCollars").css({
					"background": "url('images_shirt/collars_mao.gif')"
				});
			} else if ($("#f-27").val() == "32" || $("#f-153").val() == "166" || $("#f-285").val() == "303") {
				$("#shirtCollars").css({
					"background": "url('images_shirt/collars_rounded.gif')"
				});
			} else if ($("#f-27").val() == "33" || $("#f-153").val() == "167" || $("#f-285").val() == "304") {
				$("#shirtCollars").css({
					"background": "url('images_shirt/collars_hawaiian.gif')"
				});
				//}else if($("#f-27").val()=="132" || $("#f-153").val()=="152"){ 	// Soft Collar
				//$("#shirtCollars").css({"background":"url('images_shirt/collars_long.gif')"});	
			} else if ($("#f-27").val() == "132") {
				$("#shirtCollars").css({
					"background": "url('images_shirt/collars_ainsley.gif')"
				});
			} else if ($("#f-27").val() == "357") {
				$("#shirtCollars").css({
					"background": "url('images_shirt/collars_semi_cutaway.gif')"
				});
			} else if ($("#f-27").val() == "385") {
				$("#shirtCollars").css({
					"background": "url('images_shirt/collars_wing_tip.gif')"
				});
			} else if ($("#f-27").val() == "386") {
				$("#shirtCollars").css({
					"background": "url('images_shirt/collars_full_spread.gif')"
				});
			} else if ($("#f-27").val() == "387") {
				$("#shirtCollars").css({
					"background": "url('images_shirt/collars_double_button_cut_away.gif')"
				});
			}
		})
		$("#f-381").change(function() { // Sleeve change just for men
			if ($("#f-381").val() == "382") {
				$("#shirtArms").css({
					"background": "url('images_shirt/arms_long.gif')"
				});
				$("#shirtPlacketButton").css({
					"display": "block"
				});
				$("#shirtCuffs").css({
					"display": "block"
				});

			} else if ($("#f-381").val() == "383") { // short Sleeve - hidden Placket Button and Cuffs option
				$("#shirtArms").css({
					"background": "url('images_shirt/arms_short.gif')"
				});
				$("#shirtPlacketButton").css({
					"display": "none"
				});
				$("#shirtCuffs").css({
					"display": "none"
				});

				/*}else if($("#f-123").val()=="3"){
		     $("#shirtArms").css({"background":"url('images_shirt/arms_short_cuff.gif')"});
	      }else if($("#sSleeve").val()=="4"){
		     $("#shirtArms").css({"background":"url('images_shirt/arms_roll_up.gif')"});*/
			}

		});

		var cuffsImg = {
			38: 'cuffs_single_button_rounded.gif',
			39: 'cuffs_single_button_angled.gif',
			40: 'cuffs_single_button_straight.gif',
			41: 'cuffs_double_button_angled.gif',
			42: 'cuffs_double_button_rounded.gif',
			133: 'cuffs_double_button_straight.gif',
			134: 'cuffs_neapolitan.gif',
			383: 'cuffs_french_rounded.gif',
			388: 'cuffs_french_straight.gif',
			389: 'cuffs_french_angled.gif'
		};
		$("#f-37, #f-155, #f-286").change(function() { // Cuffs change men=f-37 | women=f-155
			if ($("#f-37").val() == "390") {
				$("#shirtArms").css({
					"background": "url('images_shirt/arms_short.gif')"
				});
				$("#shirtCuffs").css({
					"background": "none"
				});
			} else {
				$("#shirtCuffs").css({
					"background": "url('images_shirt/" + cuffsImg[$("#f-37").val()] + "')"
				});
				$("#shirtArms").css({
					"background": "url('images_shirt/arms_long.gif')"
				});
			}

			if ($("#f-155").val() == "177" || $("#f-286").val() == "306") {
				$("#shirtCuffs").css({
					"background": "url('images_shirt/cuffs_single_button.gif')"
				});
				$("#shirtArms").css({
					"background": "url('images_shirt/arms_long.gif')"
				});
			} else if ($("#f-155").val() == "178" || $("#f-286").val() == "307") {
				$("#shirtCuffs").css({
					"background": "url('images_shirt/cuffs_double_button.gif')"
				});
				$("#shirtArms").css({
					"background": "url('images_shirt/arms_long.gif')"
				});
				//}else if($("#f-37").val()=="134" || $("#f-155").val()=="170"){ 	// Rounded
				//$("#shirtCuffs").css({"background":"url('images_shirt/cuffs_triple.gif')"});
			} else if ($("#f-155").val() == "179" || $("#f-286").val() == "308") {
				$("#shirtCuffs").css({
					"background": "url('images_shirt/cuffs_convertable.gif')"
				});
				$("#shirtArms").css({
					"background": "url('images_shirt/arms_long.gif')"
				});
			} else if ($("#f-155").val() == "180" || $("#f-286").val() == "309") {
				$("#shirtCuffs").css({
					"background": "url('images_shirt/cuffs_french.gif')"
				});
				$("#shirtArms").css({
					"background": "url('images_shirt/arms_long.gif')"
				});
			} else if ($("#f-155").val() == "181" || $("#f-286").val() == "310") {
				$("#shirtCuffs").css({
					"background": "url('images_shirt/cuffs_french_rounded.gif')"
				});
				$("#shirtArms").css({
					"background": "url('images_shirt/arms_long.gif')"
				});
			} else if ($("#f-155").val() == "176" || $("#f-286").val() == "311") {
				$("#shirtCuffs").css({
					"background": "url('images_shirt/cuffs_angled.gif')"
				});
				$("#shirtArms").css({
					"background": "url('images_shirt/arms_long.gif')"
				});
				/*     
	      }else if($("#f-37").val()=="361" || $("#f-155").val()=="368" || $("#f-286").val()=="370"){	// Short Sleeve under Cuffs option - edite Feb 2015
		     $("#shirtArms").css({"background":"url('images_shirt/arms_short.gif')"});
		     $("#shirtCuffs").css({"display":"none"});
		*/
			}
		})
		$("#f-43, #f-158, #f-287").change(function() { // Fastening change men=f-43 | women=f-158
			if ($("#f-43").val() == "45" || $("#f-158").val() == "191" || $("#f-287").val() == "313") { // French
				$("#shirtButtons").css({
					"background": "url('images_shirt/buttons.gif')"
				});
				$("#shirtPlackets").css({
					"background": "none"
				});
			} else if ($("#f-43").val() == "44" || $("#f-158").val() == "190" || $("#f-287").val() == "314" || $("#f-43").val() == "384") { // Plackett
				$("#shirtButtons").css({
					"background": "url('images_shirt/buttons.gif')"
				});
				$("#shirtPlackets").css({
					"background": "url('images_shirt/plackets.gif')"
				});
			} else if ($("#f-43").val() == "47" || $("#f-158").val() == "192" || $("#f-287").val() == "315") { // Fly
				$("#shirtButtons").css({
					"background": "none"
				});
				$("#shirtPlackets").css({
					"background": "none"
				});
			}
		})
		$("#f-113, #f-159, #f-295").change(function() { // Pocket change men=f-113 | women=f-159
			if ($("#f-113").val() == "114" || $("#f-159").val() == "193" || $("#f-295").val() == "337") { // None
				$("#shirtPockets").css({
					"background": "none"
				});
			} else if ($("#f-113").val() == "115" || $("#f-159").val() == "194" || $("#f-295").val() == "338") { // Classic
				$("#shirtPockets").css({
					"background": "url('images_shirt/pockets_straight.gif')"
				});
			} else if ($("#f-113").val() == "116" || $("#f-159").val() == "195" || $("#f-295").val() == "339") { // 2 Classic
				$("#shirtPockets").css({
					"background": "url('images_shirt/pockets_straight_2.gif')"
				});
			} else if ($("#f-113").val() == "117" || $("#f-159").val() == "196" || $("#f-295").val() == "340") { // Dress
				$("#shirtPockets").css({
					"background": "url('images_shirt/pockets_vshape.gif')"
				});
			} else if ($("#f-113").val() == "118" || $("#f-159").val() == "197" || $("#f-295").val() == "341") { // 2 Dress
				$("#shirtPockets").css({
					"background": "url('images_shirt/pockets_vshape_2.gif')"
				});
			} else if ($("#f-113").val() == "119" || $("#f-159").val() == "198" || $("#f-295").val() == "342") { // Inverted Pleat
				$("#shirtPockets").css({
					"background": "url('images_shirt/pockets_inverted.gif')"
				});
			} else if ($("#f-113").val() == "120" || $("#f-159").val() == "199" || $("#f-295").val() == "343") { // 2 Inverted Pleat
				$("#shirtPockets").css({
					"background": "url('images_shirt/pockets_inverted_2.gif')"
				});
			} else if ($("#f-113").val() == "121" || $("#f-159").val() == "200" || $("#f-295").val() == "344") { // Box Pleat
				$("#shirtPockets").css({
					"background": "url('images_shirt/pockets_box.gif')"
				});
			} else if ($("#f-113").val() == "122" || $("#f-159").val() == "201" || $("#f-295").val() == "345") { // 2 Box Pleat
				$("#shirtPockets").css({
					"background": "url('images_shirt/pockets_box_2.gif')"
				});
			} else if ($("#f-113").val() == "276" || $("#f-159").val() == "277" || $("#f-295").val() == "346") { // Box Pleat
				$("#shirtPockets").css({
					"background": "url('images_shirt/pockets_pointed.gif')"
				});
			} else if ($("#f-113").val() == "278" || $("#f-159").val() == "279" || $("#f-295").val() == "347") { // 2 Box Pleat
				$("#shirtPockets").css({
					"background": "url('images_shirt/pockets_pointed_2.gif')"
				});
			}
			//$("#f-250, #f-253").removeAttr("selected");
			$("#f-250").val(251).attr("selected");
			$("#f-253").val(254).attr("selected");
			$("#f-298").val(353).attr("selected");
			$("#shirtFlaps").css({
				"background": "none"
			});
		})
		$("#f-250, #f-253, #f-298").change(function() { // Flap/s Change men=f-250 | women=f-253
			if (($("#f-250").val() == "252" || $("#f-253").val() == "255" || $("#f-298").val() == "354") &&
				($("#f-113").val() == "115" || $("#f-113").val() == "117" || $("#f-113").val() == "119" || $("#f-113").val() == "121" || // men
					$("#f-159").val() == "194" || $("#f-159").val() == "196" || $("#f-159").val() == "198" || $("#f-159").val() == "200" || // women
					$("#f-295").val() == "338" || $("#f-295").val() == "340" || $("#f-295").val() == "342" || $("#f-295").val() == "344") // dress Shirts
			) {
				$("#shirtFlaps").css({
					"background": "url('images_shirt/pocket_flap.gif')"
				});
			} else if (($("#f-250").val() == "252" || $("#f-253").val() == "255" || $("#f-298").val() == "354") &&
				($("#f-113").val() == "116" || $("#f-113").val() == "118" || $("#f-113").val() == "120" || $("#f-113").val() == "122" || // men
					$("#f-159").val() == "195" || $("#f-159").val() == "197" || $("#f-159").val() == "199" || $("#f-159").val() == "201" || // women
					$("#f-295").val() == "339" || $("#f-295").val() == "341" || $("#f-295").val() == "343" || $("#f-295").val() == "345") // dress Shirts
			) {
				$("#shirtFlaps").css({
					"background": "url('images_shirt/pocket_flaps_2.gif')"
				});
			} else {
				$("#shirtFlaps").css({
					"background": "none"
				});
			}
		})
		$("#f-141, #f-157, #f-292").change(function() { // PlacketButton change men=f-141 | women=f-157
			if ($("#f-141").val() == "143" || $("#f-157").val() == "184" || $("#f-292").val() == "332") {
				$("#shirtPlacketButton").css({
					"background": "url('images_shirt/placket_buttons.gif')"
				});
			} else if ($("#f-141").val() == "142" || $("#f-157").val() == "183" || $("#f-292").val() == "331") {
				$("#shirtPlacketButton").css({
					"background": "none"
				});
			}
		})
		$("#f-48").change(function() { // Epaulettes change just for men
			if ($("#f-48").val() == "50") {
				$("#shirtEpaulettes").css({
					"background": "url('images_shirt/epaulettes.gif')"
				});
			} else if ($("#f-48").val() == "49") {
				$("#shirtEpaulettes").css({
					"background": "none"
				});
			}
		})

		setTimeout(function() {
			$("#f-286").val(310);
			$("#f-287").val(315);
			$("#shirtCuffs").css({
				"background": "url('images_shirt/cuffs_single_button_rounded.gif')"
			});
			$("#shirtButtons").css({
				"background": "none"
			});
			$("#shirtPlackets").css({
				"background": "none"
			});

		}, 1000);

	});

	//
	-->
</script>

<div id="shirtView">
	<div id="shirtBody" style="background-image: url(images_shirt/body_normal.gif); ">
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
												<div id="shirtCuffs" style="background: url('images_shirt/cuffs_single_button_rounded.gif')">
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