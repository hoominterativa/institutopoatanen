$(function () {
    if ($(window).outerWidth()) {
        $(".carousel-serv07").addClass("owl-carousel");
        $(".carousel-serv07").owlCarousel({
            margin: 0,
            stagePadding: 0,
            smartSpeed: 450,
            dots: true,
            nav: false,
            rewind: true,
            responsive: {
                // breakpoint from 0 up
                0: {
                    items: 1,
                },
                // breakpoint from 360 up
                361: {
                    items: 1,
                },
                // breakpoint from 768 up
                800: {
                    items: 5,
                },
            },
        });
    }
});

$(function () {
    if ($(window).outerWidth() <= 800) {
        $(".carousel-serv07-product").addClass("owl-carousel");
        $(".carousel-serv07-product").owlCarousel({
            margin: 0,
            stagePadding: 0,
            smartSpeed: 450,
            dots: false,
            nav: false,
            rewind: true,
            responsive: {
                // breakpoint from 0 up
                0: {
                    items: 1,
                },
                // breakpoint from 360 up
                361: {
                    items: 1,
                },
                // breakpoint from 768 up
                800: {
                    items: 5,
                },
            },
        });
    }
});

$(function () {
    if ($(window).outerWidth()) {
        $(".serv07__gallery__main").addClass("owl-carousel");
        $(".serv07__gallery__main").owlCarousel({
            margin: 0,
            stagePadding: 0,
            smartSpeed: 450,
            dots: true,
            nav: true,
            rewind: true,
            responsive: {
                // breakpoint from 0 up
                0: {
                    items: 1,
                },
            },
        });
    }
});

$(function () {
    if ($(window).outerWidth()) {
        $(".serv07__gallery__thumbnail__carousel").addClass("owl-carousel");
        $(".serv07__gallery__thumbnail__carousel").owlCarousel({
            margin: 0,
            stagePadding: 0,
            smartSpeed: 450,
            dots: true,
            nav: false,
            rewind: true,
            responsive: {
                // breakpoint from 0 up
                0: {
                    items: 1,
                },
                // breakpoint from 360 up
                361: {
                    items: 1,
                },
                // breakpoint from 768 up
                800: {
                    items: 4,
                },
            },
        });
    }
});

$(function () {
    if ($(window).outerWidth()) {
        $(".carousel-serv07-section-product").addClass("owl-carousel");
        $(".carousel-serv07-section-product").owlCarousel({
            margin: 0,
            stagePadding: 0,
            smartSpeed: 450,
            dots: true,
            nav: false,
            rewind: true,
            responsive: {
                0: {
                    items: 1,
                },
                600: {
                    items: 2,
                },
                900: {
                    items: 3,
                },
                1200: {
                    items: 4,
                },
            },
        });
    }
});

$(function () {
    if ($(window).outerWidth()) {
        $(".carousel-serv07-show-section-product").addClass("owl-carousel");
        $(".carousel-serv07-show-section-product").owlCarousel({
            margin: 0,
            stagePadding: 0,
            smartSpeed: 450,
            dots: true,
            nav: false,
            rewind: true,
            responsive: {
                // breakpoint from 0 up
                0: {
                    items: 1,
                },
                // breakpoint from 360 up
                361: {
                    items: 1,
                },
                // breakpoint from 768 up
                800: {
                    items: 5,
                },
            },
        });
    }
});

$(".serv07-show__info__gallery__carousel").addClass("owl-carousel");
$(".serv07-show__info__gallery__carousel").owlCarousel({
    loop: false,
    dots: true,
    nav: false,
    rewind: true,
    autoHeight: true,
    margin: 10,
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

if ($(".serv07-show__galleries__thumbnail").length > 5) {
    $(".serv07-show__galleries__carousel").addClass("owl-carousel");
    $(".serv07-show__galleries__carousel").owlCarousel({
        loop: false,
        dots: true,
        nav: false,
        rewind: true,
        autoHeight: true,
        margin: 0,
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
                items: 4,
            },
            980: {
                items: 5,
            },
        },
    });
}

$(".serv07-show__btnForm--showForm").on("click", function () {
    if ($(this).hasClass("active")) {
        $(".serv07-show__wrapForm").removeClass(
            "serv07-show__wrapForm--showForm"
        );
        $(this).removeClass("active");
        $(".serv07-show__form").slideUp("fast");
    } else {
        $(".serv07-show__wrapForm").addClass("serv07-show__wrapForm--showForm");
        $(this).addClass("active");
        $(".serv07-show__form").slideDown("fast");
    }
});

$("body, html").on(
    "click",
    ".serv07-show__info__gallery__thumbnail",
    function (e) {
        var img = $(this).attr("src");
        $(".serv07-show__info__gallery__imgMain").attr("src", img);
    }
);

$("body, html").on(
    "click",
    ".serv07-show__info__gallery__options__item",
    function (e) {
        e.preventDefault();
        $(".serv07-show__info__gallery__options__item").removeClass(
            "serv07-show__info__gallery__options__item--active"
        );
        $(this).addClass("serv07-show__info__gallery__options__item--active");
    }
);

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

$(".serv07-show__info__gallery__options__item").on("click", function (e) {
    e.preventDefault();
    var id = $(this).data("id"),
        url = $(this).data("url");

    $.ajax({
        type: "POST",
        url: url,
        data: { id },
        success: function (response) {
            console.log(response);
            $("#receiveGallery > *").remove();
            $("#receiveGallery").append(response);

            $(".serv07-show__info__gallery__carousel").addClass("owl-carousel");
            $(".serv07-show__info__gallery__carousel").owlCarousel({
                loop: false,
                dots: true,
                nav: false,
                rewind: true,
                autoHeight: true,
                margin: 10,
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
        },
    });
});
