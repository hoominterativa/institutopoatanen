<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="d-flex">
                    {!! Form::label('heard', 'Categorias', ['class'=>'form-label']) !!}
                    <i class="text-danger">*</i>
                </div>
                {!! Form::select('category_id', $categories, null, [
                    'class'=>'form-select',
                    'id'=>'heard',
                    'required'=>'required',
                    'multiple' => 'multiple',
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('title', 'Título', ['class' => 'form-label']) !!}
                {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title', 'required'=>'required',]) !!}
            </div>
            <div class="col-12">
                <div class="normal-editor__content mb-3">
                    {!! Form::label('description', 'Texto', ['class'=>'form-label']) !!}
                    {!! Form::textarea('description', null, [
                        'class'=>'form-control normal-editor',
                        'data-height'=>500,
                        'id'=>'description',
                    ]) !!}
                </div>
            </div>
        </div>
        {{-- end card-body --}}
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
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Background do Box', ['class' => 'form-label']) !!}
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
                            'required' => isset($portfolio) ? false : true,
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($portfolio)
                                ? ($portfolio->path_image != ''
                                    ? url('storage/' . $portfolio->path_image)
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
