import Swiper from 'swiper/bundle'
// import { Navigation, Pagination } from 'swiper/modules';

new Swiper ('.topi08__topics', {
    autoHeight: true,
    slidesPerView: 'auto',
    spaceBetween: 8,

    pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
})
