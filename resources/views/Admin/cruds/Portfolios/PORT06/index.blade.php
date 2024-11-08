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
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">
                                        {{ getTitleModel($configModelsMain, 'Portfolios', 'PORT06') }}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">{{ getTitleModel($configModelsMain, 'Portfolios', 'PORT06') }}</h4>
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
                                data-bs-original-title="Cadastre as categorias para os portifólios"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#portfolios" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link active d-flex align-items-center">
                            {{ getTitleModel($configModelsMain, 'Portfolios', 'PORT06') }}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro dos portfólios"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#section" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Seção Home
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Essas informações serão exibidas na home do site"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#banner" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Banner da página
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Esse banner será exibido na página de portifólios"></i>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="portfolios">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <button id="btSubmitDelete"
                                                    data-route="{{ route('admin.port06.destroySelected') }}" type="button"
                                                    class="btn btn-danger" style="display: none;">Deletar
                                                    selecionados</button>
                                            </div>
                                            <div class="col-6">
                                                <a href="{{ route('admin.port06.create') }}"
                                                    class="btn btn-success float-end">Adicionar novo <i
                                                        class="mdi mdi-plus"></i></a>
                                            </div>
                                        </div>
                                        <table class="table table-bordered table-sortable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="50px"></th>
                                                    <th width="30px" class="bs-checkbox">
                                                        {{-- INSERIR UMA CLASSE ÙNICA NO "#btSubmitDelete" E NO VALUE DO INPUT ABAIXO --}}
                                                        <label><input name="btnSelectAll" value=""
                                                                type="checkbox"></label>
                                                    </th>
                                                    <th>Imagem</th>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Job Title</th>
                                                    <th width="100px">Status</th>
                                                    <th width="90px">Ações</th>
                                                </tr>
                                            </thead>

                                            <tbody data-route="{{ route('admin.port06.sorting') }}">
                                                @foreach ($portfolios as $portfolio)
                                                    <tr data-port06="{{ $portfolio->id }}">
                                                        <td class="align-middle"><span
                                                                class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                        <td class="bs-checkbox align-middle">
                                                            <label><input name="btnSelectItem" class="btnSelectItem"
                                                                    type="checkbox" value="{{ $portfolio->id }}"></label>
                                                        </td>
                                                        <td class="align-middle avatar-group">
                                                            @if ($portfolio->path_image)
                                                                <div class="avatar-group-item avatar-bg rounded-circle avatar-sm"
                                                                    style="background-image: url({{ asset('storage/' . $portfolio->path_image) }})">
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle">{{ $portfolio->title }}</td>
                                                        <td class="align-middle">{{ $portfolio->subtitle }}</td>
                                                        <td class="align-middle">{!! substr($portfolio->paragraph, 0, 25) !!}</td>
                                                        <td class="align-middle">
                                                            @if ($portfolio->active)
                                                                <span class="badge bg-success">Ativo</span>
                                                            @else
                                                                <span class="badge bg-danger">Inativo</span>
                                                            @endif
                                                            @if ($portfolio->featured)
                                                                <span class="badge bg-primary text-white">Destaque</span>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <a href="{{ route('admin.port06.edit', ['PORT06Portfolios' => $portfolio->id]) }}"
                                                                        class="btn-icon mdi mdi-square-edit-outline"></a>
                                                                </div>
                                                                <form
                                                                    action="{{ route('admin.port06.destroy', ['PORT06Portfolios' => $portfolio->id]) }}"
                                                                    class="col-4" method="POST">
                                                                    @method('DELETE') @csrf
                                                                    <button type="button"
                                                                        class="btn-icon btSubmitDeleteItem"><i
                                                                            class="mdi mdi-trash-can"></i></button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        {{-- PAGINATION --}}
                                        <div class="mt-3 float-end">
                                            {{ $portfolios->links() }}
                                        </div>
                                    </div>
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div>
                    </div>
                    <div class="tab-pane" id="categories">
                        @include('Admin.cruds.Portfolios.PORT06.Category.index', [
                            'categories' => $categories,
                        ])
                    </div>
                    <div class="tab-pane" id="section">
                        @include('Admin.cruds.Portfolios.PORT06.Section.form')
                    </div>
                    <div class="tab-pane" id="banner">
                        @include('Admin.cruds.Portfolios.PORT06.Banner.form')
                    </div>
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesIndex')
@endsection
