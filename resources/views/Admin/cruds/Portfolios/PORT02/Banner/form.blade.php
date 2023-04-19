<div class="tab-pane" id="banner">
    @if ($banner)
        {!! Form::model($banner, [
            'route' => ['admin.port02.banner.update', $banner->id],
            'class' => 'parsley-validate',
            'files' => true,
        ]) !!}
        @method('PUT')
    @else
        {!! Form::model(null, ['route' => 'admin.port02.banner.store', 'class' => 'parsley-validate', 'files' => true]) !!}
    @endif

    <div class="row col-12">
        <div class="col-12 col-lg-6">
            <div class="card card-body" id="tooltip-container">
                <div class="mb-3">
                    {!! Form::label('title', 'Título', ['class' => 'form-label']) !!}
                    {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) !!}
                </div>

                <div class="mb-3 form-check">
                    {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                    {!! Form::label('active', 'Ativar exibição', ['class' => 'form-check-label']) !!}
                </div>
            </div>
            {{-- end card-body --}}
        </div>
        <div class="col-12 col-lg-6">
            <div class="card card-body" id="tooltip-container">
                <div class="mb-3">
                    <div class="container-image-crop">
                        {!! Form::label('inputImage', 'Background desktop', ['class' => 'form-label']) !!}
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
                                'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                'data-default-file' => isset($banner)
                                    ? ($banner->path_image_desktop != ''
                                        ? url('storage/' . $banner->path_image_desktop)
                                        : '')
                                    : '',
                            ]) !!}
                        </label>
                    </div><!-- END container image crop -->
                </div>
                <div class="mb-3">
                    <div class="container-image-crop">
                        {!! Form::label('inputImage', 'Background Mobile', ['class' => 'form-label']) !!}
                        <small class="ms-2">Dimensões proporcionais mínimas
                            {{ $cropSetting->Banner->path_image_mobile->width }}x{{ $cropSetting->Banner->path_image_mobile->height }}px!</small>
                        <label class="area-input-image-crop" for="inputImage">
                            {!! Form::file('path_image_mobile', [
                                'id' => 'inputImage',
                                'class' => 'inputImage',
                                'data-status' => $cropSetting->Banner->path_image_mobile->activeCrop, // px
                                'data-min-width' => $cropSetting->Banner->path_image_mobile->width, // px
                                'data-min-height' => $cropSetting->Banner->path_image_mobile->height, // px
                                'data-box-height' => '170', // Input height in the form
                                'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                'data-default-file' => isset($banner)
                                    ? ($banner->path_image_mobile != ''
                                        ? url('storage/' . $banner->path_image_mobile)
                                        : '')
                                    : '',
                            ]) !!}
                        </label>
                    </div><!-- END container image crop -->
                </div>
            </div>
            {{-- Color Picker --}}
            <div class="card card-body" id="tooltip-container">
                <div class="mb-3">
                    {!! Form::label('background_color', 'Cor do background', ['class' => 'form-label']) !!}
                    {!! Form::text('background_color', null, [
                        'class' => 'form-control colorpicker-default',
                        'id' => 'background_color',
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
            {!! Form::button('Salvar', [
                'class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0',
                'type' => 'submit',
            ]) !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>
