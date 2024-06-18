function embedLinkYoutube(elem) {
    var val = elem.val();
    let isYouTubeLink = val.includes("youtube.com") || val.includes("youtu.be");

    if (isYouTubeLink) {
        let result = val.includes("watch?v=");

        if (result) {
            newLink = val.replace("watch?v=", "embed/");
            elem.val(newLink);
        } else {
            let url = new URL(val);
            let id = url.searchParams.get("v");
            if (id) {
                elem.val(`https://www.youtube.com/embed/${id}`);
            }
        }
    } else {
        var newVal = val
                .replaceAll("http://", "")
                .replaceAll("https://", "")
                .split("/"),
            id = newVal[1].replaceAll("?share=copy", "");
        elem.val(`https://player.vimeo.com/video/${id}?share=copy`);
    }
}

$("body").on("change, focusout", ".embedLinkYoutube", function () {
    embedLinkYoutube($(this));
});

function slugify(text) {
    return text
        .toString() // Cast to string (optional)
        .normalize("NFKD") // The normalize() using NFKD method returns the Unicode Normalization Form of a given string.
        .toLowerCase() // Convert the string to lowercase letters
        .trim() // Remove whitespace from both sides of a string (optional)
        .replace(/\s+/g, "") // Replace spaces with -
        .replace(/[^\w\-]+/g, "") // Remove all non-word chars
        .replace(/\-\-+/g, ""); // Replace multiple - with single -
}
function cloneInputsColorPicker(elem, taregt, receiver, action = "clone") {
    switch (action) {
        case "clone":
            $(taregt).find(">*").clone(true).appendTo(receiver);
            setTimeout(() => {
                $(receiver)
                    .find(".inputCloned:last input")
                    .addClass("colorpicker-default");
            }, 100);
            setTimeout(() => {
                $(".colorpicker-default").spectrum();
            }, 200);
            break;
        case "delete":
            $(elem).parent().remove();
            break;
    }
}

