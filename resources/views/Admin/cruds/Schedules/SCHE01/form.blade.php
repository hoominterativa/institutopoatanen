<div class="row col-12">
    <div class="col-12 col-lg-6">
        {!! Form::hidden('active_banner', isset($schedule) ? $schedule->active_banner : null) !!}
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title', 'Título', ['class' => 'form-label']) !!}
                        {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title', 'required'=>'required',]) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('subtitle', 'Subtítulo', ['class' => 'form-label']) !!}
                        {!! Form::text('subtitle', null, ['class' => 'form-control', 'id' => 'subtitle']) !!}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label(null, 'Data do evento', ['class'=>'form-label']) !!}
                        {!! Form::text('event_date', null, [
                            'class'=>'form-control',
                            'required'=>'required',
                            'data-provide'=>'datepicker',
                            'data-date-autoclose'=>'true',
                            'data-date-format'=>'dd/mm/yyyy',
                            'data-date-language'=>'pt-BR',
                            ])!!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label(null, 'Hora do evento', ['class'=>'form-label']) !!}
                        {!! Form::text('event_time', null, [
                            'class'=>'form-control',
                            'data-toggle'=>'input-mask',
                            'data-mask-format'=>'00:00',
                            ]) !!}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                {!! Form::label('description_box', 'Descrição do box', ['class'=>'form-label']) !!}
                <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                    data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-original-title="Uma breve descrição que será mostrada no box na home"></i>
                {!! Form::textarea('description_box', null, [
                    'class'=>'form-control',
                    'id'=>'message',
                    'rows'=>'7',
                    'data-parsley-trigger'=>'keyup',
                    'data-parsley-maxlength'=>'250',
                    'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir uma descrição de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold'=>'10',
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('description', 'Descrição', ['class'=>'form-label']) !!}
                <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                    data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-original-title="Uma breve descrição que será mostrada na página principal"></i>
                {!! Form::textarea('description', null, [
                    'class'=>'form-control',
                    'id'=>'message',
                    'rows'=>'7',
                    'data-parsley-trigger'=>'keyup',
                    'data-parsley-maxlength'=>'900',
                    'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir uma descrição de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold'=>'10',
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('information', 'Informações', ['class'=>'form-label']) !!}
                <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                    data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-original-title="Estas informações serão mostradas na página interna de cada evento em específico"></i>
                {!! Form::textarea('information', null, [
                    'class'=>'form-control',
                    'id'=>'message',
                    'rows'=>'7',
                    'data-parsley-trigger'=>'keyup',
                    'data-parsley-minlength'=>'20',
                    'data-parsley-maxlength'=>'300',
                    'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir uma descrição de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold'=>'10',
                    'placeholder'=>'Exemplo: Local do evento',
                ]) !!}
            </div>
            <div class="col-12">
                <div class="complete-editor__content mb-3">
                    {!! Form::label('text', 'Texto', ['class'=>'form-label']) !!}
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Este texto será mostrado na página interna de cada evento em específico "></i>
                    {!! Form::textarea('text', null, [
                        'class'=>'form-control complete-editor',
                        'data-height'=>500,
                        'id'=>'text',
                    ]) !!}
                </div>
            </div>
            <div class="wrapper-links my-2 border px-2 py-3">
                <ul class="nav nav-pills navtab-bg nav-justified">
                    <li class="nav-item">
                        <a href="#linkPages" data-bs-toggle="tab" aria-expanded="false" class="nav-link py-1">
                            <div class="d-flex align-items-center justify-content-center">
                                Link para página do site
                                <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                                    data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="Pode ser usado para cadastrar um link de redirecionamento para uma página do site ou conteúdo específico."></i>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#linkExternal" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                            <div class="d-flex align-items-center justify-content-center">
                                Link para página externa
                                <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                                    data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="pode ser usado para cadastrar links de redirecionamento para outros sites"></i>
                            </div>
                        </a>
                    </li>
                </ul> {{-- END .nav-tabs --}}
                <div class="tab-content">
                    <div class="tab-pane" id="linkPages">
                        <div class="row">
                            <div class="dropdown mb-3 col-12">
                                {!! Form::label(null, 'Selecione uma página do site', ['class'=>'form-label']) !!}
                                <button class="form-control dropdown-toggle text-start" type="button" id="dropdownPages" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Páginas <i class="mdi mdi-chevron-down float-end"></i>
                                </button>
                                <ul class="dropdown-menu multi-level col-12" aria-labelledby="dropdownPages">
                                    @foreach (listPage() as $page)
                                        <li class="dropdown {{$page->dropdown?'dropdown-submenu':''}}">
                                            <a href="{{$page->route}}" class="dropdown-item" data-bs-toggle="setUrl" data-target-url="#targetUrl" data-bs-toggle="dropdown">{{$page->title}}</a>
                                            @if ($page->dropdown)
                                                <ul class="dropdown-menu">
                                                    @foreach ($page->dropdown as $itens)
                                                        <li><a href="{{$itens->route}}" class="dropdown-item" data-bs-toggle="setUrl" data-target-url="#targetUrl">{{$itens->name}}</a></li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane show active" id="linkExternal"></div>
                </div> {{-- END .tab-content --}}
                <div class="row">
                    <div class="mb-3">
                        {!! Form::label('title_button', 'Título da botão', ['class' => 'form-label']) !!}
                        {!! Form::text('title_button', null, ['class' => 'form-control', 'id' => 'title_button']) !!}

                    </div>
                    <div class="col-12 col-sm-8">
                        {!! Form::label(null, 'Link do botão', ['class'=>'form-label']) !!}
                        {!! Form::url('link_button', null, ['class'=>'form-control','parsley-type'=>'url', 'id' => 'targetUrl']) !!}
                    </div>
                    <div class="col-12 col-sm-4">
                        {!! Form::label('target_link_button', 'Redirecionar', ['class'=>'form-label']) !!}
                        {!! Form::select('target_link_button', ['_self' => 'Na mesma aba', '_blank' => 'Em nova aba'], null, ['class'=>'form-select', 'id'=>'target_link_button']) !!}
                    </div>
                </div>
            </div> {{-- END ."wrapper-links --}}

        </div>
        <div class="d-flex">
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                {!! Form::label('active', 'Ativar exibição do conteúdo?', ['class' => 'form-check-label']) !!}
            </div>
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('featured', '1', null, ['class' => 'form-check-input', 'id' => 'featured']) !!}
                {!! Form::label('featured', 'Destacar na home?', ['class' => 'form-check-label']) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem do box', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->path_image_box->width }}x{{ $cropSetting->path_image_box->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_box', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image_box->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image_box->width, // px
                            'data-min-height' => $cropSetting->path_image_box->height, // px
                            'data-box-height' => '205', // Input height in the form
                            // 'required' => (!isset($schedule) || empty($schedule->path_image_box)) ? true : false, //
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($schedule)
                                ? ($schedule->path_image_box != ''
                                    ? url('storage/' . $schedule->path_image_box)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->path_image->width }}x{{ $cropSetting->path_image->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image->width, // px
                            'data-min-height' => $cropSetting->path_image->height, // px
                            'data-box-height' => '205', // Input height in the form
                            // 'required' => (!isset($schedule) || empty($schedule->path_image)) ? true : false, //
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($schedule)
                                ? ($schedule->path_image != ''
                                    ? url('storage/' . $schedule->path_image)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Ícone hora do evento', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->path_image_hours->width }}x{{ $cropSetting->path_image_hours->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_hours', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image_hours->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image_hours->width, // px
                            'data-min-height' => $cropSetting->path_image_hours->height, // px
                            'data-box-height' => '205', // Input height in the form
                            // 'required' => (!isset($schedule) || empty($schedule->path_image_hours)) ? true : false, //
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($schedule)
                                ? ($schedule->path_image_hours != ''
                                    ? url('storage/' . $schedule->path_image_hours)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Ícone Subtítulo', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->path_image_sub->width }}x{{ $cropSetting->path_image_sub->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_sub', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image_sub->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image_sub->width, // px
                            'data-min-height' => $cropSetting->path_image_sub->height, // px
                            'data-box-height' => '205', // Input height in the form
                            // 'required' => (!isset($schedule) || empty($schedule->path_image_sub)) ? true : false, //
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($schedule)
                                ? ($schedule->path_image_sub != ''
                                    ? url('storage/' . $schedule->path_image_sub)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
        {{-- end card-body --}}
    </div>
</div>
{{-- end row --}}

