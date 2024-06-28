@if ($video)
    {!! Form::model($video, ['route' => ['admin.serv12.video.update', $video->id],'class' => 'parsley-validate','files' => true,]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => 'admin.serv12.video.store', 'class' => 'parsley-validate', 'files' => true]) !!}
    {!! Form::hidden('service_id', $service->id) !!}
@endif

<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label(null, 'Link do vídeo', ['class' => 'form-label']) !!}
                {!! Form::url('link', (isset($video) ? getUri($video->link) : null), ['class' => 'form-control embedLinkYoutube', 'parsley-type' => 'url', 'id' => 'targetUrl']) !!}
            </div>
        </div>
        {{-- end card-body --}}
        <div class="mb-3 form-check">
            {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
            {!! Form::label('active', 'Ativar exibição?', ['class' => 'form-check-label']) !!}
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Capa do vídeo', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->Video->path_image->width }}x{{ $cropSetting->Video->path_image->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->Video->path_image->activeCrop, // px
                            'data-min-width' => $cropSetting->Video->path_image->width, // px
                            'data-min-height' => $cropSetting->Video->path_image->height, // px
                            'required' => (!isset($video) || empty($video->path_image)) ? true : false, //
                            'data-box-height' => '170', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($video)
                                ? ($video->path_image != ''
                                    ? url('storage/' . $video->path_image)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0', 'type' => 'submit', ]) !!}
    </div>
</div>
{!! Form::close() !!}
