import Swiper from "swiper/bundle";

new Swiper(".serv12__services__carousel", {
    slidesPerView: "auto",
    spaceBetween: 8,
    pagination: {
        el: ".serv12__services__carousel__swiper-pagination",
        clickable: true,
    },
});


new Swiper(".serv12__categories", {
    slidesPerView: "auto",
    spaceBetween: 20,
    centerInsufficientSlides: true,
});