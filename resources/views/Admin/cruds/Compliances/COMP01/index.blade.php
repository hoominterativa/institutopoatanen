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
                                    <li class="breadcrumb-item active">Compliances</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Compliances</h4>
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
                                        <button id="btSubmitDelete" data-route="{{route('admin.comp01.destroySelected')}}" type="button" class="btn btn-danger btnDeleteCompliances" style="display: none;">Deletar selecionados</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{route('admin.comp01.create')}}" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                                    </div>
                                </div>
                                <table class="table table-bordered table-sortable">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50px"></th>
                                            <th width="30px" class="bs-checkbox">
                                                <label><input name="btnSelectAll" value="btnDeleteCompliances" type="checkbox"></label>
                                            </th>
                                            <th width="60px"></th>
                                            <th>Título da Página</th>
                                            <th>Título Banner</th>
                                            <th width="120px" class="text-center">Link da página</th>
                                            <th width="90px">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody data-route="{{route('admin.comp01.sorting')}}">
                                        @foreach ($compliances as $compliance)
                                            <tr data-code="{{$compliance->id}}">
                                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                <td class="bs-checkbox align-middle">
                                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$compliance->id}}"></label>
                                                </td>
                                                <td class="align-middle">
                                                    @if ($compliance->path_image_banner)
                                                        <div class="avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/'.$compliance->path_image_banner)}})"></div>
                                                    @endif
                                                </td>
                                                <td class="align-middle">{{$compliance->title_page}}</td>
                                                <td class="align-middle">{{$compliance->title_banner}}</td>
                                                <td class="align-middle text-center">
                                                    <a href="{{route('comp01.show',['COMP01Compliances' => $compliance->slug])}}" target="_blank" class="mdi mdi-link-variant font-22"></a>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <a href="{{route('admin.comp01.edit',['COMP01Compliances' => $compliance->id])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                                        </div>
                                                        <form action="{{route('admin.comp01.destroy',['COMP01Compliances' => $compliance->id])}}" class="col-4" method="POST">
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
