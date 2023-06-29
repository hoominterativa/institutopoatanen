
{!! Form::model($product, ['route' => ['admin.prod05.bannerProduct.update', $product->id], 'class' => 'parsley-validate', 'files' => true,]) !!}
    @method('PUT')
    <div class="row col-12">
        <div class="col-12 col-lg-6">
            <div class="card card-body" id="tooltip-container">
                <div class="mb-3">
                    {!! Form::label('title_banner', 'Título', ['class' => 'form-label']) !!}
                    {!! Form::text('title_banner', null, ['class' => 'form-control', 'id' => 'title_banner']) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label('subtitle_banner', 'Subtítulo', ['class' => 'form-label']) !!}
                    {!! Form::text('subtitle_banner', null, ['class' => 'form-control', 'id' => 'subtitle_banner']) !!}
                </div>
            </div>
            {{-- end card-body --}}
        </div>
        <div class="col-12 col-lg-6">
            <div class="card card-body" id="tooltip-container">
                <div class="mb-3">
                    <div class="container-image-crop">
                        {!! Form::label('inputImage', 'Imagem Desktop', ['class' => 'form-label']) !!}
                        <small class="ms-2">Dimensões proporcionais mínimas
                            {{ $cropSetting->path_image_banner->width }}x{{ $cropSetting->path_image_banner->height }}px!</small>
                        <label class="area-input-image-crop" for="inputImage">
                            {!! Form::file('path_image_banner', [
                                'id' => 'inputImage',
                                'class' => 'inputImage',
                                'data-status' => $cropSetting->path_image_banner->activeCrop, // px
                                'data-min-width' => $cropSetting->path_image_banner->width, // px
                                'data-min-height' => $cropSetting->path_image_banner->height, // px
                                'data-box-height' => '170', // Input height in the form
                                'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff',
                                'data-default-file' => isset($product)? ($product->path_image_banner != ''? url('storage/' . $product->path_image_banner): ''): '',
                            ]) !!}
                        </label>
                    </div><!-- END container image crop -->
                </div>

                <div class="mb-3">
                    <div class="container-image-crop">
                        {!! Form::label('inputImage', 'Imagem Mobile', ['class' => 'form-label']) !!}
                        <small class="ms-2">Dimensões proporcionais mínimas {{ $cropSetting->path_image_banner_mobile->width }}x{{ $cropSetting->path_image_banner_mobile->height }}px!</small>
                        <label class="area-input-image-crop" for="inputImage">
                            {!! Form::file('path_image_banner_mobile', [
                                'id' => 'inputImage',
                                'class' => 'inputImage',
                                'data-status' => $cropSetting->path_image_banner_mobile->activeCrop, // px
                                'data-min-width' => $cropSetting->path_image_banner_mobile->width, // px
                                'data-min-height' => $cropSetting->path_image_banner_mobile->height, // px
                                'data-box-height' => '170', // Input height in the form
                                'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                'data-default-file' => isset($product)? ($product->path_image_banner_mobile != ''? url('storage/' . $product->path_image_banner_mobile): ''): '',
                            ]) !!}
                        </label>
                    </div><!-- END container image crop -->
                </div>
            </div>
        </div>
        <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
            {!! Form::button('Salvar', ['class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0','type' => 'submit',]) !!}
        </div>
    </div>
{!! Form::close() !!}
