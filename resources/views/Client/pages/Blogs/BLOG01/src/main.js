import Swiper from "swiper/bundle";

new Swiper(".blog01-page__categories", {
    slidesPerView: "auto",
    spaceBetween: 20,
    centerInsufficientSlides: true,
});

$(function () {
    // if($(window).outerWidth() <= 800){
    $(".blog01__boxs__carousel").addClass("owl-carousel");
    $(".blog01__boxs__carousel").owlCarousel({
        margin: 10,
        stagePadding: 0,
        smartSpeed: 450,
        dots: true,
        nav: false,
        items: 4,
        rewind: true,
        responsive: {
            // breakpoint from 0 up
            0: {
                items: 1,
            },
            // breakpoint from 360 up
            361: {
                items: 1,
            },
            // breakpoint from 768 up
            800: {
                items: 4,
                touchDrag: false,
                mouseDrag: false,
            },
        },
    });

    // $(".blog01-page__header__category__carousel").addClass("owl-carousel");
    // $(".blog01-page__header__category__carousel").owlCarousel({
    //     margin: 10,
    //     stagePadding: 0,
    //     smartSpeed: 450,
    //     dots: false,
    //     nav: false,
    //     rewind: true,
    //     responsive: {
    //         // breakpoint from 0 up
    //         0: {
    //             items: 2,
    //         },
    //     },
    // });
    // }

    $(".blog01-page__boxs__featured__carousel").addClass("owl-carousel");
    $(".blog01-page__boxs__featured__carousel").owlCarousel({
        margin: 10,
        stagePadding: 0,
        smartSpeed: 450,
        dots: true,
        nav: false,
        rewind: true,
        responsive: {
            // breakpoint from 0 up
            0: {
                items: 1,
            },
            // breakpoint from 360 up
            361: {
                items: 1,
            },
            // breakpoint from 768 up
            800: {
                items: 1,
            },
        },
    });
});

addEventListener("DOMContentLoaded", function () {
    const shareButton = document.getElementById("shareButton");
    if (shareButton) {
        shareButton.addEventListener("click", function () {
            // Verifique se a API do Web Share está disponível no navegador
            if (navigator.share) {
                // Dados para compartilhar
                const title = "{{$blog->title}}"; // Incorporar o título do artigo
                const description = "{{$blog->description}}"; // Incorporar o a descrição do artigo
                const url = "{{url()->current() }}"; // Incorporar a URL do artigo

                const shareData = {
                    title: title,
                    text: description,
                    url: url,
                };

                // Chame a API do Web Share para abrir a janela de compartilhamento
                navigator
                    .share(shareData)
                    .then(() => {
                        console.log("Artigo compartilhado com sucesso!");
                    })
                    .catch((error) => {
                        console.error("Erro ao compartilhar o artigo:", error);
                    });
            } else {
                alert(
                    "Este navegador não suporta compartilhamento direto. Você pode copiar o link e compartilhá-lo manualmente."
                );
            }
        });
    }
});
