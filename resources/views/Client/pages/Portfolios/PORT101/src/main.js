$(function () {
    let countItem = document.querySelectorAll(
        ".port101__content .port101__content__box"
    ).length;
    if (countItem >= 4) {
        countItem = 4;
    }

    console.log(countItem);

    $(".carousel-port101").owlCarousel({
        margin: 0,
        stagePadding: 0,
        smartSpeed: 450,
        dots: false,
        nav: true,
        responsive: {
            // breakpoint from 0 up
            0: {
                items: 1,
                margin: 0,
            },
            // breakpoint from 360 up
            361: {
                items: 1,
                margin: 0,
            },
            500: {
                items: 1,
                margin: 0,
            },
            800: {
                items: 1,
                margin: -50,
            },
            // breakpoint from 800 up
            850: {
                items: countItem,
                margin: 8,
            },
            // breakpoint from 850 up
        },
    });

    $(".carousel-port101").css(
        "width",
        $(".port101 .container--pd").outerWidth()
    );

    $(".carousel-show-port101").owlCarousel({
        items: 1,
        loop: false,
        center: true,
        dots: false,
        margin: 0,
        // mouseDrag:false,
        // touchDrag:false,
        URLhashListener: true, // ESSE
        autoplayHoverPause: true,
        startPosition: "URLHash", // E ESSE
    });
    $(".carousel-show-port101").css("width", $(window).outerWidth() / 2 - 91);
    if ($(window).outerWidth() <= 800) {
        $(".carousel-show-port101").css("width", $(window).outerWidth() - 84);
    }
    if ($(window).outerWidth() <= 800) {
        $(".carousel-show-port101").css("width", $(window).outerWidth() - 84);
    }

    $(".carousel-show-port101-nav").owlCarousel({
        margin: 12,
        stagePadding: 0,
        smartSpeed: 450,
        dots: false,
        nav: true,
        // mouseDrag:false,
        // touchDrag:false,
        items: 4,
    });

    $(".carousel-show-port101-nav").css(
        "width",
        $(window).outerWidth() / 2 - 91
    );

    if ($(window).outerWidth() <= 800) {
        $(".carousel-show-port101-nav").css(
            "width",
            $(window).outerWidth() - 84
        );
    }
    if ($(window).outerWidth() <= 800) {
        $(".carousel-show-port101-nav").css(
            "width",
            $(window).outerWidth() - 84
        );
    }
    // Change defaults
});

/* controle dos modals */
if (document.querySelector("[data-modal]")) {
    /* fecha o modal e backdrop */
    const closeModal = () => {
        document.body.style.overflowY = "visible";
        if (document.querySelector(".modal.open")) {
            document.querySelector(".modal.open").classList.remove("open");
        }
    };

    document.querySelectorAll(".modal").forEach((el) => {
        const backdrop = document.createElement("div");
        backdrop.classList.add("modal__backdrop");
        backdrop.addEventListener("click", closeModal);
        el.append(backdrop);
    });

    document.querySelectorAll(".modal__content").forEach((el) => {
        /* cria botões de fechar em cada modal */
        const btnClose = document.createElement("button");
        btnClose.classList.add("modal__btn--close");
        btnClose.innerHTML = "X";
        el.append(btnClose);
    });

    /* pega todos os itens como data-modal e add os efeitos de click */
    const linksModal = document.querySelectorAll("[data-modal]");

    for (const linkModal of linksModal) {
        linkModal.addEventListener("click", (event) => {
            event.preventDefault();
            document.body.style.overflowY = "hidden";
            const target = document.querySelector(linkModal.dataset.modal);

            target.classList.add("open");
        });
    }

    for (const btnCloseModal of document.querySelectorAll(
        ".modal__btn--close"
    )) {
        btnCloseModal.addEventListener("click", closeModal);
    }

    document.querySelectorAll(".vhem-modal__help-link").forEach((el) => {
        el.addEventListener("click", closeModal);
    });
}
/* controle dos modals */
