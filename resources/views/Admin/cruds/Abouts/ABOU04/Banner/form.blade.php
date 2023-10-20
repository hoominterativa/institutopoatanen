@if ($section)
    {!! Form::model($section, ['route' => ['admin.abou04.banner.update', $section->id],'class' => 'parsley-validate','files' => true,]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => 'admin.abou04.banner.store', 'class' => 'parsley-validate', 'files' => true]) !!}
@endif

<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title_banner', 'Título', ['class' => 'form-label']) !!}
                        {!! Form::text('title_banner', null, ['class' => 'form-control', 'id' => 'title_banner']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('subtitle_banner', 'Subtítulo', ['class' => 'form-label']) !!}
                        {!! Form::text('subtitle_banner', null, ['class' => 'form-control', 'id' => 'subtitle_banner']) !!}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                {!! Form::label('background_color_banner', 'Cor do background', ['class' => 'form-label']) !!}
                {!! Form::text('background_color_banner', null, [
                    'class' => 'form-control colorpicker-default',
                    'id' => 'background_color_banner',
                ]) !!}
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
                        {{ $cropSetting->Section->path_image_desktop_banner->width }}x{{ $cropSetting->Section->path_image_desktop_banner->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_desktop_banner', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->Section->path_image_desktop_banner->activeCrop, // px
                            'data-min-width' => $cropSetting->Section->path_image_desktop_banner->width, // px
                            'data-min-height' => $cropSetting->Section->path_image_desktop_banner->height, // px
                            'data-box-height' => '170', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($section)
                                ? ($section->path_image_desktop_banner != ''
                                    ? url('storage/' . $section->path_image_desktop_banner)
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
                        {{ $cropSetting->Section->path_image_mobile_banner->width }}x{{ $cropSetting->Section->path_image_mobile_banner->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_mobile_banner', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->Section->path_image_mobile_banner->activeCrop, // px
                            'data-min-width' => $cropSetting->Section->path_image_mobile_banner->width, // px
                            'data-min-height' => $cropSetting->Section->path_image_mobile_banner->height, // px
                            'data-box-height' => '170', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($section)
                                ? ($section->path_image_mobile_banner != ''
                                    ? url('storage/' . $section->path_image_mobile_banner)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
        {{-- Color Picker --}}
    </div>
</div>
{!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
<a href="{{route('admin.dashboard')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
{!! Form::close() !!}
