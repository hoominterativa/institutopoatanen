<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label(null, 'Link do vídeo', ['class' => 'form-label']) !!}
                {!! Form::url('link_video', (isset($content) ? getUri($content->link_video) : null), ['class' => 'form-control embedLinkYoutube', 'parsley-type' => 'url', 'id' => 'targetUrl']) !!}
            </div>
        </div>
        <div class="mb-3 form-check">
            {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
            {!! Form::label('active', 'Ativar exibição?', ['class'=>'form-check-label']) !!}
        </div>
        {{-- end card-body --}}
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Capa do vídeo(Thumbnail)', ['class' => 'form-label']) !!}
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                    data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-original-title="Cadastro da thumbnail opcional"></i>
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->path_image->width }}x{{ $cropSetting->path_image->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image->width, // px
                            'data-min-height' => $cropSetting->path_image->height, // px
                            'data-box-height' => '170', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($content)
                                ? ($content->path_image != ''
                                    ? url('storage/' . $content->path_image)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
    </div>
</div>
{{-- end row --}}
