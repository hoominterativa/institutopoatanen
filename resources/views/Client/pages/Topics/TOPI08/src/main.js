import Swiper from 'swiper/bundle'

new Swiper ('.topi08__topics', {
    autoHeight: true,
    slidesPerView: 'auto',
    spaceBetween: 8,

    pagination: {
        el: '.topi08__topics__swiper-pagination',
        clickable: true,
      },
})
