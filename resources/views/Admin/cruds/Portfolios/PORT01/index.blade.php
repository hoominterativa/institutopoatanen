@extends('Admin.core.admin')
@section('content')
    <div class="content-page">
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">{{$configModelsMain->Portfolios->PORT01->config->titlePanel}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">{{$configModelsMain->Portfolios->PORT01->config->titlePanel}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body" id="tooltip-container">
                                <div class="row mb-3">
                                    <div class="col-4">
                                        <button id="btSubmitDelete" data-route="{{route('admin.port01.destroySelected')}}" type="button" class="btn btn-danger btnDeletePortfolio" style="display: none;">Deletar selecionados</button>
                                    </div>
                                    <div class="col-8">
                                        <a href="{{$categories->count()?route('admin.port01.create'):'javascript:void(0)'}}"
                                            {!! !$categories->count()?'data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="É necessário cadastrar pelo menos uma categoria"':''!!}
                                            class="btn btn-success float-end" {!! !$categories->count()?'style="opacity: 0.4"':'' !!}>Adicionar novo <i class="mdi mdi-plus"></i></a>

                                        <button class="btn btn-secondary float-end me-2" data-bs-target="#modal-subcategory-create" data-bs-toggle="modal">Cadastrar Subcategorias <i class="mdi mdi-plus"></i></button>
                                        <button class="btn btn-primary float-end me-2" data-bs-target="#modal-category-create" data-bs-toggle="modal">Cadastrar Categorias <i class="mdi mdi-plus"></i></button>
                                        <button class="btn btn-warning float-end me-2" type="button" data-bs-toggle="collapse" data-bs-target="#portifolioSection" aria-expanded="false" aria-controls="collapseExample">
                                            Informações da Seção
                                        </button>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <div class="collapse bg-light p-3 mb-3" id="portifolioSection">
                                            @if ($section)
                                                {!! Form::model($section, ['route' => ['admin.port01.section.update', $section->id], 'class'=>'parsley-examples', 'files' => true]) !!}
                                                @method('PUT')
                                            @else
                                                {!! Form::model(null, ['route' => 'admin.port01.section.store', 'class'=>'parsley-examples', 'files' => true]) !!}
                                            @endif
                                            <div class="row">
                                                <div class="col-12 col-lg-6">
                                                    <div class="mb-2">
                                                        {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                                                        {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title', 'required' => true]) !!}
                                                    </div>
                                                    <div class="mb-2">
                                                        {!! Form::label('description', 'Descrição', ['class'=>'form-label']) !!}
                                                        {!! Form::textarea('description', null, [
                                                            'class'=>'form-control basic-editor',
                                                            'id'=>'description',
                                                        ]) !!}
                                                    </div>
                                                    <div class="mb-3 form-check me-3">
                                                        {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'activeSection']) !!}
                                                        {!! Form::label('activeSection', 'Ativar exibição na home?', ['class'=>'form-check-label']) !!}
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <div class="mb-3">
                                                        {!! Form::label('file', 'Imagem', ['class'=>'form-label']) !!}
                                                        {!! Form::file('path_image', [
                                                            'data-plugins'=>'dropify',
                                                            'data-height'=>'300',
                                                            'data-max-file-size-preview'=>'2M',
                                                            'accept'=>'image/*',
                                                            'data-default-file'=> isset($section)?$section->path_image<>''?url('storage/'.$section->path_image):'':'',
                                                        ]) !!}
                                                    </div>
                                                </div>
                                            </div>
                                                <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
                                                    {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0', 'type' => 'submit']) !!}
                                                </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div> <!-- end col-->
                                </div>
                                <table class="table table-bordered table-sortable">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50px"></th>
                                            <th width="30px" class="bs-checkbox">
                                                <label><input name="btnSelectAll" value="btnDeletePortfolio" type="checkbox"></label>
                                            </th>
                                            <th width="40px"></th>
                                            <th>Categoria / Subcategoria</th>
                                            <th>Título</th>
                                            <th>Status</th>
                                            <th width="90px">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody data-route="{{route('admin.port01.sorting')}}">
                                        @foreach ($portfolios as $portfolio)
                                            <tr data-code="{{$portfolio->id}}">
                                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                <td class="bs-checkbox align-middle">
                                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$portfolio->id}}"></label>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/'.$portfolio->path_image_box)}})"></div>
                                                </td>
                                                <td class="align-middle">{{$portfolio->category->title}} / {{$portfolio->subcategory->title}}</td>
                                                <td class="align-middle">{{$portfolio->title}}</td>
                                                <td class="align-middle">
                                                    @if ($portfolio->active)
                                                        <span class="badge bg-success text-dark">Ativo</span>
                                                    @else
                                                        <span class="badge bg-danger">Inativo</span>
                                                    @endif
                                                    @if ($portfolio->featured)
                                                        <span class="badge bg-info text-dark">Em destaque</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <a href="{{route('admin.port01.edit',['PORT01Portfolios' => $portfolio])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                                        </div>
                                                        <form action="{{route('admin.port01.destroy',['PORT01Portfolios' => $portfolio])}}" class="col-4" method="POST">
                                                            @method('DELETE') @csrf
                                                            <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{-- PAGINATION --}}
                                <div class="mt-3 float-end">
                                    {{$portfolios->links()}}
                                </div>
                            </div>
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>

    {{-- BEGIN CATEGORY --}}
    <div id="modal-category-create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="max-width: 1100px;">
            <div class="modal-content">
                <div class="modal-header p-3 pt-2 pb-2">
                    <h4 class="page-title">Cadastrar Categoria</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-3 pt-0 pb-3">
                    <button class="btn btn-secondary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#form-create-category" aria-expanded="false" aria-controls="collapseExample">
                        Exibir Formulário
                    </button>
                    <div class="bg-light p-3 mb-3 collapse" id="form-create-category">
                        {!! Form::model(null, ['route' => 'admin.port01.category.store', 'class'=>'parsley-examples', 'files' => true]) !!}
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="mb-3">
                                        {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                                        {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title']) !!}
                                    </div>
                                    <div class="mb-3 form-check mb-2">
                                        {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'activeCategory']) !!}
                                        {!! Form::label('activeCategory', 'Ativar Categoria?', ['class'=>'form-check-label']) !!}
                                    </div>
                                    <div class="mb-3 form-check mb-2">
                                        {!! Form::checkbox('featured', '1', null, ['class'=>'form-check-input', 'id'=>'featured']) !!}
                                        {!! Form::label('featured', 'Ativar Exibição na Home?', ['class'=>'form-check-label']) !!}
                                    </div>
                                    <div class="mb-3 form-check mb-2">
                                        {!! Form::checkbox('view_menu', '1', null, ['class'=>'form-check-input', 'id'=>'view_menu']) !!}
                                        {!! Form::label('view_menu', 'Ativar Exibição no Menu?', ['class'=>'form-check-label']) !!}
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="mb-3">
                                        {!! Form::label('file', 'Ícone', ['class'=>'form-label']) !!}
                                        {!! Form::file('path_image_icon', [
                                            'data-plugins'=>'dropify',
                                            'data-height'=>'200',
                                            'data-max-file-size-preview'=>'2M',
                                            'accept'=>'*',
                                            'data-default-file'=> '',
                                        ]) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
                                {!! Form::button('Cadastrar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
                                {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
                            </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="col-6">
                        <button id="btSubmitDelete" data-route="{{route('admin.port01.category.destroySelected')}}" type="button" class="btn btn-danger btnDeleteArchives" style="display: none;">Deletar selecionados</button>
                    </div>
                    <table data-toggle="table" data-page-size="5" data-pagination="false" class="table-bordered table-sortable">
                        <thead class="table-light">
                            <tr>
                                <th></th>
                                <th class="bs-checkbox">
                                    <label><input name="btnSelectAll" value="btnDeleteArchives" type="checkbox"></label>
                                </th>
                                <th class="text-center">Título</th>
                                <th class="text-center">Imagem</th>
                                <th width="200">Status</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>

                        <tbody data-route="{{route('admin.port01.category.sorting')}}">
                            @foreach ($categories as $key => $category)
                                <tr data-code="{{$category->id}}">
                                    <td><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                    <td class="bs-checkbox">
                                        <label><input data-index="{{$key}}" name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$category->id}}"></label>
                                    </td>
                                    <td>{{$category->title}}</td>
                                    <td class="table-user text-center">
                                        @if ($category->path_image_icon)
                                            <img src="{{ asset('storage/'.$category->path_image_icon) }}" name="path_image" alt="table-user" class="me-2 rounded-circle">
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        @switch($category->active)
                                            @case(0) <span class="badge bg-danger text-dark">Inativo</span> @break
                                            @case(1) <span class="badge bg-success text-dark">Ativo</span> @break
                                        @endswitch
                                        @if($category->featured)
                                            <span class="badge bg-info text-dark">Em destaque</span>
                                        @endif
                                        @if($category->view_menu)
                                            <span class="badge bg-warning text-dark">Visível no menu</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <button class="btn-icon me-2" data-bs-target="#modal-category-edit-{{$category->id}}" data-bs-toggle="modal"><i class="mdi mdi-square-edit-outline"></i></button>
                                            <form action="{{route('admin.port01.category.destroy',['PORT01PortfoliosCategory' => $category->id])}}" method="POST">
                                                @method('DELETE') @csrf
                                                <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                                            </form>
                                        </div>
                                        {{-- BEGIN EDIT CATEGORY --}}
                                        <div id="modal-category-edit-{{$category->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog" style="max-width: 800px;">
                                                <div class="modal-content">
                                                    <div class="modal-header p-3 pt-2 pb-2">
                                                        <h4 class="page-title">Editar Categoria</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body p-3 pt-0 pb-3 text-start">

                                                        {!! Form::model($category, ['route' => ['admin.port01.category.update', $category->id], 'class'=>'parsley-examples', 'files' => true]) !!}
                                                            @method('PUT')
                                                            <div class="mb-3">
                                                                {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                                                                {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title']) !!}
                                                            </div>
                                                            <div class="d-flex">
                                                                <div class="mb-3 form-check me-3">
                                                                    {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'activeCategory']) !!}
                                                                    {!! Form::label('activeCategory', 'Ativar Categoria?', ['class'=>'form-check-label']) !!}
                                                                </div>
                                                                <div class="mb-3 form-check me-3">
                                                                    {!! Form::checkbox('featured', '1', null, ['class'=>'form-check-input', 'id'=>'featured']) !!}
                                                                    {!! Form::label('featured', 'Ativar Exibição na Home?', ['class'=>'form-check-label']) !!}
                                                                </div>
                                                                <div class="mb-3 form-check me-3">
                                                                    {!! Form::checkbox('view_menu', '1', null, ['class'=>'form-check-input', 'id'=>'view_menu']) !!}
                                                                    {!! Form::label('view_menu', 'Ativar Exibição no Menu?', ['class'=>'form-check-label']) !!}
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                {!! Form::label('file', 'Ícone', ['class'=>'form-label']) !!}
                                                                {!! Form::file('path_image_icon', [
                                                                    'data-plugins'=>'dropify',
                                                                    'data-height'=>'150',
                                                                    'data-max-file-size-preview'=>'2M',
                                                                    'accept'=>'*',
                                                                    'data-default-file'=> isset($category)?$category->path_image_icon<>''?url('storage/'.$category->path_image_icon):'':'',
                                                                ]) !!}
                                                            </div>
                                                            <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
                                                                {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
                                                                {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
                                                            </div>
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- END EDIT CATEGORY --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- END CATEGORY --}}

    {{-- BEGIN SUBCATEGORY --}}
    <div id="modal-subcategory-create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="max-width: 1100px;">
            <div class="modal-content">
                <div class="modal-header p-3 pt-2 pb-2">
                    <h4 class="page-title">Cadastrar Subcategoria</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-3 pt-0 pb-3">
                    <button class="btn btn-secondary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#form-create-subcategory" aria-expanded="false" aria-controls="collapseExample">
                        Exibir Formulário
                    </button>
                    <div class="bg-light p-3 mb-3 collapse" id="form-create-subcategory">
                        {!! Form::model(null, ['route' => 'admin.port01.subcategory.store', 'class'=>'parsley-examples', 'files' => true]) !!}
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="mb-3">
                                        {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                                        {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title']) !!}
                                    </div>
                                    <div class="mb-3 form-check mb-2">
                                        {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'activeSubcategory']) !!}
                                        {!! Form::label('activeSubcategory', 'Ativar Subcategoria?', ['class'=>'form-check-label']) !!}
                                    </div>
                                    <div class="mb-3 form-check mb-2">
                                        {!! Form::checkbox('featured', '1', null, ['class'=>'form-check-input', 'id'=>'featuredSubcategory']) !!}
                                        {!! Form::label('featuredSubcategory', 'Ativar Exibição na Home?', ['class'=>'form-check-label']) !!}
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-1">
                                            {!! Form::label('normal-editor', 'Informações', ['class'=>'form-label mb-0']) !!}
                                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-original-title="Será exibida na interna de subcategoria."></i>
                                        </div>
                                        {!! Form::textarea('description', null, [
                                            'class'=>'form-control normal-editor',
                                            'id'=>'normal-editor',
                                        ]) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
                                {!! Form::button('Cadastrar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
                                {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
                            </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="col-6">
                        <button id="btSubmitDelete" data-route="{{route('admin.port01.subcategory.destroySelected')}}" type="button" class="btn btn-danger btnDeleteArchives" style="display: none;">Deletar selecionados</button>
                    </div>
                    <table data-toggle="table" data-page-size="5" data-pagination="false" class="table-bordered table-sortable">
                        <thead class="table-light">
                            <tr>
                                <th></th>
                                <th class="bs-checkbox">
                                    <label><input name="btnSelectAll" value="btnDeleteArchives" type="checkbox"></label>
                                </th>
                                <th class="text-center">Título</th>
                                <th width="200">Status</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>

                        <tbody data-route="{{route('admin.port01.subcategory.sorting')}}">
                            @foreach ($subcategories as $key => $subcategory)
                                <tr data-code="{{$subcategory->id}}">
                                    <td><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                    <td class="bs-checkbox">
                                        <label><input data-index="{{$key}}" name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$subcategory->id}}"></label>
                                    </td>
                                    <td>{{$subcategory->title}}</td>
                                    <td class="align-middle">
                                        @switch($subcategory->active)
                                            @case(0) <span class="badge bg-danger text-dark">Inativo</span> @break
                                            @case(1) <span class="badge bg-success text-dark">Ativo</span> @break
                                        @endswitch
                                        @if($subcategory->featured)
                                            <span class="badge bg-info text-dark">Em destaque</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <button class="btn-icon me-2" data-bs-target="#modal-subcategory-edit-{{$subcategory->id}}" data-bs-toggle="modal"><i class="mdi mdi-square-edit-outline"></i></button>
                                            <form action="{{route('admin.port01.subcategory.destroy',['PORT01PortfoliosSubategory' => $subcategory->id])}}" method="POST">
                                                @method('DELETE') @csrf
                                                <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                                            </form>
                                        </div>
                                        {{-- BEGIN EDIT SUBCATEGORY --}}
                                        <div id="modal-subcategory-edit-{{$subcategory->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog" style="max-width: 800px;">
                                                <div class="modal-content">
                                                    <div class="modal-header p-3 pt-2 pb-2">
                                                        <h4 class="page-title">Editar Categoria</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body p-3 pt-0 pb-3 text-start">

                                                        {!! Form::model($subcategory, ['route' => ['admin.port01.subcategory.update', $subcategory->id], 'class'=>'parsley-examples', 'files' => true]) !!}
                                                            @method('PUT')
                                                            <div class="mb-3">
                                                                {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                                                                {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title']) !!}
                                                            </div>
                                                            <div class="mb-3 form-check mb-2">
                                                                {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'activeSubcategory']) !!}
                                                                {!! Form::label('activeSubcategory', 'Ativar Subcategoria?', ['class'=>'form-check-label']) !!}
                                                            </div>
                                                            <div class="mb-3 form-check mb-2">
                                                                {!! Form::checkbox('featured', '1', null, ['class'=>'form-check-input', 'id'=>'featuredSubcategory']) !!}
                                                                {!! Form::label('featuredSubcategory', 'Ativar Exibição na Home?', ['class'=>'form-check-label']) !!}
                                                            </div>
                                                            <div class="mb-3">
                                                                <div class="d-flex align-items-center mb-1">
                                                                    {!! Form::label('normal-editor', 'Informações', ['class'=>'form-label mb-0']) !!}
                                                                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                                                                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                                                        data-bs-original-title="Será exibida na interna de subcategoria."></i>
                                                                </div>
                                                                {!! Form::textarea('description', null, [
                                                                    'class'=>'form-control normal-editor',
                                                                    'id'=>'normal-editor',
                                                                ]) !!}
                                                            </div>
                                                            <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
                                                                {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
                                                                {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
                                                            </div>
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- END EDIT CATEGORY --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- END CATEGORY --}}
    @include('Admin.components.links.resourcesIndex')
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
