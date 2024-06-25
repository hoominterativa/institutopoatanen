import Swiper from 'swiper/bundle';

new Swiper('.topi13__topics', {
    slidesPerView: "auto",
    spaceBetween: 8,
    slideToClickedSlide: true,
    slideActiveClass: 'topi13__active',
    loop: true
});

const topi13Items = document.querySelectorAll(".topi13__topics__item");

if(topi13Items){
    topi13Items.forEach((el, i) =>{
        console.log('item :' + i);
        console.log('color: ' + el.dataset.color);
        console.log('bgDesktop: ' + el.dataset.bgDesktop);
        console.log('bgMobile: ' + el.dataset.bgMobile);

        // el.addEventListener("click", ()=>{
        //     el.parentElement.querySelector('.topi13__active').classList.remove('topi13__active');
        //     el.classList.add('topi13__active');
        // })
    })
}
