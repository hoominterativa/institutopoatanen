import { Fancybox } from "@fancyapps/ui/src/Fancybox/Fancybox.js";

$(function(){
    $('#SLID03').css('height',$(window).height()-100);

    $('.slid03__form__item').parsley().on('form:submit', function(formInstance) {
        Fancybox.show([{ src: "#slid03__lightbox__form", type: "inline" }]);
        return false;
    })

    $('.slid03__form__item input').on('change', function(){
        var name = $(this).attr('name');
        $('input[name='+name+']').val($(this).val()).focus();
    })

})
