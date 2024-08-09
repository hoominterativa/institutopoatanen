{{--
    Para uma boa organização dos inputs, em caso de uma tela de cadastro com muitos campos, recomendamos dividir em dua colunas
    o "div class=col-12 dentro de .row" adicionando a classe 'col-lg-6' e duplicando toda a div e distribuir os inputs nessas colunas.

    Lista de Inputs se encontra no arquivo 'resources/views/Admin/components/forms/inputs.blade.php' é só copiar a estrutura do blase desejada e colar
    na área indicada abaixo. Veja abaixo um exemplo da estrutura do input.

    <div class="mb-3">
        {!! Form::label('validationCustom01', 'First name', ['class'=>'form-label']) !!}
        {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'validationCustom01', 'placeholder'=>'First name', 'required'=>'required']) !!}
    </div>

    PS.: Excluir esse comentário e todos relacioado a instruções.
--}}
    <div class="row">
        <div class="col-6">
        <div class="card card-body ">
            <div class="mb-3 col-12">
                {!! Form::label('validationCustom02', 'Titulo da Home', ['class' => 'form-label']) !!}
                {!! Form::text('title_home', null, [
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
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                {!! Form::label('active', 'Ativo?', ['class' => 'form-check-label']) !!}
            </div>
        </div>
    </div>
        <div class="col-6">
        <div class="card-body card">
            <div class="tab-content">
                <div class="tab-pane" id="linkPages7">
                    <div class="row">
                        <div class="dropdown mb-3 col-12">
                            {!! Form::label(null, 'Selecione uma página do site', ['class' => 'form-label']) !!}
                            <button
                                class="form-control dropdown-toggle text-start"
                                type="button" id="dropdownPages"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                                Páginas <i
                                    class="mdi mdi-chevron-down float-end"></i>
                            </button>
                            <ul class="dropdown-menu multi-level col-12"
                                aria-labelledby="dropdownPages">
                                {{-- @foreach (listPage() as $page)
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
                                @endforeach --}}
                            </ul>
                        </div>
                    </div>
                <div class="tab-pane show active" id="linkExternal7">
                </div>
            </div> {{-- END .tab-content --}}
            <div class="row">
                <div class="col-12">
                    {!! Form::label('btn_title', 'Título do botão', ['class' => 'form-label']) !!}
                    {!! Form::text('btn_title', null, [
                        'class' => 'form-control mb-3',
                        'id' => 'btn_title',
                        'placeholder' => 'Título do botão',
                    ]) !!}
                </div>
                <div class="col-12 col-sm-8">
                    {!! Form::label(null, 'Link', ['class' => 'form-label']) !!}
                    {!! Form::url('link', null, ['class' => 'form-control', 'parsley-type' => 'url', 'id' => 'targetUrl1']) !!}
                </div>
                <div class="col-12 col-sm-4">
                    {!! Form::label('target_link_one', 'Redirecionar para', ['class' => 'form-label']) !!}
                    {!! Form::select('target_link_one', ['_self' => 'Na mesma aba', '_blank' => 'Em nova aba'], null, [
                        'class' => 'form-select',
                        'id' => 'target_link_one',
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="card card-body">
                <div class="wrapper-links my-2 border px-2 py-3">
                    <h4 class="col-12 mb-3">Botão Principal
                        <i href="javascript:void(0)"
                            class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                            data-bs-container="#tooltip-container"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="Botão que aparece na página"></i>
                    </h4>
                    <ul class="nav nav-pills navtab-bg nav-justified">
                        <li class="nav-item">
                            <a href="#linkPages7" data-bs-toggle="tab"
                                aria-expanded="false" class="nav-link py-1">
                                <div
                                    class="d-flex align-items-center justify-content-center">
                                    Link para página do site
                                    <i href="javascript:void(0)"
                                        class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                                        data-bs-container="#tooltip-container"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        data-bs-original-title="Pode ser usado para cadastrar um link de redirecionamento para uma página do site ou conteúdo específico."></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#linkExternal7" data-bs-toggle="tab"
                                aria-expanded="true" class="nav-link active">
                                <div
                                    class="d-flex align-items-center justify-content-center">
                                    Link para página externa
                                    <i href="javascript:void(0)"
                                        class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                                        data-bs-container="#tooltip-container"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        data-bs-original-title="pode ser usado para cadastrar links de redirecionamento para outros sites"></i>
                                </div>
                            </a>
                        </li>
                    </ul> {{-- END .nav-tabs --}}

                </div> {{-- END .wrapper-links --}}
            </div>
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
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
        {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
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
