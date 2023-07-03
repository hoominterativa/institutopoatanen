@if (isset($galleryService))
    {!! Form::model($galleryService, ['route' => ['admin.serv05.gallery-service.update', $galleryService->id], 'class'=>'parsley-validate', 'files' => true]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => ['admin.serv05.gallery-service.store'], 'class'=>'parsley-validate', 'files' => true]) !!}
    <input type="hidden" name="service_id" value="{{ $service->id }}">
@endif
    <div class="row">
        <div class="col-12">
            <div class="card card-body border" id="tooltip-container">
                <div class="mb-3">
                    <div class="container-image-crop">
                        {!! Form::label('inputImage', 'Imagem desktop', ['class' => 'form-label']) !!}
                        <small class="ms-2">Dimensões proporcionais mínimas
                            {{ $cropSetting->GalleryService->path_image_desktop->width }}x{{ $cropSetting->GalleryService->path_image_desktop->height }}px!</small>
                        <label class="area-input-image-crop" for="inputImage">
                            {!! Form::file('path_image_desktop', [
                                'id' => 'inputImage',
                                'class' => 'inputImage',
                                'data-status' => $cropSetting->GalleryService->path_image_desktop->activeCrop, // px
                                'data-min-width' => $cropSetting->GalleryService->path_image_desktop->width, // px
                                'data-min-height' => $cropSetting->GalleryService->path_image_desktop->height, // px
                                'data-box-height' => '225', // Input height in the form
                                'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                'data-default-file' => isset($galleryService)
                                    ? ($galleryService->path_image_desktop != ''
                                        ? url('storage/' . $galleryService->path_image_desktop)
                                        : '')
                                    : '',
                            ]) !!}
                        </label>
                    </div><!-- END container image crop -->
                </div>
                <div class="mb-3">
                    <div class="container-image-crop">
                        {!! Form::label('inputImage', 'Imagem mobile', ['class' => 'form-label']) !!}
                        <small class="ms-2">Dimensões proporcionais mínimas
                            {{ $cropSetting->GalleryService->path_image_mobile->width }}x{{ $cropSetting->GalleryService->path_image_mobile->height }}px!</small>
                        <label class="area-input-image-crop" for="inputImage">
                            {!! Form::file('path_image_mobile', [
                                'id' => 'inputImage',
                                'class' => 'inputImage',
                                'data-status' => $cropSetting->GalleryService->path_image_mobile->activeCrop, // px
                                'data-min-width' => $cropSetting->GalleryService->path_image_mobile->width, // px
                                'data-min-height' => $cropSetting->GalleryService->path_image_mobile->height, // px
                                'data-box-height' => '225', // Input height in the form
                                'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                'data-default-file' => isset($galleryService)
                                    ? ($galleryService->path_image_mobile != ''
                                        ? url('storage/' . $galleryService->path_image_mobile)
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
