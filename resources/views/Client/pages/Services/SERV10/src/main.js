$('.carousel-serv10').owlCarousel({
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
        500 : {
            items:1,
            autoWidth:true,
            margin:7
        },
        // breakpoint from 361 up
        801 : {
            items:4,
            margin:13,
        }
        // breakpoint from 801 up
    }
});

$('.carousel-serv10').css('width', $('.serv10 .container').outerWidth());
