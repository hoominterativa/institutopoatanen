@if (isset($gallery))
    {!! Form::model($gallery, [
        'route' => ['admin.port02.gallery.update', $gallery->id],
        'class' => 'parsley-validate',
        'files' => true,
    ]) !!}
    @method('PUT')
@else
    {!! Form::model(null, [
        'route' => ['admin.port02.gallery.store'],
        'class' => 'parsley-validate',
        'files' => true,
    ]) !!}
    <input type="hidden" name="portfolio_id" value="{{ $portfolio->id }}">
@endif

<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body border" id="tooltip-container">
            <div class="col-12 col-sm-8">
                {!! Form::label(null, 'Link do vídeo', ['class' => 'form-label']) !!}
                <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                    data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-original-title="Caso você queira cadastrar algum vídeo externo(exemplo: Youtube)."></i>
            </div>
            {!! Form::url('link_video', null, ['class' => 'form-control embedLinkYoutube', 'parsley-type' => 'url', 'id' => 'targetUrl']) !!}
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="card card-body border" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->Gallery->path_image->width }}x{{ $cropSetting->Gallery->path_image->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->Gallery->path_image->activeCrop, // px
                            'data-min-width' => $cropSetting->Gallery->path_image->width, // px
                            'data-min-height' => $cropSetting->Gallery->path_image->height, // px
                            'data-box-height' => '205', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($gallery)
                                ? ($gallery->path_image != ''
                                    ? url('storage/' . $gallery->path_image)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', [
            'class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0',
            'type' => 'submit',
        ]) !!}
    </div>
    {!! Form::close() !!}
</div>

{{-- end row --}}
