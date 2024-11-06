import Swiper from "swiper/bundle";

new Swiper(".port06__main__carousel", {
    spaceBetween: 2,
    slidesPerView: 1,
    breakpoints: {
        992: {
            slidesPerView: 4,
        },
        768: {
            slidesPerView: 3,
        },
        576: {
            slidesPerView: 2,
        },
    },
});

new Swiper(".port06-page__categories", {
    slidesPerView: "auto",
    spaceBetween: 7,
    centerInsufficientSlides: true,
});
