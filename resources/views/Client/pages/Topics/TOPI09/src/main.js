$(function () {
    $(".topi09__carousel").owlCarousel({
        margin: 0,
        smartSpeed: 450,
        dots: false,
        nav: false,
        rewind: true,
        items: 3,
        responsive: {
            // breakpoint from 0 up
            0: {
                items: 1,
                margin: 46,
            },
            576: {
                items: 2,
                margin: 46,
            },
            800: {
                items: 3,
                margin: 46,
            },
            1000: {
                items: 4,
                margin: 46,
            },
        },
    });

    // }
});
