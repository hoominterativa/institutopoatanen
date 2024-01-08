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
        // 576: {
        //     items: 2,
        // },
        768: {
            items: 3,
            autoWidth: false,
        },
        992: {
            items: 4,
        },
    },
});
