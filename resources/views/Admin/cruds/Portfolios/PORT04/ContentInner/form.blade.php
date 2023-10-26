@if ($portfolio)
    {!! Form::model($portfolio, ['route' => ['admin.port04.update', $portfolio->id],'class' => 'parsley-validate','files' => true,]) !!}
    @method('PUT')
    {!! Form::hidden('active', $portfolio->active) !!}
    {!! Form::hidden('active_banner', $portfolio->active_banner) !!}
    {!! Form::hidden('active_section', $portfolio->active_section) !!}
    {!! Form::hidden('title', $portfolio->title) !!}
@else
    {!! Form::model(null, ['route' => 'admin.port04.store', 'class' => 'parsley-validate', 'files' => true]) !!}
@endif

<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title_content', 'Título', ['class' => 'form-label']) !!}
                        {!! Form::text('title_content', null, ['class' => 'form-control', 'id' => 'title_content',]) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('subtitle_content', 'Subtítulo', ['class' => 'form-label']) !!}
                        {!! Form::text('subtitle_content', null, ['class' => 'form-control', 'id' => 'subtitle_content']) !!}
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="normal-editor__content mb-3">
                    {!! Form::label('text_content', 'Texto', ['class'=>'form-label']) !!}
                    {!! Form::textarea('text_content', null, [
                        'class'=>'form-control normal-editor',
                        'data-height'=>500,
                        'id'=>'text_content',
                    ]) !!}
                </div>
            </div>
        </div>
        {{-- end card-body --}}
        <div class="mb-3 form-check">
            {!! Form::checkbox('active_content', '1', null, ['class' => 'form-check-input', 'id' => 'active_content']) !!}
            {!! Form::label('active_content', 'Ativar exibição?', ['class' => 'form-check-label']) !!}
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem flutuante', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->path_image_content->width }}x{{ $cropSetting->path_image_content->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_content', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image_content->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image_content->width, // px
                            'data-min-height' => $cropSetting->path_image_content->height, // px
                            'data-box-height' => '170', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($portfolio)
                                ? ($portfolio->path_image_content != ''
                                    ? url('storage/' . $portfolio->path_image_content)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', [
            'class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0',
            'type' => 'submit',
        ]) !!}
    </div>
</div>
{!! Form::close() !!}