$(function () {
    // Manipula o evento "blur" (perda de foco) em campos de entrada de URL
    $('input[type="url"]').on("blur", function () {
        var val = $(this).val().trim(); // Remove espaços em branco do início e do fim

        // Verifica se o valor do campo não começa com 'https://'
        if (val && !val.startsWith("https://")) {
            // Substitui 'http://' por 'https://'
            if (val.startsWith("http://")) {
                val = val.replace("http://", "https://");
            } else {
                // Se não começar com 'http://', adiciona 'https://'
                val = "https://" + val;
            }
            // Define o novo valor do campo
            $(this).val(val);
        }
    });

    if ($(".colorpicker-default").length) {
        $(".colorpicker-default").spectrum();
    }
    Fancybox.bind("[data-fancybox]");

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("body").on("click", "#btSubmitDelete", function () {
        var $this = $(this),
            val = [];

        $(".btnSelectItem:checked").each(function () {
            val.push($(this).val());
        });

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
        }).then(function (e) {
            if (e.value) {
                $.ajax({
                    type: "POST",
                    url: $this.data("route"),
                    data: { deleteAll: val },
                    dataType: "JSON",
                    beforeSend: function () {},
                    success: function (response) {
                        switch (response.status) {
                            case "success":
                                Swal.fire({
                                    title: "Deletado!",
                                    text: response.message,
                                    icon: "success",
                                    showConfirmButton: false,
                                });
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                                break;
                            default:
                                Swal.fire({
                                    title: "Erro!",
                                    text: response.message,
                                    icon: "error",
                                    confirmButtonColor: "#4a4fea",
                                });
                                break;
                        }
                    },
                });
            }
        });
    });
    $(".btSubmitDeleteItem").on("click", function (e) {
        e.preventDefault();
        var $this = $(this);
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
        }).then(function (e) {
            if (e.value) {
                Swal.fire({
                    title: "Deletado!",
                    text: "Item deletado com sucesso",
                    icon: "success",
                    showConfirmButton: false,
                });
                setTimeout(() => {
                    $this.parents("form").submit();
                }, 1000);
            }
        });
    });
    $(".table-sortable").each(function () {
        $(this)
            .find("> tbody")
            .sortable({
                handle: ".btnDrag",
            })
            .on("sortupdate", function (e, ui) {
                var arrId = [];
                $(this)
                    .find("> tr")
                    .each(function () {
                        var id = $(this).data("code");
                        arrId.push(id);
                    });

                $.ajax({
                    type: "POST",
                    url: $(this).data("route"),
                    data: { arrId: arrId },
                    success: function (data) {
                        if (data.status) {
                            $.NotificationApp.send(
                                "Sucesso!",
                                "Registros ordenado com sucesso",
                                "bottom-left",
                                "#00000080",
                                "success",
                                "3000"
                            );
                        } else {
                            $.NotificationApp.send(
                                "Erro!",
                                "Ocorreu um erro ao ordenar os registros",
                                "bottom-left",
                                "#00000080",
                                "error",
                                "10000"
                            );
                        }
                    },
                    error: function () {
                        $.NotificationApp.send(
                            "Erro!",
                            "Ocorreu um erro ao ordenar os registros",
                            "bottom-left",
                            "#00000080",
                            "error",
                            "10000"
                        );
                    },
                });
            });
    });

    $("#settingTheme input[type=checkbox]").on("click", function () {
        setTimeout(() => {
            var formData = new FormData(),
                route = $(this).parents("form").attr("action");
            formData.append(
                "color_scheme_mode",
                $(this)
                    .parents("form")
                    .find("[name=color-scheme-mode]:checked")
                    .val()
            );
            formData.append(
                "leftsidebar_color",
                $(this)
                    .parents("form")
                    .find("[name=leftsidebar-color]:checked")
                    .val()
            );
            formData.append(
                "leftsidebar_size",
                $(this)
                    .parents("form")
                    .find("[name=leftsidebar-size]:checked")
                    .val()
            );
            formData.append(
                "topbar_color",
                $(this)
                    .parents("form")
                    .find("[name=topbar-color]:checked")
                    .val()
            );

            $.ajax({
                type: "POST",
                url: route,
                data: formData,
                processData: false,
                contentType: false,
            });
        }, 800);
    });

    $(".selectTypeInput").on("change", function () {
        var type = $(this).val();
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
            `;
        switch (type) {
            case "select":
            case "checkbox":
            case "radio":
                html += `
                    <div class="mb-3">
                        <label class="form-label">Opções</label>
                        <input type="text" name="option_" required class="form-control inputSetOption" placeholder="Separar as opções com vírgula">
                    </div>
                `;
                break;
            case "selectEmail":
                html += `
                    <div class="mb-3">
                        <label class="form-label">Opções</label>
                        <input type="text" name="option_" required class="form-control inputSetOption" placeholder="Separar as opções com vírgula Ex.: Suporte{suporte@exemplo.com.br},Reclamações{reclamacoes@exemplo.com.br}">
                    </div>
                `;
                break;
        }
        html += "</div>";

        $(this).parents(".container-type-input").find(".infoInputs").remove();
        $(this).parents(".container-type-input > *").append(html);
    });

    $("body").on("change", ".inputSetTitle", function () {
        var val = $(this).val();
        var type = $(this)
            .parents(".container-type-input")
            .find("select")
            .val();

        $(this).attr("name", "column_" + slugify(val) + "_" + type);
        $(this)
            .parents(".container-type-input")
            .find(".inputSetRequired")
            .attr("name", "required_" + slugify(val) + "_" + type);
        $(this)
            .parents(".container-type-input")
            .find(".inputSetOption")
            .attr("name", "option_" + slugify(val) + "_" + type);
    });

    $(".cloneTypeButton").on("click", function () {
        const form = $(this).closest("form");

        form.find(".container-type-input:first")
            .clone(true)
            .appendTo(form.find(".container-inputs-contact"));
        form.find(".container-type-input:last")
            .find("select option")
            .removeAttr("selected");
        form.find(".container-type-input:last")
            .find("select option:first")
            .attr("selected", "selected");
        form.find(".infoInputs:last").remove();
    });

    $(".deleteTypeButton").on("click", function () {
        if ($(".container-type-input").length > 1) {
            $(this).parents(".container-type-input").remove();
        }
    });

    $("input[name=btnSelectItem]").on("click", function () {
        const table = $(this).parents("table");
        var btnDelete = table.find("input[name=btnSelectAll]").val(),
            lengthTotal = table.find(".btnSelectItem").length,
            lengthChecked = table.find(".btnSelectItem:checked").length;

        if (!lengthChecked) {
            $(`.${btnDelete}`).fadeOut("fast");
        } else {
            $(`.${btnDelete}`).fadeIn("fast");
        }

        table.find("input[name=btnSelectAll]").prop("checked", false);
        if (lengthTotal == lengthChecked)
            table.find("input[name=btnSelectAll]").prop("checked", true);
    });

    $("input[name=btnSelectAll]").on("click", function () {
        const table = $(this).parents("table");
        var btnDelete = $(this).val();

        if (
            table.find(".btnSelectItem:checked").length ==
            table.find(".btnSelectItem").length
        ) {
            $(`.${btnDelete}`).fadeOut("fast");
            var checked = false;
        } else {
            table.find("input[name=btnSelectAll]").prop("checked", true);
            $(`.${btnDelete}`).fadeIn("fast");
            var checked = true;
        }

        table.find(".btnSelectItem").each(function () {
            $(this).prop("checked", checked);
        });
    });

    $("body").on("click", ".dropify-clear", function () {
        var nameInput = $(this).parent().find("input:first").attr("name");
        $(this).parent().find(`input[name=delete_${nameInput}]`).remove();
        $(this)
            .parent()
            .find(`.preview-image`)
            .css("background-image", "url()");
        $(this).parent().find(`.content-area-image-crop`).show();
        $(this)
            .parent()
            .append(
                `<input type="hidden" name="delete_${nameInput}" value="${nameInput}" />`
            );
    });

    $("body").on("change", ".uploadMultipleImage .inputGetImage", function (e) {
        var $this = $(this),
            contentPreview = $(this).data("content-preview"),
            route = $this.parents("form").attr("action");
        formData = new FormData($this.parents("form")[0]);
        files = e.target.files;

        $.ajax({
            xhr: function () {
                var xhr = new window.XMLHttpRequest();

                xhr.upload.addEventListener(
                    "progress",
                    function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total,
                                percent = percentComplete * 100;

                            $this
                                .parent()
                                .parent()
                                .find(".progressBar .barr")
                                .css("width", percent + "%");
                        }
                    },
                    false
                );

                return xhr;
            },
            type: "POST",
            url: route,
            data: formData,
            dataType: "JSON",
            contentType: false,
            processData: false,
            beforeSend: function () {
                $this
                    .parents(".uploadMultipleImage")
                    .find("#containerMultipleImages img")
                    .remove();
                $.each(files, function (index, file) {
                    let reader = new FileReader();
                    reader.onload = function (event) {
                        $this
                            .parents(".uploadMultipleImage")
                            .find("#containerMultipleImages").append(`
                            <img src="${event.target.result}" class="avatar-lg object-fit-cover rounded bg-light me-1">
                        `);
                    };
                    reader.readAsDataURL(file);
                });

                $this
                    .parent()
                    .prepend(
                        `<div class="progressBar"><span class="barr"></span></div>`
                    );
                $this.parent().parent().find(".progressBar").fadeIn("fast");
            },
            success: function (response) {
                if (response.status == "success") {
                    $.NotificationApp.send(
                        "Sucesso!",
                        response.countUploads +
                            " imagens carregadas com sucesso, a página será atualizada",
                        "bottom-right",
                        "#00000080",
                        "success",
                        "8000"
                    );
                    $this
                        .parent()
                        .find(".progressBar")
                        .fadeOut("fast", function () {
                            $(this).remove();
                        });
                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                } else {
                    $.NotificationApp.send(
                        "Erro!",
                        "Erro ao subir imagens, atualize a página e tente novamente.",
                        "bottom-right",
                        "#00000080",
                        "error",
                        "8000"
                    );
                    $this
                        .parent()
                        .find(".progressBar")
                        .fadeOut("fast", function () {
                            $(this).remove();
                        });
                }
            },
            error: function () {
                $.NotificationApp.send(
                    "Erro!",
                    "Erro ao subir imagens, atualize a página e tente novamente.",
                    "bottom-right",
                    "#00000080",
                    "error",
                    "8000"
                );
                $this
                    .parent()
                    .find(".progressBar")
                    .fadeOut("fast", function () {
                        $(this).remove();
                    });
            },
        });
    });

    $("body").on("click", ".deleteImageUploadMultiple", function () {
        $(this)
            .parents(".contentPreview")
            .fadeOut("slow", function () {
                $(this).remove();
            });
    });

    $("body").on("click", "[data-delete-clone]", function () {
        $(this)
            .parent()
            .parent()
            .fadeOut("slow", function () {
                $(this).remove();
            });
    });

    $("body").on("click", "[data-plugin=clone]", function () {
        let target = $(this).data("target"),
            cloneElem = $(this).data("clone-element");

        $(cloneElem).find(">*").clone(true).appendTo(target);
    });

    $(".modal").each(function () {
        $("body").append($(this));
    });

    function changePushState(elem) {
        const tab = elem.attr("href"),
            url = `?tab=${tab}`;

        localStorage.setItem("tab", tab);
        window.history.pushState({}, tab, url);
    }

    $("[data-bs-toggle=tab]:not(.wrapper-links [data-bs-toggle=tab])").on(
        "click",
        function () {
            changePushState($(this));
        }
    );

    $(window).on("load", function () {
        if (localStorage.getItem("tab")) {
            var hash = localStorage.getItem("tab");
            if ($(`[data-bs-toggle=tab][href=\\${hash}]`).length) {
                $(
                    `[data-bs-toggle=tab]:not(.wrapper-links [data-bs-toggle=tab])`
                ).removeClass("active");
                $(`[data-bs-toggle=tab][href=\\${hash}]`).addClass("active");

                $(".tab-pane:not(.wrapper-links .tab-pane)")
                    .removeClass("active")
                    .removeClass("show");
                $(`${hash}`).addClass("active").addClass("show");
            }

            localStorage.removeItem("tab");
        }

        if (
            $(
                "[data-bs-toggle=tab].active:not(.wrapper-links [data-bs-toggle=tab])"
            ).length
        ) {
            changePushState($("[data-bs-toggle=tab].active"));
        }
    });

    $(window).on("hashchange", function (event) {
        var hash = location.hash.replace("#", "");
        $(`[data-bs-toggle=tab]`).removeClass("active");
        $(`[data-bs-toggle=tab][href=\\#${hash}]`).addClass("active");

        $(".tab-pane").removeClass("active").removeClass("show");
        $(`#${hash}`).addClass("active").addClass("show");

        localStorage.setItem("tab", `#${hash}`);
    });

    var owlDashboard = $(".owl-carousel-dashboard");
    owlDashboard.addClass("owl-carousel");
    owlDashboard.owlCarousel({
        margin: 20,
        dots: false,
        nav: true,
        navContainer: ".navOwlDashboard",
        responsive: {
            // breakpoint from 0 up
            0: {
                items: 1,
            },
            // breakpoint from 360 up
            361: {
                items: 2,
            },
            // breakpoint from 768 up
            800: {
                items: 4,
            },
        },
    });

    $("body").on("click", "[data-bs-toggle=setUrl]", function (event) {
        event.preventDefault();
        let targetUrl = $(this).data("target-url"),
            url = $(this).attr("href");
        $(targetUrl).val(url);
    });

    $("[data-bs-toggle=inputAjax]").on("change", function () {
        var formData = new FormData($(this).parents("form")[0]),
            action = $(this).parents("form").attr("action");

        $.ajax({
            type: "POST",
            url: action,
            data: formData,
            processData: false,
            contentType: false,
        });
    });

    $("#testSmtp").on("click", function (event) {
        event.preventDefault();
        var action = $(this).attr("href");
        $.ajax({
            type: "POST",
            url: action,
            processData: false,
            contentType: false,
            success: function (response) {
                switch (response.status) {
                    case "success":
                        $(".detailsTestSmtp").append(
                            `<span class="badge bg-success mt-2">${response.message}</span>`
                        );
                        break;
                    case "error":
                        $(".detailsTestSmtp").append(`
                            <span class="badge bg-danger my-2">${response.message}</span>
                            <p><b>Confira detalhes do erro abaixo.</b></p>
                            <p>${response.details}</p>
                        `);
                        break;
                }
            },
            error: function (error) {},
        });
    });

    $(".activeDropdown").on("change", function () {
        if ($(this).val() == "1") {
            $(".ifTypeDropdown").fadeIn("fast");
        } else {
            $(".ifTypeDropdown").fadeOut("fast");
            $(".ifLinkDropdown").fadeOut("fast");
            $(".ifRelations").fadeOut("fast");

            $(".activeTypeDropdown").find("option").removeAttr("selected");
            $(".activeTypeDropdown")
                .find("option:first")
                .attr("selected", "selected");
        }
    });

    $(".activeTypeDropdown").on("change", function () {
        if ($(this).val() == "1") {
            $(".ifRelations").fadeIn("fast");
            $(".ifLinkDropdown").fadeOut("fast");
        } else {
            $(".ifRelations").fadeOut("fast");
            $(".ifLinkDropdown").fadeIn("fast");

            $(".containerListPages li").remove();

            $(".selectPage").find("option").removeAttr("selected");
            $(".selectPage").find("option:first").attr("selected", "selected");
        }
    });

    $("#addLinkDropdown").on("click", function () {
        $(this)
            .parents(".ifLinkDropdown")
            .find(".contLinkDropdown:first")
            .clone(true)
            .appendTo("#receiverLinksDropdown");
        $(".contLinkDropdown:last").find("input").val("");
        $(".contLinkDropdown:last")
            .find("select option")
            .removeAttr("selected");
        $(".contLinkDropdown:last")
            .find("select option:first")
            .attr("selected", "selected");
    });

    $(".removeLinkDropdown").on("click", function () {
        if ($(".contLinkDropdown").length > 1) {
            $(this).parent().remove();
        } else {
            $(".activeDropdown").find("option").removeAttr("selected");
            $(".activeDropdown")
                .find("option:first")
                .attr("selected", "selected");
            $(".activeTypeDropdown").find("option").removeAttr("selected");
            $(".activeTypeDropdown")
                .find("option:first")
                .attr("selected", "selected");
            $(".ifTypeDropdown").fadeOut("fast");
            $(".ifLinkDropdown").fadeOut("fast");
        }
    });

    $("body").on("click", ".btnSelectPage", function () {
        $("input[name=select_dropdown]").val($(this).data("relation"));
        $(".btnViewPage .title").text($(this).text());
        $("input[name=set_dropdown]").prop("checked", false);

        let module = $("input[name=module]").val(),
            model = $("input[name=model]").val();

        getConditionsModel(module, model);
    });

    $("body").on("click", ".btnSelectPage input[type=checkbox]", function () {
        $(this).prop("checked", true);
    });

    $("body").on("click", "input[name=set_dropdown]", function () {
        let module = $("input[name=module]").val(),
            model = $("input[name=model]").val();

        $(".btnSelectPage input[type=checkbox]").prop("checked", false);

        if ($(this).is(":checked")) {
            var valueCurrent = $("input[name=select_dropdown]").val(),
                valueThis = $(this).val();

            if (valueCurrent != "this" && valueCurrent != "") {
                $newVal = `${valueCurrent},${valueThis}`;
                if ($("input[name=set_dropdown]:checked").length > 1) {
                    $newVal =
                        $("input[name=set_dropdown]:checked").first().val() +
                        "," +
                        $("input[name=set_dropdown]:checked").last().val();
                }
                $("input[name=select_dropdown]").val($newVal);
            } else {
                $("input[name=select_dropdown]").val(`${valueThis}`);
            }
            $(".btnViewPage .title").text($(".btnSelectPage").text());
            $(".ifCategory").fadeIn();
        } else {
            if ($("input[name=set_dropdown]:checked").length) {
                $("input[name=select_dropdown]").val(
                    $("input[name=set_dropdown]:checked").val()
                );
            } else {
                $("input[name=select_dropdown]").val("");
                $(".btnViewPage .title").text("");
                $(".ifCategory").fadeOut();
                $(".ifCategory input[type=checkbox]").prop("checked", false);
            }
        }

        let relations = $("input[name=select_dropdown]").val(),
            splitRelations = relations.split(",");
        getConditionsModel(module, model, splitRelations[0]);
    });

    var owlForm = $(".models-form-carousel");
    owlForm.addClass("owl-carousel");
    owlForm.owlCarousel({
        margin: 20,
        dots: false,
        nav: true,
        responsive: {
            // breakpoint from 0 up
            0: {
                items: 1,
            },
            // breakpoint from 360 up
            361: {
                items: 2,
            },
            // breakpoint from 768 up
            800: {
                items: 4,
            },
        },
    });

    $("body").on("click", ".getContentModel", function () {
        var model = $(this).val();
        $.ajax({
            type: "POST",
            url: $url + "/painel/getContentModel",
            data: { model },
            success: function (data) {
                $("#appendContent").remove();
                $("#sectionContentForm").append(data);
                createImageCrop();
            },
            error: function () {
                $.NotificationApp.send(
                    "Erro!",
                    "Ocorreu um erro ao buscar a seção de conteúdo, entre em contato com o suporte.",
                    "bottom-left",
                    "#00000080",
                    "error",
                    "10000"
                );
            },
        });
    });

    var SPMaskBehavior = function (val) {
            return val.replace(/\D/g, "").length === 11
                ? "(00) 00000-0000"
                : "(00) 0000-00009";
        },
        spOptions = {
            onKeyPress: function (val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            },
        };

    $(".sp_celphones").mask(SPMaskBehavior, spOptions);
});

