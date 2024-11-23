
jQuery(document).ready(function ($) {

    $("input#keyword_products").keyup(function() {
        let ajaxurl = instalator_template_rest.theajax;
        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: { action: 'FetchProducts', keyword_products: jQuery('#keyword_products').val() },
            success: function(data) {
                jQuery('#datafetch_products').html( data );
            
            }
        });
    
      if ($(this).val().length > 2) {
        $("#products_pagination").fadeOut();
        $(".search_ico").fadeOut();
      } else {
        $("#products_pagination").fadeIn();
        $(".search_ico").fadeIn();
      }
    });
    
    });