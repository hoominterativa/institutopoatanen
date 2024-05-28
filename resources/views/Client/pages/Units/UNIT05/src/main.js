import Swiper from "swiper/bundle";

new Swiper(".unit05__categories", {
    slidesPerView: "auto",
    spaceBetween: 12,
});

new Swiper(".unit05__content__gallery", {
    slidesPerView: 1,
    navigation: {
        prevEl: ".unit05__content__gallery__nav__swiper-button-prev",
        nextEl: ".unit05__content__gallery__nav__swiper-button-next",
    },
});

new Swiper(".unit05__content__information__subcategories", {
    slidesPerView: "auto",
    spaceBetween: 8,
    navigation: {
        prevEl: ".unit05__content__information__subcategories__nav__swiper-button-prev",
        nextEl: ".unit05__content__information__subcategories__nav__swiper-button-next",
    },

    breakpointsBase: "container",
    breakpoints: {
        620: {
            slidesPerView: 4,
        },
        500: {
            slidesPerView: 3,
        },
    },
});

new Swiper(".unit05-page__menus__categories", {
    slidesPerView: "auto",
    spaceBetween: 12,
});

new Swiper(".unit05-page__menus__subcategories", {
    slidesPerView: "auto",
    spaceBetween: 12,
});
