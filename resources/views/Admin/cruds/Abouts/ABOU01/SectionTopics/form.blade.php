@if ($section)
    {!! Form::model($section, ['route' => ['admin.abou01.section-topics.update', $section->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
    {!! Form::hidden('active_section', $section->active_section) !!}
    {!! Form::hidden('active_banner', $section->active_banner) !!}
    {!! Form::hidden('active_content', $section->active_content) !!}
@else
    {!! Form::model(null, ['route' => 'admin.abou01.section-topics.store', 'class'=>'parsley-validate', 'files'=>true]) !!}
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
            <div class="d-flex">
                <div class="mb-3 form-check me-3">
                    {!! Form::checkbox('active_topic', '1', null, ['class' => 'form-check-input', 'id' => 'active_topic']) !!}
                    {!! Form::label('active_topic', 'Ativar exibição?', ['class' => 'form-check-label']) !!}
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card card-body" id="tooltip-container">
                <div class="mb-3">
                    <div class="container-image-crop">
                        {!! Form::label('inputImage', 'Background Desktop', ['class'=>'form-label']) !!}
                        <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->Section->path_image_topic_desktop->width}}x{{$cropSetting->Section->path_image_topic_desktop->height}}px!</small>
                        <label class="area-input-image-crop" for="inputImage">
                            {!! Form::file('path_image_topic_desktop', [
                                'id'=>'inputImage',
                                'class'=>'inputImage',
                                'data-status'=>$cropSetting->Section->path_image_topic_desktop->activeCrop, // px
                                'data-min-width'=>$cropSetting->Section->path_image_topic_desktop->width, // px
                                'data-min-height'=>$cropSetting->Section->path_image_topic_desktop->height, // px
                                'data-box-height'=>'225', // Input height in the form
                                'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                'data-default-file'=> isset($section)?($section->path_image_topic_desktop<>''?url('storage/'.$section->path_image_topic_desktop):''):'',
                            ]) !!}
                        </label>
                    </div><!-- END container image crop -->
                </div>
                <div class="mb-3">
                    <div class="container-image-crop">
                        {!! Form::label('inputImage', 'Background Mobile', ['class'=>'form-label']) !!}
                        <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->Section->path_image_topic_mobile->width}}x{{$cropSetting->Section->path_image_topic_mobile->height}}px!</small>
                        <label class="area-input-image-crop" for="inputImage">
                            {!! Form::file('path_image_topic_mobile', [
                                'id'=>'inputImage',
                                'class'=>'inputImage',
                                'data-status'=>$cropSetting->Section->path_image_topic_mobile->activeCrop, // px
                                'data-min-width'=>$cropSetting->Section->path_image_topic_mobile->width, // px
                                'data-min-height'=>$cropSetting->Section->path_image_topic_mobile->height, // px
                                'data-box-height'=>'225', // Input height in the form
                                'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                'data-default-file'=> isset($section)?($section->path_image_topic_mobile<>''?url('storage/'.$section->path_image_topic_mobile):''):'',
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




