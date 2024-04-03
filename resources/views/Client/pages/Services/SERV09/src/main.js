import Swiper from "swiper/bundle";

new Swiper(".serv09__categories", {
    slidesPerView: "auto",
    spaceBetween: 18,
    centerInsufficientSlides: true,
});

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
            items: 1,
        },
        // breakpoint from 400 down
        520: {
            items: 1,
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

$(".carousel-section-gallery").owlCarousel({
    smartSpeed: 450,
    loop: true,
    dots: true,
    nav: false,
    rewind: true,

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
            items: 4,
        },
        // breakpoint from  768 down
    },
});

$(".carousel-section-gallery").css("width", $(window).outerWidth());

$(".carousel-section-feedbacks").owlCarousel({
    items: 1,
    loop: true,
    autoplay: true,
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
    nav: true,
    // navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
    // onInitialized: function (event) {
    //     $(".owl-prev", event.target).hide();
    // },
    // onChanged: function (event) {
    //     if (event.item.index === 0) {
    //     $(".owl-prev", event.target).hide();
    //     } else {
    //     $(".owl-prev", event.target).show();
    //     }

    //     if (event.item.index === event.item.count - 1) {
    //     $(".owl-next", event.target).hide();
    //     } else {
    //     $(".owl-next", event.target).show();
    //     }
    // }
});

$(".carousel-section-feedbacks").css(
    "width",
    $(
        ".sesh__section-feedbacks .container--sesh__section-feedbacks"
    ).outerWidth()
);

$(".carousel-service-related").owlCarousel({
    smartSpeed: 450,
    loop: true,
    dots: true,
    nav: false,
    rewind: true,
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

$(".carousel-service-related").css(
    "width",
    $(".sesh .sesh__service-related__main").outerWidth()
);
