$(function(){
        $('.carousel-serv04').owlCarousel({
            margin:12,
            stagePadding:0,
            smartSpeed:450,
            dots:true,
            nav:false,
            rewind: true,
            autoHeight: true,
            loop:true,
            responsive: {
                // breakpoint from 0 up
                0 : {
                    items:1
                },
                // breakpoint from 361 up
                361 : {
                    items:1
                },
                // breakpoint from 800 up
                800 : {
                    items:4,

                }
            }
        });
})
