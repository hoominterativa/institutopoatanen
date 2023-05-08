$(function(){
    $('body').on('change', '.selectPage', function(){
        let value = $(this).val(),
            module = value.split('|')[0],
            model = value.split('|')[1]

        getRelationsModel(module, model)
    })
})

function getRelationsModel(module, model, mode='create', callback=null){
    $.ajax({
        type: 'POST',
        url: $url+'/painel/getRelationsModel',
        data: {module, model},
        success: function(response){
            switch (mode) {
                case 'create':
                    $("input[name=module]").val(module)
                    $("input[name=model]").val(model)
                    $("input[name=select_dropdown]").val('')
                    $('.btnViewPage .title').text('')

                    if(response.dropdown){
                        $('.ifDropdown').fadeOut('fast');
                        $('.activeDropdown option[value=0]').attr('selected', 'selected')
                    }else{
                        $('.ifDropdown').fadeIn('fast');
                        $('.containerListPages li').remove()
                        $('.containerListPages').append(response)
                    }
                break;
                case 'edit':
                    if(response.dropdown){
                        $('.ifDropdown').fadeOut('fast');
                        $('.activeDropdown option[value=0]').attr('selected', 'selected')
                    }else{
                        $('.ifDropdown').fadeIn('fast');
                        $('.containerListPages li').remove()
                        $('.containerListPages').append(response)
                    }
                break;
            }
            if(callback) callback()
        }
    })
}

function getConditionsModel(module, model, relation=null, mode='create', callback=null){
    $.ajax({
        type: 'POST',
        url: $url+'/painel/getConditionsModel',
        data: {module, model, relation},
        success: function(response){
            if(response.dropdown){
                $('.containerSelectConditions').fadeOut('fast');
            }else{
                $('.containerSelectConditions').fadeIn('fast');
                $('.containerSelectConditions .selectConditions').remove()
                $('.containerSelectConditions').append(response)
            }
            if(callback) callback()
        }
    })
}
