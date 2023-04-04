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
                                    <li class="breadcrumb-item active">{{getTitleModel($configModelsMain, 'Contents', 'CONT09')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">{{getTitleModel($configModelsMain, 'Contents', 'CONT09')}}</h4>
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
                                        <button id="btSubmitDelete" data-route="{{route('admin.cont09.destroySelected')}}" type="button" class="btn btn-danger btnDeleteContents" style="display: none;">Deletar selecionados</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{route('admin.cont09.create')}}" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                                    </div>
                                </div>
                                <table class="table table-bordered table-sortable">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50px"></th>
                                            <th width="30px" class="bs-checkbox">
                                                <label><input name="btnSelectAll" value="btnDeleteContents" type="checkbox"></label>
                                            </th>
                                            <th>Imagem</th>
                                            <th>Título</th>
                                            <th>Subtítulo</th>
                                            <th>Link</th>
                                            <th>Job Title</th>
                                            <th>DOB</th>
                                            <th width="100px">Status</th>
                                            <th width="90px">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody data-route="{{route('admin.cont09.sorting')}}">
                                        @foreach ($contents as $content)
                                            <tr data-code="{{$content->id}}">
                                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                <td class="bs-checkbox align-middle">
                                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$content->id}}"></label>
                                                </td>
                                                <td class="align-middle avatar-group">
                                                    @if ($content->path_image_desktop)
                                                        <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/' . $content->path_image_desktop)}})"></div>
                                                    @endif
                                                </td>
                                                <td class="align-middle">Boudreaux</td>
                                                <td class="align-middle">Traffic Court Referee</td>
                                                <td class="align-middle">22 Jun 1972</td>
                                                <td class="align-middle">22 Jun 1972</td>
                                                <td class="align-middle">
                                                    <span class="badge bg-success">Ativo</span>
                                                    <span class="badge bg-primary text-white">Destaque</span>
                                                    <span class="badge bg-danger">Inativo</span>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <a href="{{route('admin.cont09.edit',['CONT09Contents' => $content->id])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                                        </div>
                                                        <form action="{{route('admin.cont09.destroy',['CONT09Contents' => $content->id])}}" class="col-4" method="POST">
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
                                    {{$contents->links()}}
                                </div>
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
