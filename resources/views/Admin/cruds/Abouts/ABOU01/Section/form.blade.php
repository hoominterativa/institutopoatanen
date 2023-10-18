@if ($section)
    {!! Form::model($section, ['route' => ['admin.abou01.section.update', $section->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
@else
    {!! Form::model(null, ['route' => 'admin.abou01.section.store', 'class'=>'parsley-validate', 'files'=>true]) !!}
@endif
<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title_section', 'Título', ['class'=>'form-label']) !!}
                        {!! Form::text('title_section', null, ['class'=>'form-control', 'id'=>'title_section']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('subtitle_section', 'Subtítulo', ['class'=>'form-label']) !!}
                        {!! Form::text('subtitle_section', null, ['class'=>'form-control', 'id'=>'subtitle_section']) !!}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                {!! Form::label('description_section', 'Descrição', ['class'=>'form-label']) !!}
                {!! Form::textarea('description_section', null, [
                    'class'=>'form-control',
                    'id'=>'description_section',
                    'data-parsley-trigger'=>'keyup',
                    'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold'=>'10',
                ]) !!}
            </div>
            {{-- Color Picker --}}
            <div class="mb-3">
                {!! Form::label('background_color_section', 'Cor do background', ['class' => 'form-label']) !!}
                {!! Form::text('background_color_section', null, [ 'class' => 'form-control colorpicker-default','id' => 'background_color_section',]) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Background Desktop', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->Section->path_image_section_desktop->width}}x{{$cropSetting->Section->path_image_section_desktop->height}}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_section_desktop', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-status'=>$cropSetting->Section->path_image_section_desktop->activeCrop, // px
                            'data-min-width'=>$cropSetting->Section->path_image_section_desktop->width, // px
                            'data-min-height'=>$cropSetting->Section->path_image_section_desktop->height, // px
                            'data-box-height'=>'225', // Input height in the form
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($section)?($section->path_image_section_desktop<>''?url('storage/'.$section->path_image_section_desktop):''):'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Background Mobile', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->Section->path_image_section_mobile->width}}x{{$cropSetting->Section->path_image_section_mobile->height}}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_section_mobile', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-status'=>$cropSetting->Section->path_image_section_mobile->activeCrop, // px
                            'data-min-width'=>$cropSetting->Section->path_image_section_mobile->width, // px
                            'data-min-height'=>$cropSetting->Section->path_image_section_mobile->height, // px
                            'data-box-height'=>'225', // Input height in the form
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($section)?($section->path_image_section_mobile<>''?url('storage/'.$section->path_image_section_mobile):''):'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
    </div>
    {{-- end card --}}
</div>
    {{-- end row --}}
{!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
<a href="{{route('admin.dashboard')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
{!! Form::close() !!}
{{-- END #formAboutSection --}}



