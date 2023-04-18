<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label('title', 'Título', ['class' => 'form-label']) !!}
                {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) !!}
            </div>
            <div class="d-flex">
                <div class="mb-3 form-check me-3">
                    {!! Form::checkbox('featured', '1', null, ['class' => 'form-check-input', 'id' => 'featured']) !!}
                    {!! Form::label('featured', 'Destacar na home', ['class' => 'form-check-label']) !!}
                </div>
                <div class="mb-3 form-check me-3">
                    {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                    {!! Form::label('active', 'Ativar exibição', ['class' => 'form-check-label']) !!}
                </div>
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
                        {{ $cropSetting->path_image_box->width }}x{{ $cropSetting->path_image_box->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_box', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image_box->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image_box->width, // px
                            'data-min-height' => $cropSetting->path_image_box->height, // px
                            'data-box-height' => '205', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($portfolio)
                                ? ($portfolio->path_image_box != ''
                                    ? url('storage/' . $portfolio->path_image_box)
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
