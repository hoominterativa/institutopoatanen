$(function() {
    'use strict';
    var $container = $('.container-image-crop')
    if ($container.length) {
        $container.each(function() {
            var $this = $(this);
            var console = window.console || { log: function() {} };
            var URL = window.URL || window.webkitURL;

            /* append html required */
            var htmlInput = `
                <div class="preview-image"></div>
                <div class="content-area-image-crop">
                    <i class="mdi mdi-upload"></i>
                    <p>Arraste e solte um arquivo aqui ou clique</p>
                </div>
                <div class="wrap-button-action">
                    <button type="button" class="dropify-clear mb-2">Remover</button>
                    <button type="button" class="button-crop">Recortar Imagem</button>
                </div>
            `;
            var htmlModal = `
                <div id="modal-crop-image" class="modal fade modal-crop-image" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Recortar imagem</h4>
                            </div>
                            <div class="modal-body">
                                <div class="img-container mb-1 float-start me-2">
                                    <img id="CropImage" src="" alt="Picture" class="img-fluid">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" id="cropped" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Salvar recorte</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            $this.find('.area-input-image-crop').append(htmlInput);
            $this.append(htmlModal);

            /* end append */

            var $image = $this.find('#CropImage');
            var $inputImage = $this.find('#inputImage');
            var $data = $inputImage.data();
            var $aspectRatio = $data.scale.split('/')
            var $scale = $data.scale ? parseInt($aspectRatio[0]) / parseInt($aspectRatio[1]) : 1 / 1;
            var $cropped = $this.find('#cropped');
            var $dataHeight = 0;
            var $dataWidth = 0;
            var options = {
                aspectRatio: $scale,
                viewMode: 0,
                preview: $this.find('.crop-img-preview'),
                minContainerWidth: 350,
                minContainerHeight: 350,
                minCropBoxWidth: $data.mincropwidth ? parseInt($data.mincropwidth) : 0,
                crop: function(e) {
                    $dataHeight = Math.round(e.detail.height);
                    $dataWidth = Math.round(e.detail.width);
                }
            };
            var uploadedImageName = 'cropped.jpg';
            var uploadedImageType = 'image/jpeg';
            var uploadedImageURL;
            var myModal = new bootstrap.Modal($this.find('#modal-crop-image'))

            $image.cropper(options);

            // Import image
            if (URL) {
                $inputImage.on('change', function() {
                    var files = this.files;
                    var file;

                    if (!$image.data('cropper')) {
                        return;
                    }

                    if (files && files.length) {

                        file = files[0];

                        if (/^image\/\w+$/.test(file.type)) {

                            myModal.show();

                            uploadedImageName = file.name;
                            uploadedImageType = file.type;

                            if (uploadedImageURL) {
                                URL.revokeObjectURL(uploadedImageURL);
                            }

                            uploadedImageURL = URL.createObjectURL(file);
                            console.log(uploadedImageURL)
                            $image.cropper('destroy').attr('src', uploadedImageURL).cropper(options);

                        } else {
                            window.alert('Please choose an image file.');
                        }
                    }
                });
            } else {
                $inputImage.prop('disabled', true).parent().addClass('disabled');
            }

            $cropped.on('click', function() {
                var result = $image.cropper("getCroppedCanvas", { maxWidth: $dataWidth, maxHeight: $dataHeight }).toDataURL(uploadedImageType);
                var nameInputFIle = $inputImage.attr('name');
                $inputImage.parent().append(`<input type="hidden" name="${nameInputFIle}_cropped" value="${result}" />`)
                $inputImage.parent().find('.button-crop').show()
                $this.find('.preview-image').css('background-image', `url(${result})`)
            })

            $this.find('.wrap-button-action .button-crop').on('click', function() {
                myModal.show();
            })
            $this.find('.wrap-button-action .dropify-clear').on('click', function() {
                $this.find('.wrap-button-action button').hide()
                $this.find('.preview-image').css('background-image', `url()`)
                $this.find('.content-area-image-crop').show()
            });
            // Get image default input upload file
            var $defaultFile = $this.find('[data-default-file]')
            if ($defaultFile.length) {
                $defaultFile.each(function() {
                    var file = $(this).data('default-file')
                    if (file != '') {
                        $(this).parent().find('.preview-image').css('background-image', `url(${file})`)
                        $(this).parent().find('.wrap-button-action button').show()
                        $(this).parent().find('.content-area-image-crop').hide()
                        $image.cropper('destroy').attr('src', file).cropper(options);
                    }
                })
            }

            setTimeout(() => {
                $this.find('> .crop-img-preview').appendTo($this.find('.modal-crop-image .modal-body'))
            }, 2000);

        })
    }


});
