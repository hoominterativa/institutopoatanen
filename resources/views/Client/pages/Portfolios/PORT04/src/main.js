import Swiper from 'swiper/bundle';

new Swiper('.port04__portfolios__carousel', {
    slidesPerView: 'auto',
    spaceBetween: 12,

    pagination: {
        el: '.port04__portfolios__carousel__swiper-pagination',
        clickable: true,
      },
});

new Swiper(".port04-page__portfolio__categories", {
    slidesPerView: "auto",
    spaceBetween: 20,
    centerInsufficientSlides: true,
});

new Swiper('.port04-page__portfolio__main__carousel', {
    slidesPerView: 'auto',
    spaceBetween: 12,

    pagination: {
        el: '.port04-page__portfolio__main__carousel__swiper-pagination',
        clickable: true,
      },
});

new Swiper('.port04-show__content__topics__carousel', {
    slidesPerView: 'auto',
    spaceBetween: 20,

});

new Swiper('.port04-show__content__gallery__carousel', {
    slidesPerView: 'auto',
    spaceBetween: 12,

    pagination: {
        el: '.port04-show__content__gallery__carousel__swiper-pagination',
        clickable: true,
      },
});

new Swiper('.port04-show__related__main__carousel', {
    slidesPerView: 'auto',
    spaceBetween: 12,

    pagination: {
        el: '.port04-show__related__main__carousel__swiper-pagination',
        clickable: true,
      },
});
