

$('.lish__topo__close').on('click', function() {
    setTimeout(function(){
        $('.lish').css("display", "none");
        $('#ligtbox-sche02-page').css("display", "flex");
    }, 300)
});
$('.lipa__banner__close').on('click', function() {
    setTimeout(function(){
        $('.fancybox__content>.carousel__button.is-close').trigger( "click" );
    }, 300)
});




$('.lish__topoengPrev__prev').on('click', function() {

    setTimeout(function(){
        $('.lish').css("display", "none");
        $('#ligtbox-sche02-page').css("display", "flex");
        // $('.is-close').on('click');
    }, 300)
});

