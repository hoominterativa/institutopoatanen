<ul class="mb-3 nav nav-tabs">
    <li class="nav-item">
        <a href="#formAbout" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">Informações da Página</a>
    </li>
    <li class="nav-item">
        <a href="#formAboutSection" data-bs-toggle="tab" aria-expanded="true" class="nav-link">Informações para Home</a>
    </li>
    <li class="nav-item">
        <a href="#formBannerAbout" data-bs-toggle="tab" aria-expanded="false" class="nav-link">Banner</a>
    </li>
    <li class="nav-item">
        <a href="#formSectionInnerAbout" data-bs-toggle="tab" aria-expanded="false" class="nav-link">Seção Página</a>
    </li>
    <li class="nav-item">
        <a href="#aboutTopicsList" class="nav-link">Tópicos</a>
    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane" id="formAboutSection">
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
                </div>
                {{-- end card-body --}}
            </div>
            {{-- end card --}}
            <div class="col-12 col-lg-6">
                <div class="card card-body" id="tooltip-container">
                    <div class="mb-3">
                        {!! Form::label('message', 'Descrição', ['class'=>'form-label']) !!}
                        {!! Form::textarea('description_section', null, [
                            'class'=>'form-control',
                            'id'=>'message',
                            'required'=>'required',
                            'data-parsley-trigger'=>'keyup',
                            'data-parsley-minlength'=>'20',
                            'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                            'data-parsley-validation-threshold'=>'10',
                        ]) !!}
                    </div>
                </div>
                {{-- end card-body --}}
            </div>
            {{-- end card --}}
        </div>
        {{-- end row --}}
    </div>
    {{-- END #formAboutSection --}}

    <div class="tab-pane" id="formBannerAbout">
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
                            <label class="area-input-image-crop" for="inputImage">
                                {!! Form::file('path_image_banner', [
                                    'id'=>'inputImage',
                                    'class'=>'inputImage',
                                    'data-scale'=>'4/3',
                                    'data-height'=>'125',
                                    'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                    'data-default-file'=> isset($about)?$about->path_image_banner<>''?url('storage/'.$about->path_image_banner):'':'',
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
    </div>
    {{-- END #formBannerAbout --}}

    <div class="tab-pane show active" id="formAbout">
        <div class="row col-12">
            <div class="col-12">
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
        </div>
        {{-- end row --}}
    </div>
    {{-- END #formAbout --}}

    <div class="tab-pane" id="formSectionInnerAbout">
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
                    <div class="mb-3">
                        {!! Form::label('message', 'Descrição', ['class'=>'form-label']) !!}
                        {!! Form::textarea('text_inner_section', null, [
                            'class'=>'form-control',
                            'id'=>'message',
                            'required'=>'required',
                            'data-parsley-trigger'=>'keyup',
                            'data-parsley-minlength'=>'20',
                            'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                            'data-parsley-validation-threshold'=>'10',
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
                            <label class="area-input-image-crop" for="inputImage">
                                {!! Form::file('path_image_inner_section', [
                                    'id'=>'inputImage',
                                    'class'=>'inputImage',
                                    'data-scale'=>'4/3',
                                    'data-height'=>'255',
                                    'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                    'data-default-file'=> isset($about)?$about->path_image_inner_section<>''?url('storage/'.$about->path_image_inner_section):'':'',
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
    </div>
    {{-- END #formSectionInnerAbout --}}
</div>
