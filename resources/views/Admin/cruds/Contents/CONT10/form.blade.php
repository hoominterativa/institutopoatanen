<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label(null, 'Data do evento', ['class' => 'form-label']) !!}
                {!! Form::text('date', null, [
                    'class' => 'form-control',
                    'required' => 'required',
                    'data-provide' => 'datepicker',
                    'data-date-autoclose' => 'true',
                    'data-date-format' => 'dd/mm/yyyy',
                    'data-date-language' => 'pt-BR',
                    'required' => 'required',
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('locale', 'Local do evento', ['class' => 'form-label']) !!}
                {!! Form::text('locale', null, [
                    'class' => 'form-control',
                    'id' => 'locale',
                    'placeholder' => 'Salvador-BA',
                    'required' => 'required',
                ]) !!}
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
                        {!! Form::label('title', 'Título do botão', ['class' => 'form-label']) !!}
                        {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) !!}
                    </div>
                    <div class="col-12 col-sm-8">
                        {!! Form::label(null, 'Link', ['class' => 'form-label']) !!}
                        {!! Form::url('link', null, ['class' => 'form-control', 'parsley-type' => 'url', 'id' => 'targetUrl']) !!}
                    </div>
                    <div class="col-12 col-sm-4">
                        {!! Form::label('link_target', 'Redirecionar para', ['class' => 'form-label']) !!}
                        {!! Form::select('link_target', ['_self' => 'Na mesma aba', '_blank' => 'Em nova aba'], null, [
                            'class' => 'form-select',
                            'id' => 'link_target',
                        ]) !!}
                    </div>

                </div>

            </div> {{-- END .wrapper-links --}}
            <div class="mb-3 form-check">
                {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                {!! Form::label('active', 'Ativar exibição', ['class' => 'form-check-label']) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
</div>
{{-- end row --}}
