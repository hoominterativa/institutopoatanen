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
                                    <li class="breadcrumb-item active">Configurações do Menu</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Configurações do Menu</h4>
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
                                        <button id="btSubmitDelete" data-route="{{route('admin.header.destroySelected')}}" type="button" class="btn btn-danger btnDeleteHeader" style="display: none;">Deletar selecionados</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{route('admin.header.create')}}" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                                    </div>
                                </div>
                                <table class="table table-bordered table-sortable">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50px"></th>
                                            <th width="30px" class="bs-checkbox">
                                                <label><input name="btnSelectAll" value="btnDeleteHeader" type="checkbox"></label>
                                            </th>
                                            <th width="200px">Título</th>
                                            <th width="150px">Lista Suspensa?</th>
                                            <th>O que está exibindo na lista</th>
                                            <th>Condições de Exibição</th>
                                            <th width="150px">Limite de Exibição</th>
                                            <th width="100px">Status</th>
                                            <th width="90px">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody data-route="{{route('admin.header.sorting')}}">
                                        @foreach ($headers as $header)
                                            <tr data-code="{{$header->id}}">
                                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                <td class="bs-checkbox align-middle">
                                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$header->id}}"></label>
                                                </td>
                                                <td class="align-middle">{{$header->title}}</td>
                                                <td class="align-middle">
                                                    @switch($header->dropdown)
                                                        @case(1)
                                                            <span class="badge bg-success">Sim</span>
                                                        @break
                                                        @case(0)
                                                            <span class="badge bg-danger">Não</span>
                                                        @break
                                                    @endswitch
                                                </td>
                                                <td class="align-middle">
                                                    @if ($header->dropdown==1)
                                                        {{getNameRelation($header->module, $header->model, $header->select_dropdown, $header->title)}}
                                                    @endif
                                                </td>
                                                <td class="align-middle">{{getCondition($header->module, $header->model, $header->condition)}}</td>
                                                <td class="align-middle">
                                                    @if ($header->limit)
                                                        Exibindo {{$header->limit}}
                                                    @else
                                                        Exibindo todos
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    @switch($header->active)
                                                        @case(1)
                                                            <span class="badge bg-success">Ativo</span>
                                                        @break
                                                        @case(0)
                                                            <span class="badge bg-danger">Inativo</span>
                                                        @break
                                                    @endswitch
                                                </td>
                                                <td class="align-middle">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <a href="{{route('admin.header.edit',['SettingHeader' => $header->id])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                                        </div>
                                                        <form action="{{route('admin.header.destroy',['SettingHeader' => $header->id])}}" class="col-4" method="POST">
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
