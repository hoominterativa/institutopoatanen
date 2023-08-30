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

        nav: nav,

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
    carrosselMultItem('.carousel-cont10v2', 6, 1, true, true, true);
})
