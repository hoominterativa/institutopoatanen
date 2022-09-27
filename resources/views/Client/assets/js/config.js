function resizeHeightSlide(){
    var heightSlide = $('[data-slide-height]').data('slide-height'),
        bodyHeight = heightSlide=='auto'?$(window).outerHeight():heightSlide
    $('[data-slide-height]').find('.container-slide').css('height', bodyHeight)
}
$(function(){
    // SET HEADER FLOATING
    const ff = $('.fixed-floating'),
        hf = ff.find('.header-floating'),
        minScrolling = ff.data('min-scrolling')

    $(window).on('scroll', function(){
        if($(this).scrollTop() >= minScrolling && !hf.hasClass('floating')){
            hf.stop().addClass('floating')
        }else if($(this).scrollTop() < (minScrolling-10) && hf.hasClass('floating')){
            hf.stop().removeClass('floating')
        }
    })

    // RESIZE SLIDE HEIGHT
    resizeHeightSlide()
    $(window).on('resize', function(){
        resizeHeightSlide()
    })
})
