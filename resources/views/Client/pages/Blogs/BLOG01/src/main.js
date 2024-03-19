import Swiper from "swiper/bundle";

new Swiper(".blog01__main__carousel", {
    slidesPerView: "auto",
    spaceBetween: 20,
    pagination: {
        el: '.blog01__main__carousel__swiper-pagination',
        clickable: true,
      },
});


new Swiper(".blog01-page__categories", {
    slidesPerView: "auto",
    spaceBetween: 20,
    centerInsufficientSlides: true,
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
