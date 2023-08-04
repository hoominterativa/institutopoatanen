$(function(){
    if($(window).outerWidth()){
        $('.carousel-serv07').addClass('owl-carousel');
        $('.carousel-serv07').owlCarousel({
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
                    items:5
                }
            }
        });
    }
})

$(function(){
    if($(window).outerWidth() <= 800){
        $('.carousel-serv07-product').addClass('owl-carousel');
        $('.carousel-serv07-product').owlCarousel({
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
                }
            }
        });
    }
})


$(function(){
    if($(window).outerWidth()){
        $('.serv07__gallery__main').addClass('owl-carousel');
        $('.serv07__gallery__main').owlCarousel({
            margin:0,
            stagePadding:0,
            smartSpeed:450,
            dots:true,
            nav:true,
            rewind: true,
            responsive: {
                // breakpoint from 0 up
                0 : {
                    items:1
                }
            }
        });
    }
})


$(function(){
    if($(window).outerWidth()){
        $('.serv07__gallery__thumbnail__carousel').addClass('owl-carousel');
        $('.serv07__gallery__thumbnail__carousel').owlCarousel({
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
                    items:4,
                }
            }
        });
    }
})



$(function(){
    if($(window).outerWidth()){
        $('.carousel-serv07-section-product').addClass('owl-carousel');
        $('.carousel-serv07-section-product').owlCarousel({
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
                    items:5
                }
            }
        });
    }
})


$(function(){
    if($(window).outerWidth()){
        $('.carousel-serv07-show-section-product').addClass('owl-carousel');
        $('.carousel-serv07-show-section-product').owlCarousel({
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
                    items:5
                }
            }
        });
    }
})
