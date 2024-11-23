window.onload = function () {
  //https://hewalex.develtio.test/wp-json/hewalex-zones/v2/getCartFromShop
 $(".offer-creator-btn").click(function(){
   $(this).addClass('active');
   $('.offer-basket-btn').removeClass('active');
   $("#offer-basket").removeClass('active');
   $("#offer-creator").addClass('active');
 });

 $(".offer-basket-btn").click(function(){
   $(this).addClass('active');
   $('.offer-creator-btn').removeClass('active');
   $("#offer-basket").addClass('active');
   $("#offer-creator").removeClass('active')
 });
};
