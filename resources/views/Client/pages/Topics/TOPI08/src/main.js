import Swiper from 'swiper/bundle'

new Swiper ('.topi08__topics__carousel', {
    autoHeight: true,
    slidesPerView: 'auto',
    spaceBetween: 8,

    pagination: {
        el: '.topi08__topics__carousel__swiper-pagination',
        clickable: true,
      },
})
