$(".bran01__content__carousel").owlCarousel({
    loop: false,
    nav: false,
    dots: true,
    margin: 12,
    rewind: true,
    autoHeight: true,
    autoWidth: true,
    responsive: {
        0: {
            items: 1,
        },
        575.98: {
            items: 2,
        },
        767.98: {
            items: 3,
        },
        991.98: {
            items: 4,
            autoWidth: false,
        },
    },
});
