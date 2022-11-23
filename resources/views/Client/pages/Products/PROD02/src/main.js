$('.carousel-prod02').owlCarousel({
    smartSpeed:450,
    loop: true,
    dots:true,
    nav:false,
    rewind: true,
    autoHeight: true,
    responsive: {
        
        0 : {
            items:1,
            margin:12
        },
        // breakpoint from 0 up
        361 : {
            items:1,
            margin:12
        },
        // breakpoint from 361 up
        801 : {
            items:3,
            margin:14,
        }
        // breakpoint from 801 up
    }
});
$('.carousel-prod02').css('width', $('.prod02 .container--edit').outerWidth());

if($(window).outerWidth() <= 801){
    $('.carousel-prod02').css('width', $('.prod02 .container--edit').outerWidth() + 150);
}
// END carousel_prod02