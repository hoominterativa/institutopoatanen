$(function() {
    'use strict';
    var $container = $('.container-image-crop')
    if ($container.length) {
        $container.each(function() {
            var $this = $(this),
                URL = window.URL || window.webkitURL,
                $inputImage = $this.find('#inputImage'),
                nameInputFIle = $inputImage.attr('name'),
                $data = $inputImage.data(),
                htmlInput = `
                    <div class="preview-image"></div>
                    <div class="content-area-image-crop">
                        <i class="icon-cloud-upload"></i>
                        <p>Arraste e solte um arquivo aqui ou clique</p>
                    </div>
                    <button type="button" class="dropify-clear mb-2">Remover</button>
                    <input type="hidden" name="${nameInputFIle}_cropped" value="" />
                `;

            $this.find('.area-input-image-crop').css('height', $data.boxHeight)
            $this.find('.area-input-image-crop').append(htmlInput);

            // Import image
            if (URL) {
                $inputImage.on('change', function() {
                    /* append html required */
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
                                    <button type="button" id="cropped" class="btn btn-secondary waves-effect">Salvar recorte</button>
                                </div>
                            </div>
                        </div>
                    `;
                    $this.append(htmlModal);
                    /* end append */

                    var files = this.files,
                        file,
                        $image = $this.find('#CropImage'),
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
                        uploadedImageName = 'cropped.jpg',
                        uploadedImageType = 'image/jpeg',
                        uploadedImageURL

                    if (files && files.length) {

                        file = files[0];

                        if (/^image\/\w+$/.test(file.type)) {

                            uploadedImageName = file.name;
                            uploadedImageType = file.type;

                            if (uploadedImageURL) {
                                URL.revokeObjectURL(uploadedImageURL);
                            }

                            uploadedImageURL = URL.createObjectURL(file);

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

                            $this.find('.content-area-image-crop').hide()
                            $this.find('> .modal-crop-image').addClass('show')

                        } else {
                            window.alert('Please choose an image file.');
                        }
                    }

                    $cropped.on('click', function() {
                        var result = $this.find(`input[name=${nameInputFIle}_cropped]`).val()
                        $this.find('.preview-image').css('background-image', `url(${result})`)
                        $this.find('.dropify-clear').show()
                        $this.find('> .modal-crop-image').remove()
                    })

                    $this.find('.dropify-clear').on('click', function() {
                        $(this).hide()
                        $this.find('.preview-image').css('background-image', `url()`)
                        $this.find(`input[name=${nameInputFIle}_cropped]`).val('')
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
        })
    }
});
