$(function(){



    let countItem =  document.querySelectorAll('.port101__content .port101__content__box').length;
    if(countItem >= 4){
        countItem = 4;
    }
    console.log(countItem);

    $('.carousel-port101').owlCarousel({
        margin:0,
        stagePadding:0,
        smartSpeed:450,
        dots:false,
        nav:true,
        responsive: {
            // breakpoint from 0 up
            0 : {
                items:1,
                margin:8
            },
            // breakpoint from 360 up
            361 : {
                items:1,
                margin:8
            },
            500 : {
                items:1,
                margin:8
            },
            800 : {
                items:1,
                margin:8
            },
            // breakpoint from 800 up
            850 : {
                items:countItem,
                margin:8
            }
            // breakpoint from 850 up
        }
    });

    $('.carousel-port101').css('width', $('.port101 .container--pd').outerWidth());
})
