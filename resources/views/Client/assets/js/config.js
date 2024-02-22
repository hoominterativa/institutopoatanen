function resizeHeightSlide() {
    // mw500=700
    if ($("[data-slide-height]").length) {
        var heightSlide = $("[data-slide-height]").data("slide-height"),
            heightWindow = $(window).outerHeight();

        if (!Number.isInteger(heightSlide)) {
            if (heightSlide.split(",")[0] == "auto") {
                slideHeight =
                    heightSlide == "auto" ? heightWindow : heightSlide + "px";
                $("[data-slide-height]")
                    .find(".container-slide")
                    .css("height", slideHeight);
            } else {
                $.each(heightSlide.split(","), function (index, value) {
                    var maxWidth = value.split("=")[0].replace("mw", ""),
                        widthWindow = $(window).outerWidth();
                    (height = value.split("=")[1]),
                        (slideHeight =
                            height == "auto" ? heightWindow : height + "px");

                    if (widthWindow <= maxWidth) {
                        $("[data-slide-height]")
                            .find(".container-slide")
                            .css("height", slideHeight);
                    }
                });
            }
        } else {
            slideHeight =
                heightSlide == "auto" ? heightWindow : heightSlide + "px";
            $("[data-slide-height]")
                .find(".container-slide")
                .css("height", slideHeight);
        }
    }
}

function insertImageMobile() {
    // INCLUDE IMAGE MOBILE
    if ($(window).outerWidth() <= 800) {
        $.each($("[data-image-mobile]"), function (index, value) {
            var imageMobile = $(this).data("image-mobile");
            switch (value.localName) {
                case "img":
                    $(this).attr("src", imageMobile);
                    break;
                default:
                    $(this).css("backgound", `url(${imageMobile})`);
                    break;
            }
        });
    }
}

$(function () {
    $(".owl-carousel").each(function () {
        const owlCarousel = $(this);
        const owlItems = owlCarousel.find(".owl-item");
        const prevButton = owlCarousel.find(".owl-prev");
        const nextButton = owlCarousel.find(".owl-next");

        if (owlItems.length > 1) {
            prevButton.show();
            nextButton.show();
        } else {
            prevButton.hide();
            nextButton.hide();
        }
    });
    // SET HEADER FLOATING
    const ff = $(".fixed-floating"),
        hf = ff.find(".header-floating"),
        minScrolling = ff.data("min-scrolling");

    $(window).on("scroll", function () {
        if ($(this).scrollTop() >= minScrolling && !hf.hasClass("floating")) {
            hf.stop().addClass("floating");
        } else if (
            $(this).scrollTop() < minScrolling - 10 &&
            hf.hasClass("floating")
        ) {
            hf.stop().removeClass("floating");
        }
    });

    // SETTINGS SLIDE
    insertImageMobile();
    resizeHeightSlide();
    $(window).on("resize", function () {
        resizeHeightSlide();
        insertImageMobile();
    });

    $(
        "form input:not(input[type=hidden], input[type=checkbox], input[type=radio]), form textarea"
    ).each(function (elem) {
        var that = $(this),
            placeholder = that.attr("placeholder"),
            name = that.attr("name"),
            typeElem = that[0].localName;

        if (placeholder) {
            if (typeElem == "select") {
                placeholder = that.find("option").first().text();
                that.find("option").first().text("");
            }

            that.parent().append(`
                <div class="form-placeholder"><label for="${name}" class="placeholder--custom">${placeholder}</label></div>
            `);
            that.parent().find(".form-placeholder").append(that);
            that.removeAttr("placeholder");
            that.attr("id", name);

            var formPlaceholder = that.parent(),
                placeholderCustom = formPlaceholder.find(
                    ".placeholder--custom"
                );

            placeholderCustom.on("click", function () {
                that.trigger("focus");
            });

            that.on("focus", function () {
                formPlaceholder.addClass("focusing");
            });

            that.on("focusout", function () {
                if ($(this).val() == "") {
                    formPlaceholder.removeClass("focusing");
                }
            });
        }
    });

    $("form select").each(function (elem) {
        var that = $(this),
            placeholder = that.find("option").first().text(),
            name = that.attr("name");

        that.parent().append(`
            <div class="form-placeholder select"><label for="${name}" class="placeholder--custom">${placeholder}</label></div>
        `);
        that.parent().find(".form-placeholder").append(that);
        that.removeAttr("placeholder");
        that.attr("id", name);

        var formPlaceholder = that.parent();

        that.on("change", function () {
            var thisValue = $(this).val();
            if (thisValue != "") {
                formPlaceholder.addClass("focusing");
            } else {
                formPlaceholder.removeClass("focusing");
            }
        });
    });
});
/******  ANIMAÇÃO ******/
// Verifica se há elementos com a classe .animation no documento
const elementosAnimados = document.querySelectorAll(".animation");
if (elementosAnimados.length > 0) {
    let delayGroup = -1; //delay =-1 pois a primeira rodada é criada depois de do primeiro incremento;

    // Função para tratar o callback da interseção
    const handleIntersection = (entradas, observador) => {
        entradas.forEach((entrada) => {
            if (entrada.isIntersecting) {
                if (delayGroup < 4) {
                    delayGroup++;
                }
                setTimeout(() => {
                    entrada.target.classList.add("animated"); // Adiciona a classe .animated
                    observador.unobserve(entrada.target); // Para de observar o elemento após adicionar a classe
                    if (delayGroup > 0) {
                        delayGroup--;
                    }
                }, delayGroup * 300);
            }
            // else {
            //     entrada.target.classList.remove("animated"); // Remove a classe .animated
            // }
        });
    };

    // Opções do Intersection Observer
    const opcoes = {
        root: null,
        rootMargin: "0px",
        threshold: 0.05,
    };

    // Cria uma nova instância do Intersection Observer
    const observador = new IntersectionObserver(handleIntersection, opcoes);

    // Observa cada elemento animado
    elementosAnimados.forEach((elemento) => {
        observador.observe(elemento);
    });
}

