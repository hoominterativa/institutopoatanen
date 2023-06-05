$(function () {
    // if($(window).outerWidth() <= 800){
    // $("topi08__carousel").addClass("owl-carousel");
    $(".topi08__carousel").owlCarousel({
        margin: 0,
        smartSpeed: 450,
        dots: false,
        nav: false,
        rewind: true,
        margin: -70,
        items: 3,
        responsive: {
            // breakpoint from 0 up
            0: {
                items: 1,
            },
            // breakpoint from 360 up
            361: {
                items: 1,
            },
        },
    });
    // }
    $(".topi08__carousel").css("width", $(window).outerWidth() + 300);
});
