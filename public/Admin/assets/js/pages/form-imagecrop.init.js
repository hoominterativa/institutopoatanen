$(function() {
    'use strict';
    var $container = $('.container-image-crop')
    if ($container.length) {
        $container.each(function() {
            var $this = $(this),
                URL = window.URL || window.webkitURL,
                $inputImage = $this.find('#inputImage'),
                $mimeTypes = $inputImage.attr('accept'),
                nameInputFIle = $inputImage.attr('name'),
                $data = $inputImage.data(),
                htmlInput = `
                    <div class="preview-image"></div>
                    <div class="content-area-image-crop">
                        <i class="icon-cloud-upload"></i>
                        <p>
                            Arraste e solte um arquivo aqui ou clique
                            <small>Recomendamos subir imagens com no máximo 2M.</small>
                            <small>Formatos aceitos: ${$mimeTypes}</small>
                        </p>
                    </div>
                    <button type="button" class="dropify-clear mb-2">Remover</button>
                    <input type="hidden" name="${nameInputFIle}_cropped" value="" />
                `;
            $this.find('.area-input-image-crop').css('height', $data.boxHeight)
            $this.find('.area-input-image-crop').append(htmlInput);

            if($data.status===undefined){
                $this.find('.area-input-image-crop').append(`<span class="badge bg-danger">Erro ao carregar recorte de imagem</span>`);
            }

            // Import image
            if (URL) {
                $inputImage.on('change', function() {
                    /* append html required */
                    if($data.status){
                        var htmlModal = `
                            <div id="modal-crop-image" class="modal-crop-image">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Recortar imagem</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row align-content-stretch">
                                            <div id="imageTargetCrop-wrapper" class="img-container pe-0 col-12 col-lg-6 d-flex justify-content-center align-items-center flex-column">
                                                <img id="CropImage" src="" alt="Picture" class="img-fluid">
                                            </div>
                                            <div class="crop-img-preview col-12 col-lg-6"></div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" id="closeCropped" class="btn btn-secondary waves-effect">Cancelar</button>
                                        <button type="button" id="cropped" class="btn btn-primary waves-effect">Salvar recorte</button>
                                    </div>
                                </div>
                            </div>
                        `;
                        $this.append(htmlModal);
                    }
                    /* end append */

                    var files = this.files,
                        file,
                        $image = $data.status?$this.find('#CropImage'):$this.find('.preview-image'),
                        $cropped = $this.find('#cropped'),
                        $minHeight = $data.minHeight * (80 / $data.minWidth),
                        $minPreviewHeight = $data.minHeight * (300 / $data.minWidth),
                        options = {
                            minSize : [80,$minHeight],
                            preserveAspectRatio : true,
                            input: true,
                            preview : {
                                display: true,
                                wrapper: $this.find('.crop-img-preview'),
                                size : [300, $minPreviewHeight]
                            }
                        },
                        uploadedImageURL

                    if (files && files.length) {

                        file = files[0];

                        if (/^image\/\w+$/.test(file.type)) {

                            if (uploadedImageURL) {
                                URL.revokeObjectURL(uploadedImageURL);
                            }

                            uploadedImageURL = URL.createObjectURL(file);

                            if(!$data.status){
                                $image.css('background-image', `url(${uploadedImageURL})`)
                                $this.find('.content-area-image-crop').hide()
                            }else{
                                $image.attr('src', uploadedImageURL)
                                $image.rcrop(options);

                                $image.on('rcrop-ready', function(){
                                    var srcOriginal = $(this).rcrop('getDataURL')
                                    $this.find(`input[name=${nameInputFIle}_cropped]`).val(srcOriginal)
                                })

                                $image.on('rcrop-changed', function(){
                                    var srcOriginal = $(this).rcrop('getDataURL')
                                    $this.find(`input[name=${nameInputFIle}_cropped]`).val(srcOriginal)
                                })
                                $this.find('> .modal-crop-image').addClass('show')
                            }
                        } else {
                            window.alert('Por favor selecione uma imagem válida.');
                        }
                    }
                    if($data.status){
                        $cropped.on('click', function() {
                            var result = $this.find(`input[name=${nameInputFIle}_cropped]`).val()
                            $this.find('.content-area-image-crop').hide()
                            $this.find('.preview-image').css('background-image', `url(${result})`)
                            $this.find('.dropify-clear').show()
                            $this.find('> .modal-crop-image').remove()
                        })
                    }

                    $this.find('.dropify-clear').on('click', function() {
                        $(this).hide()
                        $this.find('.preview-image').css('background-image', `url()`)
                        $this.find(`input[name=${nameInputFIle}_cropped]`).val('')
                        $inputImage.val('')
                        $this.find('.content-area-image-crop').show()
                    });
                });
            } else {
                $inputImage.prop('disabled', true).parent().addClass('disabled');
            }

            // Get image default input upload file
            var $defaultFile = $this.find('[data-default-file]')
            if ($defaultFile.length) {
                $defaultFile.each(function() {
                    var file = $(this).data('default-file')
                    if (file != '') {
                        $(this).parent().find('.preview-image').css('background-image', `url(${file})`)
                        $(this).parent().find('.dropify-clear').show()
                        $(this).parent().find('.content-area-image-crop').hide()
                    }
                })
            }


            $('body').on('click', '#closeCropped', function(){
                $this.find('#modal-crop-image').fadeOut('fast', function(){
                    this.remove()
                    $inputImage.val('')
                })
            })
        })
    }
});
