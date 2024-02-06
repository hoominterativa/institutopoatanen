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

new Swiper('.topi102__topics', {
    slidesPerView: 'auto',

    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});
