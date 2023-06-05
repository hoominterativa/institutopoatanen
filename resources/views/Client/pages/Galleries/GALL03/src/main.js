$(function () {
    $(".gall03__carousel").owlCarousel({
        smartSpeed: 450,
        loop: false,
        dots: false,
        nav: true,
        margin: 17,
        rewind: true,
        autoHeight: true,
        responsive: {
            0: {
                items: 1,
                // margin: -150,
            },
            // breakpoint from 0 up
            768: {
                items: 1,
                // margin: -150,
            },
            // breakpoint from 361 up
            801: {
                items: 4,
                // margin: 0,
            },
            // breakpoint from 801 up
        },
    });
    $(".gall03__carousel").css("width", $(window).outerWidth());

    let owlGallery = $(".lightbox-gall03__bottom__thumbnail__carousel");
    $(".lightbox-gall03__bottom__thumbnail__carousel").css(
        "width",
        $(window).outerWidth() / 2 - 260
    );
    if ($(window).outerWidth() <= 768) {
        $(".lightbox-gall03__bottom__thumbnail__carousel").css(
            "width",
            $(window).outerWidth() - 107
        );
    }
    owlGallery.addClass("owl-carousel");
    owlGallery.owlCarousel({
        loop: false,
        nav: true,
        dots: false,
        margin: 3,
        rewind: true,
        URLhashListener: true,
        responsive: {
            0: {
                items: 5,
            },
            500: {
                items: 5,
            },
            960: {
                items: 6,
            },
            2000: {
                items: 6,
            },
        },
    });

    $("[data-main-image]").on("click", function () {
        let mainImageSrc = $(this).data("main-image");
        let name = $(this).data("main-title");
        console.log(name);

        if (
            $(this).hasClass("lightbox-gall03__bottom__thumbnail__item--video")
        ) {
            $(".lightbox-gall03__bottom__main__iframe")
                .attr("src", mainImageSrc)
                .fadeIn("fast");
            $(".lightbox-gall03__bottom__main__item").fadeOut("slow");
            $(".lightbox-gall03__bottom__main__legend").text(name);
        } else {
            $(".lightbox-gall03__bottom__main__item")
                .attr("src", mainImageSrc)
                .fadeIn("fast");
            $(".lightbox-gall03__bottom__main__iframe").fadeOut("fast");
            $(".lightbox-gall03__bottom__main__legend").text(name);
        }
    });
});
