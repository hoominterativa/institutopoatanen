/* SECTION */
var owlPortfolios = $('.port04__portfolios__carousel');
owlPortfolios.addClass('owl-carousel')
owlPortfolios.owlCarousel({
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
/* END SECTION */

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
var owlContent = $('.port04-page__portfolio__content__carousel');
owlContent.addClass('owl-carousel')
owlContent.owlCarousel({
    loop:false,
    nav:false,
    dots:true,
    margin:24,
    rewind:true,
    autoWidth: true,
    responsive:{
        0:{
            items:1,
            autoWidth: false


        },
        576.98:{
            items: 2,
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
/* END PAGE */

/* BEGIN SHOW */
/* BEGIN TOPICS */
var owlTopics = $('.port04-show__content__topics__carousel');
owlTopics.addClass('owl-carousel')
owlTopics.owlCarousel({
    loop:false,
    nav:false,
    dots:false,
    margin:24,
    rewind:true,
    autoWidth: true,
    autoplay: 3000,
    responsive:{
        0:{
            items:1,
            autoWidth: false,
        },
        576.98:{
            items: 1,
        },

        767.98:{
            items:2
        },
        991.98:{
            items:3
        },
        1199.98:{
            items:4
        },
        1399.98:{
            items:8
        }
    }
})
/* END TOPICS */

/* BEGIN GALLERY */
var owlGallery = $('.port04-show__content__gallery__carousel');
owlGallery.addClass('owl-carousel')
owlGallery.owlCarousel({
    loop:false,
    nav:false,
    dots:true,
    margin:24,
    rewind:true,
    autoWidth: true,
    responsive:{
        0:{
            items:1,
            autoWidth: false
        },
        576.98:{
            items: 2,
        },

        767.98:{
            items:3
        },
        991.98:{
            items:5
        },
        1199.98:{
            items:4
        },
        1399.98:{
            items:8
        }
    }
})
/* END GALLERY */

/* BEGIN RELATED-ITEMS */
var owlRelated = $('.port04-show__related-items__carousel');
owlRelated.addClass('owl-carousel')
owlRelated.owlCarousel({
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
            items:2,
        },
        767.98:{
            items:4,

        },
        991.98:{
            items:4,

        },
        1199.98:{
            items:4,

        },
        2000:{
            items:5,

        }
    }
});
/* END RELATED-ITEMS */

/* END SHOW */
