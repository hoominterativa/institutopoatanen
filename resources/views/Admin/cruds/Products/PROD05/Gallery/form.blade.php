
{!! Form::model(null, ['route' => ['admin.prod05.gallery.store'], 'class'=>'parsley-validate', 'files' => true]) !!}
    {!! Form::hidden('product_id', $product->id) !!}
    <div class="row">
        <div class="col-12">
            <div class="card card-body border" id="tooltip-container">
                <div class="alert alert-warning mb-3">
                    <p class="mb-0">Selecione uma cor ou cadastre uma nova para que as imagens a serem carregadas sejam vinculadas a cor.</p>
                </div>
                <div class="mb-3">
                    {!! Form::label('color', 'Cadastrar nova Cor', ['class'=>'form-label']) !!}
                    {!! Form::text('color', '#cccccc', [
                        'class'=>'form-control colorpicker-default',
                        'id'=>'colorpicker-default',
                    ])!!}
                </div>
                {!! Form::label('color', 'Cores Existentes', ['class'=>'form-label']) !!}
                <div class="d-flex mb-3">
                    @foreach ($galleryTypes as $galleryType)
                        <div class="mb-3 d-flex align-items-center me-3">
                            {!! Form::radio('gallery_type_id', $galleryType->id, null, ['class'=>'form-check-input', 'id'=>'gallery_type_id'.$galleryType->id]) !!}
                            {!! Form::label('gallery_type_id'.$galleryType->id, ' ', ['class'=> 'form-check-label ms-2', 'style'=> 'border-radius: 50px; display:block; width: 30px; height: 30px; background-color: '.$galleryType->color]) !!}
                        </div>
                    @endforeach
                </div>
                <div class="alert alert-warning mb-3">
                    <p class="mb-0">Selecione as imagens que deseja subir e aguarde até que a mensagem de aviso seja exibida e a página seja recarregada.</p>
                </div>
                <div class="mb-3">
                    <div class="uploadMultipleImage">
                        <label for="path_image" class="content-message">
                            {!! Form::file('path_image[]', [ 'id' => 'path_image', 'multiple' => 'multiple', 'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff', 'class' => 'inputGetImage']) !!}
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
