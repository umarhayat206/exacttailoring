$(document).ready(function(){
	$("input.numeric").numeric();
	$(".hidden").hide();
	$("#showPanelPD").click(function(){
		$("#panelPD").slideToggle();
	})
})