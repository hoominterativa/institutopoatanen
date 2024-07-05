import Swiper from 'swiper/bundle';

new Swiper(".unit01__categories", {
    slidesPerView: "auto",
    spaceBetween: 20,
});

new Swiper(".unit01__main__item__gallery", {
    slidesPerView: 1,
    spaceBetween: 20,
    navigation: {
        prevEl: ".unit01__main__item__gallery__swiper-button-prev",
        nextEl: ".unit01__main__item__gallery__swiper-button-next",
    },
});

new Swiper(".unit01-show__carousel", {
    slidesPerView: 1,
    spaceBetween: 0,
    navigation: {
        prevEl: ".unit01-show__carousel__nav__swiper-button-prev",
        nextEl: ".unit01-show__carousel__nav__swiper-button-next",
    },
});
