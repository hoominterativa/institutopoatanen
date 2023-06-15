<div class="row col-12">
    <div class="col-12 ">
        <div class="card card-body " id="tooltip-container">
            <div class="mb-3">
                <div class="d-flex">
                    {!! Form::label('heard', 'Categoria', ['class'=>'form-label']) !!}
                    <i class="text-danger">*</i>
                </div>
                {!! Form::select('category_id', $categories, null, [
                    'class'=>'form-select',
                    'id'=>'heard',
                    'required'=>'required',
                    'placeholder' => 'Informe a categoria'
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('title', 'Título', ['class' => 'form-label']) !!}
                {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem Box', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->path_image->width }}x{{ $cropSetting->path_image->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image->width, // px
                            'data-min-height' => $cropSetting->path_image->height, // px
                            'data-box-height' => '205', // Input height in the form
                            'required' => isset($unit) ? false : true,
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($unit)
                                ? ($unit->path_image != ''
                                    ? url('storage/' . $unit->path_image)
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
                        {{ $cropSetting->path_image_icon->width }}x{{ $cropSetting->path_image_icon->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_icon', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image_icon->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image_icon->width, // px
                            'data-min-height' => $cropSetting->path_image_icon->height, // px
                            'data-box-height' => '205', // Input height in the form
                            // 'required' => isset($unit) ? false : true,
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($unit)
                                ? ($unit->path_image_icon != ''
                                    ? url('storage/' . $unit->path_image_icon)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    <div class="col-12 col-lg-6">

        <div class="card card-body" id="tooltip-container">
            <div class="alert alert-warning">
                <p class="mb-0">As informações cadastradas nestes campos serão mostradas na mesma seção das redes sociais.</p>
            </div>
            <div class="mb-3">
                {!! Form::label('title_show', 'Título', ['class' => 'form-label']) !!}
                {!! Form::text('title_show', null, ['class' => 'form-control', 'id' => 'title_show']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('subtitle_show', 'Subtítulo', ['class' => 'form-label']) !!}
                {!! Form::text('subtitle_show', null, ['class' => 'form-control', 'id' => 'subtitle_show']) !!}
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Ícone', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->path_image_icon_show->width }}x{{ $cropSetting->path_image_icon_show->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_icon_show', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image_icon_show->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image_icon_show->width, // px
                            'data-min-height' => $cropSetting->path_image_icon_show->height, // px
                            'data-box-height' => '205', // Input height in the form
                            'required' => isset($unit) ? false : true,
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($unit)
                                ? ($unit->path_image_icon_show != ''
                                    ? url('storage/' . $unit->path_image_icon_show)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    <div class="d-flex">
        <div class="mb-3 form-check me-3">
            {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
            {!! Form::label('active', 'Ativar exibição', ['class' => 'form-check-label']) !!}
        </div>
    </div>
</div>
{{-- end row --}}

