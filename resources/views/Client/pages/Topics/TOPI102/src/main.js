$(function(){
    if($(window).outerWidth() <= 800){
        $('.topi102__navigation ul').addClass('owl-carousel');
        $('.topi102__navigation ul').addClass('carousel-topi02-navigation');
        $('.carousel-topi02-navigation').owlCarousel({
            margin:7,
            stagePadding:0,
            smartSpeed:450,
            dots:false,
            nav:false,
            responsive: {
                // breakpoint from 0 up
                0 : {
                    items:1,
                    margin:-69
                },
                // breakpoint from 360 up
                361 : {
                    items:1,
                    margin:-69
                },
                // breakpoint from 768 up
                500 : {
                    items:1,
                    margin:-69
                },
                800 : {
                    items:2,
                    margin:-69
                }
            }
        });
    }

    let countItem =  document.querySelectorAll('.topi102__content .topi102__content__box').length;
    if(countItem >= 4){
        countItem = 4;
    }
    console.log(countItem);

    $('.carousel-topi102').owlCarousel({
        margin:0,
        stagePadding:0,
        smartSpeed:450,
        dots:false,
        nav:false,
        responsive: {
            // breakpoint from 0 up
            0 : {
                items:1,
                margin:-51
            },
            // breakpoint from 360 up
            361 : {
                items:1,
                margin:-51
            },
            500 : {
                items:1,
                margin:-51
            },
            800 : {
                items:1,
                margin:-51
            },
            // breakpoint from 800 up
            850 : {
                items:countItem,
            }
            // breakpoint from 850 up
        }
    });

    $('.carousel-topi102').css('width', $('.topi102 .container--pd').outerWidth());
})
