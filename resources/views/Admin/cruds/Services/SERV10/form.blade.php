<div class="row col-12">
    {!! Form::hidden('active_banner', isset($service) ? $service->active_banner : null) !!}
    {!! Form::hidden('active_content', isset($service) ? $service->active_content : null) !!}
    {!! Form::hidden('active_topic', isset($service) ? $service->active_topic : null) !!}
    {!! Form::hidden('active_gallery', isset($service) ? $service->active_gallery : null) !!}
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="d-flex">
                    {!! Form::label('heard', 'Categoria', ['class'=>'form-label']) !!}
                    <i class="text-danger">*</i>
                </div>
                {!! Form::select('category_id', $categories, null, [
                    'class'=>'form-select',
                    'id'=>'heard',
                    'required'=>'required',
                    'placeholder' => 'Informe a categoria do serviço'
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('title_box', 'Título do box', ['class' => 'form-label']) !!}
                {!! Form::text('title_box', null, ['class' => 'form-control', 'id' => 'title_box']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('description_box', 'Descrição do box', ['class' => 'form-label']) !!}
                {!! Form::textarea('description_box', null, [
                    'class' => 'form-control',
                    'id' => 'description_box',
                    'data-parsley-trigger' => 'keyup',
                    'data-parsley-maxlength' => '500',
                    'data-parsley-minlength-message' => 'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold' => '10',
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('title', 'Título interno', ['class' => 'form-label']) !!}
                {!! Form::text('title', null, ['class' => 'form-control', 'required'=>'required', 'id' => 'title']) !!}
            </div>
            <div class="normal-editor__content mb-3">
                {!! Form::label('text', 'Texto interno', ['class' => 'form-label']) !!}
                {!! Form::textarea('text', null, [
                    'class' => 'form-control normal-editor',
                    'data-height' => 500,
                    'id' => 'text',
                ]) !!}
            </div>
        </div>
        <div class="d-flex">
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                {!! Form::label('active', 'Ativar exibição ?', ['class' => 'form-check-label']) !!}
            </div>
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('featured', '1', null, ['class' => 'form-check-input', 'id' => 'featured']) !!}
                {!! Form::label('featured', 'Destacar na home ?', ['class' => 'form-check-label']) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem interna', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->path_image->width }}x{{ $cropSetting->path_image->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image->width, // px
                            'data-min-height' => $cropSetting->path_image->height, // px
                            'data-box-height' => '180', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($service)
                                ? ($service->path_image != ''
                                    ? url('storage/' . $service->path_image)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Ícone', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->path_image_icon_box->width }}x{{ $cropSetting->path_image_icon_box->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_icon_box', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image_icon_box->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image_icon_box->width, // px
                            'data-min-height' => $cropSetting->path_image_icon_box->height, // px
                            'data-box-height' => '180', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($service)
                                ? ($service->path_image_icon_box != ''
                                    ? url('storage/' . $service->path_image_icon_box)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem do box', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->path_image_box->width }}x{{ $cropSetting->path_image_box->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_box', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image_box->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image_box->width, // px
                            'data-min-height' => $cropSetting->path_image_box->height, // px
                            'data-box-height' => '180', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($service)
                                ? ($service->path_image_box != ''
                                    ? url('storage/' . $service->path_image_box)
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
