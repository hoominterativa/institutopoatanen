$(function(){
    $('.carousel-gall02').css('width', $(window).outerWidth() + 50);

    $('.carousel-gall02').owlCarousel({
        smartSpeed:450,
        loop: false,
        dots:true,
        nav:false,
        margin:0,
        rewind: true,
        autoHeight: true,
        responsive: {

            0 : {
                items:1,
            },
            // breakpoint from 0 up
            361 : {
                items:1,
            },
            // breakpoint from 361 up
            801 : {
                items:5,
            }
            // breakpoint from 801 up
        }
    });

    // $('.carrossel-lightbox-gall02').css('width', $(window).outerWidth());
    // $('.carrossel-lightbox-gall02').owlCarousel({
    //     items: 1,
    //     thumbs: true,
    //     thumbContainerClass: 'carrossel-lightbox-gall02-owl-thumbs',
    //     thumbItemClass: 'carrossel-lightbox-gall02-owl-thumb-item',
    //     nav: true,
    //     navText: ['<', '>']
    //   });

    $('.carrossel-lightbox-gall02').owlCarousel({
        items: 1,
        nav: true,
        dots: false,
        thumbs: true,
        thumbImage: true,
        thumbContainerClass: 'owl-thumbs',
        thumbItemClass: 'thumb'
    });
})