@if (isset($category))
    {!! Form::model($category, ['route' => ['admin.serv04.category.update', $category->id], 'class'=>'parsley-validate', 'files' => true]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => ['admin.serv04.category.store'], 'class'=>'parsley-validate', 'files' => true]) !!}
@endif
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="mb-3">
                {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title']) !!}
            </div>
            <div class="basic-editor__content mb-3">
                {!! Form::label('description', 'Texto', ['class' => 'form-label']) !!}
                {!! Form::textarea('description', null, [
                    'class' => 'form-control basic-editor',
                    'data-height' => 500,
                    'id' => 'description',
                ]) !!}
            </div>
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
                {!! Form::label('active', 'Ativar Exibição', ['class'=>'form-check-label']) !!}
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem de fundo do banner (desktop)', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->Category->path_image->width }}x{{ $cropSetting->Category->path_image->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->Category->path_image->activeCrop, // px
                            'data-min-width' => $cropSetting->Category->path_image->width, // px
                            'data-min-height' => $cropSetting->Category->path_image->height, // px
                            'data-box-height' => '225', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($category)
                                ? ($category->path_image != ''
                                    ? url('storage/' . $category->path_image)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            {{-- end card-body --}}
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
        {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
    </div>
{!! Form::close() !!}
