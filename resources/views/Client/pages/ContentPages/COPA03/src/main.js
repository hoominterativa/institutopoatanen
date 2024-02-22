import Swiper from "swiper/bundle";

new Swiper(".copa03__topics__subcategories", {
    slidesPerView: "auto",
    spaceBetween: 16,
});

new Swiper(".copa03__topics__main", {
    slidesPerView: "auto",
    spaceBetween: 12,

    navigation: {
        prevEl: ".copa03__topics__main__nav__swiper-button-prev",
        nextEl: ".copa03__topics__main__nav__swiper-button-next",
    },
});

new Swiper(".copa03__videos__subcategories", {
    slidesPerView: "auto",
    spaceBetween: 16,
});
