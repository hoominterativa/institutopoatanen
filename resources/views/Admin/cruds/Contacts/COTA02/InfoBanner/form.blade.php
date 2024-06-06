<div class="row">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <h4 class="mb-3">Informações do Banner</h4>
            <div class="mb-3">
                <div class="d-flex align-items-center mb-1">
                    {!! Form::label('title_banner', 'Título', ['class' => 'form-label mb-0']) !!}
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Título que é exibido no banner da página"></i>
                </div>
                {!! Form::text('title_banner', null, ['class' => 'form-control', 'id' => 'title_banner',]) !!}
            </div>
            <div class="mb-3">
                <div class="d-flex align-items-center mb-1">
                    {!! Form::label('subtitle_banner', 'Subtítulo', ['class' => 'form-label mb-0']) !!}
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Subtítulo que é exibido no banner da página"></i>
                </div>
                {!! Form::text('subtitle_banner', null, ['class' => 'form-control', 'id' => 'subtitle_banner']) !!}
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem Desktop', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->InfoBanner->path_image_banner_desktop->width }}x{{ $cropSetting->InfoBanner->path_image_banner_desktop->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_banner_desktop', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->InfoBanner->path_image_banner_desktop->activeCrop, // px
                            'data-min-width' => $cropSetting->InfoBanner->path_image_banner_desktop->width, // px
                            'data-min-height' => $cropSetting->InfoBanner->path_image_banner_desktop->height, // px
                            'data-box-height' => '300', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($contact)
                                ? ($contact->path_image_banner_desktop != ''
                                    ? url('storage/' . $contact->path_image_banner_desktop)
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
                        {{ $cropSetting->InfoBanner->path_image_banner_mobile->width }}x{{ $cropSetting->InfoBanner->path_image_banner_mobile->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_banner_mobile', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->InfoBanner->path_image_banner_mobile->activeCrop, // px
                            'data-min-width' => $cropSetting->InfoBanner->path_image_banner_mobile->width, // px
                            'data-min-height' => $cropSetting->InfoBanner->path_image_banner_mobile->height, // px
                            'data-box-height' => '300', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($contact)
                                ? ($contact->path_image_banner_mobile != ''
                                    ? url('storage/' . $contact->path_image_banner_mobile)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
        <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
            {!! Form::button('Salvar', ['class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0','type' => 'submit',]) !!}
        </div>
        {{-- end card-body --}}
    </div>
</div>
