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
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">{{ getTitleModel($configModelsMain, 'Topics', 'TOPI102') }}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">{{ getTitleModel($configModelsMain, 'Topics', 'TOPI102') }}</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->
                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#topic" data-bs-toggle="tab" aria-expanded="true"class="nav-link active d-flex align-items-center">
                            {{ getTitleModel($configModelsMain, 'Topics', 'TOPI102') }}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro do conteúdo principal"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#featuredtopic" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Tópicos em destaque
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Estes tópicos serão exibidos na página com a listagem de todos os serviços"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#section" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Informações da seção home
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Informações complementares que serão exibidas na home, caso esteja ativa"></i>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane show active" id="topic">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <button id="btSubmitDelete" data-route="{{ route('admin.topi102.destroySelected') }}" type="button"class="btn btn-danger btnDeleteTOPI102" style="display: none;">Deletar selecionados</button>
                                            </div>
                                            <div class="col-6">
                                                <a href="{{ route('admin.topi102.create') }}" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                                            </div>
                                        </div>
                                        <table class="table table-bordered table-sortable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="50px"></th>
                                                    <th width="30px" class="bs-checkbox">
                                                        <label>
                                                            <input name="btnSelectAll" value="btnDeleteTOPI102" type="checkbox">
                                                        </label>
                                                    </th>
                                                    <th>Imagem</th>
                                                    <th>Título/Subtítulo</th>
                                                    <th>Descrição</th>
                                                    <th>Link botão</th>
                                                    <th width="100px">Status</th>
                                                    <th width="90px">Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody data-route="{{ route('admin.topi102.sorting') }}">
                                                @foreach ($topics as $topic)
                                                    <tr data-code="{{ $topic->id }}">
                                                        <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                        <td class="bs-checkbox align-middle">
                                                            <label>
                                                                <input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{ $topic->id }}">
                                                            </label>
                                                        </td>
                                                        <td class="align-middle avatar-group">
                                                            @if ($topic->path_image_box)
                                                                <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{ asset('storage/' . $topic->path_image_box) }})"></div>
                                                            @endif
                                                            @if ($topic->path_image_lightbox)
                                                                <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{ asset('storage/' . $topic->path_image_lightbox) }})"></div>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle">{{ $topic->title }} <b>/</b> {{$topic->subtitle}}</td>
                                                        <td class="align-middle">{!! Str::limit($topic->description, 25) !!}</td>
                                                        <td class="align-middle">
                                                            @if ($topic->link_button)
                                                                <a href="{{$topic->link_button}}" target="_blank" class="mdi mdi-link-box-variant mdi-24px"></a>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle">
                                                            @switch($topic->active)
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
                                                                    <a href="{{ route('admin.topi102.edit', ['TOPI102Topics' => $topic->id]) }}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                                                </div>
                                                                <form action="{{ route('admin.topi102.destroy', ['TOPI102Topics' => $topic->id]) }}" class="col-4" method="POST">
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
                    <div class="tab-pane" id="featuredtopic">
                        @include('Admin.cruds.Topics.TOPI102.FeaturedTopics.index')
                    </div>
                    <div class="tab-pane" id="section">
                        @include('Admin.cruds.Topics.TOPI102.Section.form')
                    </div>
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesIndex')
@endsection
