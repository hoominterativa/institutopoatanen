@if ($sectionHighlighted)
    {!! Form::model($sectionHighlighted, ['route' => ['admin.copa04.sectionHighlighted.update', $sectionHighlighted->id], 'class' => 'parsley-validate', 'files' => true,]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => 'admin.copa04.sectionHighlighted.store', 'class' => 'parsley-validate', 'files' => true]) !!}
    {!! Form::hidden('contentpage_id', $contentPage->id) !!}
@endif
<div class="row col-12">
    <div class="col-12 col-lg-12">
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-body" id="tooltip-container">
                    <div class="mb-3 col-12">
                        {!! Form::label('validationCustom01', 'Título', ['class'=>'form-label']) !!}
                        {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'validationCustom01', 'placeholder'=>'Título', 'required'=>'required']) !!}
                    </div>
                    <div class="mb-3 col-12">
                        {!! Form::label('validationCustom02', 'Subtitulo', ['class'=>'form-label']) !!}
                        {!! Form::text('subtitle', null, ['class'=>'form-control', 'id'=>'validationCustom02', 'placeholder'=>'Subtitulo', 'required'=>'required']) !!}
                    </div>
                    <div class="mb-3 col-12">
                        {!! Form::label('colorpicker-default', 'Cor primária', ['class'=>'form-label']) !!}
                        {!! Form::text('color_one', null, [
                                'class'=>'form-control colorpicker-default',
                                'id'=>'colorpicker-default',
                                'required'=>'required',
                            ])!!}
                    </div>
                    <div class="basic-editor__content mb-3 col-12">
                        {!! Form::label('basic-editor', 'Texto', ['class'=>'form-label']) !!}
                        {!! Form::textarea('text', null, [
                            'class'=>'form-control basic-editor',
                            'id'=>'basic-editor',
                        ]) !!}
                    </div>
        
                    <div class="mb-3 form-check me-3">
                        {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                        {!! Form::label('active', 'Ativo?', ['class' => 'form-check-label']) !!}
                    </div>
                </div>
                <div class="card card-body" id="tooltip-container">
                    <div class="row">
                        <h4 class="col-12 mb-3">Botão
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                            data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="Botão que aparece na página"></i>
                        </h4>
                        <div class="wrapper-links my-2 border px-2 py-3">
                            <ul class="nav nav-pills navtab-bg nav-justified">
                                <li class="nav-item">
                                    <a href="#linkPages2" data-bs-toggle="tab" aria-expanded="false" class="nav-link py-1">
                                        <div class="d-flex align-items-center justify-content-center">
                                            Link para página do site
                                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-original-title="Pode ser usado para cadastrar um link de redirecionamento para uma página do site ou conteúdo específico."></i>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#linkExternal2" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
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
                                <div class="tab-pane" id="linkPages2">
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
                                <div class="tab-pane show active" id="linkExternal2"></div>
                            </div> {{-- END .tab-content --}}
                            <div class="row">
                                <div class="col-12">
                                    {!! Form::label('btn_title', 'Título do botão', ['class'=>'form-label']) !!}
                                    {!! Form::text('btn_title', null, ['class'=>'form-control mb-3', 'id'=>'btn_title', 'placeholder'=>'Título do botão']) !!}
                                </div>
                                <div class="col-12 col-sm-8">
                                    {!! Form::label(null, 'Link', ['class'=>'form-label']) !!}
                                    {!! Form::url('link', null, ['class'=>'form-control','parsley-type'=>'url', 'id' => 'targetUrl1']) !!}
                                </div>
                                <div class="col-12 col-sm-4">
                                    {!! Form::label('target_link', 'Redirecionar para', ['class'=>'form-label']) !!}
                                    {!! Form::select('target_link', ['_self' => 'Na mesma aba', '_bank' => 'Em nova aba'], null, ['class'=>'form-select', 'id'=>'target_link_button']) !!}
                                </div>
                            </div>
                        </div> {{-- END .wrapper-links --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card card-body">
                    <div class="mb-3 col-lg-12">
                        <div class="container-image-crop">
                            {!! Form::label('inputImage', 'Imagem', ['class'=>'form-label']) !!}
                            <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->Highlighted->path_image->width}}x{{$cropSetting->Highlighted->path_image->height}}px!</small>
                            <label class="area-input-image-crop" for="inputImage">
                                {!! Form::file('path_image', [
                                    'id'=>'inputImage',
                                    'class'=>'inputImage',
                                    'data-status'=>$cropSetting->Highlighted->path_image->activeCrop, // px
                                    'data-min-width'=>$cropSetting->Highlighted->path_image->width, // px
                                    'data-min-height'=>$cropSetting->Highlighted->path_image->height, // px
                                    'data-box-height'=>'225', // Input height in the form
                                    'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff',
                                    'data-default-file'=> isset($sectionHighlighted)?($sectionHighlighted->path_image<>''?url('storage/'.$sectionHighlighted->path_image):''):'',
                                ]) !!}
                            </label>
                        </div><!-- END container image crop -->
                    </div>
                </div>
            </div>
        </div>
        {{-- end card-body --}}
        <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
            {!! Form::button('Salvar', ['class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0','type' => 'submit',]) !!}
        </div>
    </div>
</div>
{{-- end row --}}
{!! Form::close() !!}

