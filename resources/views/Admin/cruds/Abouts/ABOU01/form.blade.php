<div class="row col-12">
    {!! Form::hidden('active_banner', isset($about) ? $about->active_banner : null) !!}
    {!! Form::hidden('active_section', isset($about) ? $about->active_section : null) !!}
    {!! Form::hidden('active_content', isset($about) ? $about->active_content : null) !!}
    {!! Form::hidden('link_button_content', isset($about) ? $about->link_button_content : null) !!}
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="row">
                <div class="mb-3 col-12 col-lg-6">
                    {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                    {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title', 'required'=>'required']) !!}
                </div>
                <div class="mb-3 col-12 col-lg-6">
                    {!! Form::label('subtitle', 'Subtítulo', ['class'=>'form-label']) !!}
                    {!! Form::text('subtitle', null, ['class'=>'form-control', 'id'=>'subtitle']) !!}
                </div>
            </div>
            <div class="normal-editor__content mb-3">
                {!! Form::label('normal-editor', 'Texto', ['class'=>'form-label']) !!}
                {!! Form::textarea('text', null, [
                    'class'=>'form-control normal-editor',
                    'id'=>'normal-editor',
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('background_color', 'Cor do background', ['class' => 'form-label']) !!}
                {!! Form::text('background_color', null, [ 'class' => 'form-control colorpicker-default','id' => 'background_color',]) !!}
            </div>
        </div>
        <div class="d-flex">
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                {!! Form::label('active', 'Ativar exibição ?', ['class' => 'form-check-label']) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    {{-- end card --}}
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image->width}}x{{$cropSetting->path_image->height}}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-status'=>$cropSetting->path_image->activeCrop, // px
                            'data-min-width'=>$cropSetting->path_image->width, // px
                            'data-min-height'=>$cropSetting->path_image->height, // px
                            'data-box-height'=>'225', // Input height in the form
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($about)?($about->path_image<>''?url('storage/'.$about->path_image):''):'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Background Desktop', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image_desktop->width}}x{{$cropSetting->path_image_desktop->height}}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_desktop', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-status'=>$cropSetting->path_image_desktop->activeCrop, // px
                            'data-min-width'=>$cropSetting->path_image_desktop->width, // px
                            'data-min-height'=>$cropSetting->path_image_desktop->height, // px
                            'data-box-height'=>'225', // Input height in the form
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($about)?($about->path_image_desktop<>''?url('storage/'.$about->path_image_desktop):''):'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Background Mobile', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image_mobile->width}}x{{$cropSetting->path_image_mobile->height}}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_mobile', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-status'=>$cropSetting->path_image_mobile->activeCrop, // px
                            'data-min-width'=>$cropSetting->path_image_mobile->width, // px
                            'data-min-height'=>$cropSetting->path_image_mobile->height, // px
                            'data-box-height'=>'225', // Input height in the form
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($about)?($about->path_image_mobile<>''?url('storage/'.$about->path_image_mobile):''):'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    {{-- end card --}}
</div>
{{-- end row --}}
