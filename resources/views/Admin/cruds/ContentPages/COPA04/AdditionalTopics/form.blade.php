<div class="row col-12">
    <div class="col-6">
        <div class="card card-body" id="tooltip-container">
            <input type="hidden" name="contentpage_id" value="{{$contentPage->id}}">
            <div class="mb-3 col-12">
                {!! Form::label('validationCustom01', 'Título', ['class'=>'form-label']) !!}
                {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'validationCustom01', 'placeholder'=>'Título', 'required'=>'required']) !!}
            </div>
            <div class="mb-3 col-12">
                {!! Form::label('validationCustom03', 'Vídeo', ['class'=>'form-label']) !!}
                {!! Form::text('link_video', null, ['class'=>'form-control', 'id'=>'validationCustom03', 'placeholder'=>'Link']) !!}
            </div>
        </div>

        <div class="card card-body" id="tooltip-container">
            <div class="row">
                <h4 class="col-12 mb-3">Botão
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                    data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-original-title="Botão"></i>
                </h4>
                <div class="wrapper-links my-2 border px-2 py-3">
                    <ul class="nav nav-pills navtab-bg nav-justified">
                        <li class="nav-item">
                            <a href="#linkPages5" data-bs-toggle="tab" aria-expanded="false" class="nav-link py-1">
                                <div class="d-flex align-items-center justify-content-center">
                                    Link para página do site
                                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="Pode ser usado para cadastrar um link de redirecionamento para uma página do site ou conteúdo específico."></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#linkExternal5" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
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
                        <div class="tab-pane" id="linkPages5">
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
                        <div class="tab-pane show active" id="linkExternal5"></div>
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
                            {!! Form::label('target_link_one', 'Redirecionar para', ['class'=>'form-label']) !!}
                            {!! Form::select('target_link_one', ['_self' => 'Na mesma aba', '_blank' => 'Em nova aba'], null, ['class'=>'form-select', 'id'=>'target_link_one']) !!}
                        </div>
                    </div>
                </div> {{-- END .wrapper-links --}}
            </div>
        </div>
        {{-- end card-body --}}
        <div class="mb-3 form-check me-3">
            {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
            {!! Form::label('active', 'Ativo?', ['class' => 'form-check-label']) !!}
        </div>
    </div>
    <div class="col-6">
        <div class="card card-body">            
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->AdditionalTopics->path_image->width}}x{{$cropSetting->AdditionalTopics->path_image->height}}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-status'=>$cropSetting->AdditionalTopics->path_image->activeCrop, // px
                            'data-min-width'=>$cropSetting->AdditionalTopics->path_image->width, // px
                            'data-min-height'=>$cropSetting->AdditionalTopics->path_image->height, // px
                            'data-box-height'=>'225', // Input height in the form
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff',
                            'data-default-file'=> isset($AdditionalTopics)?($AdditionalTopics->path_image<>''?url('storage/'.$AdditionalTopics->path_image):''):'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
    </div>
</div>
{{-- end row --}}

