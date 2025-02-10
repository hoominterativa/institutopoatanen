import Swiper from 'swiper/bundle';

new Swiper('.slid01', {
    slidesPerView: 1,
    loop: true,
    pagination: {
        el: '.slid01__swiper-pagination',
        clickable: true,
    },
    autoplay: {
        delay: 80000,
        disableOnInteraction: false,
    },
    speed: 900, // 500 milissegundos para a transição
    effect: 'fade', // ou 'fade', 'cube', etc.
    on: {
        slideChangeTransitionStart: function () {
            // Remove a classe de animação dos slides
            this.slides.forEach(slide => {
                slide.classList.remove('swiper-slide-active');
            });
        },
        slideChangeTransitionEnd: function () {
            // Adiciona a classe ao slide ativo
            this.slides[this.activeIndex].classList.add('swiper-slide-active');
        },
    },
});
