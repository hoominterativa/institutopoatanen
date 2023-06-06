$(function () {
    // if($(window).outerWidth() <= 800){
    // $("topi08__carousel").addClass("owl-carousel");
    $(".topi08__carousel").owlCarousel({
        margin: 0,
        smartSpeed: 450,
        dots: false,
        nav: false,
        rewind: true,
        margin: -140,
        items: 3,
        responsive: {
            // breakpoint from 0 up
            0: {
                items: 1,
                margin: 0,
            },
            // breakpoint from 360 up
            425: {
                items: 2,
                margin: 0,
            },
            769: {
                items: 3,
                margin: -42,
            },
            1200: {
                margin: -80,
            },
            1320: {
                margin: -120,
            }
        },
    });
    // }
    $(".topi08__carousel").css("width", $(window).outerWidth() + 300);
});
