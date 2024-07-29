import Swiper from 'swiper/bundle';

const buttonsPlay = document.querySelector('#video_play');
if(buttonsPlay) {
    buttonsPlay.addEventListener('click', () =>{
            const src = buttonsPlay.parentNode.dataset.src;
            const iframe = document.createElement('iframe');

            iframe.setAttribute('src', src+'?autoplay=1');
            iframe.classList.add('copa04-page__video-section__video__iframe');
            iframe.setAttribute('id', 'urlYoutube');

            buttonsPlay.style.display = 'none';

            buttonsPlay.parentNode.appendChild(iframe);


    })
}

new Swiper('.copa04-page__topics-carousel__carousel', {
    slidesPerView: 'auto',
    spaceBetween: 12,
});

new Swiper('.copa04-page__gallery-topics__carousel', {
    slidesPerView: 'auto',
    spaceBetween: 12,
});

new Swiper('.copa04-page__additional-content__carousel', {
    slidesPerView: 1,
    spaceBetween: 12,
});
