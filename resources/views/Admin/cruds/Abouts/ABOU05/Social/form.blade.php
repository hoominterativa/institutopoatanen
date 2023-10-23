@if (isset($social))
    {!! Form::model($social, ['route' => ['admin.abou05.social.update', $social->id], 'class'=>'parsley-validate', 'files' => true]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => ['admin.abou05.social.store'], 'class'=>'parsley-validate', 'files' => true]) !!}
    <input type="hidden" name="content_id" value="{{ $content->id }}">
@endif
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card card-body border" id="tooltip-container">
                <div class="mb-3">
                    {!! Form::label(null, 'Link', ['class' => 'form-label']) !!}
                    {!! Form::url('link', (isset($social) && isset($social->link) ? getUri($social->link) : null), ['class' => 'form-control', 'parsley-type' => 'url', 'id' => 'targetUrl']) !!}
                </div>
            </div>
            <div class="mb-3 form-check">
                {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
                {!! Form::label('active', 'Ativar exibição?', ['class'=>'form-check-label']) !!}
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card card-body border" id="tooltip-container">
                <div class="mb-3">
                    <div class="container-image-crop">
                        {!! Form::label('inputImage', 'Ícone', ['class' => 'form-label']) !!}
                        <small class="ms-2">Dimensões proporcionais mínimas
                            {{ $cropSetting->Social->path_image->width }}x{{ $cropSetting->Social->path_image->height }}px!</small>
                        <label class="area-input-image-crop" for="inputImage">
                            {!! Form::file('path_image', [
                                'id' => 'inputImage',
                                'class' => 'inputImage',
                                'data-status' => $cropSetting->Social->path_image->activeCrop, // px
                                'data-min-width' => $cropSetting->Social->path_image->width, // px
                                'data-min-height' => $cropSetting->Social->path_image->height, // px
                                'data-box-height' => '225', // Input height in the form
                                'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                'data-default-file' => isset($social)
                                    ? ($social->path_image != ''
                                        ? url('storage/' . $social->path_image)
                                        : '')
                                    : '',
                            ]) !!}
                        </label>
                    </div><!-- END container image crop -->
                </div>
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
        {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
    </div>
{!! Form::close() !!}
