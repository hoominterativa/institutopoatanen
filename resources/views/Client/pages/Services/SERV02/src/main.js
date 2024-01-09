$(".serv02__carousel").owlCarousel({
    autoHeight: true,
    autoWidth: false,
    dots: true,
    nav: false,
    margin: 12,
    responsive: {
        0: {
            autoWidth: true,
            items: 1,
        },
        768: {
            items: 3,
            autoWidth: false,
        },
        992: {
            items: 4,
        },
    },
});

$(".serv02-show__header__categories__carousel").owlCarousel({
    autoHeight: true,
    autoWidth: true,
    dots: false,
    nav: false,
    margin: 12,
    responsive: {
        0: {
            items: 1,
        },
        768: {
            items: 4,
        },
        992: {
            items: 5,
        },
    },
});

$(".serv02-show__topics__carousel").owlCarousel({
    autoHeight: true,
    autoWidth: false,
    dots: false,
    nav: false,
    margin: 12,
    responsive: {
        0: {
            items: 1,
            autoWidth: true,
        },
        768: {
            items: 3,
            autoWidth: false,
        },
        992: {
            items: 4,
        },
    },
});
