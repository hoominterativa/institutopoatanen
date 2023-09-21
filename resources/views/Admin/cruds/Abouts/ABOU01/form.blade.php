<div class="tab-pane" id="formAboutSection">
    @if ($about)
        {!! Form::model($about, ['route' => ['admin.abou01.update', $about->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
    @else
        {!! Form::model(null, ['route' => 'admin.abou01.store', 'class'=>'parsley-validate', 'files'=>true]) !!}
    @endif
    <div class="row col-12">
        <div class="col-12 col-lg-6">
            <div class="card card-body" id="tooltip-container">
                <div class="mb-3">
                    {!! Form::label('title_section', 'Título', ['class'=>'form-label']) !!}
                    {!! Form::text('title_section', null, ['class'=>'form-control', 'id'=>'title_section']) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label('subtitle_section', 'Subtítulo', ['class'=>'form-label']) !!}
                    {!! Form::text('subtitle_section', null, ['class'=>'form-control', 'id'=>'subtitle_section']) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label('message', 'Descrição', ['class'=>'form-label']) !!}
                    {!! Form::textarea('description_section', null, [
                        'class'=>'form-control',
                        'id'=>'message',
                        'data-parsley-trigger'=>'keyup',
                        'data-parsley-minlength'=>'20',
                        'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                        'data-parsley-validation-threshold'=>'10',
                    ]) !!}
                </div>
            </div>
            {{-- end card-body --}}
        </div>
        <div class="col-12 col-lg-6">
            <div class="card card-body" id="tooltip-container">
                <div class="mb-3">
                    <div class="container-image-crop">
                        {!! Form::label('inputImage', 'Background Desktop', ['class'=>'form-label']) !!}
                        <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image_home_desktop->width}}x{{$cropSetting->path_image_home_desktop->height}}px!</small>
                        <label class="area-input-image-crop" for="inputImage">
                            {!! Form::file('path_image_home_desktop', [
                                'id'=>'inputImage',
                                'class'=>'inputImage',
                                'data-status'=>$cropSetting->path_image_home_desktop->activeCrop, // px
                                'data-min-width'=>$cropSetting->path_image_home_desktop->width, // px
                                'data-min-height'=>$cropSetting->path_image_home_desktop->height, // px
                                'data-box-height'=>'225', // Input height in the form
                                'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                'data-default-file'=> isset($about)?($about->path_image_home_desktop<>''?url('storage/'.$about->path_image_home_desktop):''):'',
                            ]) !!}
                        </label>
                    </div><!-- END container image crop -->
                </div>
                <div class="mb-3">
                    <div class="container-image-crop">
                        {!! Form::label('inputImage', 'Background Mobile', ['class'=>'form-label']) !!}
                        <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image_home_mobile->width}}x{{$cropSetting->path_image_home_mobile->height}}px!</small>
                        <label class="area-input-image-crop" for="inputImage">
                            {!! Form::file('path_image_home_mobile', [
                                'id'=>'inputImage',
                                'class'=>'inputImage',
                                'data-status'=>$cropSetting->path_image_home_mobile->activeCrop, // px
                                'data-min-width'=>$cropSetting->path_image_home_mobile->width, // px
                                'data-min-height'=>$cropSetting->path_image_home_mobile->height, // px
                                'data-box-height'=>'225', // Input height in the form
                                'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                'data-default-file'=> isset($about)?($about->path_image_home_mobile<>''?url('storage/'.$about->path_image_home_mobile):''):'',
                            ]) !!}
                        </label>
                    </div><!-- END container image crop -->
                </div>
                {{-- Color Picker --}}
                <div class="mb-3">
                    {!! Form::label('background_color_home', 'Cor do background', ['class' => 'form-label']) !!}
                    {!! Form::text('background_color_home', null, [
                        'class' => 'form-control colorpicker-default',
                        'id' => 'background_color_home',
                    ]) !!}
                </div>
            </div>
        </div>
        {{-- end card --}}
    </div>
        {{-- end row --}}
        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
        <a href="{{route('admin.dashboard')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
    {!! Form::close() !!}
