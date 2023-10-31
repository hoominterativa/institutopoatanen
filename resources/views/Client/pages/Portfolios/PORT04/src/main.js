/* SECTION */
var owlProtfolios = $('.port04__portfolios__carousel');
owlProtfolios.addClass('owl-carousel')
owlProtfolios.owlCarousel({
    loop:false,
    nav:false,
    dots:true,
    margin:24,
    rewind:true,
    autoWidth: true,
    autoHeight: true,
    responsive:{
        0:{
            items:1,
            autoWidth: false
        },
        575.98:{
            items:2
        },
        960:{
            items:4,

        },
        2000:{
            items:5,

        }
    }
});
/* PAGE */
/* BEGIN CATEGORIES */
var owlCaterories = $('.port04-page__portfolio__categories__carousel');
owlCaterories.addClass('owl-carousel')
owlCaterories.owlCarousel({
    loop:false,
    nav: false,
    dots:false,
    margin:24,
    rewind:true,
    autoWidth: true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        960:{
            items:5
        },
        1200:{
            items:4
        },
        2000:{
            items:8
        }
    }
});

/* END CATEGORIES */


/* BEGIN CONTENT */
var owlCaterories = $('.port04-page__portfolio__content__carousel');
owlCaterories.addClass('owl-carousel')
owlCaterories.owlCarousel({
    loop:false,
    nav:false,
    dots:true,
    margin:24,
    rewind:true,
    autoWidth: true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        960:{
            items:5
        },
        1200:{
            items:4
        },
        2000:{
            items:8
        }
    }
});

/* END CONTENT */
