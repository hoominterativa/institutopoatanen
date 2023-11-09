$(".carousel-serv09").owlCarousel({
    smartSpeed: 450,
    loop: false,
    dots: true,
    nav: false,
    rewind: true,
    autoHeight: true,
    margin: 12,
    responsive: {
        0: {
            items: 1,
        },
        // breakpoint from 0 down
        400: {
            items: 2,
        },
        // breakpoint from 400 down
        520: {
            items: 2,
        },
        // breakpoint from 520 down
        768: {
            items: 2,
        },
        // breakpoint from 768 down
        980: {
            items: 2,
        },
        // breakpoint from  768 down
    },
});

$('.carousel-serv04').css('width', $('.serv09 .container--serv09').outerWidth());