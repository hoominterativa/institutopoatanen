import Swiper from "swiper/bundle";

new Swiper(".sche01__carousel", {
    slidesPerView: "auto",
    spaceBetween: 12,
    navigation: {
        prevEl: ".sche01__carousel__nav__swiper-button-prev",
        nextEl: ".sche01__carousel__nav__swiper-button-next",
    },
});
