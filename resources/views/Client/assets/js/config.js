$(function(){
    const minScrolling = $('.fixed-floating-top').data('min-scrolling')
    $(window).on('scroll', function(){
        var height = $('.fixed-floating-top').outerHeight()

        if($(this).scrollTop() >= minScrolling){

            $('.fixed-floating-top').parent().css('padding-top', height)
            $('.fixed-floating-top').addClass('floating')
            $('.fixed-floating-top').css('margin-top', -height)

            setTimeout(() => {
                $('.fixed-floating-top').css('margin-top', 0)
            }, 500);

        }else if($(this).scrollTop() < 90){

            $('.fixed-floating-top').css('margin-top', -height)
            $('.fixed-floating-top').parent().removeAttr('style')
            $('.fixed-floating-top').removeClass('floating')

            setTimeout(() => {
                $('.fixed-floating-top').css('margin-top', 0)
            }, 500);

        }
    })
})
