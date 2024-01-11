@if ($about)
    {!! Form::model($about, ['route' => ['admin.abou04.update', $about->id],'class' => 'parsley-validate','files' => true,]) !!}
    @method('PUT')
    {!! Form::hidden('active_banner', $about->active_banner) !!}
    {!! Form::hidden('active_topics', $about->active_topics) !!}
    {!! Form::hidden('active', $about->active) !!}
    {!! Form::hidden('title', $about->title) !!}
@else
    {!! Form::model(null, ['route' => 'admin.abou04.store', 'class' => 'parsley-validate', 'files' => true]) !!}
@endif

<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label('title_galleries', 'Título', ['class'=>'form-label']) !!}
                {!! Form::text('title_galleries', null, ['class'=>'form-control', 'id'=>'title_galleries']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('description_galleries', 'Descrição', ['class'=>'form-label']) !!}
                {!! Form::textarea('description_galleries', null, [
                    'class'=>'form-control',
                    'id'=>'description_galleries',
                    'data-parsley-trigger'=>'keyup',
                    'data-parsley-maxlength'=>'800',
                    'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold'=>'10',
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
                        {!! Form::label('title_button_galleries', 'Título da botão', ['class' => 'form-label']) !!}
                        {!! Form::text('title_button_galleries', null, ['class' => 'form-control', 'id' => 'title_button_galleries']) !!}
                    </div>
                    <div class="col-12 col-sm-8">
                        {!! Form::label(null, 'Link do botão', ['class' => 'form-label']) !!}
                        {!! Form::url('link_button_galleries', (isset($about) ? getUri($about->link_button_galleries) : null), ['class' => 'form-control', 'parsley-type' => 'url', 'id' => 'targetUrl']) !!}
                     </div>
                    <div class="col-12 col-sm-4">
                        {!! Form::label('target_link_button_galleries', 'Redirecionar para', ['class' => 'form-label']) !!}
                        {!! Form::select('target_link_button_galleries', ['_self' => 'Na mesma aba', '_blank' => 'Em nova aba'], null, [
                            'class' => 'form-select',
                            'id' => 'target_link_button_galleries',
                        ]) !!}
                    </div>
                </div>
            </div> {{-- END .wrapper-links --}}
        </div>
        {{-- end card-body --}}
        <div class="d-flex">
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active_galleries', '1', null, ['class' => 'form-check-input', 'id' => 'active_galleries']) !!}
                {!! Form::label('active_galleries', 'Ativar exibição?', ['class' => 'form-check-label']) !!}
            </div>
        </div>
    </div>
</div>
{!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
<a href="{{route('admin.dashboard')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
{!! Form::close() !!}
