@if (isset($content))
    <div class="row mb-3">
        <div class="col-6">
            <a href="javascript:void(0)"  data-bs-target="#modal-galleryContent-create-{{$content->id}}" data-bs-toggle="modal" class="btn btn-warning">Galeria <i class="mdi mdi-plus"></i></a>
        </div>
    </div>

    {{-- BEGIN MODAL GALERIA CREATE --}}
    <div id="modal-galleryContent-create-{{$content->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="max-width: 1100px;">
            <div class="modal-content">
                <div class="modal-header p-3 pt-2 pb-2">
                    <h4 class="page-title">Cadastrar Imagens</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-3 pt-0 pb-3">
                    @include('Admin.cruds.Units.UNIT03.Content.Gallery.form',[
                        'galleryContent' => null,
                        'content' => $content
                    ])
                    @include('Admin.cruds.Units.UNIT03.Content.Gallery.index',[
                        'content' => $content
                    ])
                </div>
            </div>
        </div>
    </div>
    {{-- END MODAL GALERIA CREATE --}}

    {!! Form::model($content, ['route' => ['admin.unit03.content.update', $content->id], 'class'=>'parsley-validate', 'files' => true]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => ['admin.unit03.content.store'], 'class'=>'parsley-validate', 'files' => true]) !!}
@endif
    <input type="hidden" name="unit_id" value="{{ $unit->id }}">
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card card-body border" id="tooltip-container">
                <div class="row">
                    <div class="mb-3">
                        {!! Form::label('title', 'Título', ['class' => 'form-label']) !!}
                        {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('subtitle', 'Subtítulo', ['class' => 'form-label']) !!}
                        {!! Form::text('subtitle', null, ['class' => 'form-control', 'id' => 'subtitle']) !!}
                    </div>
                    <div class="col-12">
                        <div class="normal-editor__content mb-3">
                            {!! Form::label('text', 'Texto', ['class'=>'form-label']) !!}
                            {!! Form::textarea('text', null, [
                                'class'=>'form-control normal-editor',
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
                    <div class="d-flex">
                        <div class="mb-3 form-check me-3">
                            {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                            {!! Form::label('active', 'Ativar exibição', ['class' => 'form-check-label']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card card-body border" id="tooltip-container">
                <div class="mb-3">
                    <div class="container-image-crop">
                        {!! Form::label('inputImage', 'Imagem de capa(thumbnail)', ['class' => 'form-label']) !!}
                        <small class="ms-2">Dimensões proporcionais mínimas
                            {{ $cropSetting->Content->path_image->width }}x{{ $cropSetting->Content->path_image->height }}px!</small>
                        <label class="area-input-image-crop" for="inputImage">
                            {!! Form::file('path_image', [
                                'id' => 'inputImage',
                                'class' => 'inputImage',
                                'data-status' => $cropSetting->Content->path_image->activeCrop, // px
                                'data-min-width' => $cropSetting->Content->path_image->width, // px
                                'data-min-height' => $cropSetting->Content->path_image->height, // px
                                'data-box-height' => '170', // Input height in the form
                                'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                'data-default-file' => isset($content)
                                    ? ($content->path_image != ''
                                        ? url('storage/' . $content->path_image)
                                        : '')
                                    : '',
                            ]) !!}
                        </label>
                    </div><!-- END container image crop -->
                </div>
                <div class="mb-3">
                    <div class="container-image-crop">
                        {!! Form::label('inputImage', 'Background desktop', ['class' => 'form-label']) !!}
                        <small class="ms-2">Dimensões proporcionais mínimas
                            {{ $cropSetting->Content->path_image_desktop->width }}x{{ $cropSetting->Content->path_image_desktop->height }}px!</small>
                        <label class="area-input-image-crop" for="inputImage">
                            {!! Form::file('path_image_desktop', [
                                'id' => 'inputImage',
                                'class' => 'inputImage',
                                'data-status' => $cropSetting->Content->path_image_desktop->activeCrop, // px
                                'data-min-width' => $cropSetting->Content->path_image_desktop->width, // px
                                'data-min-height' => $cropSetting->Content->path_image_desktop->height, // px
                                'data-box-height' => '170', // Input height in the form
                                'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                'data-default-file' => isset($content)
                                    ? ($content->path_image_desktop != ''
                                        ? url('storage/' . $content->path_image_desktop)
                                        : '')
                                    : '',
                            ]) !!}
                        </label>
                    </div><!-- END container image crop -->
                </div>
                <div class="mb-3">
                    <div class="container-image-crop">
                        {!! Form::label('inputImage', 'Background Mobile', ['class' => 'form-label']) !!}
                        <small class="ms-2">Dimensões proporcionais mínimas
                            {{ $cropSetting->Content->path_image_mobile->width }}x{{ $cropSetting->Content->path_image_mobile->height }}px!</small>
                        <label class="area-input-image-crop" for="inputImage">
                            {!! Form::file('path_image_mobile', [
                                'id' => 'inputImage',
                                'class' => 'inputImage',
                                'data-status' => $cropSetting->Content->path_image_mobile->activeCrop, // px
                                'data-min-width' => $cropSetting->Content->path_image_mobile->width, // px
                                'data-min-height' => $cropSetting->Content->path_image_mobile->height, // px
                                'data-box-height' => '170', // Input height in the form
                                'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                'data-default-file' => isset($content)
                                    ? ($content->path_image_mobile != ''
                                        ? url('storage/' . $content->path_image_mobile)
                                        : '')
                                    : '',
                            ]) !!}
                        </label>
                    </div><!-- END container image crop -->
                </div>
                 {{-- Color Picker --}}
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
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
        {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
    </div>
{!! Form::close() !!}
