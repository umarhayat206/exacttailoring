<script type="text/javascript">
<!--
$(document).ready(function(){
	    
        $('#productPrice, #productFabricWeigth, #promotionDiscount, #promotionGetfreeItem, #membermeasurementShirtNeck, #membermeasurementShirtChest, #membermeasurementShirtStomach, #membermeasurementShirtHips, #membermeasurementShirtLenght, #membermeasurementShirtSleeveLength, #membermeasurementShirtShortSleeve, #membermeasurementShirtCuff, #membermeasurementShirtUpperarm, #membermeasurementShirtShoulder, #membermeasurementTrousersA, #membermeasurementTrousersB, #membermeasurementTrousersC, #membermeasurementTrousersD, #membermeasurementTrousersE, #membermeasurementTrousersF, #membermeasurementTrousersG, #membermeasurementBoxersWaist, #membermeasurementBoxersTopofLeg, #membermeasurementBoxersLength, #membermeasurementBoxersHip, #membermeasurementBoxersInsideLeg').keyup(function(){
	      $(this).digits();
        });
 
        $( "#promotionStart, #promotionUntill" ).datepicker({
	      numberOfMonths:1 ,
	      showButtonPanel: true,
	      dateFormat: 'yy-mm-dd'
	      /*minDate: new Date()*/
        });
        
       /*
        $("#promotionType1").focus(function(){
	      $("#hiddendivdiscount").show();
	      $("#hiddendivfreeitem").hide();
	      $("#hiddendivproducttwo").hide();
	      $("#hiddendivproductone").show();
	      return(false);
        });
       
        $("#promotionType2").focus(function(){
	      $("#hiddendivdiscount").hide();
	      $("#hiddendivfreeitem").show();
	      $("#hiddendivproducttwo").show();
	      $("#hiddendivproductone").show();
	      return(false);
        });

        $("#promotionType3").focus(function(){
	      $("#hiddendivdiscount").hide();
	      $("#hiddendivfreeitem").hide();
	      $("#hiddendivproducttwo").show();
	      $("#hiddendivproductone").show();
	      return(false);
        });
       */

        $("#allproduct").change(function(){
	      $("#hiddendivproductone").hide();
	      return(false);
        });
       
        $("#selectproduct").change(function(){
	      $("#hiddendivproductone").show();
	      return(false);
        });
       
        $('#formcustomercomment, #memberregisform, #contactform, #subcontactform, #ordercatalogueform, #quickregis, #quicklogin').validate();
       
        $('img#refresh').click(function() {
	      change_captcha();
        });

       	$('#checkall').click(function() {

		   if ($(this).is(':checked')){
		     $('.checkallfree').attr('checked', true);
		   }
		   else{
		     $('.checkallfree').attr('checked', false);
		   }

		});

		$('#checkall1').click(function() {

		   if ($(this).is(':checked')){
		     $('.checkallfree1').attr('checked', true);
		   }
		   else{
		     $('.checkallfree1').attr('checked', false);
		   }

		});


       function change_captcha() {
	      document.getElementById('captcha').src="get_captcha.php?rnd=" + Math.random();
       }

       $(".editaccountinfo").click(function(){
	      $("#hiddeneditaccountinfo").slideToggle();
	      return(false);
       });
       
       $(".changeoassword").click(function(){
	      $("#hiddenchangeoassword").slideToggle();
	      return(false);
       });
       
       $(".modifyaddress").click(function(){
	      $("#hiddenmodifyaddress").slideToggle();
	      return(false);
       });
       
       $(".wishlist").click(function(){
	      $("#hiddenwishlist").slideToggle();
	      return(false);
       });
       
       $(".modifymeasurement").click(function(){
	      $("#hiddenmodifymeasurement").slideToggle();
	      return(false);
       });
       
       $(".orderhistory").click(function(){
	      $("#hiddenorderhistory").slideToggle();
	      return(false);
       });
       
       $(".vouchershistory").click(function(){
	      $("#hiddenvouchershistory").slideToggle();
	      return(false);
       });
       
       $(".shirtsoption").click(function(){
	      $("#hiddenstyleoptions-shirts").slideToggle();
	      return(false);
       });
       
       $(".trousersoption").click(function(){
	      $("#hiddenstyleoptions-trousers").slideToggle();
	      return(false);
       });
       
       $("#shirtmeasurement").change(function(){
	      $("#divshirtmeasurement").show();
	      $("#divtrousersmeasurement").hide();
	      $("#divboxersmeasurement").hide();
	      return(false);
       });

       $("#trousersmeasurement").change(function(){
	      $("#divshirtmeasurement").hide();
	      $("#divtrousersmeasurement").show();
	      $("#divboxersmeasurement").hide();
	      return(false);
       });
       
       $("#boxersmeasurement").change(function(){
	      $("#divshirtmeasurement").hide();
	      $("#divtrousersmeasurement").hide();
	      $("#divboxersmeasurement").show();
	      return(false);
       });

      $("a[rel^='prettyPhoto']").prettyPhoto({ 
	      modal: true
       });

       // Dialog Login Form
       $('#dialog1').dialog({ 
	      autoOpen: false,
	      width: 400,
	      modal:true,
	      resizable:false,

	      buttons: {
		     "Login": function(){ 
			    $('#memberloginform').submit();
		     }, 
		     "Cancel": function() { 
			    $(this).dialog("close");
			    window.location="<?=_URL_;?>";
		     }
		    
	      }
       }); 

       $('.loginclick').click(function(){
	      $('#dialog1').dialog('open');
	      return false;
       });
       
       // Dialog Request Password
       $('#dialog3').dialog({ 
	      autoOpen: false,
	      width: 400,
	      modal:true,
	      resizable:false,

	      buttons: {
		     "Submit": function(){ 
			    $('#requestpasswordform').submit();
		     }, 
		     "Cancel": function() { 
			    $(this).dialog("close");
			    window.location="<?=_URL_;?>";
		     }
		    
	      }
       }); 

       $('.passwordclick').click(function(){
	      $('#dialog3').dialog('open');
	      return false;
       });
       
       // Dialog Regis Form
       /*
       $('#dialog2').dialog({
	      autoOpen: false,
	      width: 450,
	      modal:true,
	      resizable:false,

	      buttons: {
		     "Ok": function(){ 
			    $('#memberregisform').submit();
		     }, 
		     "Cancel": function() { 
			    $(this).dialog("close"); 
		     } 
	      }
       });

       $('.regisclick').click(function(){
	      $('#dialog2').dialog('open');
	      return false;
       });
       */

});  

//-->	
</script>