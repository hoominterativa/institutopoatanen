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
                                    <li class="breadcrumb-item"><a href="{{route('admin.serv12.index')}}">{{ getTitleModel($configModelsMain, 'Services', 'SERV12')}}</a></li>
                                    <li class="breadcrumb-item active">Editar {{ getTitleModel($configModelsMain, 'Services', 'SERV12')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar {{ getTitleModel($configModelsMain, 'Services', 'SERV12')}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#editService" data-bs-toggle="tab" aria-expanded="true" class="nav-link active d-flex align-items-center">
                            {{getTitleModel($configModelsMain, 'Services', 'SERV12')}}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Edição do conteúdo principal"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#topics" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Tópicos
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro dos tópicos"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#video" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Vídeo
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro do vídeo"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#galleries" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Galeria
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro de uma ou mais imagens"></i>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="editService">
                        {!! Form::model($service, ['route' => ['admin.serv12.update', $service->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
                            @include('Admin.cruds.Services.SERV12.form')
                            {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                            <a href="{{route('admin.serv12.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                        {!! Form::close() !!}
                    </div>
                    <div class="tab-pane" id="topics">
                        @include('Admin.cruds.Services.SERV12.Topics.index', [
                            'topics' => $topics,
                            'service' => $service
                        ])
                    </div>
                    <div class="tab-pane" id="video">
                        @include('Admin.cruds.Services.SERV12.Video.form', [
                            'video' => $video,
                            'service' => $service
                        ])
                    </div>
                    <div class="tab-pane" id="galleries">
                        @include('Admin.cruds.Services.SERV12.Galleries.index', [
                            'galleries' => $galleries,
                            'service' => $service
                        ])
                    </div>
                </div>
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
