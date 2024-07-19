
const buttonsPlay = document.querySelectorAll('#video_play');
if(buttonsPlay) {
    buttonsPlay.forEach(el =>{
        el.addEventListener('click', () =>{
            const src = el.parentNode.dataset.src;
            const iframe = document.createElement('iframe');

            iframe.setAttribute('src', src+'?autoplay=1');
            iframe.classList.add('copa04-page__video-section__video__iframe');
            iframe.setAttribute('id', 'urlYoutube');

            el.style.display = 'none';

            el.parentNode.appendChild(iframe);

        })
    })
}

var swiper = new Swiper(".mySwiper", {
    slidesPerView: "auto",
    spaceBetween: 30,
    navigation: {
        prevEl: ".copa04-page__topics-carousel__butons-down__right",
        nextEl: ".copa04-page__topics-carousel__butons-down__left",
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
  });
