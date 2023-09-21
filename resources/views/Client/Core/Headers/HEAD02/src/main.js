
$(function(){
    $(window).on('scroll', function(){
        var rolagem = $(this).scrollTop();

        if(rolagem >= 90 && $('#HEAD02').hasClass('normal')){
            $('#HEAD02').removeClass('normal');
            $('#HEAD02').addClass('flutuante');
        } // FIM - if(rolagem >= 200 && $('#HEAD02').hasClass('normal')){

        if(rolagem < 90 && $('#HEAD02').hasClass('flutuante')) {
            $('#HEAD02').addClass('normal');
            $('#HEAD02').removeClass('flutuante');
        } // FIM - if(rolagem < 200 && $('#HEAD02').hasClass('flutuante')) {

    });
});
