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
                                    <li class="breadcrumb-item active">{{getTitleModel($configModelsMain, 'Blogs', 'BLOG03')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">{{getTitleModel($configModelsMain, 'Blogs', 'BLOG03')}}</h4>
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
                                data-bs-original-title="Cadastre as categorias para os artigos"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#blogs" data-bs-toggle="tab" aria-expanded="true" class="nav-link active d-flex align-items-center">
                            {{getTitleModel($configModelsMain, 'Blogs', 'BLOG03')}}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro dos blogs"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#banner" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Banner
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Este banner será exibido na página blog"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#section" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center" >
                            Informações da seção
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Informações complementares que serão exibidas na home, caso esteja ativa"></i>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="blogs">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-3">
                                                @include('Admin.cruds.Blogs.BLOG03.filter',[
                                                    'categories' => $categories
                                                ])
                                            </div>
                                            <div class="col-4">
                                                <button id="btSubmitDelete" data-route="{{route('admin.blog03.destroySelected')}}" type="button" class="btn btn-danger btnDeleteBLOG03" style="display: none;">Deletar selecionados</button>
                                            </div>
                                            <div class="col-5">
                                                <a href="{{route('admin.blog03.create')}}" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                                            </div>
                                        </div>
                                        <table class="table table-bordered table-sortable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="50px"></th>
                                                    <th width="30px" class="bs-checkbox">
                                                        <label><input name="btnSelectAll" value="btnDeleteBLOG03" type="checkbox"></label>
                                                    </th>
                                                    <th></th>
                                                    <th>Categoria</th>
                                                    <th>Título</th>
                                                    <th>Publicação</th>
                                                    <th width="100px">Status</th>
                                                    <th width="90px">Ações</th>
                                                </tr>
                                            </thead>

                                            <tbody data-route="{{route('admin.blog03.sorting')}}">
                                                @foreach ($blogs as $blog)
                                                    <tr data-code="{{$blog->id}}">
                                                        <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                        <td class="bs-checkbox align-middle">
                                                            <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$blog->id}}"></label>
                                                        </td>
                                                        <td class="align-middle avatar-group">
                                                            @if ($blog->path_image)
                                                                <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/' .$blog->path_image)}})"></div>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle">{{$blog->category->title}}</td>
                                                        <td class="align-middle">{{$blog->title}}</td>
                                                        <td class="align-middle">{{Carbon\Carbon::parse($blog->publishing)->format('d/m/Y')}}</td>
                                                        <td class="align-middle">
                                                            @if ($blog->active)
                                                                <span class="badge bg-success me-2">Ativo</span>
                                                            @else
                                                                <span class="badge bg-danger me-2">Inativo</span>
                                                            @endif
                                                            @if ($blog->featured)
                                                                <span class="badge bg-primary text-white me-2">Destaque Home</span>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <a href="{{route('admin.blog03.edit',['BLOG03Blogs' => $blog->id])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                                                </div>
                                                                <form action="{{route('admin.blog03.destroy',['BLOG03Blogs' => $blog->id])}}" class="col-4" method="POST">
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
                                            {{$blogs->links()}}
                                        </div>
                                    </div>
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div>
                    </div>
                    <div class="tab-pane" id="categories">
                        @include('Admin.cruds.Blogs.BLOG03.Category.index',[
                            'categories' => $blogCategories
                        ])
                    </div>
                    <div class="tab-pane" id="section">
                        <div class="card">
                            <div class="card-body">
                                @include('Admin.cruds.Blogs.BLOG03.Section.form',[
                                    'section' => $section
                                ])
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="banner">
                        <div class="card">
                            <div class="card-body">
                                @include('Admin.cruds.Blogs.BLOG03.Banner.form',[
                                    'banner' => $banner
                                ])
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesIndex')
@endsection
