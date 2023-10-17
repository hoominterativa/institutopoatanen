<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        {!! Form::label(null, 'Data do evento', ['class'=>'form-label']) !!}
                        <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                            data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="Informe a data do evento">
                        </i>
                        {!! Form::text('event_date', null, [
                                'class'=>'form-control',
                                'required'=>'required',
                                'data-provide'=>'datepicker',
                                'data-date-autoclose'=>'true',
                                'data-date-format'=>'dd/mm/yyyy',
                                'placeholder'=> '19/07/1986',
                                'data-date-language'=>'pt-BR',
                                'data-date-start-date'=>'0d', // Isso permite datas a partir do dia atual (0d)
                            ])!!}
                    </div>
                    <div class="col-12 col-sm-6">
                        {!! Form::label('event_locale', 'Local do evento', ['class' => 'form-label']) !!}
                        <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                            data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="Recomendanos seguir este padrão: Salvador-BA">
                        </i>
                        {!! Form::text('event_locale', null, ['class' => 'form-control', 'id' => 'event_locale', 'required'=>'required', 'placeholder'=> 'Salvador-BA']) !!}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                {!! Form::label('informations', 'Informações', ['class'=>'form-label']) !!}
                <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                    data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-original-title="Informações referentes de cada evento em específico"></i>
                {!! Form::textarea('informations', null, [
                    'class'=>'form-control',
                    'id'=>'message',
                    'rows'=>'7',
                    'data-parsley-trigger'=>'keyup',
                    'data-parsley-minlength'=>'20',
                    'data-parsley-maxlength'=>'900',
                    'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir uma descrição de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold'=>'10',
                    'placeholder'=>'Exemplo: Local do evento',
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
                    <div class="mb-3">
                        {!! Form::label('title_button_one', 'Título da botão', ['class' => 'form-label']) !!}
                        {!! Form::text('title_button_one', null, ['class' => 'form-control', 'id' => 'title_button_one']) !!}

                    </div>
                    <div class="col-12 col-sm-8">
                        {!! Form::label(null, 'Link do botão', ['class' => 'form-label']) !!}
                        {!! Form::url('link_button_one', (isset($schedule) && isset($schedule->link_button_one) ? getUri($schedule->link_button_one) : null), ['class' => 'form-control', 'parsley-type' => 'url', 'id' => 'targetUrl']) !!}
                    </div>
                    <div class="col-12 col-sm-4">
                        {!! Form::label('target_link_button_one', 'Redirecionar', ['class'=>'form-label']) !!}
                        {!! Form::select('target_link_button_one', ['_self' => 'Na mesma aba', '_blank' => 'Em nova aba'], null, ['class'=>'form-select', 'id'=>'target_link_button_one']) !!}
                    </div>
                </div>
            </div> {{-- END ."wrapper-links --}}
            <div class="wrapper-links my-2 border px-2 py-3">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        {!! Form::label('title_button_two', 'Título da botão externo', ['class' => 'form-label']) !!}
                        {!! Form::text('title_button_two', null, ['class' => 'form-control', 'id' => 'title_button_two']) !!}

                    </div>
                    <div class="col-12 col-sm-6">
                        {!! Form::label(null, 'Link do botão externo', ['class' => 'form-label']) !!}
                        {!! Form::url('link_button_two', (isset($schedule) && isset($schedule->link_button_two) ? getUri($schedule->link_button_two) : null), ['class' => 'form-control', 'parsley-type' => 'url', 'id' => 'targetUrl']) !!}
                    </div>
                </div>
            </div>
            <div class="d-flex">
                <div class="mb-3 form-check me-3">
                    {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                    {!! Form::label('active', 'Ativar exibição do evento?', ['class' => 'form-check-label']) !!}
                </div>
                <div class="mb-3 form-check me-3">
                    {!! Form::checkbox('featured', '1', null, ['class' => 'form-check-input', 'id' => 'featured']) !!}
                    {!! Form::label('featured', 'Destacar evento?', ['class' => 'form-check-label']) !!}
                </div>
            </div>
        </div>
        {{-- end card-body --}}
    </div>
</div>
{{-- end row --}}
