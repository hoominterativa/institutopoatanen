$(function(){

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
                    items:1
                },
                // breakpoint from 361 up
                361 : {
                    items:1
                },
                // breakpoint from 800 up
                800 : {
                    items:4,
                }
            }
        });
        $('.carousel-abou02-topic').css('width', $('.abou02-page__topic .container').outerWidth() + 280);
        $(window).on('resize', function() {
            $('.carousel-abou02-topic').css('width', $('.abou02-page__topic .container').outerWidth()  + 280);
        });
        $(window).on('resize', function(){
            if($(window).outerWidth() <= 600){
                $('.carousel-abou02-topic').css('width', $('.abou02-page__topic .container').outerWidth());
            }
        });
        if($(window).outerWidth() <= 600){
            $('.carousel-abou02-topic').css('width', $('.abou02-page__topic .container').outerWidth());
        }
})
