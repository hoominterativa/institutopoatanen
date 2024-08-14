import Swiper from "swiper/bundle";

new Swiper(".serv12__categories", {
    slidesPerView: "auto",
    spaceBetween: 20,
    centerInsufficientSlides: true,
});

new Swiper(".serv12__services__carousel", {
    slidesPerView: "auto",
    spaceBetween: 8,
    pagination: {
        el: ".serv12__services__carousel__swiper-pagination",
        clickable: true,
    },
});

new Swiper(".serv12-page__categories", {
    slidesPerView: "auto",
    spaceBetween: 20,
});

new Swiper(".serv12-page__services-section__carousel", {
    slidesPerView: "auto",
    spaceBetween: 24,
});
new Swiper(".serv12-page__services-section__topics", {
    slidesPerView: "auto",
    spaceBetween: 24,
});

function reproduzirVideozinho(playButton, iframeClass) {
    playButton.addEventListener("click", () => {
        const src = playButton.parentNode.dataset.src;
        const iframe = document.createElement("iframe");

        iframe.setAttribute("src", src + "?autoplay=1");
        iframe.classList.add(iframeClass);
        iframe.setAttribute("id", "urlYoutube");

        playButton.style.display = "none";

        playButton.parentNode.appendChild(iframe);
    });
}

const buttonsPlay = document.querySelectorAll(
    ".serv12-page__services-section__video__button"
);

if (buttonsPlay) {
    buttonsPlay.forEach((el) => {
        reproduzirVideozinho(
            el,
            "serv12-page__services-section__video__iframe"
        );
    });
}

// CARROSSEL DO LIGHTBOX
const serv12Show = document.querySelectorAll(".serv12-show");

if (serv12Show) {
    serv12Show.forEach((el) => {
        const thumbs = new Swiper(
            el.querySelector(".serv12-show__gallery__thumbs"),
            {
                spaceBetween: 10,
                slidesPerView: 4,
                freeMode: true,
                slideToClickedSlide: true,
                watchSlidesProgress: true,
            }
        );

        new Swiper(el.querySelector(".serv12-show__gallery__carousel"), {
            slidesPerView: 1,
            spaceBetween: 20,
            thumbs: {
                swiper: thumbs,
            },

            navigation: {
                nextEl: ".serv12-show__gallery__carousel__swiper-button-next",
                prevEl: ".serv12-show__gallery__carousel__swiper-button-prev",
            },
        });

        const videoShow = el.querySelectorAll(
            ".serv12-show__gallery__carousel__item__button"
        );
        if (videoShow) {
            videoShow.forEach((el) =>
                reproduzirVideozinho(
                    el,
                    "serv12-page__services-section__video__iframe"
                )
            );
        }
    });
}
