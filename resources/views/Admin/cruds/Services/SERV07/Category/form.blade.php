<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title', 'Título', ['class' => 'form-label']) !!}
                        {!! Form::text('title', null, ['class' => 'form-control', 'required'=>'required', 'id' => 'title']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('subtitle', 'Subtítulo', ['class' => 'form-label']) !!}
                        {!! Form::text('subtitle', null, ['class' => 'form-control', 'id' => 'subtitle']) !!}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                {!! Form::label('description', 'Breve Descrição', ['class' => 'form-label']) !!}
                {!! Form::textarea('description', null, [
                    'class' => 'form-control',
                    'id' => 'description',
                    'rows' => 5,
                    'data-parsley-trigger' => 'keyup',
                    'data-parsley-minlength' => '20',
                    'data-parsley-maxlength' => '600',
                    'data-parsley-minlength-message' => 'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold' => '10',
                ]) !!}
            </div>
            <div class="d-flex">
                <div class="mb-3 form-check me-3">
                    {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                    {!! Form::label('active', 'Ativar exibição?', ['class' => 'form-check-label']) !!}
                </div>
                <div class="mb-3 form-check me-3">
                    {!! Form::checkbox('featured', '1', null, ['class' => 'form-check-input', 'id' => 'featured']) !!}
                    {!! Form::label('featured', 'Destacar na home?', ['class' => 'form-check-label']) !!}
                </div>
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Ícone', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->Category->path_image_icon->width }}x{{ $cropSetting->Category->path_image_icon->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_icon', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->Category->path_image_icon->activeCrop, // px
                            'data-min-width' => $cropSetting->Category->path_image_icon->width, // px
                            'data-min-height' => $cropSetting->Category->path_image_icon->height, // px
                            'data-box-height' => '180', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($category)
                                ? ($category->path_image_icon != ''
                                    ? url('storage/' . $category->path_image_icon)
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
                        {{ $cropSetting->Category->path_image->width }}x{{ $cropSetting->Category->path_image->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->Category->path_image->activeCrop, // px
                            'data-min-width' => $cropSetting->Category->path_image->width, // px
                            'data-min-height' => $cropSetting->Category->path_image->height, // px
                            'data-box-height' => '205', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($category)
                                ? ($category->path_image != ''
                                    ? url('storage/' . $category->path_image)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
        {{-- end card-body --}}
    </div>
</div>
{{-- end row --}}


