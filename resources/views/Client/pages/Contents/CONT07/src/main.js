$(function(){
        $('.carousel-gallery-cont07').owlCarousel({
                loop:false,
                autoplay:false,
                nav:false,
                dots: true,
                margin:5,
                stagePadding:0,
                smartSpeed:450,
                autoplayTimeout:5000,
                rewind: true,
                autoHeight: true,
                responsive:{
                    0:{
                        items:2,
                        margin:-25
                    },
                    500:{
                        items:2,
                        margin:-25
                    },
                    992:{
                        items:3,
                        margin:-25
                    },
                     800:{
                        items:4
                    },
                    1200:{
                        items:4
                    }
                }
        });
        $('.carousel-gallery-cont07').css('width', $(window).outerWidth() - 213);
        $(window).resize(function(){
                $('.carousel-gallery-cont07').css('width', $(window).outerWidth());
        });
        if($(window).outerWidth() <= 600){
                $('.carousel-gallery-cont07').css('width', $(window).outerWidth());
        }
})
    