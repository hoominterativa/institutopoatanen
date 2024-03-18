@if ($section)
    {!! Form::model($section, [
        'route' => ['admin.serv04.section.update', $section->id], 'class' => 'parsley-validate', 'files' => true,
    ]) !!}
    @method('PUT')
    {!! Form::hidden('active_section', $section->active_section) !!}
@else
    {!! Form::model(null, ['route' => 'admin.serv04.section.store', 'class' => 'parsley-validate', 'files' => true]) !!}
@endif

<div class="card card-body" id="tooltip-container">
    <div class="row">
        <div class="col-12 col-sm-6">
            <div class="mb-2">
                {!! Form::label('title_banner', 'Título do Banner', ['class' => 'form-label']) !!}
                {!! Form::text('title_banner', null, ['class' => 'form-control', 'id' => 'title_banner']) !!}
            </div>
            <div class="mb-2">
                {!! Form::label('description_banner', 'Descrição banner', ['class' => 'form-label']) !!}
                {!! Form::textarea('description_banner', null, [
                    'class' => 'form-control',
                    'id' => 'description_banner',
                    'data-parsley-trigger' => 'keyup',
                    'data-parsley-maxlength' => '500',
                    'data-parsley-minlength-message' => 'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold' => '10',
                ]) !!}
            </div>
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active_banner', '1', null, ['class' => 'form-check-input', 'id' => 'active_banner']) !!}
                {!! Form::label('active_banner', 'Ativar exibição na página?', ['class' => 'form-check-label']) !!}
            </div>
        </div>
        <div class="col-12 col-sm-6">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem Desktop', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->Section->path_image_banner_desktop->width }}x{{ $cropSetting->Section->path_image_banner_desktop->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_banner_desktop', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->Section->path_image_banner_desktop->activeCrop, // px
                            'data-min-width' => $cropSetting->Section->path_image_banner_desktop->width, // px
                            'data-min-height' => $cropSetting->Section->path_image_banner_desktop->height, // px
                            'data-box-height' => '225', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($section)
                                ? ($section->path_image_banner_desktop != ''
                                    ? url('storage/' . $section->path_image_banner_desktop)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>

            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem Mobile', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->Section->path_image_banner_mobile->width }}x{{ $cropSetting->Section->path_image_banner_mobile->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_banner_mobile', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->Section->path_image_banner_mobile->activeCrop, // px
                            'data-min-width' => $cropSetting->Section->path_image_banner_mobile->width, // px
                            'data-min-height' => $cropSetting->Section->path_image_banner_mobile->height, // px
                            'data-box-height' => '225', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($section)
                                ? ($section->path_image_banner_mobile != ''
                                    ? url('storage/' . $section->path_image_banner_mobile)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', [ 'class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0', 'type' => 'submit']) !!}
    </div>
</div>
{!! Form::close() !!}


