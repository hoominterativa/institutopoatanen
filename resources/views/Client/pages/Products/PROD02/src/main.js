$('.carousel-prod02').owlCarousel({
    smartSpeed:450,
    loop: true,
    dots:true,
    nav:false,
    rewind: true,
    autoHeight: true,
    responsive: {
        
        0 : {
            items:1,
            margin:12
        },
        // breakpoint from 0 up
        361 : {
            items:1,
            margin:12
        },
        // breakpoint from 361 up
        801 : {
            items:4,
            margin:20,
        }
        // breakpoint from 801 up
    }
});

$('.carousel-prod02').css('width', $('.prod02 .container--edit').outerWidth());

if($(window).outerWidth() <= 801){
    $('.carousel-prod02').css('width', $('.prod02 .container--edit').outerWidth() + 150);
}
// END carousel_prod02




if($(window).outerWidth() <= 801){
    $('.prod02__page__content__category').addClass('owl-carousel');
    $('.prod02__page__content__category').addClass('caroussel_prod02-page');

    $('.caroussel_prod02-page').owlCarousel({
        margin:5,
        items:2,
        stagePadding:0,
        smartSpeed:450,
        dots:true,
        nav:false,
        rewind: true,
        autoHeight: true,
        responsive: {
        
            0 : {
                items:1,
                margin:12
            },
            // breakpoint from 0 up
            400 : {
                items:1,
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


$('.caroussel_prod02-show').owlCarousel({
    margin:5,
    items:1,
    stagePadding:0,
    smartSpeed:450,
    dots:true,
    nav:false,
    rewind: true,
    autoHeight: true
});

$('.caroussel_prod02-show').css('width', $(window).outerWidth() / 2 - 108);

var altLightbox = $('.lightbox-prod02__content__carrossel').outerHeight();
console.log(altLightbox);
$('.caroussel_prod02-show').css('height', $(altLightbox));
