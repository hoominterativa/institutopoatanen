
$(function(){
    $(window).on('scroll', function(){
        var rolagem = $(this).scrollTop();

        if(rolagem >= 90 && $('#HEAD03').hasClass('normal')){
            $('#HEAD03').removeClass('normal');
            $('#HEAD03').addClass('flutuante');
        } // FIM - if(rolagem >= 200 && $('#HEAD03').hasClass('normal')){

        if(rolagem < 90 && $('#HEAD03').hasClass('flutuante')) {
            $('#HEAD03').addClass('normal');
            $('#HEAD03').removeClass('flutuante');
        } // FIM - if(rolagem < 200 && $('#HEAD03').hasClass('flutuante')) {

    });
});
