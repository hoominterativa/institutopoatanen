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
$(function() {

    Fancybox.bind('[data-fancybox]');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#btSubmitDelete').on('click', function() {
        var $this = $(this),
            val = []

        $('.btSelectItem:checked').each(function() {
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
                                    window.location.href = window.location.href
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

    $('.table-sortable tbody').sortable({
        handle: '.btnDrag'
    }).on('sortupdate', function(e, ui) {

        var arrId = []
        $(this).find('tr').each(function() {
            var id = $(this).data('code')
            arrId.push(id)
        })

        console.log(arrId)
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
                    <input type="text" name="title_" required class="form-control inputSetTitle" placeholder="Nome que será exibido para o cliente">
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
        }
        html += '</div>'


        $(this).parents('.container-type-input').find('.infoInputs').remove()
        $(this).parents('.container-type-input').append(html);
    })

    $('body').on('change', '.inputSetTitle', function() {
        var val = $(this).val()
        var type = $(this).parents('.container-type-input').find('select').val()

        $(this).attr('name', 'title_' + slugify(val) + '_' + type)
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

    $('input[name=btSelectAll]').on('click', function() {
        console.log($('.btSelectItem:checked').length)
        if ($('.btSelectItem:checked').length == $('.btSelectItem').length) {
            $('#btSubmitDelete').fadeOut('fast');
            var checked = false
        } else {
            $('input[name=btSelectAll]').prop('checked', true)
            $('#btSubmitDelete').fadeIn('fast');
            var checked = true
        }
        $('.btSelectItem').each(function() {
            $('.btSelectItem').prop("checked", checked)
        })
    })

    $('body').on('click', '.dropify-clear', function() {
        var nameInput = $(this).parent().find('input:first').attr('name')
        $(this).parent().find('input[name=delete]').remove()
        $(this).parent().append(`<input type="hidden" name="delete_${nameInput}" value="${nameInput}" />`);
    })
})