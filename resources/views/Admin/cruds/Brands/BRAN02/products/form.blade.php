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
<div class="col-12">
    <div class="mb-3 card-body card">
        {!! Form::label('name', 'Nome da Categoria', ['class' => 'form-label']) !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'title', 'required' => 'required']) !!}
        <div class="mt-3">
            {!! Form::label('category_id	', 'Selecione a Categoria do Produto', ['class' => 'form-label']) !!}
            {!! Form::select(
                'options',
                [
                    '1' => 'Option 1',
                    '2' => 'Option 2',
                    '3' => 'Option 2',
                ],
                null,
                [
                    'class' => 'form-select',
                    'id' => 'category_id	',
                    'required' => 'required',
                    'placeholder' => 'Escolha a categoria...',
                ],
            ) !!}
        </div>
    </div>

    <div class="card card-body" id="tooltip-container">
        <div class="row">
            {{-- Editor de Link --}}
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
                                    {{-- @foreach (listPage() as $page)
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
                                        @endforeach --}}
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane show active" id="linkExternal"></div>
                </div> {{-- END .tab-content --}}
                <div class="row">
                    <div class="col-12 col-sm-8">
                        {!! Form::label(null, 'button_link', ['class' => 'form-label']) !!}
                        {!! Form::url('button_link', null, ['class' => 'form-control', 'parsley-type' => 'url', 'id' => 'targetUrl']) !!}
                    </div>
                    <div class="col-12 col-sm-4">
                        {!! Form::label('target_link', 'Redirecionar para', ['class' => 'form-label']) !!}
                        {!! Form::select('target_link', ['_self' => 'Na mesma aba', '_blank' => 'Em nova aba'], null, [
                            'class' => 'form-select',
                            'id' => 'target_link_button',
                        ]) !!}
                    </div>
                </div>

            </div>
            {{-- END .wrapper-links --}}

            {{-- Editor de Imagem --}}
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->path_image->width }}x{{ $cropSetting->path_image->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image->width, // px
                            'data-min-height' => $cropSetting->path_image->height, // px
                            'data-box-height' => '225', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff',
                            'data-default-file' => isset($BrandsProducts)
                                ? ($BrandsProducts->path_image != ''
                                    ? url('storage/' . $BrandsProducts->path_image)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            {{-- Editor de Texto --}}
        </div>
        <div class="mt-1 row">
            <div class="form-check me-3">
                {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                {!! Form::label('active', 'Ativar Exibição?', ['class' => 'form-check-label']) !!}
            </div>
            <div class="form-check me-3">
                {!! Form::checkbox('highlighted', '1', null, ['class' => 'form-check-input', 'id' => 'featured']) !!}
                {!! Form::label('highlighted', 'Destacar na home?', ['class' => 'form-check-label']) !!}
            </div>
        </div>
    </div>
    {{-- end card-body --}}
</div>

{{-- end row --}}

{{-- Essa estrutura pode ser usada junto ao label do input para aparecer o ícone de duvida do lado do mesmo. pode usar a estutura abaixo substituindo o "Form::label" --}}
{{-- <div class="d-flex align-items-center mb-1">
    {!! Form::label('validationCustom01', 'First name', ['class'=>'form-label']) !!}
    <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
        data-bs-original-title="Coloque a mensagem desejado aqui"></i>
</div> --}}
