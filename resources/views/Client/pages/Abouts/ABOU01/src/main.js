$(function () {
    $(".abou01-page__topics__carousel").owlCarousel({
        margin: 5,
        stagePadding: 0,
        smartSpeed: 450,
        dots: true,
        nav: false,
        rewind: true,
        autoHeight: true,
        responsive: {
            // breakpoint from 0 up
            0: {
                items: 1,
            },
            // breakpoint from 361 up
            576: {
                items: 2,
            },
            // breakpoint from 800 up
            768: {
                items: 3,
                touchDrag: false,
                mouseDrag: false,
            },
        },
    });
});
