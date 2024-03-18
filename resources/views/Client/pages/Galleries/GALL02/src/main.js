import Swiper from 'swiper/bundle';

new Swiper('.gall02__gallery__carousel', {
    slidesPerView: 'auto',

    navigation: {
        nextEl: ".gall02__gallery__nav__swiper-button-next",
        prevEl: ".gall02__gallery__nav__swiper-button-prev",
    },
});

const galleryLightBoxes = document.querySelectorAll('.gall02-show');

if(galleryLightBoxes.length>0){

    galleryLightBoxes.forEach(el =>{

        var thumbs = new Swiper(el.querySelector('.gall02-show__thumbs'), {
            spaceBetween: 10,
            slidesPerView: 'auto',
            freeMode: true,
            centerInsufficientSlides: true,
            slideToClickedSlide: true,
            watchSlidesProgress: true,


          });

        new Swiper(el.querySelector(".gall02-show__gallery"), {
            spaceBetween: 10,
            slidesPerView: 'auto',

            navigation: {
                nextEl: ".gall02-show__gallery__swiper-button-next",
                prevEl: ".gall02-show__gallery__swiper-button-prev",
            },

            thumbs: {
              swiper: thumbs,
            },
          });


    })

}


