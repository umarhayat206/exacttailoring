$(document).ready(function() {
$('.account').click(function(){
   $('.memberpanelhiddenbox').slideToggle();
});
$('.login-detail').click(function(){
   $('.login-detail-div').slideToggle();
});
$('.Modify-shipping').click(function(){
   $('.Modify-shipping-address').slideToggle();
});
$('.modify-measurement').click(function(){
   $('.modify-measurement-div').slideToggle();
});
$('.order-history').click(function(){
   $('.order-history-div').slideToggle();
});
$('.voucher-history').click(function(){
   $('.voucher-history-div').slideToggle();
});
$('[data-toggle=offcanvas]').click(function() {
    $('.row-offcanvas').toggleClass('active');
  });
$('.order-history2').click(function(){
   $('.order-history-div').slideToggle();
});
$('.shirtsoption').click(function(){
   $('#hiddenstyleoptions-shirts').slideToggle();
});
$('.trousersoption').click(function(){
   $('#hiddenstyleoptions-trousers').slideToggle();
});


});