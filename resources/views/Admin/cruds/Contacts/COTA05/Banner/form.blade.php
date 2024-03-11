@if ($contact)
    {!! Form::model($contact, ['route' => ['admin.cota05.update', $contact->id],'class' => 'parsley-validate','files' => true,]) !!}
    @method('PUT')
    {!! Form::hidden('slug', $contact->slug) !!}
    {!! Form::hidden('active', $contact->active) !!}
    {!! Form::hidden('active_form',  $contact->active_form ) !!}
@else
    {!! Form::model(null, ['route' => 'admin.cota05.store', 'class' => 'parsley-validate', 'files' => true]) !!}
@endif
<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title_banner', 'Título', ['class' => 'form-label mb-0']) !!}
                        {!! Form::text('title_banner', null, ['class' => 'form-control', 'id' => 'title_banner']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('subtitle_banner', 'Subtítulo', ['class' => 'form-label mb-0']) !!}
                        {!! Form::text('subtitle_banner', null, ['class' => 'form-control', 'id' => 'subtitle_banner']) !!}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                {!! Form::label('colorpicker-default', 'Cor de fundo', ['class' => 'form-label']) !!}
                {!! Form::text('background_color_banner', null, [ 'class' => 'form-control colorpicker-default', 'id' => 'colorpicker-default', ]) !!}
            </div>
        </div>
        <div class="mb-3 form-check">
            {!! Form::checkbox('active_banner', '1', null, ['class'=>'form-check-input', 'id'=>'active_banner']) !!}
            {!! Form::label('active_banner', 'Ativar exbição?', ['class'=>'form-check-label']) !!}
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem Desktop', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->path_image_desktop_banner->width }}x{{ $cropSetting->path_image_desktop_banner->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_desktop_banner', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image_desktop_banner->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image_desktop_banner->width, // px
                            'data-min-height' => $cropSetting->path_image_desktop_banner->height, // px
                            'data-box-height' => '300', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($contact)
                                ? ($contact->path_image_desktop_banner != ''
                                    ? url('storage/' . $contact->path_image_desktop_banner)
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
                        {{ $cropSetting->path_image_mobile_banner->width }}x{{ $cropSetting->path_image_mobile_banner->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_mobile_banner', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image_mobile_banner->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image_mobile_banner->width, // px
                            'data-min-height' => $cropSetting->path_image_mobile_banner->height, // px
                            'data-box-height' => '300', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($contact)
                                ? ($contact->path_image_mobile_banner != ''
                                    ? url('storage/' . $contact->path_image_mobile_banner)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', [ 'class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0', 'type' => 'submit']) !!}
    </div>
</div>
{!! Form::close() !!}