/* HOTFIX PARA O HEADER */
window.addEventListener("scroll", () => {
    /* Esconde o dropdown do menu quando há uma rolagem da tela */
    const menuAberto = document.querySelector(".sublink--menu.show");
    if (menuAberto) {
        menuAberto.classList.remove("show");
        document
            .querySelector(".menu-list .link.show")
            .classList.remove("show");
    }
});

/* NOVO SCRIPT DE ANIMAÇÃO DO ACCORDION */
class Accordion {
    constructor(el) {
        // Store the <details> element
        this.el = el;
        // Store the <summary> element
        this.summary = el.querySelector("summary");
        // Store the <div class="details-content"> element
        this.content = el.querySelector(".details-content");

        // Store the animation object (so we can cancel it if needed)
        this.animation = null;
        // Store if the element is closing
        this.isClosing = false;
        // Store if the element is expanding
        this.isExpanding = false;
        // Detect user clicks on the summary element
        this.summary.addEventListener("click", (e) => this.onClick(e));
    }

    onClick(e) {
        // Stop default behaviour from the browser
        e.preventDefault();

        let timeOutValue = 0;

        // Check if there is another open accordion
        const openAccordions = document.querySelectorAll("details[open]");
        if (openAccordions.length > 0) {
            // Close the currently open accordion
            openAccordions.forEach((accordion) => {
                if (accordion !== this.el) {
                    accordion._accordionInstance.shrink();
                    timeOutValue = 225;
                }
            });
        }

        // Check if the element is being closed or is already closed
        if (this.isClosing || !this.el.open) {
            setTimeout(() => {
                this.open();
            }, timeOutValue);
            // Check if the element is being openned or is already open
        } else if (this.isExpanding || this.el.open) {
            this.shrink();
        }
    }

    shrink() {
        // Set the element as "being closed"
        this.isClosing = true;

        // Store the current height of the element
        const startHeight = `${this.el.offsetHeight}px`;
        // Calculate the height of the summary
        const endHeight = `${this.summary.offsetHeight}px`;

        // If there is already an animation running
        if (this.animation) {
            // Cancel the current animation
            this.animation.cancel();
        }

        // Start a WAAPI animation
        this.animation = this.el.animate(
            {
                // Set the keyframes from the startHeight to endHeight
                height: [startHeight, endHeight],
            },
            {
                duration: 200,
                easing: "linear",
            }
        );

        // When the animation is complete, call onAnimationFinish()
        this.animation.onfinish = () => this.onAnimationFinish(false);
        // If the animation is cancelled, isClosing variable is set to false
        this.animation.oncancel = () => (this.isClosing = false);
    }

