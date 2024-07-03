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

new Swiper(".port05-show__related__carousel", {
    slidesPerView: 1,
    spaceBetween: 8,
    direction: "vertical",
    height: 375,
    grid: {
        rows: 1,
    },
    breakpoints: {
        992: {
            grid: {
                rows: 3,
            },
        },
        720: {
            grid: {
                rows: 2,
            },
        },
    },
});
