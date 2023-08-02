@if ($section)
    {!! Form::model($section, ['route' => ['admin.serv07.banner.update', $section->id], 'class' => 'parsley-validate', 'files' => true,]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => 'admin.serv07.banner.store', 'class' => 'parsley-validate', 'files' => true]) !!}
@endif

<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="row">
                <div class="col-sm-6">
                    {!! Form::label('title_banner', 'Título', ['class' => 'form-label']) !!}
                    {!! Form::text('title_banner', null, ['class' => 'form-control', 'id' => 'title_banner']) !!}
                </div>
                <div class="col-sm-6">
                    {!! Form::label('background_color', 'Cor do background', ['class' => 'form-label']) !!}
                    {!! Form::text('background_color', null, ['class' => 'form-control colorpicker-default','id' => 'background_color',]) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Background Desktop', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->Banner->path_image_desktop->width }}x{{ $cropSetting->Banner->path_image_desktop->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_desktop', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->Banner->path_image_desktop->activeCrop, // px
                            'data-min-width' => $cropSetting->Banner->path_image_desktop->width, // px
                            'data-min-height' => $cropSetting->Banner->path_image_desktop->height, // px
                            'data-box-height' => '170', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff',
                            'data-default-file' => isset($section)? ($section->path_image_desktop != ''? url('storage/' . $section->path_image_desktop): ''): '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>

            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Background Mobile', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas {{ $cropSetting->Banner->path_image_mobile->width }}x{{ $cropSetting->Banner->path_image_mobile->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_mobile', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->Banner->path_image_mobile->activeCrop, // px
                            'data-min-width' => $cropSetting->Banner->path_image_mobile->width, // px
                            'data-min-height' => $cropSetting->Banner->path_image_mobile->height, // px
                            'data-box-height' => '170', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($section)? ($section->path_image_mobile != ''? url('storage/' . $section->path_image_mobile): ''): '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0','type' => 'submit',]) !!}
    </div>
</div>
{!! Form::close() !!}
