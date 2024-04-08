import Swiper from "swiper/bundle";

new Swiper(".serv09__categories", {
    slidesPerView: "auto",
    spaceBetween: 18,
    centerInsufficientSlides: true,
});

new Swiper(".serv09__main__carousel", {
    slidesPerView: "auto",
    spaceBetween: 16,

    pagination: {
        el: ".serv09__main__carousel__swiper-pagination",
        clickable: true,
    },
});

new Swiper(".serv09-page__aside__categories", {
    slidesPerView: "auto",
    spaceBetween: 18,
});

new Swiper(".serv09-show__topics", {
    slidesPerView: "auto",
    spaceBetween: 18,
});

new Swiper(".serv09-show__gallery", {
    slidesPerView: "auto",
    spaceBetween: 18,

    pagination: {
        el: ".serv09-show__gallery__swiper-pagination",
        clickable: true,
    },
});

new Swiper(".serv09-show__feedbacks__carousel", {
    slidesPerView: 1,
    navigation: {
        nextEl: ".serv09-show__feedbacks__carousel__nav__swiper-button-next",
        prevEl: ".serv09-show__feedbacks__carousel__nav__swiper-button-prev",
    },
});

new Swiper(".serv09-show__related__categories", {
    slidesPerView: "auto",
    spaceBetween: 18,
    centerInsufficientSlides: true,
});

new Swiper(".serv09-show__related__main__carousel", {
    slidesPerView: "auto",
    spaceBetween: 16,

    pagination: {
        el: ".serv09-show__related__main__carousel__swiper-pagination",
        clickable: true,
    },
});
