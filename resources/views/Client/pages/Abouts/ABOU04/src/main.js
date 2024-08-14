import Swiper from "swiper/bundle";

new Swiper(".abou04-page__topics__carousel", {
    slidesPerView: 1,
    spaceBetween: 28,
    breakpoints: {
        728: {
            slidesPerView: 2,
        },
        992: {
            slidesPerView: 3,
        },
    },
});
