$(".prod05__carousel").owlCarousel({
    loop: false,
    dots: true,
    nav: false,
    rewind: true,
    autoHeight: true,
    margin: 21,
    responsive: {
        0: {
            items: 1,
        },
        // breakpoint from 0 up
        520: {
            items: 2,
        },
        // breakpoint from 361 up
        768: {
            items: 3,
        },
        980: {
            items: 4,
        },
    },
});

$('.prod05-show__info__gallery__carousel').addClass('owl-carousel');
$(".prod05-show__info__gallery__carousel").owlCarousel({
    loop: false,
    dots: true,
    nav: false,
    rewind: true,
    autoHeight: true,
    margin: 10,
    responsive: {
        0: {
            items: 1,
        },
        // breakpoint from 0 up
        520: {
            items: 2,
        },
        // breakpoint from 361 up
        768: {
            items: 3,
        },
        980: {
            items: 4,
        },
    },
});

if($('.prod05-show__galleries__thumbnail').length > 5){
    $('.prod05-show__galleries__carousel').addClass('owl-carousel');
    $(".prod05-show__galleries__carousel").owlCarousel({
        loop: false,
        dots: true,
        nav: false,
        rewind: true,
        autoHeight: true,
        margin: 0,
        responsive: {
            0: {
                items: 1,
            },
            // breakpoint from 0 up
            520: {
                items: 2,
            },
            // breakpoint from 361 up
            768: {
                items: 4,
            },
            980: {
                items: 5,
            },
        },
    });
}

$('.prod05-show__btnForm--showForm').on('click', function(){
    if($(this).hasClass('active')){
        $('.prod05-show__wrapForm').removeClass('prod05-show__wrapForm--showForm');
        $(this).removeClass('active')
        $('.prod05-show__form').slideUp('fast')
    }else{
        $('.prod05-show__wrapForm').addClass('prod05-show__wrapForm--showForm');
        $(this).addClass('active')
        $('.prod05-show__form').slideDown('fast')
    }
})

$('body, html').on('click', '.prod05-show__info__gallery__thumbnail', function(e){
    var img = $(this).attr('src');
    $('.prod05-show__info__gallery__imgMain').attr('src', img);
});

$('body, html').on('click', '.prod05-show__info__gallery__options__item', function(e){
    e.preventDefault();
    $('.prod05-show__info__gallery__options__item').removeClass('prod05-show__info__gallery__options__item--active');
    $(this).addClass('prod05-show__info__gallery__options__item--active');
});
