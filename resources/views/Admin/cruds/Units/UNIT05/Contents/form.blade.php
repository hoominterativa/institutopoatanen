@if (isset($content))
    {!! Form::model($content, ['route' => ['admin.unit05.content.update', $content->id], 'class'=>'parsley-validate', 'files' => true]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => ['admin.unit05.content.store'], 'class'=>'parsley-validate', 'files' => true]) !!}
@endif
    <input type="hidden" name="unit_id" value="{{ $unit->id }}">
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card card-body border" id="tooltip-container">
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
                <div class="col-12">
                    <div class="normal-editor__content mb-3">
                        {!! Form::label('text', 'Texto', ['class'=>'form-label']) !!}
                        {!! Form::textarea('text', null, [
                            'class'=>'form-control normal-editor',
                            'data-height'=>500,
                            'id'=>'text',
                        ]) !!}
                    </div>
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
                    <div class="container-image-crop">
                        {!! Form::label('inputImage', 'Imagem', ['class' => 'form-label']) !!}
                        <small class="ms-2">Dimensões proporcionais mínimas
                            {{ $cropSetting->Content->path_image->width }}x{{ $cropSetting->Content->path_image->height }}px!</small>
                        <label class="area-input-image-crop" for="inputImage">
                            {!! Form::file('path_image', [
                                'id' => 'inputImage',
                                'class' => 'inputImage',
                                'data-status' => $cropSetting->Content->path_image->activeCrop, // px
                                'data-min-width' => $cropSetting->Content->path_image->width, // px
                                'data-min-height' => $cropSetting->Content->path_image->height, // px
                                'data-box-height' => '170', // Input height in the form
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
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
        {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
    </div>
{!! Form::close() !!}
