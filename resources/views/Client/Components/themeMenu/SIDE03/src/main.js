$(function(){
    $('body').append('<div class="side03__override trasition"></div>');
    $('[data-plugin=sidebar]').on('click', function(){
        if($('#SIDE03').hasClass('side03--show')){
            $('#SIDE03').removeClass('side03--show');
            $(this).removeClass('active');
            $('.side03__override').removeClass('side03__override--show');
            $('body').removeClass('no-scroll');
        }else{
            $('#SIDE03').addClass('side03--show');
            $(this).addClass('active');
            $('.side03__override').addClass('side03__override--show');
            $('body').addClass('no-scroll');
        }
    })
    $('.side03__button-close').on('click', function(){
        $('#SIDE03').removeClass('side03--show');
        $(this).removeClass('active');
        $('.side03__override').removeClass('side03__override--show');
        $('body').removeClass('no-scroll');
    })
})

