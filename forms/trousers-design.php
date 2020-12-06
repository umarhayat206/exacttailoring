<script type="text/javascript">
<!--
$(document).ready(function(){

    $("#f-211").change(function(){ 	
	    if($("#f-211").val()=="222"){		
		    $("#trousersSideAdjuster").css({"background":"url('images_trousers/1.png')"});
			$("#f-215").val("229").attr({"disabled":"disabled"});
			$("#trousersElasticated").css({"background":"none"});

	    }else{ 	
		    $("#trousersSideAdjuster").css({"background":"none"});
			$("#f-215").removeAttr("disabled");
	    }
      })
      $("#f-212").change(function(){	
	    if($("#f-212").val()=="224"){	
		    $("#trousersBraceButtons").css({"background":"url('images_trousers/2.png')"});
	    }else{ 	
		    $("#trousersBraceButtons").css({"background":"none"});
	    }
      })
      $("#f-213").change(function(){	
	    if($("#f-213").val()=="226"){
		   $("#trousersButtonFly").css({"background":"url('images_trousers/3.png')"});
	    }else{ 	
		    $("#trousersButtonFly").css({"background":"none"});
	    }
      })
      $("#f-214").change(function(){	
	    if($("#f-214").val()=="228"){
		    $("#trousersFrontPleats").css({"background":"url('images_trousers/4.png')"});

			$("#f-218").val("235").attr({"disabled":"disabled"});
			$("#trousersFrogPocket").css({"background":"none"});

	    }else{ 	
		    $("#trousersFrontPleats").css({"background":"none"});
			$("#f-218").removeAttr("disabled");
	    }
      })
      $("#f-215").change(function(){	
	    if($("#f-215").val()=="230"){	
		    $("#trousersElasticated").css({"background":"url('images_trousers/5.png')"}); 

			$("#f-211").val("221").attr({"disabled":"disabled"});
			$("#trousersSideAdjuster").css({"background":"none"});

	    }else{ 	
		    $("#trousersElasticated").css({"background":"none"});
			$("#f-211").removeAttr("disabled");
	    }
      })
      $("#f-216").change(function(){	
	    if($("#f-216").val()=="232"){		
		   $("#trousersTurnUps").css({"background":"url('images_trousers/6.png')"});	     
	    }else{ 	
		   $("#trousersTurnUps").css({"background":"none"});
	    }
      })
      $("#f-217").change(function(){	
	    if($("#f-217").val()=="234"){		
		   $("#trousersInsideCashPocket").css({"background":"url('images_trousers/7.png')"});	     
	    }else{ 	
		   $("#trousersInsideCashPocket").css({"background":"none"});
	    }
      })
      $("#f-218").change(function(){ // PlacketButton change men=f-141 | women=f-157
	    if($("#f-218").val()=="236"){
		    $("#trousersFrogPocket").css({"background":"url('images_trousers/8.png')"});

			$("#f-214").val("227").attr({"disabled":"disabled"});
			$("#trousersFrontPleats").css({"background":"none"});

	    }else{ 	
		    $("#trousersFrogPocket").css({"background":"none"});
			$("#f-214").removeAttr("disabled");
	    }
      })
      $("#f-219").change(function(){	// Epaulettes change just for men
	      if($("#f-219").val()=="238"){
		     $("#trousers2hipPockets").css({"background":"url('images_trousers/9.png')"});
	      }else if($("#f-48").val()=="49"){
		     $("#trousers2hipPockets").css({"background":"none"});
	      }
      })
      $("#f-220").change(function(){ // PlacketButton change men=f-141 | women=f-157
	    if($("#f-220").val()=="240"){
		    $("#trousersLinedForepart").css({"background":"url('images_trousers/10.png')"});
	    }else{ 	
		    $("#trousersLinedForepart").css({"background":"none"});
	    }
      })

});  

//-->	
</script>

<div id="trousersView">
    <div id="trousersBody" style="background-image: url(images_trousers/main.png); background-position: initial initial; background-repeat: initial initial;">
    <div id="trousersSideAdjuster">
    <div id="trousersBraceButtons">
    <div id="trousersButtonFly">
    <div id="trousersFrontPleats">
    <div id="trousersElasticated">
    <div id="trousersTurnUps">
    <div id="trousersInsideCashPocket">
    <div id="trousersFrogPocket">
    <div id="trousers2hipPockets">
    <div id="trousersLinedForepart">
    <!--<div id="shirtCuffs">
   </div>-->
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