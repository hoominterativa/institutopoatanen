import Swiper from 'swiper/bundle'

new Swiper ('.feed05__main', {
    slidesPerView: 3,
    spaceBetween: '32',
    centeredSlides: true,
    loop: true,
    slideActiveClass: 'active',
    centeredSlidesBounds: true,

    navigation: {
        nextEl: ".feed05__main__nav__swiper-button-next",
        prevEl: ".feed05__main__nav__swiper-button-prev",
      },
})
