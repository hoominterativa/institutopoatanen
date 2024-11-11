@if (isset($gallery))
    {!! Form::model($gallery, [
        'route' => ['admin.port06.gallery.update', $gallery->id],
        'class' => 'parsley-validate',
        'files' => true,
    ]) !!}
    @method('PUT')
@else
    {!! Form::model(null, [
        'route' => ['admin.port06.gallery.store'],
        'class' => 'parsley-validate',
        'files' => true,
    ]) !!}
    {!! Form::hidden('portfolio_id', $portfolio->id) !!}
@endif
<div class="row">
    <div class="col-12">
        <div class="alert alert-warning mb-3">
            <p class="mb-0">Caso seja cadastrado um link para o vídeo, a imagem sera usada automáticamente como capa do
                vídeo.</p>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body border" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label(null, 'Link do vídeo(Youtube ou Vímeo)', ['class' => 'form-label']) !!}
                {!! Form::url(
                    'link_video',
                    isset($gallery) && isset($gallery->link_video) ? getUri($gallery->link_video) : null,
                    ['class' => 'form-control embedLinkYoutube', 'parsley-type' => 'url', 'id' => 'targetUrl'],
                ) !!}
            </div>
        </div>
        <div class="d-flex">
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                {!! Form::label('active', 'Destacar conteúdo?', ['class' => 'form-check-label']) !!}
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body border" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{-- {{ $cropSetting->Gallery->path_image->width }}x{{ $cropSetting->Gallery->path_image->height }}px!</small> --}}
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            // 'data-status' => $cropSetting->Gallery->path_image->activeCrop, // px
                            // 'data-min-width' => $cropSetting->Gallery->path_image->width, // px
                            // 'data-min-height' => $cropSetting->Gallery->path_image->height, // px
                            'data-box-height' => '170', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($gallery)
                                ? ($gallery->path_image != ''
                                    ? url('storage/' . $gallery->path_image)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
    </div>
</div>
<div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
    {!! Form::button('Salvar', [
        'class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3',
        'type' => 'submit',
    ]) !!}
    {!! Form::button('Fechar', [
        'class' => 'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left',
        'data-bs-dismiss' => 'modal',
        'type' => 'button',
    ]) !!}
</div>
{!! Form::close() !!}
