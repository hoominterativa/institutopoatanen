$(function(){
    $('.pota01__boxs__carousel').addClass('owl-carousel');
    $('.pota01__boxs__carousel').owlCarousel({
        margin:10,
        stagePadding:0,
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
                touchDrag: false,
                mouseDrag: false
            }
        }
    });

    $('.pota01-page__header__category__carousel').addClass('owl-carousel');
    $('.pota01-page__header__category__carousel').owlCarousel({
        margin:10,
        stagePadding:0,
        dots:false,
        nav:false,
        rewind: true,
        responsive: {
            // breakpoint from 0 up
            0 : {
                items:2
            },
        }
    });

    $('.pota01-home__featuredHome__caroussel').addClass('owl-carousel');
    $('.pota01-home__featuredHome__caroussel').owlCarousel({
        margin:10,
        stagePadding:0,
        dots:false,
        nav:false,
        rewind: true,
        responsive: {
            // breakpoint from 0 up
            0 : {
                items:2
            },
        }
    });

    $('.pota01-page__boxs__featured__carousel').addClass('owl-carousel');
    $('.pota01-page__boxs__featured__carousel').owlCarousel({
        margin:10,
        stagePadding:0,
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
                items:1
            }
        }
    });
})
