{!! Form::model(null, ['route' => ['admin.topi04.gallery.store'], 'class'=>'parsley-validate', 'files' => true]) !!}
    {!! Form::hidden('topic_id', $topic->id) !!}
    <div class="row">
        <div class="col-12">
            <div class="card card-body border" id="tooltip-container">
                <div class="alert alert-warning mb-3">
                    <p class="mb-0">Selecione as imagens que deseja subir e aguarde até que a mensagem de aviso seja exibida e a página seja recarregada.</p>
                </div>
                <div class="mb-3">
                    <div class="uploadMultipleImage">
                        <label for="path_image" class="content-message">
                            {!! Form::file('path_image[]', [ 'id' => 'path_image', 'multiple' => 'multiple', 'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.svg', 'class' => 'inputGetImage']) !!}
                            <i class="mdi mdi-cloud-upload-outline mdi-36px"></i>
                            <h4 class="title">Solte as imagens aqui ou clique para fazer upload.</h4>
                            <span class="text-muted font-13">Carregar imagens com no máximo <strong>2mb</strong></span>
                        </label>
                        <div id="containerMultipleImages" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{!! Form::close() !!}
