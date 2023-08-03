@if ($category)
    {!! Form::model($category, [
        'route' => ['admin.serv07.category.update', $category->id],
        'class' => 'parsley-validate',
        'files' => true,
    ]) !!}
    @method('PUT')
    {!! Form::hidden('active', $category->active) !!}
    {!! Form::hidden('featured', $category->featured) !!}
@else
    {!! Form::model(null, ['route' => 'admin.serv07.category.store', 'class' => 'parsley-validate', 'files' => true]) !!}
@endif

<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="alert alert-warning">
                <p class="mb-0">• As informações cadastradas nestes campos serão mostradas na seção "TOPIC" da página interna.</p>
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title_topic', 'Título', ['class' => 'form-label']) !!}
                        {!! Form::text('title_topic', null, ['class' => 'form-control', 'id' => 'title_topic']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('subtitle_topic', 'Subtítulo', ['class' => 'form-label']) !!}
                        {!! Form::text('subtitle_topic', null, ['class' => 'form-control', 'id' => 'subtitle_topic']) !!}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                {!! Form::label('description_topic', 'Descrição', ['class' => 'form-label']) !!}
                {!! Form::textarea('description_topic', null, [
                    'class' => 'form-control',
                    'id' => 'description_topic',
                    'data-parsley-trigger' => 'keyup',
                    'data-parsley-minlength' => '20',
                    'data-parsley-maxlength' => '900',
                    'data-parsley-minlength-message' => 'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold' => '10',
                ]) !!}
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="alert alert-warning">
                <p class="mb-0">• As informações cadastradas nestes campos serão mostradas na seção "SERVICE" da página interna.</p>
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title_service', 'Título', ['class' => 'form-label']) !!}
                        {!! Form::text('title_service', null, ['class' => 'form-control', 'id' => 'title_service']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('subtitle_service', 'Subtítulo', ['class' => 'form-label']) !!}
                        {!! Form::text('subtitle_service', null, ['class' => 'form-control', 'id' => 'subtitle_service']) !!}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                {!! Form::label('description_service', 'Descrição', ['class' => 'form-label']) !!}
                {!! Form::textarea('description_service', null, [
                    'class' => 'form-control',
                    'id' => 'description_service',
                    'data-parsley-trigger' => 'keyup',
                    'data-parsley-minlength' => '20',
                    'data-parsley-maxlength' => '900',
                    'data-parsley-minlength-message' => 'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold' => '10',
                ]) !!}
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="alert alert-warning">
                <p class="mb-0">• As informações cadastradas nestes campos serão mostradas na seção "Banner" da página show.</p>
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title_banner', 'Título', ['class' => 'form-label']) !!}
                        {!! Form::text('title_banner', null, ['class' => 'form-control', 'id' => 'title_banner']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('background_color', 'Cor do background', ['class' => 'form-label']) !!}
                        {!! Form::text('background_color', null, ['class' => 'form-control colorpicker-default','id' => 'background_color',]) !!}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Background Desktop', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->Category->path_image_desktop->width }}x{{ $cropSetting->Category->path_image_desktop->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_desktop', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->Category->path_image_desktop->activeCrop, // px
                            'data-min-width' => $cropSetting->Category->path_image_desktop->width, // px
                            'data-min-height' => $cropSetting->Category->path_image_desktop->height, // px
                            'data-box-height' => '170', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff',
                            'data-default-file' => isset($category)? ($category->path_image_desktop != ''? url('storage/' . $category->path_image_desktop): ''): '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Background Mobile', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas {{ $cropSetting->Category->path_image_mobile->width }}x{{ $cropSetting->Category->path_image_mobile->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_mobile', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->Category->path_image_mobile->activeCrop, // px
                            'data-min-width' => $cropSetting->Category->path_image_mobile->width, // px
                            'data-min-height' => $cropSetting->Category->path_image_mobile->height, // px
                            'data-box-height' => '170', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($category)? ($category->path_image_mobile != ''? url('storage/' . $category->path_image_mobile): ''): '',
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


