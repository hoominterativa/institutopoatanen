$(function(){
    $('.carousel-topi101').owlCarousel({
        margin:0,
        stagePadding:0,
        smartSpeed:450,
        dots:false,
        nav:false,
        loop: true,
        rewind: true,
        responsive: {
            // breakpoint from 0 up
            0 : {
                items:1
            },
            // breakpoint from 360 up
            500 : {
                items:1
            },
            // breakpoint from 800 up
            800 : {
                items:4,
            }
        }
    });

    $('.carousel-topi101').css('width', $(window).outerWidth());
    if($(window).outerWidth() <= 801){
        $('.carousel-topi101').css('width', $('.container--topic101').outerWidth());
    }
})
