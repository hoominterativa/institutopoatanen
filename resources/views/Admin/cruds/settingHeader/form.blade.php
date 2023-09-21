{!! Form::hidden('module', null) !!}
{!! Form::hidden('model', null) !!}
{!! Form::hidden('pageN', null) !!}
{!! Form::hidden('select_dropdown', null) !!}
{!! Form::hidden('set_condition', isset($header->condition)?$header->condition:null) !!}
<div class="row col-12">
    <div class="col-12 col-md-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="d-flex align-items-center mb-1">
                    {!! Form::label('title', 'Título da página', ['class'=>'form-label mb-0']) !!}
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="O título será exibido no menu do site."></i>
                </div>
                {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title', 'required'=>'required']) !!}
            </div>
            <div class="mb-3">
                <div class="d-flex align-items-center mb-1">
                    {!! Form::label('page', 'Páginas do site', ['class'=>'form-label mb-0']) !!}
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="A página selecionada será usada para redirecionar o usuário quando clicar no menu."></i>
                </div>
                {!! Form::select('page', listPage('pages'), null, [
                    'class'=>'form-select selectPage',
                    'id'=>'page',
                    'placeholder' => 'Selecione uma página'
                ]) !!}
            </div>
            <div class="alert alert-warning">
                <p class="mb-0"><b>IMPORTANTE: </b> Ao cadastrar o link as configurações restantes serão ignoradas, só cadastre o link em caso de necessidade.</p>
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
                        {!! Form::label('target_link', 'Redirecionar para', ['class'=>'form-label']) !!}
                        {!! Form::select('target_link', ['_self' => 'Na mesma aba', '_blank' => 'Em nova aba'], null, ['class'=>'form-select', 'id'=>'target_link_button']) !!}
                    </div>
                </div>
            </div> {{-- END .wrapper-links --}}
            <div class="mb-3 form-check">
                {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
                {!! Form::label('active', 'Ativar exibição deste link no menu?', ['class'=>'form-check-label']) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    <div class="col-12 col-md-6">
        <div class="card card-body" id="tooltip-container">
            <div class="ifDropdown" style="display: none;">
                <div class="mb-3">
                    <div class="d-flex align-items-center mb-1">
                        {!! Form::label('dropdown', 'Terá lista suspensa?', ['class'=>'form-label mb-0']) !!}
                        <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                            data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="Lista suspensa é um submenu que aparece quando um link do menu principal é clicado."></i>
                    </div>
                    {!! Form::select('dropdown', [0 => 'Não', 1 => 'Sim'], null, [
                        'class'=>'form-select activeDropdown',
                        'id'=>'dropdown',
                        'required'=>'required'
                    ]) !!}
                </div>
                <div class="mb-3 ifRelations" style="display: none;">
                    <div class="mb-3 col-12">
                        <div class="d-flex align-items-center mb-1">
                            {!! Form::label('dropdown', 'O que será exibido?', ['class'=>'form-label mb-0']) !!}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Selecione o que a lista suspensa deste menu exibirá."></i>
                        </div>
                        <button class="form-control dropdown-toggle text-start btnViewPage" type="button" id="dropdownPages" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="title"></span>
                        </button>
                        <ul class="list-group multi-level col-12 ps-0 containerListPages"></ul>
                    </div>
                    <div class="mb-3 form-check ifCategory" style="display: none;">
                        {!! Form::checkbox('exists', '1', null, ['class'=>'form-check-input', 'id'=>'exists', 'style'=>'margin-top: 9px;']) !!}
                        {!! Form::label('exists', 'Verificar se existe registros associados?', ['class'=>'form-check-label']) !!}
                        <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                            data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="Marcar esta opção habilitará a verificação de registros associados ao que foi selecionado para exibição. Ex.: Não irá exibir categorias sem artigos associados."></i>
                    </div>
                    <div class="mb-3 containerSelectConditions"></div>
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-1">
                        {!! Form::label('limit', 'Quantidade de exibição', ['class'=>'form-label mb-0']) !!}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Defina a quantidade de registros que serão exibidos na lista"></i>
                        </div>
                        {!! Form::select('limit', [
                                "4" => '4',
                                "5" => '5',
                                "6" => '6',
                                "7" => '7',
                                "8" => '8',
                                "9" => '9',
                                "10" => '10',
                                "all" => 'Todos'
                            ], null, [
                            'class'=>'form-select',
                            'id'=>'limit',
                        ]) !!}
                    </div>
                </div>
                {{-- END .ifRelations --}}
            </div>
        </div>
    </div>
</div>
{{-- end row --}}

{{-- Essa estrutura pode ser usada junto ao label do input para aparecer o ícone de duvida do lado do mesmo. pode usar a estutura abaixo substituindo o "Form::label" --}}
{{-- <div class="d-flex align-items-center mb-1">
    {!! Form::label('validationCustom01', 'First name', ['class'=>'form-label']) !!}
    <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
        data-bs-original-title="Coloque a mensagem desejado aqui"></i>
</div> --}}
