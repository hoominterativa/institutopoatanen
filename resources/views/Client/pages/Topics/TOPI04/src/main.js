import Swiper from 'swiper/bundle';


new Swiper('.topi04__gallery', {
    slidesPerView: 1,

    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
});

new Swiper(".topi04__information__topics", {
    slidesPerView: 'auto',
})
