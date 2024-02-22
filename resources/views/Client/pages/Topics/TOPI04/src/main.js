import Swiper from 'swiper/bundle';


new Swiper('.topi04__gallery', {
    slidesPerView: 1,

    navigation: {
        nextEl: ".topi04__gallery__nav__swiper-button-next swiper-button-next",
        prevEl: ".topi04__gallery__nav__swiper-button-prev swiper-button-prev",
      },
});

new Swiper(".topi04__information__topics", {
    slidesPerView: 'auto',
})
