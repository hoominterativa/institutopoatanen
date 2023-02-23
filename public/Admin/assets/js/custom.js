function slugify(text) {
    return text
        .toString() // Cast to string (optional)
        .normalize('NFKD') // The normalize() using NFKD method returns the Unicode Normalization Form of a given string.
        .toLowerCase() // Convert the string to lowercase letters
        .trim() // Remove whitespace from both sides of a string (optional)
        .replace(/\s+/g, '') // Replace spaces with -
        .replace(/[^\w\-]+/g, '') // Remove all non-word chars
        .replace(/\-\-+/g, ''); // Replace multiple - with single -
}
function cloneInputsColorPicker(elem, taregt, receiver, action='clone'){
    switch (action) {
        case 'clone':
            $(taregt).find('>*').clone(true).appendTo(receiver)
            setTimeout(() => {
                $(receiver).find('.inputCloned:last input').addClass('colorpicker-default')
            }, 100);
            setTimeout(() => {
                $(".colorpicker-default").spectrum()
            }, 200);
        break;
        case 'delete':
            $(elem).parent().remove();
        break;
    }
}

$(function() {
    if($(".colorpicker-default").length){
        $(".colorpicker-default").spectrum()
    }
    Fancybox.bind('[data-fancybox]');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('body').on('click', '#btSubmitDelete', function() {
        var $this = $(this),
            val = []

        $('.btnSelectItem:checked').each(function() {
            val.push($(this).val())
        })

        Swal.fire({
            title: "Tem certeza?",
            text: "Você não poderá reverter isso!",
            icon: "warning",
            showCancelButton: !0,
            confirmButtonText: "Sim, exclua!",
            cancelButtonText: "Não, cancele!",
            confirmButtonClass: "btn btn-success mt-2",
            cancelButtonClass: "btn btn-danger ms-2 mt-2",
            buttonsStyling: !1,
        }).then(function(e) {
            if (e.value) {
                $.ajax({
                    type: 'POST',
                    url: $this.data('route'),
                    data: { deleteAll: val },
                    dataType: 'JSON',
                    beforeSend: function() {},
                    success: function(response) {
                        switch (response.status) {
                            case 'success':
                                Swal.fire({ title: "Deletado!", text: response.message, icon: "success", showConfirmButton: false })
                                setTimeout(() => {
                                    window.location.reload()
                                }, 1000);
                                break;
                            default:
                                Swal.fire({ title: "Erro!", text: response.message, icon: "error", confirmButtonColor: "#4a4fea" })
                                break;
                        }
                    }
                })
            }
        });
    })
    $('.btSubmitDeleteItem').on('click', function(e) {
        e.preventDefault()
        var $this = $(this)
        Swal.fire({
            title: "Tem certeza?",
            text: "Você não poderá reverter isso!",
            icon: "warning",
            showCancelButton: !0,
            confirmButtonText: "Sim, exclua!",
            cancelButtonText: "Não, cancele!",
            confirmButtonClass: "btn btn-success mt-2",
            cancelButtonClass: "btn btn-danger ms-2 mt-2",
            buttonsStyling: !1,
        }).then(function(e) {
            if (e.value) {
                Swal.fire({ title: "Deletado!", text: "Item deletado com sucesso", icon: "success", showConfirmButton: false })
                setTimeout(() => {
                    $this.parents('form').submit()
                }, 1000);
            }
        });
    })
    $('.table-sortable').each(function(){
        $(this).find('> tbody').sortable({
            handle: '.btnDrag'
        }).on('sortupdate', function(e, ui) {

            var arrId = []
            $(this).find('> tr').each(function() {
                var id = $(this).data('code')
                arrId.push(id)
            })

            $.ajax({
                type: 'POST',
                url: $(this).data('route'),
                data: { arrId: arrId },
                success: function(data) {
                    if (data.status) {
                        $.NotificationApp.send("Sucesso!", "Registros ordenado com sucesso", "bottom-left", "#00000080", "success", '3000');
                    } else {
                        $.NotificationApp.send("Erro!", "Ocorreu um erro ao ordenar os registros", "bottom-left", "#00000080", "error", '10000');
                    }
                },
                error: function() {
                    $.NotificationApp.send("Erro!", "Ocorreu um erro ao ordenar os registros", "bottom-left", "#00000080", "error", '10000');
                }
            })
        });
    })

    $('#settingTheme input[type=checkbox]').on('click', function() {
        setTimeout(() => {
            var formData = new FormData(),
                route = $(this).parents('form').attr('action')
            formData.append('color_scheme_mode', $(this).parents('form').find('[name=color-scheme-mode]:checked').val())
            formData.append('leftsidebar_color', $(this).parents('form').find('[name=leftsidebar-color]:checked').val())
            formData.append('leftsidebar_size', $(this).parents('form').find('[name=leftsidebar-size]:checked').val())
            formData.append('topbar_color', $(this).parents('form').find('[name=topbar-color]:checked').val())

            $.ajax({
                type: 'POST',
                url: route,
                data: formData,
                processData: false,
                contentType: false
            })
        }, 800);

    })

    $('.selectTypeInput').on('change', function() {
        var type = $(this).val()
        var html = `
            <div class="infoInputs">
                <div class="mb-3">
                    <label class="form-label">Titulo</label>
                    <div class="row">
                        <div class="col-9">
                            <input type="text" name="column_" required class="form-control inputSetTitle" placeholder="Nome que será exibido para o cliente">
                        </div>
                        <div class="col-3">
                            <div class="form-check mt-1">
                                <input type="checkbox" name="_required" class="form-check-input inputSetRequired" id="_required" value="1">
                                <label for="_required" class="form-label">Obrigatório?</label>
                            </div>
                        </div>
                    </div>
                </div>
            `
        switch (type) {
            case 'select':
            case 'checkbox':
            case 'radio':
                html += `
                    <div class="mb-3">
                        <label class="form-label">Opções</label>
                        <input type="text" name="option_" required class="form-control inputSetOption" placeholder="Separar as opções com vírgula">
                    </div>
                `
            break;
            case 'selectEmail':
                html += `
                    <div class="mb-3">
                        <label class="form-label">Opções</label>
                        <input type="text" name="option_" required class="form-control inputSetOption" placeholder="Separar as opções com vírgula Ex.: Suporte{suporte@exemplo.com.br},Reclamações{reclamacoes@exemplo.com.br}">
                    </div>
                `
            break;
        }
        html += '</div>'


        $(this).parents('.container-type-input').find('.infoInputs').remove()
        $(this).parents('.container-type-input > *').append(html);
    })

    $('body').on('change', '.inputSetTitle', function() {
        var val = $(this).val()
        var type = $(this).parents('.container-type-input').find('select').val()

        $(this).attr('name', 'column_' + slugify(val) + '_' + type)
        $(this).parents('.container-type-input').find('.inputSetRequired').attr('name', 'required_' + slugify(val) + '_' + type)
        $(this).parents('.container-type-input').find('.inputSetOption').attr('name', 'option_' + slugify(val) + '_' + type)
    })

    $('.cloneTypeButton').on('click', function() {
        $('.container-type-input:first').clone(true).appendTo('.container-inputs-contact');
        $('.container-type-input:last').find('select option').removeAttr('selected');
        $('.container-type-input:last').find('select option:first').attr('selected', 'selected');
        $('.infoInputs:last').remove()
    })

    $('.deleteTypeButton').on('click', function() {
        if ($('.container-type-input').length > 1) {
            $(this).parents('.container-type-input').remove();
        }
    })

    $('input[name=btnSelectItem]').on('click', function() {
        const table = $(this).parents('table')
        var btnDelete = table.find('input[name=btnSelectAll]').val(),
            lengthTotal = table.find('.btnSelectItem').length,
            lengthChecked = table.find('.btnSelectItem:checked').length

        if (!lengthChecked) {
            $(`.${btnDelete}`).fadeOut('fast');
        } else {
            $(`.${btnDelete}`).fadeIn('fast');
        }

        table.find('input[name=btnSelectAll]').prop('checked', false)
        if(lengthTotal == lengthChecked) table.find('input[name=btnSelectAll]').prop('checked', true)
    })

    $('input[name=btnSelectAll]').on('click', function() {
        const table = $(this).parents('table')
        var btnDelete = $(this).val()

        if (table.find('.btnSelectItem:checked').length == table.find('.btnSelectItem').length) {
            $(`.${btnDelete}`).fadeOut('fast');
            var checked = false
        } else {
            table.find('input[name=btnSelectAll]').prop('checked', true)
            $(`.${btnDelete}`).fadeIn('fast');
            var checked = true
        }

        table.find('.btnSelectItem').each(function() {
            $(this).prop("checked", checked)
        })
    })

    $('body').on('click', '.dropify-clear', function() {
        var nameInput = $(this).parent().find('input:first').attr('name')
        $(this).parent().find(`input[name=delete_${nameInput}]`).remove()
        $(this).parent().find(`.preview-image`).css('background-image','url()')
        $(this).parent().find(`.content-area-image-crop`).show()
        $(this).parent().append(`<input type="hidden" name="delete_${nameInput}" value="${nameInput}" />`);
    })

    $('body').on('change', '.uploadMultipleImage .inputGetImage', function(e){
        var $this = $(this),
            contentPreview = $(this).data('content-preview'),
            route = $this.parents('form').attr('action')
            formData = new FormData($this.parents('form')[0])
            files = e.target.files

        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();

                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total,
                            percent = percentComplete * 100

                        $this.parent().parent().find('.progressBar .barr').css('width', percent + '%')
                    }
                }, false);

                return xhr;
            },
            type: 'POST',
            url: route,
            data: formData,
            dataType: 'JSON',
            contentType: false,
            processData: false,
            beforeSend: function() {
                $this.parents('.uploadMultipleImage').find('#containerMultipleImages img').remove();
                $.each(files, function(index, file){
                    let reader = new FileReader();
                    reader.onload = function(event){
                        $this.parents('.uploadMultipleImage').find('#containerMultipleImages').append(`
                            <img src="${event.target.result}" class="avatar-lg object-fit-cover rounded bg-light me-1">
                        `)
                    }
                    reader.readAsDataURL(file);
                })

                $this.parent().prepend(`<div class="progressBar"><span class="barr"></span></div>`)
                $this.parent().parent().find('.progressBar').fadeIn('fast')
            },
            success: function(response) {
                if(response.status == 'success'){
                    $.NotificationApp.send("Sucesso!", response.countUploads+" imagens carregadas com sucesso, a página será atualizada", "bottom-right", "#00000080", "success", '8000')
                    $this.parent().find('.progressBar').fadeOut('fast', function(){
                        $(this).remove()
                    })
                    setTimeout(() => {
                        window.location.href = window.location.href;
                    }, 5000);
                }else{
                    $.NotificationApp.send("Erro!", "Erro ao subir imagens, atualize a página e tente novamente.", "bottom-right", "#00000080", "error", '8000');
                    $this.parent().find('.progressBar').fadeOut('fast', function(){
                        $(this).remove()
                    })
                }

            },
            error: function(){
                $.NotificationApp.send("Erro!", "Erro ao subir imagens, atualize a página e tente novamente.", "bottom-right", "#00000080", "error", '8000');
                $this.parent().find('.progressBar').fadeOut('fast', function(){
                    $(this).remove()
                })
            }
        })
    })

    $('body').on('click', '.deleteImageUploadMultiple', function(){
        $(this).parents('.contentPreview').fadeOut('slow', function(){
            $(this).remove()
        })
    })

    $('body').on('click', '[data-delete-clone]', function(){
        $(this).parent().parent().fadeOut('slow', function(){
            $(this).remove()
        })
    })

    $('body').on('click', '[data-plugin=clone]', function(){
        let target = $(this).data('target'),
            cloneElem = $(this).data('clone-element')

        $(cloneElem).find('>*').clone(true).appendTo(target)
    })

    $('.modal').each(function(){
        $('body').append($(this))
    })

    function changePushState(elem){
        const tab = elem.attr('href'),
            url = `?tab=${tab}`;

        localStorage.setItem('tab', tab)
        window.history.pushState({}, tab, url);
    }

    $('[data-bs-toggle=tab]:not(.tab-static)').on('click', function(){
        changePushState($(this))
    });

    $(window).on('load', function(){
        if(localStorage.getItem('tab')){
            var hash = localStorage.getItem('tab')
            if($(`[data-bs-toggle=tab][href=\\${hash}]`).length){
                $(`[data-bs-toggle=tab]:not(.tab-static)`).removeClass('active')
                $(`[data-bs-toggle=tab][href=\\${hash}]`).addClass('active')

                $('.tab-pane:not(.tab-static)').removeClass('active').removeClass('show')
                $(`${hash}`).addClass('active').addClass('show')
            }

            localStorage.removeItem('tab')
        }

        if($('[data-bs-toggle=tab].active:not(.tab-static)').length){
            changePushState($('[data-bs-toggle=tab].active'))
        }
    })

    $(window).on('hashchange',function(event){
        var hash = location.hash.replace('#','');
        $(`[data-bs-toggle=tab]`).removeClass('active')
        $(`[data-bs-toggle=tab][href=\\#${hash}]`).addClass('active')

        $('.tab-pane').removeClass('active').removeClass('show')
        $(`#${hash}`).addClass('active').addClass('show')

        localStorage.setItem('tab', `#${hash}`)
    });

    var owlDashboard = $('.owl-carousel-dashboard')
    owlDashboard.addClass('owl-carousel');
    owlDashboard.owlCarousel({
        margin:20,
        dots:false,
        nav:true,
        navContainer: '.navOwlDashboard',
        responsive: {
            // breakpoint from 0 up
            0 : {
                items:1
            },
            // breakpoint from 360 up
            361 : {
                items:2
            },
            // breakpoint from 768 up
            800 : {
                items:4
            }
        }
    });

    $('body').on('click', '[data-bs-toggle=setUrl]', function(event){
        event.preventDefault()
        let targetUrl = $(this).data('target-url'),
            url = $(this).attr('href')
        $(targetUrl).val(url)
    })

    $('[data-bs-toggle=inputAjax]').on('change', function(){
        var formData = new FormData($(this).parents('form')[0]),
            action = $(this).parents('form').attr('action')

        $.ajax({
            type: 'POST',
            url: action,
            data: formData,
            processData: false,
            contentType: false,
        })
    })

    $('#testSmtp').on('click', function(event){
        event.preventDefault()
        var action = $(this).attr('href')
        $.ajax({
            type: 'POST',
            url: action,
            processData: false,
            contentType: false,
            success: function(response){
                switch (response.status) {
                    case 'success':
                        $('.detailsTestSmtp').append(`<span class="badge bg-success mt-2">${response.message}</span>`)
                    break;
                    case 'error':
                        $('.detailsTestSmtp').append(`
                            <span class="badge bg-danger my-2">${response.message}</span>
                            <p><b>Confira detalhes do erro abaixo.</b></p>
                            <p>${response.details}</p>
                        `)
                    break;
                }
            },
            error:function(error){

            }
        })
    })
})
