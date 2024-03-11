// if($("#videoApre").length){
//     var valorAntigo = $("#videoApre").attr('data-src');
//     var caminhoCapaVideo = $("#videoApre").attr('data-capa-video');
//     var arrValorAntigo = new Array();

//     if(valorAntigo.indexOf("/embed/") > 0){ //só sobe link do yt então essa checagem se torna redundante;
//         //caso haja um video embed do you tube e não tenha thumbnail vinda do painel é recupreamos a thumbnail do próprio youtube;
//             if(valorAntigo != ""){
//                 arrValorAntigo = valorAntigo.split("/embed/");
//                 if(arrValorAntigo.length > 1){
//                         arrValorAntigo = arrValorAntigo[1].split('&');
//                         if(caminhoCapaVideo == ""){
//                                 $("#videoApre").css('background-image', 'url(https://i.ytimg.com/vi/'+arrValorAntigo[0]+'/hqdefault.jpg)');
//                         }else{
//                                 $("#videoApre").css('background-image', 'url('+caminhoCapaVideo+')');
//                         }
//                 }
//             }
//     }




// }

// $('body').on('click', '.cont06__video__button', function(){
//     $urlVideo = $(this).parents('.cont06__video').attr('data-src');
//     // cria um ifrme com o vídeo do youtube
//     $(this).parents('.cont06__video').append('<iframe id="urlYoutube" width="99.5%" height=500" src="'+$urlVideo+'?autoplay=1" frameborder="0" allowfullscreen></iframe>');
//     // $(this).parents('#cont06__video').remove();
// });


const buttonsPlay = document.querySelectorAll('.cont06__video__button');

if(buttonsPlay) {
    buttonsPlay.forEach(el =>{
        el.addEventListener('click', () =>{
            const src = el.parentNode.dataset.src;
            const iframe = document.createElement('iframe');

            iframe.setAttribute('src', src+'?autoplay=1');
            iframe.classList.add('cont06__video__iframe');
            iframe.setAttribute('id', 'urlYoutube');

            el.style.display = 'none';

            el.parentNode.appendChild(iframe);

        })
    })
}
