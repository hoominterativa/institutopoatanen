$('.carousel_unit01').owlCarousel({
    smartSpeed:450,
    items:1,
    // loop: true,
    dots:true,
    nav:false,
    // rewind: true,
    autoHeight: true
});
$('.carousel_unit01').css('width', $('.unit01-page__divisor__section__boxRight').outerWidth());

if($(window).outerWidth() <= 801){
    $('.carousel_unit01').css('width', $('.unit01-page__divisor__section__boxRight').outerWidth());
}
// END carousel_unit01


$(".unit01-show-carousel").owlCarousel({
    smartSpeed: 450,
    loop: false,
    dots: false,
    nav: true,
    rewind: true,
    autoHeight: true,
    items: 1,
});

$(".unit01-show-carousel").css("width", $(window).outerWidth() / 2 - 108);

var altLightbox = $(".lightbox-unit01").outerHeight();
$(".unit01-show-carousel").css("height", $(altLightbox));

if($(window).outerWidth() <= 800){
    $(".unit01-show-carousel").css("width", $(window).outerWidth() - 16);
}

