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
                                    <li class="breadcrumb-item active">{{ getTitleModel($configModelsMain, 'Feedbacks', 'FEED01') }}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">{{ getTitleModel($configModelsMain, 'Feedbacks', 'FEED01') }}</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#feedbacks" data-bs-toggle="tab" aria-expanded="true" class="nav-link active d-flex align-items-center">
                            {{ getTitleModel($configModelsMain, 'Feedbacks', 'FEED01') }}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro do conteúdo principal"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#section" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Informações complementares
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro de informações adcionais para o conteúdo principal"></i>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="feedbacks">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <button id="btSubmitDelete" data-route="{{ route('admin.feed01.destroySelected') }}" type="button" class="btn btn-danger btnDeleteFEED01" style="display: none;">Deletar selecionados</button>
                                            </div>
                                            <div class="col-6">
                                                <a href="{{ route('admin.feed01.create') }}" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                                            </div>
                                        </div>
                                        <table class="table table-bordered table-sortable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="50px"></th>
                                                    <th width="30px" class="bs-checkbox">
                                                        <label><input name="btnSelectAll" value="btnDeleteFEED01" type="checkbox"></label>
                                                    </th>
                                                    <th>Imagem</th>
                                                    <th>Nome do usuário</th>
                                                    <th>Cargo</th>
                                                    <th>Depoimento</th>
                                                    <th width="100px">Status</th>
                                                    <th width="90px">Ações</th>
                                                </tr>
                                            </thead>

                                            <tbody data-route="{{ route('admin.feed01.sorting') }}">
                                                @foreach ($feedbacks as $feedback)
                                                    <tr data-code="{{ $feedback->id }}">
                                                        <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                        <td class="bs-checkbox align-middle">
                                                            <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{ $feedback->id }}"></label>
                                                        </td>
                                                        <td class="align-middle avatar-group">
                                                            @if ($feedback->path_image)
                                                                <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{ asset('storage/' . $feedback->path_image) }})"></div>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle">{{ $feedback->name }}</td>
                                                        <td class="align-middle">{{ $feedback->profession }}</td>
                                                        <td class="align-middle">{!! $feedback->testimony !!}</td>
                                                        <td class="align-middle">
                                                            @switch($feedback->active)
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
                                                                    <a href="{{ route('admin.feed01.edit', ['FEED01Feedbacks' => $feedback->id]) }}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                                                </div>
                                                                <form action="{{ route('admin.feed01.destroy', ['FEED01Feedbacks' => $feedback->id]) }}" class="col-4" method="POST">
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
                        @include("Admin.cruds.Feedbacks.FEED01.Section.form")
                    </div>
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesIndex')
@endsection
