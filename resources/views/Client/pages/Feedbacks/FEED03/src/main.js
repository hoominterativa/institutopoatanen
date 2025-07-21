
$('.carousel-feed03').owlCarousel({
    smartSpeed:450,
    loop: true,
    dots:true,
    nav:false,
    rewind: true,
    autoHeight: true,
    margin:100,
    responsive: {

        0 : {
            items:1
        },
        // breakpoint from 0 up
        400 : {
            items:1
        },
        // breakpoint from 361 up
        500 : {
            items:2
        },
        // breakpoint from 500 up
        801 : {
            items:2

        }
        // breakpoint from 801 up
    }
});
$('.carrossel-feed03').css('width', $('.feed03 .container').outerWidth());

