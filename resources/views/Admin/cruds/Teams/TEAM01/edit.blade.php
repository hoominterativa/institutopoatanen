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
                                    <li class="breadcrumb-item"><a href="{{route('admin.team01.index')}}">{{ getTitleModel($configModelsMain, 'Teams', 'TEAM01') }}</a></li>
                                    <li class="breadcrumb-item active">Editar {{ getTitleModel($configModelsMain, 'Teams', 'TEAM01') }}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar {{ getTitleModel($configModelsMain, 'Teams', 'TEAM01') }}</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#editTeam" data-bs-toggle="tab" aria-expanded="true" class="nav-link active  d-flex align-items-center">
                            {{ getTitleModel($configModelsMain, 'Teams', 'TEAM01') }}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Edição do conteúdo principal"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#socials" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Redes Sociais
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro de redes sociais"></i>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="editTeam">
                        <div class="collapse show" id="formService">
                            {!! Form::model($team, ['route' => ['admin.team01.update', $team->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
                                @include('Admin.cruds.Teams.TEAM01.form')
                                {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                                <a href="{{route('admin.team01.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="tab-pane" id="socials">
                        @include('Admin.cruds.Teams.TEAM01.SocialMedia.index', [
                            'team' => $team,
                            'socials' => $socials,
                        ])
                    </div>
                </div>
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
