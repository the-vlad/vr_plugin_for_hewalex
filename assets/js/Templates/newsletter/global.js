jQuery(document).ready(function ($) {
  $("#sm-newsletter").submit(function (e) {
    e.preventDefault();
    jQuery.ajax({
      url: instalator_template_rest.theajax,
      type: "post",
      data: $("#sm-newsletter").serialize(),

      success: function (response) {
        $("#sm-newsletter")[0].reset();
        if ($("#success-message").is(":empty")) {
          $("#success-message").append(
            "<div class='the-respond'><div class='checkmark'></div><p>Zostałeś zapisany do naszego newslettera!</p></div>"
          );
        }
      },
    });
    return false;
  });
});
