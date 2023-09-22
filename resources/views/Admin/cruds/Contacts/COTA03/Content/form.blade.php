<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center mb-1">
                            {!! Form::label('title_content', 'Título', ['class' => 'form-label mb-0']) !!}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Título que é exibido no conteúdo da página"></i>
                        </div>
                        {!! Form::text('title_content', null, ['class' => 'form-control', 'id' => 'title_content',]) !!}
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center mb-1">
                            {!! Form::label('subtitle_content', 'Subtítulo', ['class' => 'form-label mb-0']) !!}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Subtítulo que é exibido no conteúdo da página"></i>
                        </div>
                        {!! Form::text('subtitle_content', null, ['class' => 'form-control', 'id' => 'subtitle_content']) !!}
                    </div>
                </div>
            </div>
            <div class="wrapper-links my-2 border px-2 py-3">
                <ul class="nav nav-pills navtab-bg nav-justified">
                    <li class="nav-item">
                        <a href="#linkPages" data-bs-toggle="tab" aria-expanded="false" class="nav-link py-1">
                            <div class="d-flex align-items-center justify-content-center">
                                Link para página do site
                                <i href="javascript:void(0)"
                                    class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                                    data-bs-container="#tooltip-container" data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    data-bs-original-title="Pode ser usado para cadastrar um link de redirecionamento para uma página do site ou conteúdo específico."></i>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#linkExternal" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                            <div class="d-flex align-items-center justify-content-center">
                                Link para página externa
                                <i href="javascript:void(0)"
                                    class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                                    data-bs-container="#tooltip-container" data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    data-bs-original-title="pode ser usado para cadastrar links de redirecionamento para outros sites"></i>
                            </div>
                        </a>
                    </li>
                </ul> {{-- END .nav-tabs --}}
                <div class="tab-content">
                    <div class="tab-pane" id="linkPages">
                        <div class="row">
                            <div class="dropdown mb-3 col-12">
                                {!! Form::label(null, 'Selecione uma página do site', ['class' => 'form-label']) !!}
                                <button class="form-control dropdown-toggle text-start" type="button"
                                    id="dropdownPages" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    Páginas <i class="mdi mdi-chevron-down float-end"></i>
                                </button>
                                <ul class="dropdown-menu multi-level col-12" aria-labelledby="dropdownPages">
                                    @foreach (listPage() as $page)
                                        <li class="dropdown {{ $page->dropdown ? 'dropdown-submenu' : '' }}">
                                            <a href="{{ $page->route }}" class="dropdown-item" data-bs-toggle="setUrl"
                                                data-target-url="#targetUrl"
                                                data-bs-toggle="dropdown">{{ $page->title }}</a>
                                            @if ($page->dropdown)
                                                <ul class="dropdown-menu">
                                                    @foreach ($page->dropdown as $itens)
                                                        <li><a href="{{ $itens->route }}" class="dropdown-item"
                                                                data-bs-toggle="setUrl"
                                                                data-target-url="#targetUrl">{{ $itens->name }}</a>
                                                        </li>
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
                        {!! Form::label('title_button_content', 'Título do botão', ['class' => 'form-label']) !!}
                        {!! Form::text('title_button_content', null, ['class' => 'form-control', 'id' => 'title_button_content']) !!}
                    </div>
                    <div class="col-12 col-sm-8">
                        {!! Form::label(null, 'Link do botão', ['class' => 'form-label']) !!}
                        {!! Form::url('link_button_content', (isset($content) && isset($content->link_button_content) ? getUri($content->link_button_content) : null), ['class' => 'form-control', 'parsley-type' => 'url', 'id' => 'targetUrl']) !!}
                     </div>
                    <div class="col-12 col-sm-4">
                        {!! Form::label('target_link_button_content', 'Redirecionar para', ['class' => 'form-label']) !!}
                        {!! Form::select('target_link_button_content', ['_self' => 'Na mesma aba', '_blank' => 'Em nova aba'], null, [
                            'class' => 'form-select',
                            'id' => 'target_link_button_content',
                        ]) !!}
                    </div>
                </div>
            </div> {{-- END .wrapper-links --}}
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem Flutuante', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->Content->path_image_content->width }}x{{ $cropSetting->Content->path_image_content->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_content', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->Content->path_image_content->activeCrop, // px
                            'data-min-width' => $cropSetting->Content->path_image_content->width, // px
                            'data-min-height' => $cropSetting->Content->path_image_content->height, // px
                            'data-box-height' => '300', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($contact)
                                ? ($contact->path_image_content != ''
                                    ? url('storage/' . $contact->path_image_content)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
        <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
            {!! Form::button('Salvar', [
                'class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0',
                'type' => 'submit',
            ]) !!}
        </div>
        {{-- end card-body --}}
    </div>
</div>

