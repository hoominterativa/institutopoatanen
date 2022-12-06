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
                                    <li class="breadcrumb-item active">{{$configModelsMain->WorkWith->WOWI01->config->titlePanel}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">{{$configModelsMain->WorkWith->WOWI01->config->titlePanel}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#infoPage" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                            Lista de Páginas
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Listagem das páginas de conteúdos"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#sectionPage" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                            Seções da Página
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Informações que serão exibidas na seção que aparece na Home do site caso esteja ativada"></i>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane show active" id="infoPage">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <button id="btSubmitDelete" data-route="{{route('admin.wowi01.destroySelected')}}" type="button" class="btn btn-danger btnDeleteWorkWith" style="display: none;">Deletar selecionados</button>
                                            </div>
                                            <div class="col-6">
                                                <a href="{{route('admin.wowi01.create')}}" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                                            </div>
                                        </div>
                                        <table class="table table-bordered table-sortable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="50px"></th>
                                                    <th width="30px" class="bs-checkbox">
                                                        <label><input name="btnSelectAll" value="btnDeleteWorkWith" type="checkbox"></label>
                                                    </th>
                                                    <th></th>
                                                    <th>Título</th>
                                                    <th>description</th>
                                                    <th width="100px">Status</th>
                                                    <th width="90px">Ações</th>
                                                </tr>
                                            </thead>

                                            <tbody data-route="{{route('admin.wowi01.sorting')}}">
                                                @foreach ($workwiths as $workwith)
                                                    <tr data-code="{{$workwith->id}}">
                                                        <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                        <td class="bs-checkbox align-middle">
                                                            <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$workwith->id}}"></label>
                                                        </td>
                                                        <td class="align-middle avatar-group">
                                                            @if ($workwith->path_image_icon)
                                                                <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/'.$workwith->path_image_icon)}})"></div>
                                                            @endif
                                                            @if ($workwith->path_image_thumbnail)
                                                                <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/'.$workwith->path_image_thumbnail)}})"></div>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle">{{$workwith->title_box}}</td>
                                                        <td class="align-middle">{{$workwith->description}}</td>
                                                        <td class="align-middle">
                                                            @if ($workwith->active)
                                                                <span class="badge bg-success">Ativo</span>
                                                            @else
                                                                <span class="badge bg-danger">Inativo</span>
                                                            @endif
                                                            @if ($workwith->featured_menu)
                                                                <span class="badge bg-primary text-white">Exibindo no menu do site</span>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <a href="{{route('admin.wowi01.edit',['WOWI01WorkWith' => $workwith->id])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                                                </div>
                                                                <form action="{{route('admin.wowi01.destroy',['WOWI01WorkWith' => $workwith->id])}}" class="col-4" method="POST">
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
                    </div>
                    {{-- END .tab-pane --}}
                    <div class="tab-pane" id="sectionPage">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        @include('Admin.cruds.WorkWith.WOWI01.Section.form',[
                                            'section' => $section
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- END .tab-content --}}
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesIndex')
@endsection
