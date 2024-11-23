jQuery(document).ready(function ($) {

    $('#toggleShippingYes').click(function(){
       if($(this).hasClass('disabledState')){
         $(this).removeClass('disabledState');
        $('#toggleShippingNo').addClass('disabledState')
        $("#additional_address").slideDown();
        $("#additional_address").css('display','flex');
       }
    });

   $('#toggleShippingNo').click(function(){
        if($(this).hasClass('disabledState')){
        $(this).removeClass('disabledState');
        $('#toggleShippingYes').addClass('disabledState')
        $("#additional_address").slideUp();
        }
});

});