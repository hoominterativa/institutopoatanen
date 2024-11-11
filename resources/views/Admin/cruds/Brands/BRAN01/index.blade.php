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
                                    <li class="breadcrumb-item active">{{ getTitleModel($configModelsMain, 'Brands', 'BRAN01') }}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">{{ getTitleModel($configModelsMain, 'Brands', 'BRAN01') }}</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->
                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#brands" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link active d-flex align-items-center">
                            {{ getTitleModel($configModelsMain, 'Brands', 'BRAN01') }}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro do conteúdo principal."></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#content" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Informações para seção adicional
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Informações que serão exibidas acima da lista de marcas na página interna."></i>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="#section" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Informações para home
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Informações que serão exibidas na home, caso esteja ativa."></i>
                        </a>
                    </li> --}}
                    <li class="nav-item">
                        <a href="#banner" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Banner da página
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Esse banner será exibido na página."></i>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane show active" id="brands">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <button id="btSubmitDelete" data-route="{{ route('admin.bran01.destroySelected') }}" type="button" class="btn btn-danger btnDeleteBrands" style="display: none;">Deletar selecionados</button>
                                            </div>
                                            <div class="col-6">
                                                <a href="{{ route('admin.bran01.create') }}" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                                            </div>
                                        </div>
                                        <table class="table table-bordered table-sortable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="50px"></th>
                                                    <th width="30px" class="bs-checkbox">
                                                        <label><input name="btnSelectAll" value="btnDeleteBrands" type="checkbox"></label>
                                                    </th>
                                                    <th>Imagens</th>
                                                    <th>Links</th>
                                                    <th width="100px">Status</th>
                                                    <th width="90px">Ações</th>
                                                </tr>
                                            </thead>

                                            <tbody data-route="{{ route('admin.bran01.sorting') }}">
                                                @foreach ($brands as $brand)
                                                    <tr data-code="{{ $brand->id }}">
                                                        <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                        <td class="bs-checkbox align-middle">
                                                            <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{ $brand->id }}"></label>
                                                        </td>
                                                        <td class="align-middle avatar-group">
                                                            @if ($brand->path_image_icon || $brand->path_image_box)
                                                                <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{ asset('storage/' . $brand->path_image_icon) }})"></div>
                                                                <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{ asset('storage/' . $brand->path_image_box) }})"></div>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle"><a href="{{ $brand->link }}" target="_blank" class="mdi mdi-link-box-variant mdi-24px"></a></td>
                                                        <td class="align-middle">
                                                            @switch($brand->active)
                                                                @case(1)
                                                                    <span class="badge bg-success">Ativo</span>
                                                                @break

                                                                @case(0)
                                                                    <span class="badge bg-danger">Inativo</span>
                                                                @break
                                                            @endswitch
                                                            @if ($brand->featured)
                                                                <span class="badge bg-primary text-white">Em destaque</span>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <a href="{{ route('admin.bran01.edit', ['BRAN01Brands' => $brand->id]) }}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                                                </div>
                                                                <form action="{{ route('admin.bran01.destroy', ['BRAN01Brands' => $brand->id]) }}" class="col-4" method="POST">
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
                                            {{ $brands->links() }}
                                        </div>
                                    </div>
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div>
                        <!-- end row -->
                    </div>
                    {{-- <div class="tab-pane" id="section">
                        @include('Admin.cruds.Brands.BRAN01.Section.form')
                    </div> --}}
                    <div class="tab-pane" id="banner">
                        @include('Admin.cruds.Brands.BRAN01.Banner.form')
                    </div>
                    <div class="tab-pane" id="content">
                        @include('Admin.cruds.Brands.BRAN01.Content.form')
                    </div>
                </div>
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesIndex')
@endsection
