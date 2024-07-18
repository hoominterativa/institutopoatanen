<<<<<<< Updated upstream
const buttonsPlay = document.querySelectorAll('.cont06v1__video__button');
=======
const buttonsPlay = document.querySelectorAll('#video_play');
>>>>>>> Stashed changes

if(buttonsPlay) {
    buttonsPlay.forEach(el =>{
        el.addEventListener('click', () =>{
            const src = el.parentNode.dataset.src;
            const iframe = document.createElement('iframe');

            iframe.setAttribute('src', src+'?autoplay=1');
            iframe.classList.add('cont06v1__video__iframe');
            iframe.setAttribute('id', 'urlYoutube');

            el.style.display = 'none';

            el.parentNode.appendChild(iframe);

        })
    })
}
<<<<<<< Updated upstream
/* CONT06 */
=======
var swiper = new Swiper(".mySwiper", {
    slidesPerView: 4,
    spaceBetween: 30,
    freeMode: true,
    pagination: {
      el: ".swiper-pagination",
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
      clickable: true,
    },
  });
>>>>>>> Stashed changes
