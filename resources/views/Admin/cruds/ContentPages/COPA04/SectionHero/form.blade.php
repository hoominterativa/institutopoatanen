@if ($sectionHero)
    {!! Form::model($sectionHero, ['route' => ['admin.copa04.sectionHero.update', $sectionHero->id], 'class' => 'parsley-validate', 'files' => true,]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => 'admin.copa04.sectionHero.store', 'class' => 'parsley-validate', 'files' => true]) !!}
    {!! Form::hidden('contentpage_id', $contentPage->id) !!}
@endif
    <div class="row col-12">
        <div class="col-12 col-lg-6">
            <div class="card card-body" id="tooltip-container">
                <div class="mb-3 col-12">
                    {!! Form::label('validationCustom01', 'Título', ['class'=>'form-label']) !!}
                    {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'validationCustom01', 'placeholder'=>'Título', 'required'=>'required']) !!}
                </div>
                <div class="basic-editor__content mb-3 col-12">
                    {!! Form::label('basic-editor', 'Descrição', ['class'=>'form-label']) !!}
                    {!! Form::textarea('description', null, [
                        'class'=>'form-control basic-editor',
                        'id'=>'basic-editor',
                    ]) !!}
                </div>
                <div class="row">
                    <div class="mb-3 col-4">
                        {!! Form::label('colorpicker-default', 'Cor primária', ['class'=>'form-label']) !!}
                        {!! Form::text('color_one', null, [
                                'class'=>'form-control colorpicker-default',
                                'id'=>'colorpicker-default',
                                'required'=>'required',
                            ])!!}
                    </div>
                    <div class="mb-3 col-4">
                        {!! Form::label('colorpicker-default', 'Cor secundária', ['class'=>'form-label']) !!}
                        {!! Form::text('color_two', null, [
                                'class'=>'form-control colorpicker-default',
                                'id'=>'colorpicker-default',
                                'required'=>'required',
                            ])!!}
                    </div>
                    <div class="mb-3 col-4">
                        {!! Form::label('colorpicker-default', 'Cor terciária', ['class'=>'form-label']) !!}
                        {!! Form::text('color_three', null, [
                                'class'=>'form-control colorpicker-default',
                                'id'=>'colorpicker-default',
                                'required'=>'required',
                            ])!!}
                    </div>
                </div>
                <div class="mb-3 form-check me-3">
                    {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                    {!! Form::label('active', 'Ativo?', ['class' => 'form-check-label']) !!}
                </div>
            </div>

            <div class="card card-body" id="tooltip-container">
                <div class="row">
                    <h4 class="col-12 mb-3">Botão Banner
                        <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Botão que aparece no banner da página"></i>
                    </h4>

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
                            <div class="col-12">
                                {!! Form::label('title_btn', 'Título do botão', ['class'=>'form-label']) !!}
                                {!! Form::text('title_btn', null, ['class'=>'form-control mb-3', 'id'=>'title_btn', 'placeholder'=>'Título do botão']) !!}
                            </div>
                            <div class="col-12 col-sm-8">
                                {!! Form::label(null, 'Link', ['class'=>'form-label']) !!}
                                {!! Form::url('link', null, ['class'=>'form-control','parsley-type'=>'url', 'id' => 'targetUrl']) !!}
                            </div>
                            <div class="col-12 col-sm-4">
                                {!! Form::label('target_link', 'Redirecionar para', ['class'=>'form-label']) !!}
                                {!! Form::select('target_link', ['_self' => 'Na mesma aba', '_bank' => 'Em nova aba'], null, ['class'=>'form-select', 'id'=>'target_link_button']) !!}
                            </div>
                        </div>
                    </div> {{-- END .wrapper-links --}}
                </div>
            </div>

            <div class="card card-body" id="tooltip-container">
                <div class="row">
                    <h4 class="col-12 mb-3">Botão Topo
                        <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Botão que aparece antes do banner da página"></i>
                    </h4>
                    <div class="wrapper-links my-2 border px-2 py-3">
                        <ul class="nav nav-pills navtab-bg nav-justified">
                            <li class="nav-item">
                                <a href="#linkPages1" data-bs-toggle="tab" aria-expanded="false" class="nav-link py-1">
                                    <div class="d-flex align-items-center justify-content-center">
                                        Link para página do site
                                        <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                                            data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-original-title="Pode ser usado para cadastrar um link de redirecionamento para uma página do site ou conteúdo específico."></i>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#linkExternal1" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
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
                            <div class="tab-pane" id="linkPages1">
                                <div class="row">
                                    <div class="dropdown mb-3 col-12">
                                        {!! Form::label(null, 'Selecione uma página do site', ['class'=>'form-label']) !!}
                                        <button class="form-control dropdown-toggle text-start" type="button" id="dropdownPages" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Páginas <i class="mdi mdi-chevron-down float-end"></i>
                                        </button>
                                        <ul class="dropdown-menu multi-level col-12" aria-labelledby="dropdownPages">
                                            @foreach (listPage() as $page)
                                                <li class="dropdown {{$page->dropdown?'dropdown-submenu':''}}">
                                                    <a href="{{$page->route}}" class="dropdown-item" data-bs-toggle="setUrl" data-target-url="#targetUrl1" data-bs-toggle="dropdown">{{$page->title}}</a>
                                                    @if ($page->dropdown)
                                                        <ul class="dropdown-menu">
                                                            @foreach ($page->dropdown as $itens)
                                                                <li><a href="{{$itens->route}}" class="dropdown-item" data-bs-toggle="setUrl" data-target-url="#targetUrl1">{{$itens->name}}</a></li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane show active" id="linkExternal1"></div>
                        </div> {{-- END .tab-content --}}
                        <div class="row">
                            <div class="col-12">
                                {!! Form::label('button_text', 'Título do botão', ['class'=>'form-label']) !!}
                                {!! Form::text('button_text', null, ['class'=>'form-control mb-3', 'id'=>'button_text', 'placeholder'=>'Título do botão']) !!}
                            </div>
                            <div class="col-12 col-sm-8">
                                {!! Form::label(null, 'Link', ['class'=>'form-label']) !!}
                                {!! Form::url('button_link', null, ['class'=>'form-control','parsley-type'=>'url', 'id' => 'targetUrl1']) !!}
                            </div>
                            <div class="col-12 col-sm-4">
                                {!! Form::label('target_link', 'Redirecionar para', ['class'=>'form-label']) !!}
                                {!! Form::select('target_link', ['_self' => 'Na mesma aba', '_bank' => 'Em nova aba'], null, ['class'=>'form-select', 'id'=>'target_link_button']) !!}
                            </div>
                        </div>
                    </div> {{-- END .wrapper-links --}}
                </div>
            </div>
            {{-- end card-body --}}
        </div>
        <div class="col-12 col-lg-6">
            <div class="container-image-crop mb-3">
                {!! Form::label('inputImage', 'Imagem', ['class'=>'form-label']) !!}
                <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image->width}}x{{$cropSetting->path_image->height}}px!</small>
                <label class="area-input-image-crop" for="inputImage">
                    {!! Form::file('path_image', [
                        'id'=>'inputImage',
                        'class'=>'inputImage',
                        'data-status'=>$cropSetting->path_image->activeCrop, // px
                        'data-min-width'=>$cropSetting->path_image->width, // px
                        'data-min-height'=>$cropSetting->path_image->height, // px
                        'data-box-height'=>'285', // Input height in the form
                        'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff',
                        'data-default-file'=> isset($sectionHero)?($sectionHero->path_image<>''?url('storage/'.$sectionHero->path_image):''):'',
                    ]) !!}
                </label>
            </div><!-- END container image crop -->
            <div class="container-image-crop mb-3">
                {!! Form::label('inputImage', 'Imagem Logo', ['class'=>'form-label']) !!}
                <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_logo->width}}x{{$cropSetting->path_logo->height}}px!</small>
                <label class="area-input-image-crop" for="inputImage">
                    {!! Form::file('path_logo', [
                        'id'=>'inputImage',
                        'class'=>'inputImage',
                        'data-status'=>$cropSetting->path_logo->activeCrop, // px
                        'data-min-width'=>$cropSetting->path_logo->width, // px
                        'data-min-height'=>$cropSetting->path_logo->height, // px
                        'data-box-height'=>'285', // Input height in the form
                        'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff',
                        'data-default-file'=> isset($sectionHero)?($sectionHero->path_logo<>''?url('storage/'.$sectionHero->path_logo):''):'',
                    ]) !!}
                </label>
            </div><!-- END container image crop -->
            <div class="container-image-crop mb-3">
                {!! Form::label('inputImage', 'Imagem icone', ['class'=>'form-label']) !!}
                <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_icon->width}}x{{$cropSetting->path_icon->height}}px!</small>
                <label class="area-input-image-crop" for="inputImage">
                    {!! Form::file('path_icon', [
                        'id'=>'inputImage',
                        'class'=>'inputImage',
                        'data-status'=>$cropSetting->path_icon->activeCrop, // px
                        'data-min-width'=>$cropSetting->path_icon->width, // px
                        'data-min-height'=>$cropSetting->path_icon->height, // px
                        'data-box-height'=>'285', // Input height in the form
                        'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff',
                        'data-default-file'=> isset($sectionHero)?($sectionHero->path_icon<>''?url('storage/'.$sectionHero->path_icon):''):'',
                    ]) !!}
                </label>
            </div><!-- END container image crop -->
        </div>
        <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
            {!! Form::button('Salvar', ['class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0','type' => 'submit',]) !!}
        </div>
    </div>
    {{-- end row --}}
{!! Form::close() !!}
