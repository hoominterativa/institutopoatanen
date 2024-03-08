import Swiper from 'swiper/bundle';

new Swiper('.topi02__topics__carousel', {
    slidesPerView: 'auto',
    spaceBetween: 12,
    breakpoints:{
        992:{
            spaceBetween: 32
        }
    }
});
