@if ($service)
    {!! Form::model($service, ['route' => ['admin.serv10.update', $service->id],'class' => 'parsley-validate','files' => true,]) !!}
    @method('PUT')
    {!! Form::hidden('slug', $service->slug) !!}
    {!! Form::hidden('featured', $service->featured) !!}
    {!! Form::hidden('active', $service->active) !!}
    {!! Form::hidden('active_gallery',  $service->active_gallery ) !!}
    {!! Form::hidden('active_content',  $service->active_content ) !!}
    {!! Form::hidden('active_topic',  $service->active_topic ) !!}
@else
    {!! Form::model(null, ['route' => 'admin.serv10.store', 'class' => 'parsley-validate', 'files' => true]) !!}
@endif

<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label('title_banner', 'Título', ['class' => 'form-label']) !!}
                {!! Form::text('title_banner', null, ['class' => 'form-control', 'id' => 'title_banner']) !!}
            </div>
        </div>
        {{-- end card-body --}}
        <div class="mb-3 form-check">
            {!! Form::checkbox('active_banner', '1', null, ['class' => 'form-check-input', 'id' => 'active_banner']) !!}
            {!! Form::label('active_banner', 'Ativar exibição?', ['class' => 'form-check-label']) !!}
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Background desktop', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->path_image_desktop_banner->width }}x{{ $cropSetting->path_image_desktop_banner->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_desktop_banner', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image_desktop_banner->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image_desktop_banner->width, // px
                            'data-min-height' => $cropSetting->path_image_desktop_banner->height, // px
                            'data-box-height' => '170', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($service)
                                ? ($service->path_image_desktop_banner != ''
                                    ? url('storage/' . $service->path_image_desktop_banner)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Background mobile', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->path_image_mobile_banner->width }}x{{ $cropSetting->path_image_mobile_banner->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_mobile_banner', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image_mobile_banner->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image_mobile_banner->width, // px
                            'data-min-height' => $cropSetting->path_image_mobile_banner->height, // px
                            'data-box-height' => '170', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($service)
                                ? ($service->path_image_mobile_banner != ''
                                    ? url('storage/' . $service->path_image_mobile_banner)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0', 'type' => 'submit', ]) !!}
    </div>
</div>
{!! Form::close() !!}
