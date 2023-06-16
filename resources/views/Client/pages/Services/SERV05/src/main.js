$(".serv05__carousel").owlCarousel({
    smartSpeed: 450,
    loop: true,
    dots: true,
    nav: false,
    rewind: true,
    autoHeight: true,
    margin: 12,
    responsive: {
        0: {
            items: 1,
        },
        // breakpoint from 0 up
        520: {
            items: 2,
        },
        // breakpoint from 361 up
        768: {
            items: 3,
        },
        980: {
            items: 4,
        },
    },
});

$(".serv05-banner-carousel").owlCarousel({
    smartSpeed: 450,
    loop: true,
    dots: true,
    nav: false,
    rewind: true,
    autoHeight: true,
    margin: 0,
    items: 1,
});

$(".serv05-show__topics__carousel").owlCarousel({
    smartSpeed: 450,
    loop: true,
    dots: true,
    nav: false,
    rewind: true,
    autoHeight: true,
    margin: 30,
    responsive: {
        0: {
            items: 1,
        },
        620: {
            items: 2,
        },
        980: {
            items: 3,
        },
    },
});
