function carrosselMultItem(element, quantItem, quantLamina, auto, nav, dots){

    var quantItemAppend = $(element).find('>*').length;

    var refFor = quantItemAppend / quantItem;

    for(var i=1; i <= refFor; i++){

        $(element).append('<div class="contItemAppend'+i+' pd-carrossel"></div>');

        $(element).find('> *:lt('+quantItem+')').addClass('appendItem'+i);

        $(element).find('.appendItem'+i).appendTo('.contItemAppend'+i+'');

    }

    $(element).owlCarousel({

        loop: false,

        nav: true,

        dots: dots,

        autoplay: false,

        responsiveClass:true,

        responsive:{

            0:{

                items:1

            },

            400:{

                items:1

            },

            620:{

                items:1

            },

            840:{

                items: quantLamina,

                margin:0,

            }

        }

    });// FIM $('.owl-carousel').owlCarousel({

}
$(function(){
    carrosselMultItem('.carousel-cont13', 6, 1, true, true, true);

    if ($(window).outerWidth() <= 801) {
        $(".carousel-cont13").css("width", $(".cont13 .cont13__main").outerWidth());
    }
   
   
   
   
    $(".carousel-lics").owlCarousel({
        smartSpeed: 450,
        loop: false,
        dots: true,
        nav: true,
        rewind: true,
        autoHeight: true,
        items:1,
    });
    
    $(".carousel-lics").css("width", $(window).outerWidth() / 2 - 150);
    
    if ($(window).outerWidth() <= 801) {
        $(".carousel-lics").css("width", $(window).outerWidth() - 20);
    }
});



