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
                                    <li class="breadcrumb-item active">{{getTitleModel($configModelsMain, 'Contents', 'CONT13')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">{{getTitleModel($configModelsMain, 'Contents', 'CONT13')}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#contents" data-bs-toggle="tab" aria-expanded="true" class="nav-link active d-flex align-items-center">
                            {{getTitleModel($configModelsMain, 'Contents', 'CONT13')}}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro do conteúdo principal"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#section" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center" >
                            Informações da seção
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Informações complementares que serão exibidas na home"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#topic" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center" >
                            Tópicos
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro dos tópicos"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#sectionTopic" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center" >
                            Informações da seção tópicos
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Informações complementares dos tópicos"></i>
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
                                                <button id="btSubmitDelete" data-route="{{route('admin.cont13.destroySelected')}}" type="button" class="btn btn-danger btnDeleteContents" style="display: none;">Deletar selecionados</button>
                                            </div>
                                            <div class="col-6">
                                                <a href="{{route('admin.cont13.create')}}" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
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
                                                    <th>Texto</th>
                                                    <th>Link</th>
                                                    <th width="100px">Status</th>
                                                    <th width="90px">Ações</th>
                                                </tr>
                                            </thead>

                                            <tbody data-route="{{route('admin.cont13.sorting')}}">
                                                @foreach ($contents as $content)
                                                    <tr data-code="{{$content->id}}">
                                                        <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                        <td class="bs-checkbox align-middle">
                                                            <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$content->id}}"></label>
                                                        </td>
                                                        <td class="align-middle avatar-group">
                                                            @if ($content->path_image || $content->path_image_desktop || $content->path_image_mobile)
                                                                <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/' . $content->path_image)}})"></div>
                                                                <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/' . $content->path_image_desktop)}})"></div>
                                                                <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/' . $content->path_image_mobile)}})"></div>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle">{{$content->title}}</td>
                                                        <td class="align-middle">{{$content->subtitle}}</td>
                                                        <td class="align-middle">{!! substr($content->text , 0, 50) !!}<b>...</b></td>
                                                        <td class="align-middle">
                                                            @if ($content->link)
                                                                <a href="{{ $content->link }}" target="_blank" class="mdi mdi-link-box-variant mdi-24px"></a>
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
                                                                    <a href="{{route('admin.cont13.edit',['CONT13Contents' => $content->id])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                                                </div>
                                                                <form action="{{route('admin.cont13.destroy',['CONT13Contents' => $content->id])}}" class="col-4" method="POST">
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
                        @include('Admin.cruds.Contents.CONT13.Section.form')
                    </div>
                    <div class="tab-pane" id="topic">
                        @include('Admin.cruds.Contents.CONT13.Topics.index')
                    </div>
                    <div class="tab-pane" id="sectionTopic">
                        @include('Admin.cruds.Contents.CONT13.SectionTopic.form')
                    </div>
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesIndex')
@endsection
