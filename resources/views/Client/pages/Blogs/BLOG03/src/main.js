$(function(){
    $('.blog03__boxs__carousel').owlCarousel({
        smartSpeed:450,
        loop: false,
        dots:true,
        nav:false,
        rewind: true,
        autoHeight: true,
        responsive: {
            // breakpoint from 0 up
            0 : {
                items:1,
                margin:-100
            },
            // breakpoint from 0
            200 : {
                items:1,
                margin:-100
            },
            // breakpoint from 200 up

            500 : {
                items:1,
                margin:-100

            },
            // breakpoint from 815 up
            820 : {
                items:1,
                margin:-50
            }
            // breakpoint from 820 up
        }
    });
    $('.blog03__boxs__carousel').css('width', $(window).outerWidth() + 150);
    if($(window).outerWidth() <= 801){
        $('.blog03__boxs__carousel').css('width', $(window).outerWidth());
    }
})
