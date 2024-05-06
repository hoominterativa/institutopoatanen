@if ($service)
    {!! Form::model($service, ['route' => ['admin.serv05.update', $service->id], 'class' => 'parsley-validate', 'files' => true,]) !!}
    @method('PUT')
    {!! Form::hidden('active_about_inner', $service->active_about_inner) !!}
    {!! Form::hidden('active_topic', $service->active_topic) !!}
    {!! Form::hidden('featured', $service->featured) !!}
    {!! Form::hidden('active', $service->active) !!}
    {!! Form::hidden('slug', $service->slug) !!}
    {!! Form::hidden('link_topic', getUri($service->link_topic)) !!}
@else
    {!! Form::model(null, ['route' => 'admin.serv05.store', 'class' => 'parsley-validate', 'files' => true]) !!}
@endif

<div class="card card-body" id="tooltip-container">
    <div class="row">
        <div class="col-12 col-sm-6">
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title_banner', 'Título', ['class' => 'form-label']) !!}
                        {!! Form::text('title_banner', null, ['class' => 'form-control', 'id' => 'title_banner']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('subtitle_banner', 'Subtítulo', ['class' => 'form-label']) !!}
                        {!! Form::text('subtitle_banner', null, ['class' => 'form-control', 'id' => 'subtitle_banner']) !!}
                    </div>
                </div>
            </div>
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active_banner', '1', null, ['class' => 'form-check-input', 'id' => 'active_banner']) !!}
                {!! Form::label('active_banner', 'Ativar exibição na página?', ['class' => 'form-check-label']) !!}
            </div>
        </div>
        <div class="col-12 col-sm-6">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem Desktop', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->path_image_desktop->width }}x{{ $cropSetting->path_image_desktop->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_desktop', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image_desktop->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image_desktop->width, // px
                            'data-min-height' => $cropSetting->path_image_desktop->height, // px
                            'data-box-height' => '225', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($service)
                                ? ($service->path_image_desktop != ''
                                    ? url('storage/' . $service->path_image_desktop)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem Mobile', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->path_image_mobile->width }}x{{ $cropSetting->path_image_mobile->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_mobile', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image_mobile->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image_mobile->width, // px
                            'data-min-height' => $cropSetting->path_image_mobile->height, // px
                            'data-box-height' => '225', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($service)
                                ? ($service->path_image_mobile != ''
                                    ? url('storage/' . $service->path_image_mobile)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', [ 'class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0', 'type' => 'submit']) !!}
    </div>
</div>
{!! Form::close() !!}


