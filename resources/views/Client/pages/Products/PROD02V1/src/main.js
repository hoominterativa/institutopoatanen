$(".carousel-prod02v1").owlCarousel({
    smartSpeed: 450,
    loop: false,
    dots: true,
    nav: false,
    rewind: true,
    autoHeight: true,
    responsive: {
        0: {
            items: 1,
            margin: 10,
        },
        // breakpoint from 0 up
        361: {
            items: 1,
            margin: 10,
        },
        // breakpoint from 361 up
        480: {
            items: 2,
            margin: 10,
        },
        // breakpoint from 480 up
        801: {
            items: 4,
            margin: 20,
        },
        // breakpoint from 801 up
    },
});

$(".carousel-prod02v1").css("width", $(".prod02v1 .container--edit").outerWidth());

if ($(window).outerWidth() <= 801) {
    $(".carousel-prod02v1").css(
        "width",
        $(".prod02v1 .container--edit").outerWidth() + 150
    );
}
// END carousel_prod02v1

if ($(window).outerWidth() <= 801) {
    $(".prod02v1__navigation__nav__mobile").addClass("owl-carousel");
    $(".prod02v1__navigation__nav__mobile").addClass("caroussel-prod02v1-mobile");
    $(".caroussel-prod02v1-mobile").css("width", $(window).outerWidth());

    $(".caroussel-prod02v1-mobile").owlCarousel({
        margin: 10,
        items: 3,
        stagePadding: 0,
        smartSpeed: 450,
        dots: true,
        nav: false,
        rewind: true,
        autoHeight: true,
    });
}

if ($(window).outerWidth() <= 801) {
    $(".prod02v1__page__content__category").addClass("owl-carousel");
    $(".prod02v1__page__content__category").addClass("caroussel_prod02v1-page");

    $(".caroussel_prod02v1-page").owlCarousel({
        stagePadding: 0,
        smartSpeed: 450,
        dots: true,
        nav: false,
        rewind: true,
        autoHeight: true,
        responsive: {
            0: {
                items: 2,
                margin: 12,
            },
            // breakpoint from 0 up
            400: {
                items: 2,
                margin: 12,
            },
            // breakpoint from 400 up
            801: {
                items: 2,
                margin: 20,
            },
            // breakpoint from 801 up
        },
    });
}

$(".caroussel_prod02v1-show").owlCarousel({
    margin: 5,
    items: 1,
    stagePadding: 0,
    smartSpeed: 450,
    dots: true,
    nav: false,
    rewind: true,
    autoHeight: true,
});

$(".caroussel_prod02v1-show").css("width", $(window).outerWidth() / 2 - 108);

var altLightbox = $(".lightbox-prod02v1__content__carrossel").outerHeight();
$(".caroussel_prod02v1-show").css("height", $(altLightbox));

if ($(window).outerWidth() <= 801) {
    $(".caroussel_prod02v1-show").css("width", $(window).outerWidth() - 16);
    // $('.caroussel_prod02v1-show .owl-stage').css('width', $(window).outerWidth() - 150);
    // $('.caroussel_prod02v1-show .owl-item').css('width', $(window).outerWidth() - 150);
}
