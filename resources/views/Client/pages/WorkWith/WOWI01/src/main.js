$(function(){
    if($(window).outerWidth() <= 800){
        $('.carousel-wowi01').addClass('owl-carousel');
        $('.carousel-wowi01').owlCarousel({
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

        $('.wowi01-show__container-box__carousel').addClass('owl-carousel');
        $('.wowi01-show__container-box__carousel').owlCarousel({
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

    }
    // END if($(window).outerWidth() <= 800){
})
