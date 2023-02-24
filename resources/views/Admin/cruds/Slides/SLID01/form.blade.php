<ul class="mb-0 nav nav-tabs" id="tooltip-container">
    <li class="nav-item">
        <a href="#slideDesktop" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center active">
            Informações para Desktop {{ deviceDetect() }}
            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-original-title="Cadastrar informações para o slide que será exibido quando o site for aberto no desktop"></i>
        </a>
    </li>
    <li class="nav-item">
        <a href="#slideMobile" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center" >
            Informações para Mobile
            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-original-title="Cadastrar informações para o slide que será exibido quando o site for aberto em um dispositivo móvel"></i>
        </a>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane show active" id="slideDesktop">
        <div class="row col-12">
            <div class="col-12 col-lg-6">
                <div class="card card-body" id="tooltip-container">
                    <div class="row">
                        <div class="mb-3 col-12 col-sm-6">
                            {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                            {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title']) !!}
                        </div>
                        <div class="mb-3 col-12 col-sm-6">
                            {!! Form::label('subtitle', 'Subtítulo', ['class'=>'form-label']) !!}
                            {!! Form::text('subtitle', null, ['class'=>'form-control', 'id'=>'subtitle']) !!}
                        </div>
                    </div>
                    <div class="mb-3">
                        {!! Form::label('description', 'Descrição', ['class'=>'form-label']) !!}
                        {!! Form::textarea('description', null, [
                            'class'=>'form-control',
                            'id'=>'description',
                            'rows' => 3,
                            'data-parsley-trigger'=>'keyup',
                            'data-parsley-minlength'=>'10',
                            'data-parsley-maxlength'=>'300',
                            'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                            'data-parsley-validation-threshold'=>'10',
                        ]) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('title_button', 'Título Botão', ['class'=>'form-label']) !!}
                        {!! Form::text('title_button', null, ['class'=>'form-control', 'id'=>'title_button']) !!}
                    </div>
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-1">
                            {!! Form::label('position_content', 'Posição do Conteudo', ['class'=>'form-label mb-0']) !!}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Informa em qual posição o conteúdo do banner ficará"></i>
                        </div>
                        {!! Form::select('position_content', ['start' => 'A esquerda', 'center' => 'No Centro', 'end' => 'A direita'], isset($slide)?$slide->position_content:'start', [
                            'class'=>'form-select', 'id'=>'position_content']) !!}
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
                            <div class="col-12 col-sm-8">
                                {!! Form::label(null, 'Link Botão', ['class'=>'form-label']) !!}
                                {!! Form::url('link_button', null, ['class'=>'form-control','parsley-type'=>'url', 'id' => 'targetUrl']) !!}
                            </div>
                            <div class="col-12 col-sm-4">
                                {!! Form::label('target_link_button', 'Redirecionar', ['class'=>'form-label']) !!}
                                {!! Form::select('target_link_button', ['_self' => 'Na mesma aba', '_target' => 'Em nova aba'], null, ['class'=>'form-select', 'id'=>'target_link_button']) !!}
                            </div>
                        </div>
                    </div> {{-- END ."wrapper-links --}}

                    <div class="mb-3 form-check">
                        {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
                        {!! Form::label('active', 'Ativar Banner', ['class'=>'form-check-label']) !!}
                    </div>
                </div>
                {{-- end card-body --}}
            </div>
            {{-- end col-12 --}}
            <div class="col-12 col-lg-6">
                <div class="card card-body">
                    <div class="mb-3">
                        <div class="container-image-crop">
                            {!! Form::label('inputImage', 'Imagem do Banner', ['class'=>'form-label']) !!}
                            <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image_desktop->width}}x{{$cropSetting->path_image_desktop->height}}px!</small>
                            <label class="area-input-image-crop" for="inputImage">
                                {!! Form::file('path_image_desktop', [
                                    'id'=>'inputImage',
                                    'class'=>'inputImage',
                                    'data-status'=>$cropSetting->path_image_desktop->activeCrop, // px
                                    'data-min-width'=>$cropSetting->path_image_desktop->width, // px
                                    'data-min-height'=>$cropSetting->path_image_desktop->height, // px
                                    'data-box-height'=>'250', // Input height in the form
                                    'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                    'data-default-file'=> isset($slide)?($slide->path_image_desktop<>''?url('storage/'.$slide->path_image_desktop):''):'',
                                ]) !!}
                            </label>
                        </div><!-- END container image crop -->
                    </div>
                    <div class="mb-3">
                        <div class="container-image-crop">
                            <div class="d-flex align-items-center mb-1">
                                {!! Form::label('inputImage', 'Imagem Flutuante png', ['class'=>'form-label mb-0']) !!}
                                <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                                    data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="Imagem que ficará visível sobre a imagem do desktop e ao lado do conteúdo de texto no banner."></i>
                                    <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image_png->width}}x{{$cropSetting->path_image_png->height}}px!</small>
                            </div>
                            <label class="area-input-image-crop" for="inputImage">
                                {!! Form::file('path_image_png', [
                                    'id'=>'inputImage',
                                    'class'=>'inputImage',
                                    'data-status'=>$cropSetting->path_image_png->activeCrop, // px
                                    'data-min-width'=>$cropSetting->path_image_png->width, // px
                                    'data-min-height'=>$cropSetting->path_image_png->height, // px
                                    'data-box-height'=>'250', // Input height in the form
                                    'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                    'data-default-file'=> isset($slide)?($slide->path_image_png<>''?url('storage/'.$slide->path_image_png):''):'',
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
    <div class="tab-pane show active" id="slideMobile">
        <div class="row col-12">
            <div class="col-12 col-lg-6">
                <div class="card card-body" id="tooltip-container">
                    <div class="row">
                        <div class="mb-3 col-12 col-sm-6">
                            {!! Form::label('title_mobile', 'Título', ['class'=>'form-label']) !!}
                            {!! Form::text('title_mobile', null, ['class'=>'form-control', 'id'=>'title_mobile']) !!}
                        </div>
                        <div class="mb-3 col-12 col-sm-6">
                            {!! Form::label('subtitle_mobile', 'Subtítulo', ['class'=>'form-label']) !!}
                            {!! Form::text('subtitle_mobile', null, ['class'=>'form-control', 'id'=>'subtitle_mobile']) !!}
                        </div>
                    </div>
                    <div class="mb-3">
                        {!! Form::label('description_mobile', 'Descrição', ['class'=>'form-label']) !!}
                        {!! Form::textarea('description_mobile', null, [
                            'class'=>'form-control',
                            'id'=>'description_mobile',
                            'rows' => 3,
                            'data-parsley-trigger'=>'keyup',
                            'data-parsley-minlength'=>'10',
                            'data-parsley-maxlength'=>'300',
                            'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                            'data-parsley-validation-threshold'=>'10',
                        ]) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('title_button_mobile', 'Título Botão', ['class'=>'form-label']) !!}
                        {!! Form::text('title_button_mobile', null, ['class'=>'form-control', 'id'=>'title_button_mobile']) !!}
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
                            <div class="col-12 col-sm-8">
                                {!! Form::label(null, 'Link Botão', ['class'=>'form-label']) !!}
                                {!! Form::url('link_button_mobile', null, ['class'=>'form-control','parsley-type'=>'url', 'id' => 'targetUrl']) !!}
                            </div>
                            <div class="col-12 col-sm-4">
                                {!! Form::label('target_link_button_mobile', 'Redirecionar', ['class'=>'form-label']) !!}
                                {!! Form::select('target_link_button_mobile', ['_self' => 'Na mesma aba', '_target' => 'Em nova aba'], null, ['class'=>'form-select', 'id'=>'target_link_button_mobile']) !!}
                            </div>
                        </div>
                    </div> {{-- END ."wrapper-links --}}

                    <div class="mb-3 form-check">
                        {!! Form::checkbox('active_mobile', '1', null, ['class'=>'form-check-input', 'id'=>'active_mobile']) !!}
                        {!! Form::label('active_mobile', 'Ativar Banner', ['class'=>'form-check-label']) !!}
                    </div>
                </div>
                {{-- end card-body --}}
            </div>
            {{-- end col-12 --}}
            <div class="col-12 col-lg-6">
                <div class="card card-body">
                    <div class="mb-3">
                        <div class="container-image-crop">
                            {!! Form::label('inputImage', 'Imagem do Banner', ['class'=>'form-label']) !!}
                            <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image_mobile->width}}x{{$cropSetting->path_image_mobile->height}}px!</small>
                            <label class="area-input-image-crop" for="inputImage">
                                {!! Form::file('path_image_mobile', [
                                    'id'=>'inputImage',
                                    'class'=>'inputImage',
                                    'data-status'=>$cropSetting->path_image_mobile->activeCrop, // px
                                    'data-min-width'=>$cropSetting->path_image_mobile->width, // px
                                    'data-min-height'=>$cropSetting->path_image_mobile->height, // px
                                    'data-box-height'=>'250', // Input height in the form
                                    'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                    'data-default-file'=> isset($slide)?($slide->path_image_mobile<>''?url('storage/'.$slide->path_image_mobile):''):'',
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
