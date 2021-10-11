const path = "http://localhost/petlove/sistema";
const apiPath = "http://localhost/petlove/api-new";

$(window).on("load", function(e) {
    $(".loader").fadeOut();
});

$("#modal-close").click(function(e) {
    $(".modal").removeClass("modal-show");
});