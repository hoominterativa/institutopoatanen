$('.carrosel-topi04-topics').owlCarousel({
    smartSpeed:450,
    loop: false,
    dots:true,
    nav:false,
    rewind: true,
    autoHeight: true,
    margin:2,
    responsive: {

        0 : {
            items:3
        },
        // breakpoint from 0 up
        361 : {
            items:3
        },
        // breakpoint from 361 up
        801 : {
            items:3

        }
        // breakpoint from 801 up
    }
});
$('.carrosel-topi04-topics').css('width', $('.topi04__boxRight').outerWidth());

