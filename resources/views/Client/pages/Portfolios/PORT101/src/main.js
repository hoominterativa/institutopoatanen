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
                margin:-50
            },
            // breakpoint from 360 up
            361 : {
                items:1,
                margin:-50
            },
            500 : {
                items:1,
                margin:-50
            },
            800 : {
                items:1,
                margin:-50
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




    $('.carousel-show-port101').owlCarousel({
        items:1,
        loop:false,
        center:true,
        margin:0,
        // mouseDrag:false,
        // touchDrag:false,
        URLhashListener:true, // ESSE 
        autoplayHoverPause:true,
        startPosition: 'URLHash' // E ESSE
    });
    $('.carousel-show-port101').css('width', $('#lightbox-port101-1').outerWidth() / 2 + 16);


    $('.carousel-show-port101-nav').owlCarousel({
        margin:12,
        stagePadding:0,
        smartSpeed:450,
        dots:false,
        nav:true,
        // mouseDrag:false,
        // touchDrag:false,
        items:4
    });
    $('.carousel-show-port101-nav').css('width', $('#lightbox-port101-1').outerWidth() / 2 + 16);

    // Change defaults
    $('[data-fancybox]').fancybox({
        touch: false
    });

    let fotoNav = document.getElementById("foto-nav");
    fotoNav.addEventListener('click', function(event){
        event.preventDefault();
        fotoNav.removeAttribute("tabindex", "1");
    });
})

