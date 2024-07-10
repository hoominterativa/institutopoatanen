import Swiper from "swiper/bundle";

new Swiper(".port05__categories", {
    slidesPerView: "auto",
    spaceBetween: 8,
});

new Swiper(".port05-page__content__categories", {
    slidesPerView: "auto",
    spaceBetween: 8,
    centerInsufficientSlides: true,
});

new Swiper(".port05-show__content__categories", {
    slidesPerView: "auto",
    spaceBetween: 8,
    centerInsufficientSlides: true,
});

new Swiper(".port05-show__feedback__carousel", {
    slidesPerView: "auto",
    spaceBetween: 8,
});

// NOTE: AO AJUSTAR ESTE CAROUSEL COM GRID TBM É NECESSÁRIO AJUSTAR O CSS DA CLASSE .swiper-wrapper
new Swiper(".port05-show__related__carousel", {
    slidesPerView: 1,
    spaceBetween: 0,
    direction: "vertical",
    height: 375,
    grid: {
        fill: "column",
        rows: 1,
    },
    breakpoints: {
        992: {
            grid: {
                fill: "row",
                rows: 3,
            },
        },
        767: {
            grid: {
                fill: "row",
                rows: 2,
            },
        },
    },
});
