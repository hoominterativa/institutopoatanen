@if ($about)
    {!! Form::model($about, ['route' => ['admin.abou01.update', $about->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
@else
    {!! Form::model(null, ['route' => 'admin.abou01.store', 'class'=>'parsley-validate', 'files'=>true]) !!}
@endif
    <div class="row col-12">
        <div class="col-12 col-lg-6">
            <div class="card card-body" id="tooltip-container">
                <div class="row">
                    <div class="mb-3 col-12 col-lg-6">
                        {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                        {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title']) !!}
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
    {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
    <a href="{{route('admin.dashboard')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
{!! Form::close() !!}
{{-- END #formAbout --}}
