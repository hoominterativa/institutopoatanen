var valorAntigo = $("#videoApre").attr('data-src');
var caminhoCapaVideo = $("#videoApre").attr('data-capa-video');
var arrValorAntigo = new Array();
if(valorAntigo.indexOf("/embed/") > 0){
        if(valorAntigo != ""){
            arrValorAntigo = valorAntigo.split("/embed/");
            if(arrValorAntigo.length > 1){
                    arrValorAntigo = arrValorAntigo[1].split('&');
                    if(caminhoCapaVideo == ""){
                            $("#videoApre").css('background-image', 'url(https://i.ytimg.com/vi/'+arrValorAntigo[0]+'/hqdefault.jpg)');
                    }else{
                            $("#videoApre").css('background-image', 'url('+caminhoCapaVideo+')');
                    }
            }
        }
}
$('body').on('click', '#videoApre .play', function(){
    $urlVideo = $(this).parents('#videoApre').attr('data-src');
    $(this).parents('.cont07__boxVideo__content').append('<iframe id="urlYoutube" width="99.5%" height=500" src="'+$urlVideo+'?autoplay=1" frameborder="0" allowfullscreen></iframe>');
    $(this).parents('#videoApre').remove();
}); 