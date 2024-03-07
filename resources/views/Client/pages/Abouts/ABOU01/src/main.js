import Swiper from 'swiper/bundle';

new Swiper('.abou01-page__topics__carousel', {
    slidesPerView:  'auto',
    spaceBetween: 24,

    pagination: {
        el: '.abou01-page__topics__carousel__swiper-pagination',
        clickable: true,
      },
});
