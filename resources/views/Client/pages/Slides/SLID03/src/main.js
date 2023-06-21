$(function(){
    $('#SLID03').css('height',$(window).height()-100);

    $('.slid03__form__item').parsley().on('form:submit', function(formInstance) {
        console.log($(this))
        $('.slid03__content__form__targetLightnbox').click()
        return false;
    })
})
