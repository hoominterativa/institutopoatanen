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
                                <table data-toggle="table" data-page-size="5" data-pagination="false" class="table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Título Página</th>
                                            <th>Autor</th>
                                            <th>Descrição</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td>{{$optimization->title}}</td>
                                            <td>{{$optimization->author}}</td>
                                            <td>{{$optimization->description}}</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <a href="{{route('admin.optimization.edit',['optimization' => $optimization->id])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                                    </div>
                                                </div>
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
                                        <button id="btSubmitDelete" data-route="{{route('admin.optimizePage.destroySelected')}}" type="button" class="btn btn-danger" style="display: none;">Deletar selecionados</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{route('admin.optimizePage.create')}}" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                                    </div>
                                </div>
                                <table data-toggle="table" data-page-size="5" data-pagination="false" class="table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="bs-checkbox">
                                                <label><input name="btSelectAll" type="checkbox"></label>
                                            </th>
                                            <th>Página</th>
                                            <th>Título</th>
                                            <th>Autor</th>
                                            <th>Descrição</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($optimizePages as $key => $optimizePage)
                                            <tr>
                                                <td class="bs-checkbox">
                                                    <label><input data-index="{{$key}}" name="btSelectItem" class="btSelectItem" type="checkbox" value="{{$optimizePage->id}}"></label>
                                                </td>
                                                <td>{{$optimizePage->page}}</td>
                                                <td>{{$optimizePage->title}}</td>
                                                <td>{{$optimizePage->author}}</td>
                                                <td>{{$optimizePage->description}}</td>
                                                <td>
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
