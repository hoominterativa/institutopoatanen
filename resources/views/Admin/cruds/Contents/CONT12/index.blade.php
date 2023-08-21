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
                                    <li class="breadcrumb-item active">{{getTitleModel($configModelsMain, 'Contents', 'CONT12')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">{{getTitleModel($configModelsMain, 'Contents', 'CONT12')}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#contents" data-bs-toggle="tab" aria-expanded="true" class="nav-link active d-flex align-items-center">
                            {{getTitleModel($configModelsMain, 'Contents', 'CONT12')}}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro dos conteúdos"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#section" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center" >
                            Informações da seção
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Informações complementares que serão exibidas na home, caso esteja ativa"></i>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane show active" id="contents">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <button id="btSubmitDelete" data-route="{{route('admin.cont12.destroySelected')}}" type="button" class="btn btn-danger btnDelete" style="display: none;">Deletar selecionados</button>
                                            </div>
                                            <div class="col-6">
                                                <a href="{{route('admin.cont12.create')}}" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                                            </div>
                                        </div>
                                        <table class="table table-bordered table-sortable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="50px"></th>
                                                    <th width="30px" class="bs-checkbox">
                                                        <label><input name="btnSelectAll" value="btnDelete" type="checkbox"></label>
                                                    </th>
                                                    <th>Imagem</th>
                                                    <th>Título</th>
                                                    <th>Título do botão</th>
                                                    <th>Link do botão</th>
                                                    <th>Arquivo</th>
                                                    <th width="100px">Status</th>
                                                    <th width="90px">Ações</th>
                                                </tr>
                                            </thead>

                                            <tbody data-route="{{route('admin.cont12.sorting')}}">
                                                @foreach ($contents as $content)
                                                    <tr data-code="{{$content->id}}">
                                                        <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                        <td class="bs-checkbox align-middle">
                                                            <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$content->id}}"></label>
                                                        </td>
                                                        <td class="align-middle avatar-group">
                                                            @if ($content->path_image_icon)
                                                                <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/' . $content->path_image_icon)}})"></div>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle">{{$content->title}}</td>
                                                        <td class="align-middle">{{$content->title_button}}</td>
                                                        <td class="align-middle">
                                                            @if ($content->link_button)
                                                                <a href="{{ $content->link_button }}" target="_blank" class="mdi mdi-link-box-variant mdi-24px"></a>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle">
                                                            @if ($content->path_archive)
                                                                <a href="{{asset('storage/'.$content->path_archive)}}" target="_blank" rel="noopener noreferrer"><i class="mdi mdi-cloud-download font-20"></i></a>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle">
                                                            @if ($content->active)
                                                                <span class="badge bg-success">Ativo</span>
                                                            @else
                                                                <span class="badge bg-danger">Inativo</span>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <a href="{{route('admin.cont12.edit',['CONT12Contents' => $content->id])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                                                </div>
                                                                <form action="{{route('admin.cont12.destroy',['CONT12Contents' => $content->id])}}" class="col-4" method="POST">
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
                    </div>
                    <div class="tab-pane" id="section">
                        @include('Admin.cruds.Contents.CONT12.Section.form')
                    </div>
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesIndex')
@endsection
