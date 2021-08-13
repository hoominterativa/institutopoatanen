$(function() {
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
})