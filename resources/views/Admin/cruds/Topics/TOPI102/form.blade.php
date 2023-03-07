<ul class="mb-0 nav nav-tabs" id="tooltip-container">
    <li class="nav-item">
        <a href="#slideDesktop" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center active">
            Informações para Desktop
            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-original-title="Cadastrar informações para o tópico que será exibido quando o site for aberto no desktop"></i>
        </a>
    </li>
    <li class="nav-item">
        <a href="#slideMobile" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
            Informações para Mobile
            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-original-title="Cadastrar informações para o tópico que será exibido quando o site for aberto em um dispositivo móvel"></i>
        </a>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane show active" id="slideDesktop">
        <div class="row col-12">
            <div class="col-12 col-lg-6">
                <div class="card card-body" id="tooltip-container">
                    <div class="mb-3">
                        {!! Form::label('title', 'Título', ['class' => 'form-label']) !!}
                        {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('text', 'Descrição', ['class' => 'form-label']) !!}
                        {!! Form::textarea('text', null, [
                            'class' => 'form-control',
                            'id' => 'text',
                            'data-parsley-trigger' => 'keyup',
                            'data-parsley-minlength' => '20',
                            'data-parsley-maxlength' => '150',
                            'data-parsley-minlength-message' => 'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                            'data-parsley-validation-threshold' => '10',
                        ]) !!}
                    </div>
                    <div class="mb-3 form-check">
                        {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                        {!! Form::label('active', 'Ativar Banner', ['class' => 'form-check-label']) !!}
                    </div>
                </div>
                {{-- end card-body --}}
            </div>
            {{-- end col-12 --}}
            <div class="col-12 col-lg-6">
                <div class="card card-body">
                    <div class="mb-3">
                        <div class="container-image-crop">
                            {!! Form::label('inputImage', 'Imagem do Banner Desktop', ['class' => 'form-label']) !!}
                            <small class="ms-2">Dimensões proporcionais mínimas
                                {{ $cropSetting->path_image_desktop->width }}x{{ $cropSetting->path_image_desktop->height }}px!</small>
                            <label class="area-input-image-crop" for="inputImage">
                                {!! Form::file('path_image_desktop', [
                                    'id' => 'inputImage',
                                    'class' => 'inputImage',
                                    'data-status' => $cropSetting->path_image_desktop->activeCrop, // px
                                    'data-min-width' => $cropSetting->path_image_desktop->width, // px
                                    'data-min-height' => $cropSetting->path_image_desktop->height, // px
                                    'data-box-height' => '250', // Input height in the form
                                    'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                    'data-default-file' => isset($topic)
                                        ? ($topic->path_image_desktop != ''
                                            ? url('storage/' . $topic->path_image_desktop)
                                            : '')
                                        : '',
                                ]) !!}
                            </label>
                        </div><!-- END container image crop -->
                    </div>
                </div>
                {{-- end card-body --}}
            </div>
            {{-- end col-12 --}}
        </div>
        {{-- end row --}}
    </div>
    {{-- Mobile --}}
    <div class="tab-pane show active" id="slideMobile">
        <div class="row col-12">
            <div class="col-12 col-lg-6">
                <div class="card card-body" id="tooltip-container">
                    <div class="mb-3">
                        {!! Form::label('title_mobile', 'Título', ['class' => 'form-label']) !!}
                        {!! Form::text('title_mobile', null, ['class' => 'form-control', 'id' => 'title_mobile']) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('text_mobile', 'Descrição', ['class' => 'form-label']) !!}
                        {!! Form::textarea('text_mobile', null, [
                            'class' => 'form-control',
                            'id' => 'text_mobile',
                            'data-parsley-trigger' => 'keyup',
                            'data-parsley-minlength' => '20',
                            'data-parsley-maxlength' => '150',
                            'data-parsley-minlength-message' => 'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                            'data-parsley-validation-threshold' => '10',
                        ]) !!}
                    </div>
                    <div class="mb-3 form-check">
                        {!! Form::checkbox('active_mobile', '1', null, ['class' => 'form-check-input', 'id' => 'active_mobile']) !!}
                        {!! Form::label('active_mobile', 'Ativar Tópico', ['class' => 'form-check-label']) !!}
                    </div>
                </div>
                {{-- end card-body --}}
            </div>
            {{-- end col-12 --}}
            <div class="col-12 col-lg-6">
                <div class="card card-body">
                    <div class="mb-3">
                        <div class="container-image-crop">
                            {!! Form::label('inputImage', 'Imagem do Banner Mobile', ['class' => 'form-label']) !!}
                            <small class="ms-2">Dimensões proporcionais mínimas
                                {{ $cropSetting->path_image_mobile->width }}x{{ $cropSetting->path_image_mobile->height }}px!</small>
                            <label class="area-input-image-crop" for="inputImage">
                                {!! Form::file('path_image_mobile', [
                                    'id' => 'inputImage',
                                    'class' => 'inputImage',
                                    'data-status' => $cropSetting->path_image_mobile->activeCrop, // px
                                    'data-min-width' => $cropSetting->path_image_mobile->width, // px
                                    'data-min-height' => $cropSetting->path_image_mobile->height, // px
                                    'data-box-height' => '250', // Input height in the form
                                    'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                    'data-default-file' => isset($topic)
                                        ? ($topic->path_image_mobile != ''
                                            ? url('storage/' . $topic->path_image_mobile)
                                            : '')
                                        : '',
                                ]) !!}
                            </label>
                        </div><!-- END container image crop -->
                    </div>
                </div>
                {{-- end card-body --}}
            </div>
            {{-- end col-12 --}}
        </div>
        {{-- end row --}}
    </div>
</div>
