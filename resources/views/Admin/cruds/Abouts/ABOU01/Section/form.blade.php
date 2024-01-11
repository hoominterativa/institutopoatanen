@if ($about)
    {!! Form::model($about, ['route' => ['admin.abou01.update', $about->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
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
            <div class="normal-editor__content mb-3">
                {!! Form::label('normal-editor', 'Texto', ['class'=>'form-label']) !!}
                {!! Form::textarea('description_section', null, [
                    'class'=>'form-control normal-editor',
                    'id'=>'normal-editor',
                ]) !!}
            </div>
            {{-- Color Picker --}}
            <div class="mb-3">
                {!! Form::label('background_color_section', 'Cor do background', ['class' => 'form-label']) !!}
                {!! Form::text('background_color_section', null, [ 'class' => 'form-control colorpicker-default','id' => 'background_color_section',]) !!}
            </div>
        </div>
        <div class="d-flex">
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active_section', '1', null, ['class' => 'form-check-input', 'id' => 'active_section']) !!}
                {!! Form::label('active_section', 'Ativar exibição?', ['class' => 'form-check-label']) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Background Desktop', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image_section_desktop->width}}x{{$cropSetting->path_image_section_desktop->height}}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_section_desktop', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-status'=>$cropSetting->path_image_section_desktop->activeCrop, // px
                            'data-min-width'=>$cropSetting->path_image_section_desktop->width, // px
                            'data-min-height'=>$cropSetting->path_image_section_desktop->height, // px
                            'data-box-height'=>'225', // Input height in the form
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($about)?($about->path_image_section_desktop<>''?url('storage/'.$about->path_image_section_desktop):''):'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Background Mobile', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image_section_mobile->width}}x{{$cropSetting->path_image_section_mobile->height}}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_section_mobile', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-status'=>$cropSetting->path_image_section_mobile->activeCrop, // px
                            'data-min-width'=>$cropSetting->path_image_section_mobile->width, // px
                            'data-min-height'=>$cropSetting->path_image_section_mobile->height, // px
                            'data-box-height'=>'225', // Input height in the form
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($about)?($about->path_image_section_mobile<>''?url('storage/'.$about->path_image_section_mobile):''):'',
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



