$(function(){
    if($(window).outerWidth() <= 800){
        $('.carousel-abou01-topic').addClass('owl-carousel');
        $('.carousel-abou01-topic').owlCarousel({
            margin:5,
            stagePadding:0,
            smartSpeed:450,
            dots:true,
            nav:false,
            rewind: true,
            autoHeight: true,
            responsive: {
                // breakpoint from 0 up
                0 : {
                    items:1
                },
                // breakpoint from 361 up
                361 : {
                    items:1
                },
                // breakpoint from 800 up
                800 : {
                    items:3,
                    touchDrag: false,
                    mouseDrag: false
                }
            }
        });
    }
})
