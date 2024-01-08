@if ($section)
    {!! Form::model($section, ['route' => ['admin.copa02.section.update', $section->id], 'class' => 'parsley-validate', 'files' => true,]) !!}
    @method('PUT')
    {!! Form::hidden('active_banner', $section->active_banner) !!}
    {!! Form::hidden('active_section_topic', $section->active_section_topic) !!}
    {!! Form::hidden('active_last_section', $section->active_last_section) !!}
@else
    {!! Form::model(null, ['route' => 'admin.copa02.section.store', 'class' => 'parsley-validate', 'files' => true]) !!}
@endif

<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title_content', 'Título', ['class' => 'form-label']) !!}
                        {!! Form::text('title_content', null, ['class' => 'form-control', 'id' => 'title_content']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('subtitle_content', 'Subtítulo', ['class' => 'form-label']) !!}
                        {!! Form::text('subtitle_content', null, ['class' => 'form-control', 'id' => 'subtitle_content']) !!}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="complete-editor__content mb-3">
                    {!! Form::label('complete-editor', 'Descrição', ['class'=>'form-label']) !!}
                    {!! Form::textarea('description_content', null, [
                        'class'=>'form-control complete-editor',
                        'id'=>'complete-editor',
                    ]) !!}
                </div>
            </div>
            <div class="col-12">
                {!! Form::label('background_color_content', 'Cor do background', ['class' => 'form-label']) !!}
                {!! Form::text('background_color_content', null, ['class' => 'form-control colorpicker-default','id' => 'background_color_content',]) !!}
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active_content', '1', null, ['class' => 'form-check-input', 'id' => 'active_content']) !!}
                {!! Form::label('active_content', 'Ativar exibição dos campos?', ['class' => 'form-check-label']) !!}
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Background Desktop', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->Section->path_image_desktop_content->width }}x{{ $cropSetting->Section->path_image_desktop_content->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_desktop_content', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->Section->path_image_desktop_content->activeCrop, // px
                            'data-min-width' => $cropSetting->Section->path_image_desktop_content->width, // px
                            'data-min-height' => $cropSetting->Section->path_image_desktop_content->height, // px
                            'data-box-height' => '170', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff',
                            'data-default-file' => isset($section)? ($section->path_image_desktop_content != ''? url('storage/' . $section->path_image_desktop_content): ''): '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Background Mobile', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas {{ $cropSetting->Section->path_image_mobile_content->width }}x{{ $cropSetting->Section->path_image_mobile_content->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_mobile_content', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->Section->path_image_mobile_content->activeCrop, // px
                            'data-min-width' => $cropSetting->Section->path_image_mobile_content->width, // px
                            'data-min-height' => $cropSetting->Section->path_image_mobile_content->height, // px
                            'data-box-height' => '170', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($section)? ($section->path_image_mobile_content != ''? url('storage/' . $section->path_image_mobile_content): ''): '',
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
