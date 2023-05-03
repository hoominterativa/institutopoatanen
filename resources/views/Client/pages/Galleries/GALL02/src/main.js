$(function(){
    $('.carousel-gall02').owlCarousel({
        margin:0,
        stagePadding:0,
        smartSpeed:450,
        dots:false,
        nav:false,
        // loop:true,
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
})