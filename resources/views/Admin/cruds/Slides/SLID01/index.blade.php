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
                                    <li class="breadcrumb-item active">Banners</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Banners</h4>
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
                                        <button id="btSubmitDelete" data-route="{{route('admin.slid01.destroySelected')}}" type="button" class="btn btn-danger" style="display: none;">Deletar selecionados</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{route('admin.slid01.create')}}" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                                    </div>
                                </div>
                                <table class="table table-bordered table-sortable">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50px"></th>
                                            <th width="30px" class="bs-checkbox">
                                                <label><input name="btSelectAll" type="checkbox"></label>
                                            </th>
                                            <th width="40px"></th>
                                            <th>Título</th>
                                            <th>Subtítulo</th>
                                            <th class="text-center" width="100px">Posição do conteúdo</th>
                                            <th class="text-center" width="100px">Status</th>
                                            <th class="text-center" width="90px">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody data-route="{{route('admin.slid01.sorting')}}">
                                        @foreach ($slides as $slide)
                                            <tr data-code="{{$slide->id}}">
                                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                <td class="bs-checkbox align-middle">
                                                    <label><input name="btSelectItem" class="btSelectItem" type="checkbox" value="{{$slide->id}}"></label>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/'.$slide->path_image_desktop)}})"></div>
                                                </td>
                                                <td class="align-middle">{{$slide->title}}</td>
                                                <td class="align-middle">{{$slide->subtitle}}</td>
                                                <td class="align-middle">
                                                    @switch($slide->position_content)
                                                        @case('start') <span class="badge bg-info">a esquerda</span> @break
                                                        @case('center') <span class="badge bg-info">no centro</span> @break
                                                        @case('end') <span class="badge bg-info">a direita</span> @break
                                                    @endswitch
                                                </td>
                                                <td class="align-middle">
                                                    @switch($slide->active)
                                                        @case(1) <span class="badge bg-success">Ativo</span> @break
                                                        @case(0) <span class="badge bg-danger">Inativo</span> @break
                                                    @endswitch
                                                </td>
                                                <td class="align-middle">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <a href="{{route('admin.slid01.edit',['SLID01Slides' => $slide->id])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                                        </div>
                                                        <form action="{{route('admin.slid01.destroy',['SLID01Slides' => $slide->id])}}" class="col-4" method="POST">
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
