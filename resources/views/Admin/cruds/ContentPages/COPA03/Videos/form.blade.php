@if (isset($video))
    {!! Form::model($video, ['route' => ['admin.copa03.video.update', $video->id], 'class'=>'parsley-validate', 'files' => true]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => ['admin.copa03.video.store'], 'class'=>'parsley-validate', 'files' => true]) !!}
@endif
<div class="row">
    <div class="col-12 col-lg-6">
        <div class="card card-body border" id="tooltip-container">
            <div class="mb-3">
                <div class="d-flex">
                    {!! Form::label('heard', 'Subcategoria', ['class'=>'form-label']) !!}
                    <i class="text-danger">*</i>
                </div>
                {!! Form::select('subvideo_id', $subcategoryVideosExists, null, [
                    'class'=>'form-select',
                    'id'=>'heard',
                    'required'=>'required',
                    'placeholder' => 'Informe a subcategoria'
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title',]) !!}
            </div>

            <div class="mb-3">
                {!! Form::label(null, 'Link do vídeo', ['class' => 'form-label']) !!}
                <i class="text-danger">Atenção: Caso você cadastre um arquivo, o link do vídeo será desconsiderado.</i>
                {!! Form::url('link', (isset($video) ? getUri($video->link) : null), ['class' => 'form-control embedLinkYoutube', 'parsley-type' => 'url', 'id' => 'targetUrl']) !!}
            </div>
        </div>
        <div class="d-flex">
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                {!! Form::label('active', 'Ativar exibição?', ['class' => 'form-check-label']) !!}
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body border" id="tooltip-container">
            <div class="mb-3">
                <i class="text-danger">Atenção: Caso você cadastre um arquivo, o link será desconsiderado.</i>
                {!! Form::label('file', 'Arquivo', ['class'=>'form-label']) !!}
                {!! Form::file('path_archive', [
                    'data-plugins'=>'dropify',
                    'data-height'=>'300',
                    'data-max-file-size-preview'=>'2M',
                    'accept'=>'*',
                    'data-default-file'=> isset($video)?($video->path_archive<>''?url('storage/'.$video->path_archive):''):'',
                ]) !!}
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Capa do vídeo', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->Video->path_image->width }}x{{ $cropSetting->Video->path_image->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->Video->path_image->activeCrop, // px
                            'data-min-width' => $cropSetting->Video->path_image->width, // px
                            'data-min-height' => $cropSetting->Video->path_image->height, // px
                            'data-box-height' => '225', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($video)
                                ? ($video->path_image != ''
                                    ? url('storage/' . $video->path_image)
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
<div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
    {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
    {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
</div>
{!! Form::close() !!}
