$(function(){
        $('.carousel-serv04').owlCarousel({
            margin:12,
            stagePadding:0,
            smartSpeed:450,
            dots:true,
            nav:false,
            rewind: true,
            autoHeight: true,
            loop:false,
            responsive: {
                // breakpoint from 0 up
                0 : {
                    items:1
                },
                // breakpoint from 500 up
                500 : {
                    items:1
                },
                // breakpoint from 800 up
                800 : {
                    items:4,

                }
            }
        });
        if($(window).outerWidth() <= 500){
            $('.carousel-serv04').css('width', $(window).outerWidth());
        }


        $('.carousel-serv04-page__subcategory').owlCarousel({
            margin:12,
            stagePadding:0,
            smartSpeed:450,
            dots:true,
            nav:false,
            rewind: true,
            autoHeight: true,
            loop:false,
            responsive: {
                // breakpoint from 0 up
                0 : {
                    items:1,
                    margin:0,
                },
                // breakpoint from 500 up
                500 : {
                    items:1,
                    margin:0,
                },
                // breakpoint from 800 up
                800 : {
                    items:4,

                }
            }
        });
        if($(window).outerWidth() <= 500){
            $('.carousel-serv04-page__subcategory').css('width', $(window).outerWidth() + 200);
        }


})
