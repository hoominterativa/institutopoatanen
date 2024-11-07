import Swiper from "swiper/bundle";

new Swiper(".port06__main__carousel", {
    spaceBetween: 2,
    slidesPerView: 1,
    breakpoints: {
        992: {
            slidesPerView: 4,
        },
        768: {
            slidesPerView: 3,
        },
        576: {
            slidesPerView: 2,
        },
    },
});

new Swiper(".port06-page__categories", {
    slidesPerView: "auto",
    spaceBetween: 7,
    centerInsufficientSlides: true,
});

const port06ButtonsPlay = document.querySelectorAll(
    ".port06-show__gallery__video__button"
);

if (port06ButtonsPlay) {
    port06ButtonsPlay.forEach((el) => {
        el.addEventListener("click", () => {
            const src = el.parentNode.dataset.src;
            const iframe = document.createElement("iframe");

            iframe.setAttribute("src", src + "?autoplay=1");
            iframe.classList.add("port06-show__gallery__video__iframe");
            iframe.setAttribute("id", "urlYoutube");

            el.style.display = "none";

            el.parentNode.appendChild(iframe);
        });
    });
}
