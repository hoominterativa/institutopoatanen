$(function(){
    if($(window).outerWidth() <= 800){
        $('.topi102__navigation ul').addClass('owl-carousel');
        $('.topi102__navigation ul').addClass('carousel-topi02-navigation');
        $('.carousel-topi02-navigation').owlCarousel({
            margin:0,
            stagePadding:0,
            smartSpeed:450,
            dots:false,
            nav:false,
            rewind: true,
            responsive: {
                // breakpoint from 0 up
                0 : {
                    items:1
                },
                // breakpoint from 360 up
                361 : {
                    items:1
                },
                // breakpoint from 768 up
                800 : {
                    items:3,
                    touchDrag: false,
                    mouseDrag: false
                }
            }
        });
    }

    $('.carousel-topi102').owlCarousel({
        margin:0,
        stagePadding:0,
        smartSpeed:450,
        dots:false,
        nav:false,
        // rewind: true,
        responsive: {
            // breakpoint from 0 up
            0 : {
                items:1
            },
            // breakpoint from 360 up
            361 : {
                items:1
            },
            // breakpoint from 768 up
            800 : {
                items:4,
            }
        }
    });

    $('.carousel-topi102').css('width', $('.topi102 .container--pd').outerWidth());
})
