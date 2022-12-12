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