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
                                    <li class="breadcrumb-item active">{{ getTitleModel($configModelsMain, 'Products', 'PROD02V1')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">{{ getTitleModel($configModelsMain, 'Products', 'PROD02V1')}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#categories" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Categorias
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastre as categorias para os produtos"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#products" data-bs-toggle="tab" aria-expanded="true" class="nav-link active d-flex align-items-center">
                            {{getTitleModel($configModelsMain, 'Products', 'PROD02V1')}}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro dos produtos"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#banner" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Banner
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Este banner será exibido na página de produtos"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#section" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center" >
                            Informações da seção produtos
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Informações complementares que serão exibidas na home, caso esteja ativa"></i>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="products">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <button id="btSubmitDelete" data-route="{{route('admin.prod02v1.destroySelected')}}" type="button" class="btn btn-danger btnDeleteProducts" style="display: none;">Deletar selecionados</button>
                                            </div>
                                            <div class="col-6">
                                                <a href="{{route('admin.prod02v1.create')}}" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                                            </div>
                                        </div>
                                        <table class="table table-bordered table-sortable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="50px"></th>
                                                    <th width="30px" class="bs-checkbox">
                                                        <label><input name="btnSelectAll" value="btnDeleteProducts" type="checkbox"></label>
                                                    </th>
                                                    <th>Imagem</th>
                                                    <th>Categoria</th>
                                                    <th>Título/Subtítulo</th>
                                                    <th>Descrição</th>
                                                    <th>Texto</th>
                                                    <th>Título Botão</th>
                                                    <th>Link Botão</th>
                                                    <th width="100px">Status</th>
                                                    <th width="90px">Ações</th>
                                                </tr>
                                            </thead>

                                            <tbody data-route="{{route('admin.prod02v1.sorting')}}">
                                                @foreach ($products as $product)
                                                    <tr data-code="{{$product->id}}">
                                                        <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                        <td class="bs-checkbox align-middle">
                                                            <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$product->id}}"></label>
                                                        </td>
                                                        <td class="align-middle avatar-group">
                                                            @if ($product->path_image_box)
                                                                <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/' . $product->path_image_box)}})"></div>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle">{{$product->category->title}}</td>
                                                        <td class="align-middle">{{$product->title}} <b>/</b> {{$product->subtitle}}</td>
                                                        <td class="align-middle">{!! substr($product->description, 0, 35) !!}</td>
                                                        <td class="align-middle">{!! substr($product->text, 0, 35) !!}</td>
                                                        <td class="align-middle">{{$product->title_button}}</td>
                                                        <td class="align-middle"><a href="{{ $product->link_button }}" target="_blank" class="mdi mdi-link-box-variant mdi-24px"></a></td>
                                                        <td class="align-middle">
                                                            @if ($product->active)
                                                                <span class="badge bg-success">Ativo</span>
                                                            @else
                                                                <span class="badge bg-danger">Inativo</span>
                                                            @endif
                                                            @if ($product->featured)
                                                                <span class="badge bg-primary text-white">Destaque</span>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <a href="{{route('admin.prod02v1.edit',['PROD02V1Products' => $product->id])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                                                </div>
                                                                <form action="{{route('admin.prod02v1.destroy',['PROD02V1Products' => $product->id])}}" class="col-4" method="POST">
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
                                            {{$products->links()}}
                                        </div>
                                    </div>
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div>
                    </div>
                    <div class="tab-pane" id="categories">
                        @include('Admin.cruds.Products.PROD02V1.Category.index', [
                            'categories' => $productCategories
                        ])
                    </div>
                    <div class="tab-pane" id="banner">
                        @include('Admin.cruds.Products.PROD02V1.Banner.form')
                    </div>
                    <div class="tab-pane" id="section">
                        @include('Admin.cruds.Products.PROD02V1.Section.form')
                    </div>
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesIndex')
@endsection
