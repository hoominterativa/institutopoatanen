@if ($section)
    {!! Form::model($section, ['route' => ['admin.abou04.section-topics.update', $section->id],'class' => 'parsley-validate','files' => true,]) !!}
    @method('PUT')
    {!! Form::hidden('active_banner', $section->active_banner) !!}
    {!! Form::hidden('active_galleries', $section->active_galleries) !!}
    {!! Form::hidden('active_section', $section->active_section) !!}
@else
    {!! Form::model(null, ['route' => 'admin.abou04.section-topics.store', 'class' => 'parsley-validate', 'files' => true]) !!}
@endif

<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label('background_color_topics', 'Cor do background', ['class' => 'form-label']) !!}
                {!! Form::text('background_color_topics', null, [
                    'class' => 'form-control colorpicker-default',
                    'id' => 'background_color_topics',
                ]) !!}
            </div>
        </div>
        {{-- end card-body --}}
        <div class="d-flex">
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active_topics', '1', null, ['class' => 'form-check-input', 'id' => 'active_topics']) !!}
                {!! Form::label('active_topics', 'Ativar exibição?', ['class' => 'form-check-label']) !!}
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Background desktop', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->Section->path_image_desktop_topics->width }}x{{ $cropSetting->Section->path_image_desktop_topics->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_desktop_topics', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->Section->path_image_desktop_topics->activeCrop, // px
                            'data-min-width' => $cropSetting->Section->path_image_desktop_topics->width, // px
                            'data-min-height' => $cropSetting->Section->path_image_desktop_topics->height, // px
                            'data-box-height' => '170', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($section)
                                ? ($section->path_image_desktop_topics != ''
                                    ? url('storage/' . $section->path_image_desktop_topics)
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
                        {{ $cropSetting->Section->path_image_mobile_topics->width }}x{{ $cropSetting->Section->path_image_mobile_topics->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_mobile_topics', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->Section->path_image_mobile_topics->activeCrop, // px
                            'data-min-width' => $cropSetting->Section->path_image_mobile_topics->width, // px
                            'data-min-height' => $cropSetting->Section->path_image_mobile_topics->height, // px
                            'data-box-height' => '170', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($section)
                                ? ($section->path_image_mobile_topics != ''
                                    ? url('storage/' . $section->path_image_mobile_topics)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
    </div>
</div>
{!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
<a href="{{route('admin.dashboard')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
{!! Form::close() !!}
