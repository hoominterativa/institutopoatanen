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
                            <h4 class="page-title">Dashboard</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <table data-toggle="table" data-page-size="5" data-pagination="false" class="table-bordered table-sortable">
                    <thead class="table-light">
                        <tr>
                            <th></th>
                            <th class="bs-checkbox">
                                <label><input name="btSelectAll" type="checkbox"></label>
                            </th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Job Title</th>
                            <th>DOB</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody data-route="{{route('admin.dashboard.create')}}">
                        <tr data-code="1">
                            <td><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                            <td class="bs-checkbox">
                                <label><input data-index="" name="btSelectItem" class="btSelectItem" type="checkbox" value=""></label>
                            </td>
                            <td>Isidra</td>
                            <td>Boudreaux</td>
                            <td>Traffic Court Referee</td>
                            <td>22 Jun 1972</td>
                            <td>
                                <span class="badge bg-success">Ativo</span>
                                <span class="badge bg-primary text-white">Destaque</span>
                                <span class="badge bg-danger">Inativo</span>
                            </td>
                        </tr>
                        <tr data-code="2">
                            <td><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                            <td class="bs-checkbox">
                                <label><input data-index="" name="btSelectItem" class="btSelectItem" type="checkbox" value=""></label>
                            </td>
                            <td>Isidra</td>
                            <td>Boudreaux</td>
                            <td>Traffic Court Referee</td>
                            <td>22 Jun 1972</td>
                            <td>
                                <span class="badge bg-success">Ativo</span>
                                <span class="badge bg-primary text-white">Destaque</span>
                                <span class="badge bg-danger">Inativo</span>
                            </td>
                        </tr>
                        <tr data-code="3">
                            <td><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                            <td class="bs-checkbox">
                                <label><input data-index="" name="btSelectItem" class="btSelectItem" type="checkbox" value=""></label>
                            </td>
                            <td>Isidra</td>
                            <td>Boudreaux</td>
                            <td>Traffic Court Referee</td>
                            <td>22 Jun 1972</td>
                            <td>
                                <span class="badge bg-success">Ativo</span>
                                <span class="badge bg-primary text-white">Destaque</span>
                                <span class="badge bg-danger">Inativo</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="row">
                    @foreach ($modelsMain as $module => $models)
                        @foreach ($models as $code => $model)
                            <div class="col-md-6 col-xl-3">
                                <a nofollow href="{{route('admin.'.Str::lower($code).'.index')}}">
                                    <div class="widget-rounded-circle card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="avatar-lg rounded-circle border-secondary border shadow m-auto mb-3">
                                                        <i class="{{$model->config->iconPanel<>''?$model->config->iconPanel:'mdi-cancel'}} mdi font-24 avatar-title text-dark"></i>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="text-center">
                                                        <h4 class="text-dark mt-1">{{$model->config->titlePanel}}</h4>
                                                        <p class="text-muted mb-1">Ver Listagem</p>
                                                    </div>
                                                </div>
                                            </div> <!-- end row-->
                                        </div>
                                    </div> <!-- end widget-rounded-circle-->
                                </a>
                            </div> <!-- end col-->
                        @endforeach
                    @endforeach
                </div>

            </div> <!-- container -->

        </div> <!-- content -->

    </div>
    @include('Admin.components.links.resourcesIndex')
@endsection
