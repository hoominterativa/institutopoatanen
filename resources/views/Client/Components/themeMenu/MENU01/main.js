function adJustPosition(){
    $('[data-plugin=sidebar]').each(function(){
        let sdTarget = $(this).attr('href'),
            sdWidth = $(sdTarget).outerWidth()
        $(sdTarget).css('right', -sdWidth).removeClass('hidden').removeClass('open')
    })
}
$(function(){
    adJustPosition()
    $(window).on('resize', function(){
        adJustPosition()
    })

    $('html').on('click', '[data-plugin=sidebar]', function(e){
        e.preventDefault();

        let sdTarget = $(this).attr('href'),
            sdWidth = $(sdTarget).outerWidth()

        if($(sdTarget).hasClass('open')){
            $(sdTarget).animate({'right': -sdWidth}, 400).removeClass('open')
            $('body').removeClass('no-scroll')
        }else{
            $('body').addClass('no-scroll')
            $(sdTarget).animate({'right': 0}, 400).addClass('open')
        }
    })

    $('html').on('click', '.button---close--sidebar-right', function(e){
        let sdWidth = $(this).parents('.main--sidebar-right').outerWidth()
        $(this).parents('.main--sidebar-right').animate({'right': -sdWidth}, 400).removeClass('open')
        $('body').removeClass('no-scroll')
    })
})
