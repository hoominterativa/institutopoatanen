$(function () {
    // if($(window).outerWidth() <= 800){
    $(".blog01__boxs__carousel").addClass("owl-carousel");
    $(".blog01__boxs__carousel").owlCarousel({
        margin: 10,
        stagePadding: 0,
        smartSpeed: 450,
        dots: true,
        nav: false,
        items: 4,
        rewind: true,
        responsive: {
            // breakpoint from 0 up
            0: {
                items: 1,
            },
            // breakpoint from 360 up
            361: {
                items: 1,
            },
            // breakpoint from 768 up
            800: {
                items: 4,
                touchDrag: false,
                mouseDrag: false,
            },
        },
    });

    $(".blog01-page__header__category__carousel").addClass("owl-carousel");
    $(".blog01-page__header__category__carousel").owlCarousel({
        margin: 10,
        stagePadding: 0,
        smartSpeed: 450,
        dots: false,
        nav: false,
        rewind: true,
        responsive: {
            // breakpoint from 0 up
            0: {
                items: 2,
            },
        },
    });
    // }

    $(".blog01-page__boxs__featured__carousel").addClass("owl-carousel");
    $(".blog01-page__boxs__featured__carousel").owlCarousel({
        margin: 10,
        stagePadding: 0,
        smartSpeed: 450,
        dots: true,
        nav: false,
        rewind: true,
        responsive: {
            // breakpoint from 0 up
            0: {
                items: 1,
            },
            // breakpoint from 360 up
            361: {
                items: 1,
            },
            // breakpoint from 768 up
            800: {
                items: 1,
            },
        },
    });
});
