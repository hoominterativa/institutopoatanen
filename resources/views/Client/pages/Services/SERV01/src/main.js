$(function(){
    if($(window).outerWidth() <= 800){
        $('.carousel-serv01').addClass('owl-carousel');
        $('.carousel-serv01').owlCarousel({
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
                    items:5,
                    touchDrag: false,
                    mouseDrag: false
                }
            }
        });

        $('.carousel-serv01-show__links').addClass('owl-carousel');
        $('.carousel-serv01-show__links').owlCarousel({
            margin:11,
            stagePadding:0,
            smartSpeed:450,
            dots:false,
            nav:false,
            rewind: true,
            responsive: {
                // breakpoint from 0 up
                0 : {
                    items:2
                },
                // breakpoint from 360 up
                361 : {
                    items:2
                },
                // breakpoint from 768 up
                800 : {
                    items:5,
                    touchDrag: false,
                    mouseDrag: false
                }
            }
        });

        $('.carousel-serv01-show__topics').addClass('owl-carousel');
        $('.carousel-serv01-show__topics').owlCarousel({
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
                    items:4,
                    touchDrag: false,
                    mouseDrag: false
                }
            }
        });
    }
    // END if($(window).outerWidth() <= 800){

    $('.carousel-serv01-show__portfolios').addClass('owl-carousel');
    $('.carousel-serv01-show__portfolios').owlCarousel({
        margin:0,
        stagePadding:0,
        smartSpeed:450,
        dots:true,
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
                items:4
            }
        }
    });
})
