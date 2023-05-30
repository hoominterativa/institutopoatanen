$('.carousel-team01').owlCarousel({
    smartSpeed:450,
    loop: false,
    dots:true,
    nav:false,
    rewind: true,
    autoHeight: true,
    responsive: {

        0 : {
            items:1,
            margin:10
        },
        // breakpoint from 0 up
        361 : {
            items:1,
            margin:10
        },
        // breakpoint from 361 up
        801 : {
            items:4,
            margin:20,
        }
        // breakpoint from 801 up
    }
});

$('.carousel-team01').css('width', $(window).outerWidth() + 50);

if($(window).outerWidth() <= 801){
    $('.carousel-team01').css('width', $('.team01 .container--edit').outerWidth() + 150);
}
// END carousel_team01

if($(window).outerWidth() <= 801){

    $('.team01__navigation__nav__mobile').addClass('owl-carousel');
    $('.team01__navigation__nav__mobile').addClass('caroussel-team01-mobile');
    $('.caroussel-team01-mobile').css('width', $(window).outerWidth());

    $('.caroussel-team01-mobile').owlCarousel({
        margin:10,
        items:3,
        stagePadding:0,
        smartSpeed:450,
        dots:true,
        nav:false,
        rewind: true,
        autoHeight: true
    });

}




if($(window).outerWidth() <= 801){
    $('.team01__page__content__category').addClass('owl-carousel');
    $('.team01__page__content__category').addClass('caroussel_team01-page');

    $('.caroussel_team01-page').owlCarousel({
        stagePadding:0,
        smartSpeed:450,
        dots:true,
        nav:false,
        rewind: true,
        autoHeight: true,
        responsive: {

            0 : {
                items:2,
                margin:12
            },
            // breakpoint from 0 up
            400 : {
                items:2,
                margin:12
            },
            // breakpoint from 400 up
            801 : {
                items:2,
                margin:20,
            }
            // breakpoint from 801 up
        }
    });

}


$('.caroussel_team01-show').owlCarousel({
    margin:5,
    items:1,
    stagePadding:0,
    smartSpeed:450,
    dots:true,
    nav:false,
    rewind: true,
    autoHeight: true
});

$('.caroussel_team01-show').css('width', $(window).outerWidth() / 2 - 108);

var altLightbox = $('.lightbox-team01__content__carrossel').outerHeight();
$('.caroussel_team01-show').css('height', $(altLightbox));

if($(window).outerWidth() <= 801){
    $('.caroussel_team01-show').css('width', $(window).outerWidth() - 16);
    // $('.caroussel_team01-show .owl-stage').css('width', $(window).outerWidth() - 150);
    // $('.caroussel_team01-show .owl-item').css('width', $(window).outerWidth() - 150);
}