document.addEventListener("DOMContentLoaded", () => {
    const stateSelect = document.querySelector("#serv09_form_adm_panel_state");
    const citySelect = document.querySelector("#serv09_form_adm_panel_city");

    if (stateSelect && citySelect) {
        const token = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");

        const route =
            stateSelect.parentNode.querySelector("[data-route]").dataset.route;

        stateSelect.addEventListener("change", (ev) => {
            fetch(route, {
                headers: {
                    "X-CSRF-TOKEN": token,
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    state_id: ev.target.value,
                }),
                method: "POST",
            })
                .then((response) => response.json())
                .then((text) => {
                    let citiesListItems =
                        "<option selected='selected' value=''>Selecione a cidade</option>";

                    Object.entries(text.cities).forEach(([key, value]) => {
                        citiesListItems += `<option value="${key}">${value}</option>`;
                    });

                    citySelect.innerHTML = citiesListItems;
                })
                .catch((error) => console.error(error));
        });
    }


    const channelSelect = document.querySelectorAll('.port05-select');

if (channelSelect) {

    channelSelect.forEach((el) => {
        const categories_container = el.parentNode.querySelector('.categories_container');

        el.addEventListener('change', ev => {
            const channelSelectedValue = ev.target.value;
            const channelSelectedOption = ev.target.querySelector(`option[value="${channelSelectedValue}"]`).innerText;


            if (!categories_container.querySelector(`[value="${channelSelectedValue}"]`)) {
                categories_container.innerHTML += ` <label class="btn btn-light btn-xs waves-effect waves-light">${channelSelectedOption} <i class="mdi mdi-close" onclick="deleteChannelHandler(event)"></i>
                 <input type="hidden" value='${channelSelectedValue}' name="value_id[]"></label>`
            }
        });
    })
}
});


