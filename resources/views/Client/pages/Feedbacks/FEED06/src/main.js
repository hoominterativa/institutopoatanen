$(".feed06__carousel").owlCarousel({
    smartSpeed: 450,
    loop: true,
    dots: true,
    nav: false,
    rewind: true,
    autoHeight: true,
    margin: -60,
    responsive: {
        0: {
            items: 1,
            margin: 17,
        },
        // breakpoint from 0 up
        400: {
            items: 1,
            margin: 17,
        },
        // breakpoint from 361 up
        768: {
            items: 1,
            margin: 17,
        },
        // breakpoint from 500 up
        801: {
            items: 2,
        },
        // breakpoint from 801 up
    },
});
