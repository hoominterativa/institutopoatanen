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

        margin:0,

        nav: nav,

        dots: dots,

        autoplay: auto,

        responsiveClass:true,

        responsive:{

            0:{

                items:1

            },

            400:{

                items:1

            },

            650:{

                items:1

            },

            840:{

                items: quantLamina

            }

        }

    });// FIM $('.owl-carousel').owlCarousel({

}

$(function(){
    carrosselMultItem('.caroulsel-cont10', 6, 1, false, false, true);
})