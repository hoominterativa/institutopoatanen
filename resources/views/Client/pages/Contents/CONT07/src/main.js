import Swiper from 'swiper/bundle';

new Swiper('.cont07__gallery__carousel', {
    slidesPerView: 'auto',
    spaceBetween: 20,

    navigation: {
        nextEl: ".cont07__gallery__nav__swiper-button-next",
        prevEl: ".cont07__gallery__nav__swiper-button-prev",
      },
});


// O botão abre o primeiro elemento da galeria de vídeos
const buttonPlay = document.querySelector('.cont07__video__button');

if(buttonPlay) {
    buttonPlay.addEventListener('click', () => {
      document.querySelector('.cont07__gallery__item').click();
    })
}
