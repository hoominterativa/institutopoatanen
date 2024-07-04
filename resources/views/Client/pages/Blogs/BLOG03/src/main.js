import Swiper from "swiper/bundle";

new Swiper(".blog03__main", {
    slidesPerView: "auto",
    spaceBetween: 32,
})
new Swiper(".blog03-show__related__carousel", {
    slidesPerView: "auto",
    spaceBetween: 32,
})

// CONSTANTES PARA COMPARTILHAMENTO
const shareButton = document.querySelector(".blog03-show__article__share");

// FRONTEND: FAZER COM O TOGGLE;
if (shareButton) {
    const modal = document.querySelector(".blog03-show__article__modal");
    const closeButton = document.querySelector(
        ".blog03-show__article__modal__header__close"
    );
    const copyButton = document.querySelector(
        ".blog03-show__article__modal__main__copy__button"
    );
    const link = document.querySelector(
        ".blog03-show__article__modal__main__copy__link"
    );
    const url = window.location.href;
    const whatsapp = document.querySelector("#whatsapp");
    const facebook = document.querySelector("#facebook");
    const x = document.querySelector("#x");
    const email = document.querySelector("#email");
    const text = "Confira este link: ";

    function handlePostModalOpen(m) {
        m.showModal();
        m.classList.add("open");
        document.querySelector("body").style.overflowY = "hidden";
    }

    function handlePostModalClose(m) {
        m.classList.remove("open");
        document.querySelector("body").style.overflowY = "auto";

        setTimeout(() => {
            m.close();
        }, 150);
    }

    // SEÇÃO DO MODAL
    shareButton.addEventListener(
        "click",
        handlePostModalOpen.bind(null, modal)
    );

    // set timeout para colocar animação de saída
    closeButton.addEventListener(
        "click",
        handlePostModalClose.bind(null, modal)
    );

    // SEÇÃO DE CÓPIA
    link.innerText = url;
    copyButton.addEventListener("click", () => {
        navigator.clipboard.writeText(link.innerText).then(() => {
            alert("Link copiado");
        });
    });

    // SEÇÃO DE COMPARTILHAMENTO
    whatsapp.addEventListener("click", () => {
        whatsapp.href =
            "https://api.whatsapp.com/send?text=" +
            encodeURIComponent(text + url);
    });

    facebook.addEventListener("click", () => {
        facebook.href =
            "https://www.facebook.com/sharer/sharer.php?u=" +
            encodeURIComponent(url);
    });

    x.addEventListener("click", () => {
        x.href =
            "https://twitter.com/intent/tweet?url=" +
            encodeURIComponent(url) +
            "&text=" +
            encodeURIComponent(text);
    });

    email.addEventListener("click", () => {
        const title = document.querySelector(
            ".blog03-show__article__title"
        ).innerText;
        const descritption = document.querySelector(
            ".blog03-show__article__description"
        ).innerText;

        email.href = `mailto:?subject=Confira este artigo${title}&body=${descritption}\n Aqui está o link ${url}`;
        console.log(email.href);
    });
}
