$(".unit03-show__top__carousel").owlCarousel({
    smartSpeed: 450,
    loop: false,
    dots: false,
    nav: true,
    rewind: true,
    autoHeight: true,
    responsive: {
        0: {
            items: 3,
            margin: 10,
        },
        // breakpoint from 0 up
        361: {
            items: 3,
            margin: 10,
        },
        // breakpoint from 361 up
        801: {
            items: 3,
            margin: 20,
        },
        // breakpoint from 801 up
    },
});

$(".unit03-show__content__carousel").owlCarousel({
    smartSpeed: 450,
    loop: false,
    dots: true,
    nav: false,
    rewind: true,
    autoHeight: true,
    items: 1,
});
