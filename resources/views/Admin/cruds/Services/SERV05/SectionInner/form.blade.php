@if ($service)
    {!! Form::model($service, ['route' => ['admin.serv05.update', $service->id], 'class' => 'parsley-validate', 'files' => true,]) !!}
    @method('PUT')
    {!! Form::hidden('active_about_inner', $service->active_about_inner) !!}
    {!! Form::hidden('active_banner', $service->active_banner) !!}
    {!! Form::hidden('featured', $service->featured) !!}
    {!! Form::hidden('active', $service->active) !!}
    {!! Form::hidden('slug', $service->slug) !!}
@else
    {!! Form::model(null, ['route' => 'admin.serv05.store', 'class' => 'parsley-validate', 'files' => true]) !!}
@endif

<div class="card card-body" id="tooltip-container">
    <div class="row">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title_topic', 'Título do tópico', ['class' => 'form-label']) !!}
                        {!! Form::text('title_topic', null, ['class' => 'form-control', 'id' => 'title_topic']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('subtitle_topic', 'Subtítulo do tópico', ['class' => 'form-label']) !!}
                        {!! Form::text('subtitle_topic', null, ['class' => 'form-control', 'id' => 'subtitle_topic']) !!}
                    </div>
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
                        {!! Form::label('title_topic_button', 'Título do botão', ['class' => 'form-label']) !!}
                        {!! Form::text('title_topic_button', null, ['class' => 'form-control', 'id' => 'title_topic_button']) !!}
                    </div>
                    <div class="col-12 col-sm-8">
                        {!! Form::label(null, 'Link do botão', ['class'=>'form-label']) !!}
                        {!! Form::url('link_topic', isset($service) ? getUri($service->link_topic) : null, ['class'=>'form-control','parsley-type'=>'url', 'id' => 'targetUrl']) !!}
                    </div>
                    <div class="col-12 col-sm-4">
                        {!! Form::label('target_link', 'Redirecionar', ['class'=>'form-label']) !!}
                        {!! Form::select('target_link', ['_self' => 'Na mesma aba', '_blank' => 'Em nova aba'], null, ['class'=>'form-select', 'id'=>'target_link']) !!}
                    </div>
                </div>
            </div> {{-- END ."wrapper-links --}}
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active_topic', '1', null, ['class' => 'form-check-input', 'id' => 'active_topic']) !!}
                {!! Form::label('active_topic', 'Ativar exibição ?', ['class' => 'form-check-label']) !!}
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', [ 'class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0', 'type' => 'submit']) !!}
    </div>
</div>
{!! Form::close() !!}