    open() {
        // Apply a fixed height on the element
        this.el.style.height = `${this.el.offsetHeight}px`;
        // Force the [open] attribute on the details element
        this.el.open = true;
        // Wait for the next frame to call the expand function
        window.requestAnimationFrame(() => this.expand());
    }

    expand() {
        // Set the element as "being expanding"
        this.isExpanding = true;
        // Get the current fixed height of the element
        const startHeight = `${this.el.offsetHeight}px`;
        // Calculate the open height of the element (summary height + content height)
        const endHeight = `${
            this.summary.offsetHeight + this.content.offsetHeight
        }px`;

        // If there is already an animation running
        if (this.animation) {
            // Cancel the current animation
            this.animation.cancel();
        }

        // Start a WAAPI animation
        this.animation = this.el.animate(
            {
                // Set the keyframes from the startHeight to endHeight
                height: [startHeight, endHeight],
            },
            {
                duration: 200,
                easing: "ease-out",
            }
        );
        // When the animation is complete, call onAnimationFinish()
        this.animation.onfinish = () => this.onAnimationFinish(true);
        // If the animation is cancelled, isExpanding variable is set to false
        this.animation.oncancel = () => (this.isExpanding = false);
    }

    onAnimationFinish(open) {
        // Set the open attribute based on the parameter
        this.el.open = open;
        // Clear the stored animation
        this.animation = null;
        // Reset isClosing & isExpanding
        this.isClosing = false;
        this.isExpanding = false;
        // Remove the overflow hidden and the fixed height
        this.el.style.height = this.el.style.overflow = "";
    }
}

const details = document.querySelectorAll("details");

if (details.length > 0) {
    details.forEach((el) => {
        el._accordionInstance = new Accordion(el);
    });
}

/***********************************************************/

/*  QUEDINHA - DROPDOWN DO SISTEMA */
const quedinhaBtnList = document.querySelectorAll(".quedinha__btn");

quedinhaBtnList.forEach((quedinhaBtn) => {
    const content = quedinhaBtn.nextElementSibling;
    // Verifica se existe um subMenu dentro do dropdown
    if (content.classList.contains("quedinha__content--sub-menu")) {
        const elRect = content.getBoundingClientRect();

        // Calcula a diferença entre a largura da viewport e a parede esquerda do elemento em si.

        const diff = window.innerWidth - elRect.left;
        // Verifica se o diff é menor que a largura do elemento. Sendo menor, altera-se o estilo, fazendo com que o subMenu abra para o lado oposto;
        if (diff < elRect.width) {
            content.style.left = "unset";
            content.style.right = "100%";
        }
    }

    quedinhaBtn.addEventListener("click", () => {
        if (quedinhaBtn.parentElement.classList.contains("open")) {
            quedinhaBtn.parentElement.classList.remove("open");

            const quedinhaSub =
                quedinhaBtn.parentElement.querySelector(".quedinha.open");

            if (quedinhaSub) {
                quedinhaSub.classList.remove("open");
            }
        } else {
            /* elemento que está esperando para ser aberto */
            const quedinhaToOpen = quedinhaBtn.parentElement;

            /* verificando elementos irmãos que possam estar abertos e fechando-os */
            const quedinhaOpen =
                quedinhaToOpen.parentElement.querySelectorAll(".quedinha.open");

            if (quedinhaOpen.length > 0) {
                quedinhaOpen.forEach((el) => {
                    el.classList.remove("open");
                });
            }

            quedinhaToOpen.classList.add("open");
        }
    });
});

// Fecha o dropdown se o usuário clicar fora dele mesmo.
window.onclick = function (event) {
    if (!event.target.matches(".quedinha__btn")) {
        document
            .querySelectorAll(".quedinha.open")
            .forEach((el) => el.classList.remove("open"));
    }
};

/***********************************************************/
