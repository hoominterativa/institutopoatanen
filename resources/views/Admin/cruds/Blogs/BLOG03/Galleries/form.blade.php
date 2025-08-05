@if (isset($gallery))
    {!! Form::model($gallery, [
        'route' => ['admin.blog03.images.update', $gallery->id],
        'class' => 'parsley-validate',
        'files' => true,
    ]) !!}
    @method('PUT')
@else
    {!! Form::model(null, [
        'route' => ['admin.blog03.images.store'],
        'class' => 'parsley-validate',
        'files' => true,
    ]) !!}
    {{-- @if (isset($blog)) --}}
    <input type="hidden" name="blog_id" value="{{ $blog->id }}">
    {{-- @endif --}}
@endif
<div class="row">
    <div class="col-12">
        <div class="card card-body border" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label(null, 'Link do vídeo(Youtube)', ['class' => 'form-label']) !!}
                {!! Form::url('link_url', isset($gallery) && isset($gallery->link_url) ? getUri($gallery->link_url) : null, [
                    'class' => 'form-control embedLinkYoutube',
                    'parsley-type' => 'url',
                    'id' => 'targetUrl',
                ]) !!}
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem', ['class' => 'form-label']) !!}
                    {{-- <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->Galleries->path_image->width }}x{{ $cropSetting->Galleries->path_image->height }}px!</small> --}}
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => 'false', // px
                            'data-min-width' => '500px', // px
                            'data-min-height' => '500px', // px
                            'data-box-height' => '225', // Input height in the form
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
        {{-- end card-body --}}
    </div>
</div>

<div class="button-btn d-flex justify-content-between align-items-center col-12 p-2 m-auto mb-2">
    <div class="form-check ms-2">
        {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
        {!! Form::label('active', 'Ativar Exibição?', ['class'=>'form-check-label']) !!}
    </div>
    <div class="d-flex">
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
</div>
{!! Form::close() !!}
