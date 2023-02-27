$(function(){
    $('body').on('change', '.selectPage', function(){
        let value = $(this).val(),
            module = value.split('|')[0],
            model = value.split('|')[1]

        $.ajax({
            type: 'POST',
            url: $url+'/painel/getRelationsModel',
            data: {module, model},
            success: function(response){
                $("input[name=module]").val(module)
                $("input[name=model]").val(model)
                $("input[name=select_dropdown]").val('')
                $('.btnViewPage .title').text('')

                if(response.dropdown){
                    $('.ifDropdown').fadeOut('fast');
                }else{
                    $('.ifDropdown').fadeIn('fast');
                    $('.containerListPages li').remove()
                    $('.containerListPages').append(response)
                }
            }
        })
    })
})