</div>
{{-- END #formAboutSection --}}

<div class="tab-pane" id="formBannerAbout">
    @if ($about)
        {!! Form::model($about, ['route' => ['admin.abou01.update', $about->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
    @else
        {!! Form::model(null, ['route' => 'admin.abou01.store', 'class'=>'parsley-validate', 'files'=>true]) !!}
    @endif
        <div class="row col-12">
            <div class="col-12 col-lg-6">
                <div class="card card-body" id="tooltip-container">
                    <div class="mb-3">
                        {!! Form::label('title_banner', 'Título', ['class'=>'form-label']) !!}
                        {!! Form::text('title_banner', null, ['class'=>'form-control', 'id'=>'title_banner']) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('subtitle_banner', 'Subtítulo', ['class'=>'form-label']) !!}
                        {!! Form::text('subtitle_banner', null, ['class'=>'form-control', 'id'=>'subtitle_banner']) !!}
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
                            <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image_banner->width}}x{{$cropSetting->path_image_banner->height}}px!</small>
                            <label class="area-input-image-crop" for="inputImage">
                                {!! Form::file('path_image_banner', [
                                    'id'=>'inputImage',
                                    'class'=>'inputImage',
                                    'data-status'=>$cropSetting->path_image_banner->activeCrop, // px
                                    'data-min-width'=>$cropSetting->path_image_banner->width, // px
                                    'data-min-height'=>$cropSetting->path_image_banner->height, // px
                                    'data-box-height'=>'225', // Input height in the form
                                    'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                    'data-default-file'=> isset($about)?($about->path_image_banner<>''?url('storage/'.$about->path_image_banner):''):'',
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
</div>
{{-- END #formBannerAbout --}}
<div class="tab-pane" id="formSectionTopics">
    @if ($about)
        {!! Form::model($about, ['route' => ['admin.abou01.update', $about->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
    @else
        {!! Form::model(null, ['route' => 'admin.abou01.store', 'class'=>'parsley-validate', 'files'=>true]) !!}
    @endif
        <div class="row col-12">
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
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card card-body" id="tooltip-container">
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
            {{-- Color Picker --}}
            <div class="col-12">
                <div class="card card-body" id="tooltip-container">
                    <div class="mb-3">
                        {!! Form::label('background_color', 'Cor do background', ['class' => 'form-label']) !!}
                        {!! Form::text('background_color', null, [
                            'class' => 'form-control colorpicker-default',
                            'id' => 'background_color',
                        ]) !!}
                    </div>
                </div>
            </div>
        </div>
        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
        <a href="{{route('admin.dashboard')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
    {!! Form::close() !!}
</div>

<div class="tab-pane show active" id="formAbout">
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
                </div>
                {{-- end card-body --}}
            </div>
            {{-- end card --}}
        </div>
        {{-- end row --}}
        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
        <a href="{{route('admin.dashboard')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
    {!! Form::close() !!}
</div>
{{-- END #formAbout --}}

<div class="tab-pane" id="formSectionInnerAbout">
    @if ($about)
        {!! Form::model($about, ['route' => ['admin.abou01.update', $about->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
    @else
        {!! Form::model(null, ['route' => 'admin.abou01.store', 'class'=>'parsley-validate', 'files'=>true]) !!}
    @endif
        <div class="row col-12">
            <div class="col-12 col-lg-6">
                <div class="card card-body" id="tooltip-container">
                    <div class="mb-3">
                        {!! Form::label('title_inner_section', 'Título', ['class'=>'form-label']) !!}
                        {!! Form::text('title_inner_section', null, ['class'=>'form-control', 'id'=>'title_inner_section']) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('subtitle_inner_section', 'Subtítulo', ['class'=>'form-label']) !!}
                        {!! Form::text('subtitle_inner_section', null, ['class'=>'form-control', 'id'=>'subtitle_inner_section']) !!}
                    </div>
                    <div class="normal-editor__content mb-3">
                        {!! Form::label('normal-editor', 'Descrição', ['class'=>'form-label']) !!}
                        {!! Form::textarea('text_inner_section', null, [
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
                            <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image_inner_section->width}}x{{$cropSetting->path_image_inner_section->height}}px!</small>
                            <label class="area-input-image-crop" for="inputImage">
                                {!! Form::file('path_image_inner_section', [
                                    'id'=>'inputImage',
                                    'class'=>'inputImage',
                                    'data-status'=>$cropSetting->path_image_inner_section->activeCrop, // px
                                    'data-min-width'=>$cropSetting->path_image_inner_section->width, // px
                                    'data-min-height'=>$cropSetting->path_image_inner_section->height, // px
                                    'data-box-height'=>'225', // Input height in the form
                                    'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                    'data-default-file'=> isset($about)?($about->path_image_inner_section<>''?url('storage/'.$about->path_image_inner_section):''):'',
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
</div>
{{-- END #formSectionInnerAbout --}}

