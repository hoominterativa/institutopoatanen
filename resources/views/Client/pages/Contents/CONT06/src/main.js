const buttonsPlay = document.querySelectorAll('.cont06__video__button');

if(buttonsPlay) {
    buttonsPlay.forEach(el =>{
        el.addEventListener('click', () =>{
            const src = el.parentNode.dataset.src;
            const iframe = document.createElement('iframe');

            iframe.setAttribute('src', src+'?autoplay=1');
            iframe.classList.add('cont06__video__iframe');
            iframe.setAttribute('id', 'urlYoutube');

            el.style.display = 'none';

            el.parentNode.appendChild(iframe);

        })
    })
}
