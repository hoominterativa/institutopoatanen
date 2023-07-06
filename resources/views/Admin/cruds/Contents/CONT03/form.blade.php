
<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('subtitle', 'Título', ['class'=>'form-label']) !!}
                {!! Form::text('subtitle', null, ['class'=>'form-control', 'id'=>'subtitle']) !!}
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
                        {!! Form::label(null, 'Link', ['class'=>'form-label']) !!}
                        {!! Form::url('link', null, ['class'=>'form-control','parsley-type'=>'url', 'id' => 'targetUrl']) !!}
                    </div>
                    <div class="col-12 col-sm-4">
                        {!! Form::label('link_target', 'Redirecionar para', ['class'=>'form-label']) !!}
                        {!! Form::select('link_target', ['_self' => 'Na mesma aba', '_target' => 'Em nova aba'], null, ['class'=>'form-select', 'id'=>'link_target']) !!}
                    </div>
                </div>
            </div> {{-- END .wrapper-links --}}

            <div class="mb-3 form-check">
                {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
                {!! Form::label('active', 'Ativar exibição', ['class'=>'form-check-label']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('description', 'Descrição', ['class'=>'form-label']) !!}
                {!! Form::textarea('description', null, [
                    'class'=>'form-control',
                    'id'=>'description',
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
                    {!! Form::label('inputImage', 'Imagem do Centro', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image_center->width}}x{{$cropSetting->path_image_center->height}}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_center', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-status'=>$cropSetting->path_image_center->activeCrop, // px
                            'data-min-width'=>$cropSetting->path_image_center->width, // px
                            'data-min-height'=>$cropSetting->path_image_center->height, // px
                            'data-box-height'=>'170', // Input height in the form
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($content)?($content->path_image_center<>''?url('storage/'.$content->path_image_center):''):'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>

            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem da Esquerda', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image_right->width}}x{{$cropSetting->path_image_right->height}}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_right', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-status'=>$cropSetting->path_image_right->activeCrop, // px
                            'data-min-width'=>$cropSetting->path_image_right->width, // px
                            'data-min-height'=>$cropSetting->path_image_right->height, // px
                            'data-box-height'=>'170', // Input height in the form
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($content)?($content->path_image_right<>''?url('storage/'.$content->path_image_right):''):'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>

            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem Background', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image_background->width}}x{{$cropSetting->path_image_background->height}}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_background', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-status'=>$cropSetting->path_image_background->activeCrop, // px
                            'data-min-width'=>$cropSetting->path_image_background->width, // px
                            'data-min-height'=>$cropSetting->path_image_background->height, // px
                            'data-box-height'=>'170', // Input height in the form
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($content)?($content->path_image_background<>''?url('storage/'.$content->path_image_background):''):'',
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
