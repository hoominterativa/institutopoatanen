$(function(){
    $('.carousel_abou02').owlCarousel({
        smartSpeed:450,
        loop: true,
        dots:true,
        nav:false,
        rewind: true,
        autoHeight: true,
        responsive: {
            // breakpoint from 0 up
            0 : {
                items:1,
                margin:12
            },
            // breakpoint from 361 up
            361 : {
                items:1,
                margin:12
            },
            // breakpoint from 801 up
            801 : {
                items:3,
                margin:14,
            }
        }
    });
    $('.carousel_abou02').css('width', $('.abou02 .abou02__boxRight').outerWidth() + 280);
    $(window).on('resize', function() {
        $('.carousel_abou02').css('width', $('.abou02 .abou02__boxRight').outerWidth()  + 280);
    });
    $(window).on('resize', function(){
        if($(window).outerWidth() <= 801){
            $('.carousel_abou02').css('width', $('.abou02 .abou02__boxRight').outerWidth() + 150);
        }
    });
    if($(window).outerWidth() <= 801){
        $('.carousel_abou02').css('width', $('.abou02 .abou02__boxRight').outerWidth() + 150);
    }

    $('.carousel-abou02-topic').owlCarousel({
        margin:5,
        stagePadding:0,
        smartSpeed:450,
        loop: true,
        dots:true,
        nav:false,
        rewind: true,
        autoHeight: true,
        responsive: {
            // breakpoint from 0 up
            0 : {
                items:2
            },
            // breakpoint from 361 up
            361 : {
                items:2
            },
            500 : {
                items:2
            },
            // breakpoint from 50 up
            815 : {
                items:3,
            },
            // breakpoint from 800 up
            820 : {
                items:4,
            }
            // breakpoint from 801 up
        }
    });
    $('.carousel-abou02-topic').css('width', $(window).outerWidth());
    $(window).on('resize', function() {
        $('.carousel-abou02-topic').css('width', $(window).outerWidth());
    });
    $(window).on('resize', function(){
        if($(window).outerWidth() <= 801){
            $('.carousel-abou02-topic').css('width', $('.abou02-page__topic .container').outerWidth());
        }
    });
    if($(window).outerWidth() <= 801){
        $('.carousel-abou02-topic').css('width', $('.abou02-page__topic .container').outerWidth());
    }
})
