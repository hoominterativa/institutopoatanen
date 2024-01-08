$('.carousel-topics-copa02-page').owlCarousel({
    margin:80,
    stagePadding:0,
    smartSpeed:450,
    dots:true,
    nav:false,
    rewind: true,
    autoHeight: true,
    loop:false,
    responsive: {
        // breakpoint from 0 up
        0 : {
            items:1
        },
        // breakpoint from 500 up
        500 : {
            items:1
        },
        // breakpoint from 800 up
        800 : {
            items:3,

        }
    }
});
