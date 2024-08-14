import Swiper from "swiper/bundle";

new Swiper(".cont14__categories", {
    slidesPerView: "auto",
    spaceBetween: 16,
    breakpoints: {
        991.98: {
            direction: "vertical",
        },
    },
});

new Swiper(".cont14__information__carousel", {
    slidesPerView: 1,
    spaceBetween: 8,
});

const token = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");
const categories = document.querySelectorAll(".cont14__categories__item");

if (categories) {
    const mainInformation = document.querySelector(".cont14__information");
    categories.forEach((category) => {
        const url = category.dataset.url;
        category.addEventListener("click", () => {
            fetch(url, {
                headers: {
                    "X-CSRF-TOKEN": token,
                },
                method: "POST",
            })
                .then((res) => res.text())
                .then((text) => {
                    mainInformation.innerHTML = text;
                })
                .then(() => {
                    new Swiper(".cont14__information__carousel", {
                        slidesPerView: 1,
                        spaceBetween: 8,
                    });
                })
                .then(() => {
                    category.parentNode
                        .querySelector(".cont14__categories__item.active")
                        .classList.remove("active");
                    category.classList.add("active");
                });
        });
    });
}
