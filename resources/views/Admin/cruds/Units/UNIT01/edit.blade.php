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
                                    <li class="breadcrumb-item"><a href="{{route('admin.unit01.index')}}">{{getTitleModel ($configModelsMain, 'Units', 'UNIT01')}}</a></li>
                                    <li class="breadcrumb-item active">Editar {{getTitleModel ($configModelsMain, 'Units', 'UNIT01')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar {{getTitleModel ($configModelsMain, 'Units', 'UNIT01')}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#unit" data-bs-toggle="tab" aria-expanded="true" class="nav-link active d-flex align-items-center">
                            {{ getTitleModel($configModelsMain, 'Units', 'UNIT01') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#topic" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Tópicos
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="Cadastro de tópicos com links."></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#galleries" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Galeria
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="Você pode cadastrar múltiplas imagens."></i>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="unit">
                        <div class="collapse show" id="formService">
                            {!! Form::model($unit, ['route' => ['admin.unit01.update', $unit->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
                                @include('Admin.cruds.Units.UNIT01.form')
                                {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                                <a href="{{route('admin.unit01.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="tab-pane" id="topic">
                        @include('Admin.cruds.Units.UNIT01.Topics.index', [
                            'unit' => $unit,
                            'topics' => $topics,
                        ])
                    </div>
                    <div class="tab-pane" id="galleries">
                        @include('Admin.cruds.Units.UNIT01.Galleries.index', [
                            'unit' => $unit,
                            'galleries' => $galleries,
                        ])
                    </div>

                </div>
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
