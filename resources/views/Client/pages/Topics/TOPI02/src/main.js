import Swiper from 'swiper/bundle';

const swiper = new Swiper('.topi02__topics', {
    slidesPerView: 'auto',
    spaceBetween: 12,
    breakpoints:{
        992:{
            spaceBetween: 32
        }
    }
});
