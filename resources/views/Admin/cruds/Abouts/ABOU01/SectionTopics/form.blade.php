@if ($about)
    {!! Form::model($about, ['route' => ['admin.abou01.update', $about->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
    {!! Form::hidden('active_section', $about->active_section) !!}
    {!! Form::hidden('active_banner', $about->active_banner) !!}
    {!! Form::hidden('active_content', $about->active_content) !!}
    {!! Form::hidden('active', $about->active) !!}
    {!! Form::hidden('slug', $about->slug) !!}
    {!! Form::hidden('link_button_content', $about->link_button_content) !!}
@else
    {!! Form::model(null, ['route' => 'admin.abou01.store', 'class'=>'parsley-validate', 'files'=>true]) !!}
@endif
    <div class="row col-12">
        <div class="col-12 col-lg-6">
            <div class="card card-body" id="tooltip-container">
                 {{-- Color Picker --}}
                 <div class="mb-3">
                    {!! Form::label('background_color_topic', 'Cor do background', ['class' => 'form-label']) !!}
                    {!! Form::text('background_color_topic', null, [ 'class' => 'form-control colorpicker-default','id' => 'background_color_topic',]) !!}
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card card-body" id="tooltip-container">
                <div class="mb-3">
                    <div class="container-image-crop">
                        {!! Form::label('inputImage', 'Background Desktop', ['class'=>'form-label']) !!}
                        <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image_topic_desktop->width}}x{{$cropSetting->path_image_topic_desktop->height}}px!</small>
                        <label class="area-input-image-crop" for="inputImage">
                            {!! Form::file('path_image_topic_desktop', [
                                'id'=>'inputImage',
                                'class'=>'inputImage',
                                'data-status'=>$cropSetting->path_image_topic_desktop->activeCrop, // px
                                'data-min-width'=>$cropSetting->path_image_topic_desktop->width, // px
                                'data-min-height'=>$cropSetting->path_image_topic_desktop->height, // px
                                'data-box-height'=>'225', // Input height in the form
                                'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                'data-default-file'=> isset($about)?($about->path_image_topic_desktop<>''?url('storage/'.$about->path_image_topic_desktop):''):'',
                            ]) !!}
                        </label>
                    </div><!-- END container image crop -->
                </div>
                <div class="mb-3">
                    <div class="container-image-crop">
                        {!! Form::label('inputImage', 'Background Mobile', ['class'=>'form-label']) !!}
                        <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image_topic_mobile->width}}x{{$cropSetting->path_image_topic_mobile->height}}px!</small>
                        <label class="area-input-image-crop" for="inputImage">
                            {!! Form::file('path_image_topic_mobile', [
                                'id'=>'inputImage',
                                'class'=>'inputImage',
                                'data-status'=>$cropSetting->path_image_topic_mobile->activeCrop, // px
                                'data-min-width'=>$cropSetting->path_image_topic_mobile->width, // px
                                'data-min-height'=>$cropSetting->path_image_topic_mobile->height, // px
                                'data-box-height'=>'225', // Input height in the form
                                'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                'data-default-file'=> isset($about)?($about->path_image_topic_mobile<>''?url('storage/'.$about->path_image_topic_mobile):''):'',
                            ]) !!}
                        </label>
                    </div><!-- END container image crop -->
                </div>
            </div>
        </div>
    </div>
    {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
    <a href="{{route('admin.dashboard')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
{!! Form::close() !!}




