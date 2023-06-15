@if (isset($gallery))
    {!! Form::model($gallery, [
        'route' => ['admin.unit03.gallery.update', $gallery->id],
        'class' => 'parsley-validate',
        'files' => true,
    ]) !!}
    @method('PUT')
@else
    {!! Form::model(null, [
        'route' => ['admin.unit03.gallery.store'],
        'class' => 'parsley-validate',
        'files' => true,
    ]) !!}
    <input type="hidden" name="unit_id" value="{{ $unit->id }}">
@endif

<div class="row col-12">
    <div class="col-12">
        <div class="mb-3">
            <i class="text-danger">Atenção: Cadastro opcional, recomendamos escolher apenas uma das opções</i>
         </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body border" id="tooltip-container">
            <div class="col-12 col-sm-8">
                {!! Form::label(null, 'Link do vídeo', ['class' => 'form-label']) !!}
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
        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
        {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
    </div>
    {!! Form::close() !!}
</div>

{{-- end row --}}
