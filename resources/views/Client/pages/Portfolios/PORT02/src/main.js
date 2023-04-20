var owlCaterories = $('.port02__categories__carousel');
owlCaterories.addClass('owl-carousel')
owlCaterories.owlCarousel({
    loop:false,
    nav:true,
    dots:true,
    margin:10,
    rewind:true,
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
            items:6
        },
        2000:{
            items:8
        }
    }
});

var owlProtfolios = $('.port02__portfolios__carousel');
owlProtfolios.addClass('owl-carousel')
owlProtfolios.owlCarousel({
    loop:false,
    nav:true,
    dots:false,
    margin:10,
    rewind:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        960:{
            items:3
        },
        2000:{
            items:5
        }
    }
});

var owlGallery = $('.port02__show__gallery__thumbnail__carousel');
owlGallery.addClass('owl-carousel')
owlGallery.owlCarousel({
    loop:false,
    nav:true,
    dots:false,
    margin:10,
    rewind:true,
    responsive:{
        0:{
            items:2
        },
        600:{
            items:3
        },
        960:{
            items:4
        },
        2000:{
            items:5
        }
    }
});


$("[data-main-image]").on("click", function() {
    var mainImageSrc = $(this).data("main-image");
    if($(this).hasClass('port02__show__gallery__thumbnail__item--video')){
        $(".port02__show__gallery__main .port02__show__gallery__main__iframe").attr("src", mainImageSrc).fadeIn('fast');
        $(".port02__show__gallery__main .port02__show__gallery__main__item").fadeOut('slow');
    }else{
        $(".port02__show__gallery__main .port02__show__gallery__main__item").attr("src", mainImageSrc).fadeIn('fast');
        $(".port02__show__gallery__main .port02__show__gallery__main__iframe").fadeOut('fast');
    }
});
