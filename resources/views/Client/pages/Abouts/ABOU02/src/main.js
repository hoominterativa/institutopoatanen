$(function(){
    $('.carousel_abou02').owlCarousel({
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
    $('.carousel_abou02').css('width', $('.abou02 .abou02__boxRight').outerWidth() + 496);

    if($(window).outerWidth() <= 801){
        $('.carousel_abou02').css('width', $('.abou02 .abou02__boxRight').outerWidth() + 150);
    }
    // END carousel_abou02

    $('.carousel-abou02-topic').owlCarousel({
        smartSpeed:450,
        loop: true,
        dots:true,
        nav:false,
        rewind: true,
        autoHeight: true,
        responsive: {
            // breakpoint from 0 up
            0 : {
                items:1,
                margin:12
            },
            // breakpoint from 0
            200 : {
                items:1,
                margin:12
            },
            // breakpoint from 200 up
            361 : {
                items:1,
                margin:12
                
            },
            // breakpoint from 361 up
            500 : {
                items:2,
                margin:12
                
            },
            // breakpoint from 500 up
            815 : {
                items:3,
                margin:14
            },
            // breakpoint from 815 up
            820 : {
                items:4,
                margin:14
            }
            // breakpoint from 820 up
        }
    });
    $('.carousel-abou02-topic').css('width', $(window).outerWidth() + 280);
    if($(window).outerWidth() <= 801){
        $('.carousel-abou02-topic').css('width', $(window).outerWidth() + 50);
    }
    // END carousel-abou02-topic
})
