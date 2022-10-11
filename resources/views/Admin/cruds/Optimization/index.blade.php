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
                                    <li class="breadcrumb-item active">SEO</li>
                                </ol>
                            </div>
                            <h4 class="page-title mb-0">Scripts e SEO</h4>
                            <p class="mt-0">Cadastro de scripts (Google Analytics, Facebook Pixel, etc) e descrições para a página home do site</p>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3"></div>
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Título Página</th>
                                            <th>Autor</th>
                                            <th>Descrição</th>
                                            <th width="50px">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td class="align-middle">{{$optimization->title}}</td>
                                            <td class="align-middle">{{$optimization->author}}</td>
                                            <td class="align-middle">{{$optimization->description}}</td>
                                            <td class="align-middle text-center">
                                                <a href="{{route('admin.optimization.edit',['optimization' => $optimization->id])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div>
                <!-- end row -->
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <h4 class="page-title">Informações das Páginas</h4>
                            <p class="mt-0">Cadastro de informações individuais para cada página, exceto a home, do site</p>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <button id="btSubmitDelete" data-route="{{route('admin.optimizePage.destroySelected')}}" type="button" class="btn btn-danger btnDeleteOptimization" style="display: none;">Deletar selecionados</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{route('admin.optimizePage.create')}}" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                                    </div>
                                </div>
                                <table class="table table-bordered table-sortable">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50px"></th>
                                            <th width="30px" class="bs-checkbox">
                                                <label><input name="btnSelectAll" value="btnDeleteOptimization" type="checkbox"></label>
                                            </th>
                                            <th>Página</th>
                                            <th>Título</th>
                                            <th>Autor</th>
                                            <th>Descrição</th>
                                            <th width="90px">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody data-route="{{route('admin.optimizePage.sorting')}}">
                                        @foreach ($optimizePages as $optimizePage)
                                            <tr>
                                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                <td class="bs-checkbox align-middle">
                                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$optimizePage->id}}"></label>
                                                </td>
                                                <td class="align-middle">{{$optimizePage->page}}</td>
                                                <td class="align-middle">{{$optimizePage->title}}</td>
                                                <td class="align-middle">{{$optimizePage->author}}</td>
                                                <td class="align-middle">{{$optimizePage->description}}</td>
                                                <td class="align-middle">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <a href="{{route('admin.optimizePage.edit',['optimizePage' => $optimizePage->id])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                                        </div>
                                                        <form action="{{route('admin.optimizePage.destroy',['optimizePage' => $optimizePage->id])}}" class="col-4" method="POST">
                                                            @method('DELETE') @csrf
                                                            <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesIndex')
@endsection
