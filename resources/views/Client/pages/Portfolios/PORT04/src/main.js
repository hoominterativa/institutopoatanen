var owlProtfolios = $('.port04__portfolios__carousel');
owlProtfolios.addClass('owl-carousel')
owlProtfolios.owlCarousel({
    loop:false,
    nav:false,
    dots:true,
    margin:24,
    rewind:true,
    autoWidth: true,
    autoHeight: true,
    responsive:{
        0:{
            items:1,
            autoWidth: false
        },
        575.98:{
            items:2
        },
        960:{
            items:4,

        },
        2000:{
            items:5,

        }
    }
});
