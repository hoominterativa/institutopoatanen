$(function(){
    // SET HEADER FLOATING
    const ff = $('.fixed-floating'),
        hf = ff.find('.header-floating'),
        minScrolling = ff.data('min-scrolling')

    $(window).on('scroll', function(){
        var height = ff.outerHeight()

        if($(this).scrollTop() >= minScrolling && !hf.hasClass('floating')){
            hf.stop().addClass('floating')
            hf.stop().css('margin-top', -height)
            ff.stop().css('padding-top', height)

            setTimeout(() => {
                hf.stop().animate({'margin-top': 0}, 300)
            }, 500);

        }else if($(this).scrollTop() < (minScrolling-10) && hf.hasClass('floating')){

            hf.stop().animate({'margin-top': -height}, 300)

            setTimeout(() => {
                hf.stop().removeClass('floating')
                hf.stop().css('margin-top', 0)
                ff.stop().css('padding-top', 0)
            }, 800);

        }
    })

    var heightSlide = $('[data-slide-height]').data('slide-height'),
        bodyHeight = heightSlide=='auto'?$(window).outerHeight():heightSlide
    $('[data-slide-height]').css('height', bodyHeight)
})
