<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title', 'Título', ['class' => 'form-label']) !!}
                        {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('subtitle', 'Subtítulo', ['class' => 'form-label']) !!}
                        {!! Form::text('subtitle', null, ['class' => 'form-control', 'id' => 'subtitle']) !!}
                    </div>
                </div>
            </div>
            <div class="normal-editor__content mb-3">
                {!! Form::label('normal-editor', 'Texto', ['class'=>'form-label']) !!}
                {!! Form::textarea('text', null, [
                    'class'=>'form-control normal-editor',
                    'id'=>'normal-editor',
                ]) !!}
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title_inner', 'Título lightbox', ['class' => 'form-label']) !!}
                        {!! Form::text('title_inner', null, ['class' => 'form-control', 'id' => 'title_inner']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('subtitle_inner', 'Subtítulo lightbox', ['class' => 'form-label']) !!}
                        {!! Form::text('subtitle_inner', null, ['class' => 'form-control', 'id' => 'subtitle_inner']) !!}
                    </div>
                </div>
            </div>
            <div class="normal-editor__content mb-3">
                {!! Form::label('normal-editor', 'Texto lightbox', ['class'=>'form-label']) !!}
                {!! Form::textarea('text_inner', null, [
                    'class'=>'form-control normal-editor',
                    'id'=>'normal-editor',
                ]) !!}
            </div>
            <div class="d-flex">
                <div class="mb-3 form-check me-3">
                    {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                    {!! Form::label('active', 'Ativar exibição?', ['class' => 'form-check-label']) !!}
                </div>
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem flutuante', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->Content->path_image->width }}x{{ $cropSetting->Content->path_image->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->Content->path_image->activeCrop, // px
                            'data-min-width' => $cropSetting->Content->path_image->width, // px
                            'data-min-height' => $cropSetting->Content->path_image->height, // px
                            'data-box-height' => '205', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($content)
                                ? ($content->path_image != ''
                                    ? url('storage/' . $content->path_image)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem lightbox', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->Content->path_image_inner->width }}x{{ $cropSetting->Content->path_image_inner->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_inner', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->Content->path_image_inner->activeCrop, // px
                            'data-min-width' => $cropSetting->Content->path_image_inner->width, // px
                            'data-min-height' => $cropSetting->Content->path_image_inner->height, // px
                            'data-box-height' => '180', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($content)
                                ? ($content->path_image_inner != ''
                                    ? url('storage/' . $content->path_image_inner)
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




