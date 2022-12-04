$(function(){
    $('.send_form_ajax').on('submit', function(event){
        event.preventDefault()

        const formData = new FormData($(this)[0]),
            action = $(this).attr('action')

        $.ajax({
            type: 'POST',
            url: action,
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function(data){
                $.toast().reset('all');
                $.toast({
                    heading: 'Enviando',
                    text: 'Estamos enviando as informações do formulário, por favor aguarde!',
                    hideAfter: false,
                    icon: 'info',
                    loaderBg: '#9EC600'
                })
            },
            success: function(data){
                if(data.status=='success'){
                    $.toast().reset('all');
                    $toastInstance = $.toast({
                        heading: 'Enviado com Sucesso',
                        text: 'As informações foram enviadas com sucesso!',
                        icon: 'success',
                        loaderBg: '#9EC600',
                        beforeHide: function () {
                            console.log('Toast is about to hide.');
                            window.location.href=data.redirect
                        }
                    })
                }else{
                    $.toast().reset('all');
                    $.toast({
                        heading: 'Enviando',
                        text: 'Erro ao enviar informações, tente novamente em alguns instantes.',
                        hideAfter: false,
                        icon: 'error',
                    })
                }
            },
            error: function(){
                $.toast().reset('all');
                $.toast({
                    heading: 'Enviando',
                    text: 'Erro ao enviar informações, tente novamente em alguns instantes.',
                    hideAfter: false,
                    icon: 'error',
                })
            }
        })
    })
})
