
    {!! Form::model($bran02, ['route' => ['admin.bran02.category.update', $bran02->id], 'class' => 'parsley-validate', 'files' => true,]) !!}
    @method('PUT')
<div class="row">
    <div class="col-6">
        <div class="card card-body ">
            {{-- Editor da Seção Principal --}}
            <div class="mb-3 col-12">
                {!! Form::label('validationCustom02', 'Titulo da Home', ['class' => 'form-label']) !!}
                {!! Form::text('title_home',  null, [
                    'class' => 'form-control',
                    'id' => 'validationCustom02',
                    'placeholder' => 'Titulo da Home',
                    'required' => 'required',
                ]) !!}
            </div>
            <div class="mb-3 col-12">
                {!! Form::label('validationCustom02', 'Subtitulo da Home', ['class' => 'form-label']) !!}
                {!! Form::text('subtitle_home', null, [
                    'class' => 'form-control',
                    'id' => 'validationCustom02',
                    'placeholder' => 'Subtitulo da Home',
                    'required' => 'required',
                ]) !!}
            </div>
            {{-- 
            Fim do Editor da seção principal

            Editor da Seção de Banner
            --}}
            <div class="mb-3 col-12">
                {!! Form::label('validationCustom02', 'Titulo do Banner', ['class' => 'form-label']) !!}
                {!! Form::text('title_banner', null, [
                    'class' => 'form-control',
                    'id' => 'validationCustom02',
                    'placeholder' => 'Titulo do Banner',
                    'required' => 'required',
                ]) !!}
            </div>
            <div class="mb-3 col-12">
                {!! Form::label('validationCustom02', 'Subtitulo do Banner', ['class' => 'form-label']) !!}
                {!! Form::text('subtitle_banner', null, [
                    'class' => 'form-control',
                    'id' => 'validationCustom02',
                    'placeholder' => 'Subtitulo do Banner',
                    'required' => 'required',
                ]) !!}
            </div>
            {{--
            Fim do Editor da seção de Banner

            Editor da Seção de Pagina
            --}}
            <div class="mb-3 col-12">
                {!! Form::label('validationCustom02', 'Titulo da Pagina', ['class' => 'form-label']) !!}
                {!! Form::text('title_page', null, [
                    'class' => 'form-control',
                    'id' => 'validationCustom02',
                    'placeholder' => 'Titulo da Pagina',
                    'required' => 'required',
                ]) !!}
            </div>
            <div class="mb-3 col-12">
                {!! Form::label('validationCustom02', 'Subtitulo da Pagina', ['class' => 'form-label']) !!}
                {!! Form::text('subtitle_page', null, [
                    'class' => 'form-control',
                    'id' => 'validationCustom02',
                    'placeholder' => 'Subtitulo da Pagina',
                    'required' => 'required',
                ]) !!}
            </div>
                            {{-- Editor de Imagem --}}
                            <div class="mb-3">
                                <div class="container-image-crop">
                                    {!! Form::label('inputImage', 'Imagem', ['class'=>'form-label']) !!}
                                    <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image_banner->width}}x{{$cropSetting->path_image_banner->height}}px!</small>
                                    <label class="area-input-image-crop" for="inputImage">
                                        {!! Form::file('path_image', [
                                            'id'=>'inputImage',
                                            'class'=>'inputImage',
                                            'data-status'=>$cropSetting->path_image_banner->activeCrop, // px
                                            'data-min-width'=>$cropSetting->path_image_banner->width, // px
                                            'data-min-height'=>$cropSetting->path_image_banner->height, // px
                                            'data-box-height'=>'225', // Input height in the form
                                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff',
                                            'data-default-file'=> isset($bran02)?($bran02->path_image<>''?url('storage/'.$bran02->path_image):''):'',
                                        ]) !!}
                                    </label>
                                </div><!-- END container image crop -->
                            </div>
            {{-- 
            Fim do Editor da seção de Pagina

            Editor Ativado ou Desativado
            --}}
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                {!! Form::label('active', 'Ativo?', ['class' => 'form-check-label']) !!}
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card-body card">
            {{-- Editor de Link e Button --}}
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
                        {!! Form::label('button_text', 'Escrita Botão', ['class'=>'form-label']) !!}
                        {!! Form::text('button_text', null, ['class'=>'form-control', 'id'=>'title', 'required'=>'required']) !!}    
                    </div>
                    <div class="col-12 col-sm-8">
                        {!! Form::label(null, 'button_link', ['class'=>'form-label']) !!}
                        {!! Form::url('button_link', null, ['class'=>'form-control','parsley-type'=>'url', 'id' => 'targetUrl']) !!}
                    </div>
                    <div class="col-12 col-sm-4">
                        {!! Form::label('target_link', 'Redirecionar para', ['class'=>'form-label']) !!}
                        {!! Form::select('target_link', ['_self' => 'Na mesma aba', '_blank' => 'Em nova aba'], null, ['class'=>'form-select', 'id'=>'target_link_button']) !!}
                    </div>
                </div>
            </div> 
            {{-- 
            Fim do Editor de Link e Button

            END .wrapper-links 
            --}}
        </div>
        <div class="card card-body">
            <div class="basic-editor__content my-3 col-12">
                {!! Form::label('basic-editor', 'Texto', ['class' => 'form-label']) !!}
                {!! Form::textarea('description', null, [
                    'class' => 'form-control basic-editor',
                    'id' => 'basic-editor',
                ]) !!}
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-start col-12 p-2 m-auto mb-2">
        {!! Form::button('Atualizar', [
            'class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3',
            'type' => 'submit',
        ]) !!}
    </div>
</div>
{{-- end row --}}

{!! Form::close() !!}