import { Fancybox } from "@fancyapps/ui/src/Fancybox/Fancybox.js";

$('#SLID03').css('height',$(window).height()-100);

$('.slid03__form__item').parsley().on('form:submit', function(formInstance) {
    Fancybox.show([{ src: "#slid03__lightbox__form", type: "inline" }]);
    return false;
})

$('.slid03__form__item input').on('change', function(){
    var name = $(this).attr('name');
    $('input[name='+name+']').val($(this).val()).focus();
})

// Deleta as informações adicionais
$('body, html').on('click', '.slid03-show__form__additional__delete', function(){
    $(this).parent().fadeOut('fast', function(){
        $(this).remove()
    })
})

// Adiciona as informações adicionais
$('.slid03-show__form__additional__add').on('click', function(){
    var url = $(this).data('url');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('.slid03-show__form__item input[name=_token]').val()
        },
        type: 'POST',
        url: url,
        success: function(data){
            $('.slid03-show__form__additional #receiveInputs').prepend(data);
            var additionalLength = $('.slid03-show__form__additional__item').length

            $('.slid03-show__form__additional__item').first().find('input:not(input[type=hidden], input[type=checkbox], input[type=radio]), textarea').each(function(elem){
                var that = $(this),
                    placeholder = that.attr('placeholder'),
                    name = that.attr('name'),
                    typeElem = that[0].localName

                if(placeholder){
                    if(typeElem == 'select'){
                        placeholder = that.find('option').first().text()
                        that.find('option').first().text('')
                    }

                    that.parent().append(`
                        <div class="form-placeholder"><label for="${name+additionalLength}" class="placeholder--custom">${placeholder}</label></div>
                    `)
                    that.parent().find('.form-placeholder').append(that)
                    that.removeAttr('placeholder')
                    that.attr('id', name+additionalLength)

                    var formPlaceholder = that.parent(),
                        placeholderCustom = formPlaceholder.find('.placeholder--custom')

                    placeholderCustom.on('click', function(){
                        that.trigger('focus')
                    })

                    that.on('focus', function(){
                        formPlaceholder.addClass('focusing')
                    })

                    that.on('focusout', function(){
                        if($(this).val()==''){
                            formPlaceholder.removeClass('focusing')
                        }
                    })
                }
            })
        }
    })
})

