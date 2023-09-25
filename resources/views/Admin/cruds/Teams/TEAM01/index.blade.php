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
                                    <li class="breadcrumb-item active">{{ getTitleModel($configModelsMain, 'Teams', 'TEAM01') }}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">{{ getTitleModel($configModelsMain, 'Teams', 'TEAM01') }}</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#categories" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Categorias
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastre as categorias"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#teams" data-bs-toggle="tab" aria-expanded="true" class="nav-link active d-flex align-items-center">
                            {{ getTitleModel($configModelsMain, 'Teams', 'TEAM01') }}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro do conteúdo principal"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#sectionTeam" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Seção Equipe
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Seção complementar do conteúdo principal"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#banner" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Banner
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Este banner será exibido na página interna"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#section" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center" >
                            Informações da seção equipe para home
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Informações complementares que serão exibidas na home, caso esteja ativa"></i>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="teams">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-3">
                                                @include('Admin.cruds.Teams.TEAM01.filter',[
                                                    'categories' => $categories
                                                ])
                                            </div>
                                            <div class="col-4">
                                                <button id="btSubmitDelete" data-route="{{route('admin.team01.destroySelected')}}" type="button" class="btn btn-danger btnDeleteTeams" style="display: none;">Deletar selecionados</button>
                                            </div>
                                            <div class="col-5">
                                                <a href="{{route('admin.team01.create')}}" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                                            </div>
                                        </div>
                                        <table class="table table-bordered table-sortable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="50px"></th>
                                                    <th width="30px" class="bs-checkbox">
                                                        <label><input name="btnSelectAll" value="btnDeleteTeams" type="checkbox"></label>
                                                    </th>
                                                    <th>Imagem</th>
                                                    <th>Categoria</th>
                                                    <th>Título/Subtítulo</th>
                                                    <th>Descrição</th>
                                                    <th>Texto</th>
                                                    <th>Título Botão</th>
                                                    <th>Link Botão</th>
                                                    <th width="100px">Status</th>
                                                    <th width="90px">Ações</th>
                                                </tr>
                                            </thead>

                                            <tbody data-route="{{route('admin.team01.sorting')}}">
                                                @foreach ($teams as $team)
                                                    <tr data-code="{{$team->id}}">
                                                        <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                        <td class="bs-checkbox align-middle">
                                                            <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$team->id}}"></label>
                                                        </td>
                                                        <td class="align-middle avatar-group">
                                                            @if ($team->path_image_icon)
                                                                <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/' . $team->path_image_icon)}})"></div>
                                                            @endif
                                                            @if ($team->path_image_box)
                                                            <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/' . $team->path_image_box)}})"></div>
                                                        @endif
                                                        </td>
                                                        <td class="align-middle">{{$team->category->title}}</td>
                                                        <td class="align-middle">{{$team->title}} <b>/</b> {{$team->subtitle}}</td>
                                                        <td class="align-middle">{!! substr($team->description, 0, 25 ) !!}</td>
                                                        <td class="align-middle">{!! substr($team->text, 0, 30) !!}</td>
                                                        <td class="align-middle">{{$team->title_button}}</td>
                                                        <td class="align-middle"><a href="{{ $team->link_button }}" target="_blank" class="mdi mdi-link-box-variant mdi-24px"></a></td>
                                                        <td class="align-middle">
                                                            @if ($team->active)
                                                                <span class="badge bg-success">Ativo</span>
                                                            @else
                                                                <span class="badge bg-danger">Inativo</span>
                                                            @endif
                                                            @if ($team->featured)
                                                                <span class="badge bg-primary text-white">Destaque</span>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <a href="{{route('admin.team01.edit',['TEAM01Teams' => $team->id])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                                                </div>
                                                                <form action="{{route('admin.team01.destroy',['TEAM01Teams' => $team->id])}}" class="col-4" method="POST">
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
                                            {{$teams->links()}}
                                        </div>
                                    </div>
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div>
                    </div>
                    <div class="tab-pane" id="categories">
                        @include('Admin.cruds.Teams.TEAM01.Category.index', [
                            'categories' => $teamsCategories
                        ])
                    </div>
                    <div class="tab-pane" id="sectionTeam">
                        @include('Admin.cruds.Teams.TEAM01.SectionTeam.form', [
                            'sectionTeam' => $sectionTeam
                        ])
                    </div>
                    <div class="tab-pane" id="banner">
                        @include('Admin.cruds.Teams.TEAM01.Banner.form', [
                            'banner' => $banner
                        ])
                    </div>
                    <div class="tab-pane" id="section">
                        @include('Admin.cruds.Teams.TEAM01.Section.form', [
                            'section' => $section
                        ])
                    </div>
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesIndex')
@endsection
