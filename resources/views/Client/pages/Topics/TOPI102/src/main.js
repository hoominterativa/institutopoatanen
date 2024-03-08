import Swiper from 'swiper/bundle';

new Swiper('.topi102__navigation', {
    slidesPerView: 'auto',
    spaceBetween: 8,
    breakpoints: {
        992: {
            slidesPerView: 3,
            spaceBetween: 64,

        }
    }
});

new Swiper('.topi102__topics__carousel', {
    slidesPerView: 'auto',

    navigation: {
        nextEl: ".topi102__topics__carousel__nav__swiper-button-next",
        prevEl: ".topi102__topics__carousel__nav__swiper-button-prev",
    },
});
