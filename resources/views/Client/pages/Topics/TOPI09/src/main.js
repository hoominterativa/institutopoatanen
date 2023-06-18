$(function () {
    if($(window).outerWidth() <= 768){
        $(".row--carrossel").addClass("owl-carousel");
        $(".row--carrossel").addClass("topi09__carousel");
        $(".topi09__box").css("width", "100%");
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
                    margin: 0,
                    margin: 46,
                },
                // breakpoint from 360 up
                425: {
                    items: 2,
                    margin: 46,
                },
                768: {
                    items: 2,
                    margin: 46,
                },
            },
        });

        $(".topi09__carousel").css("width", $(window).outerWidth());
    }
});
