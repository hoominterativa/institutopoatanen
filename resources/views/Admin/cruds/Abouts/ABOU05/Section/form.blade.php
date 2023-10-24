@if ($section)
    {!! Form::model($section, ['route' => ['admin.abou05.section.update', $section->id], 'class' => 'parsley-validate', 'files' => true,]) !!}
    @method('PUT')
    {!! Form::hidden('active_banner', $section->active_banner) !!}
    {!! Form::hidden('active_content', $section->active_content) !!}
@else
    {!! Form::model(null, ['route' => 'admin.abou04.section.store', 'class' => 'parsley-validate', 'files' => true]) !!}
@endif

<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="row">
                    <div class="mb-3 col-12 col-lg-6">
                        {!! Form::label('title_section', 'Título', ['class'=>'form-label']) !!}
                        {!! Form::text('title_section', null, ['class'=>'form-control', 'id'=>'title_section']) !!}
                    </div>
                    <div class="mb-3 col-12 col-lg-6">
                        {!! Form::label('subtitle_section', 'Subtítulo', ['class'=>'form-label']) !!}
                        {!! Form::text('subtitle_section', null, ['class'=>'form-control', 'id'=>'subtitle_section']) !!}
                    </div>
                </div>
            </div>
            <div class="normal-editor__content mb-3">
                {!! Form::label('description_section', 'Descrição', ['class'=>'form-label']) !!}
                {!! Form::textarea('description_section', null, [
                    'class'=>'form-control normal-editor',
                    'id'=>'description_section',
                ]) !!}
            </div>
            {{-- Color Picker --}}
            <div class="mb-3">
                {!! Form::label('background_color_section', 'Cor do background', ['class' => 'form-label']) !!}
                {!! Form::text('background_color_section', null, [
                    'class' => 'form-control colorpicker-default',
                    'id' => 'background_color_section',
                ]) !!}
            </div>
        </div>
        {{-- end card-body --}}
        <div class="d-flex">
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active_section', '1', null, ['class' => 'form-check-input', 'id' => 'active_section']) !!}
                {!! Form::label('active_section', 'Ativar exibição?', ['class' => 'form-check-label']) !!}
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Background desktop', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->Section->path_image_desktop_section->width }}x{{ $cropSetting->Section->path_image_desktop_section->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_desktop_section', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->Section->path_image_desktop_section->activeCrop, // px
                            'data-min-width' => $cropSetting->Section->path_image_desktop_section->width, // px
                            'data-min-height' => $cropSetting->Section->path_image_desktop_section->height, // px
                            'data-box-height' => '170', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($section)
                                ? ($section->path_image_desktop_section != ''
                                    ? url('storage/' . $section->path_image_desktop_section)
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
                        {{ $cropSetting->Section->path_image_mobile_section->width }}x{{ $cropSetting->Section->path_image_mobile_section->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_mobile_section', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->Section->path_image_mobile_section->activeCrop, // px
                            'data-min-width' => $cropSetting->Section->path_image_mobile_section->width, // px
                            'data-min-height' => $cropSetting->Section->path_image_mobile_section->height, // px
                            'data-box-height' => '170', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($section)
                                ? ($section->path_image_mobile_section != ''
                                    ? url('storage/' . $section->path_image_mobile_section)
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
