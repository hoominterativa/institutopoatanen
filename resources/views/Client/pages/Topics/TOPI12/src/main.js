import Swiper from 'swiper/bundle';

new Swiper('.topi12__topics', {
    direction: "vertical",
    slidesPerView: 1,
    centeredSlides: true,
    loop: true,
    slideActiveClass: "topi12__active",
    centeredSlidesBounds: true,
    breakpoints: {
        991.98:{
            slidesPerView: 2
        }
    },
    navigation: {
        nextEl: ".topi12__topics__navigation__swiper-button-next",
        prevEl: ".topi12__topics__navigation__swiper-button-prev ",
    },



});
