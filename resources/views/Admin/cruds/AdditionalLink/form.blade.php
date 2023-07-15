@if (isset($additionalLink))
    {!! Form::model($additionalLink, ['route' => ['admin.additionalLink.update', $additionalLink->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
@else
    {!! Form::model(null, ['route' => 'admin.additionalLink.store', 'class'=>'parsley-validate', 'files'=>true]) !!}
@endif
    <div class="modal-body p-4" id="tooltip-container">
        <div class="mb-3">
            <div class="d-flex align-items-center mb-1">
                {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                    data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-original-title="Esse título será exibido no botão caso só exista um link para mesma posição"></i>
            </div>
            {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title']) !!}
        </div>
        <div class="wrapper-links my-2 border px-2 py-3">
            <ul class="nav nav-pills navtab-bg nav-justified">
                <li class="nav-item">
                    <a href="#linkPages{{isset($additionalLink)?'-'.$additionalLink->id:''}}" data-bs-toggle="tab" aria-expanded="false" class="nav-link py-1">
                        <div class="d-flex align-items-center justify-content-center">
                            Link para página do site
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Pode ser usado para cadastrar um link de redirecionamento para uma página do site ou conteúdo específico."></i>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#linkExternal{{isset($additionalLink)?'-'.$additionalLink->id:''}}" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
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
                <div class="tab-pane" id="linkPages{{isset($additionalLink)?'-'.$additionalLink->id:''}}">
                    <div class="row">
                        <div class="dropdown mb-3 col-12">
                            {!! Form::label(null, 'Selecione uma página do site', ['class'=>'form-label']) !!}
                            <button class="form-control dropdown-toggle text-start" type="button" id="dropdownPages" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Páginas <i class="mdi mdi-chevron-down float-end"></i>
                            </button>
                            <ul class="dropdown-menu multi-level col-12" aria-labelledby="dropdownPages">
                                @foreach (listPage() as $page)
                                    <li class="dropdown {{$page->dropdown?'dropdown-submenu':''}}">
                                        <a href="{{$page->route}}" class="dropdown-item" data-bs-toggle="setUrl" data-target-url="#targetUrl{{isset($additionalLink)?'-'.$additionalLink->id:''}}" data-bs-toggle="dropdown">{{$page->title}}</a>
                                        @if ($page->dropdown)
                                            <ul class="dropdown-menu">
                                                @foreach ($page->dropdown as $itens)
                                                    <li><a href="{{$itens->route}}" class="dropdown-item" data-bs-toggle="setUrl" data-target-url="#targetUrl{{isset($additionalLink)?'-'.$additionalLink->id:''}}">{{$itens->name}}</a></li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-pane show active" id="linkExternal{{isset($additionalLink)?'-'.$additionalLink->id:''}}"></div>
            </div> {{-- END .tab-content --}}
            <div class="row">
                <div class="col-12 col-sm-8">
                    {!! Form::label(null, 'Link', ['class'=>'form-label']) !!}
                    {!! Form::text('link', null, ['class'=>'form-control', 'id' => 'targetUrl'.(isset($additionalLink)?'-'.$additionalLink->id:'')]) !!}
                </div>
                <div class="col-12 col-sm-4">
                    {!! Form::label('link_target', 'Redirecionar para', ['class'=>'form-label']) !!}
                    {!! Form::select('link_target', ['_self' => 'Na mesma aba', '_blank' => 'Em nova aba'], null, ['class'=>'form-select', 'id'=>'link_target_button']) !!}
                </div>
            </div>
        </div> {{-- END .wrapper-links --}}
        <div class="mb-3">
            <div class="d-flex align-items-center mb-1">
                {!! Form::label('position', 'Posição do Botão', ['class'=>'form-label']) !!}
                <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                    data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-original-title="Define qual área no site o botão vai ser impresso"></i>
            </div>
            {!! Form::select('position', ['header' => 'Topo do site', 'footer' => 'Rodapé do site', 'both' => 'Ambas as Posições'], null, [
                'class'=>'form-select',
                'id'=>'position',
                'required'=>'required',
                'placeholder' => '--'
            ]) !!}
        </div>
        <div class="mb-3 form-check">
            {!! Form::checkbox('active', 1, null, ['class'=>'form-check-input', 'id'=>'active']) !!}
            {!! Form::label('active', 'Ativar exibição', ['class'=>'form-check-label']) !!}
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cancelar</button>
        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
    </div>
    {{-- end row --}}
{!! Form::close() !!}

