var owlContent = $('.cont08__information__content__carousel');
owlContent.addClass('owl-carousel')
owlContent.owlCarousel({
    loop:false,
    nav:false,
    dots:true,
    margin:24,
    rewind:true,
    // autoWidth: true,
    autoHeight: true,
    responsive:{
        0:{
            items:2,
            autoWidth: false
        },
        575.98:{
            items:3
        },
        960:{
            items:4,

        },
        2000:{
            items:5,

        }
    }
});
