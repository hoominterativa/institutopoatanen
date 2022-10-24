function resizeHeightSlide(){
    // mw500=700
    var heightSlide = $('[data-slide-height]').data('slide-height'),
        heightWindow = $(window).outerHeight()

    if(heightSlide.split(',')){
        if(heightSlide.split(',')[0]=='auto'){
            slideHeight = heightSlide=='auto'?heightWindow:heightSlide+'px'
            $('[data-slide-height]').find('.container-slide').css('height', slideHeight)
        }else{
            $.each(heightSlide.split(','), function(index, value){
                var maxWidth = (value.split('=')[0]).replace('mw', ''),
                    widthWindow = $(window).outerWidth()
                    height = value.split('=')[1],
                    slideHeight = height=='auto'?heightWindow:height+'px'

                if(widthWindow <= maxWidth){
                    $('[data-slide-height]').find('.container-slide').css('height', slideHeight)
                }
            })
        }
    }else{
        slideHeight = heightSlide=='auto'?heightWindow:heightSlide+'px'
        $('[data-slide-height]').find('.container-slide').css('height', slideHeight)
    }

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
