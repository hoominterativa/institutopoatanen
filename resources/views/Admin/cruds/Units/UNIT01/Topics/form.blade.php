@if (isset($topic))
    {!! Form::model($topic, ['route' => ['admin.unit01.topic.update', $topic->id], 'class'=>'parsley-validate', 'files' => true]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => ['admin.unit01.topic.store'], 'class'=>'parsley-validate', 'files' => true]) !!}
    <input type="hidden" name="unit_id" value="{{ $unit->id }}">
@endif
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card card-body border" id="tooltip-container">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-sm-6">
                            {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                            {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title']) !!}
                        </div>
                        <div class="col-sm-6">
                            {!! Form::label('subtitle', 'Subtítulo', ['class'=>'form-label']) !!}
                            {!! Form::text('subtitle', null, ['class'=>'form-control', 'id'=>'subtitle']) !!}
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    {!! Form::label('description', 'Descrição', ['class'=>'form-label']) !!}
                    {!! Form::textarea('description', null, [
                        'class'=>'form-control',
                        'id'=>'description',
                        'data-parsley-trigger'=>'keyup',
                        'data-parsley-maxlength'=>'500',
                        'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                        'data-parsley-validation-threshold'=>'10',
                    ]) !!}
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
                            {!! Form::url('link', (isset($topic) ? getUri($topic->link) : null), ['class'=>'form-control','parsley-type'=>'url', 'id' => 'targetUrl']) !!}
                        </div>
                        {{-- <div class="col-12 col-sm-4">
                            {!! Form::label('target_link', 'Redirecionar para', ['class'=>'form-label']) !!}
                            {!! Form::select('target_link', ['_blank' => 'Em nova aba', '_lightbox' => 'Abrir no lightbox'], null, ['class'=>'form-select', 'id'=>'target_link']) !!}
                        </div> --}}
                    </div>
                </div> {{-- END .wrapper-links --}}
            </div>
            <div class="mb-3 form-check">
                {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
                {!! Form::label('active', 'Ativar exibição?', ['class'=>'form-check-label']) !!}
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card card-body border" id="tooltip-container">
                <div class="mb-3">
                    <div class="container-image-crop">
                        {!! Form::label('inputImage', 'Ícone', ['class' => 'form-label']) !!}
                        <small class="ms-2">Dimensões proporcionais mínimas
                            {{ $cropSetting->Topic->path_image_icon->width }}x{{ $cropSetting->Topic->path_image_icon->height }}px!</small>
                        <label class="area-input-image-crop" for="inputImage">
                            {!! Form::file('path_image_icon', [
                                'id' => 'inputImage',
                                'class' => 'inputImage',
                                'data-status' => $cropSetting->Topic->path_image_icon->activeCrop, // px
                                'data-min-width' => $cropSetting->Topic->path_image_icon->width, // px
                                'data-min-height' => $cropSetting->Topic->path_image_icon->height, // px
                                'data-box-height' => '225', // Input height in the form
                                'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                'data-default-file' => isset($topic)
                                    ? ($topic->path_image_icon != ''
                                        ? url('storage/' . $topic->path_image_icon)
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
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
        {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
    </div>
{!! Form::close() !!}
