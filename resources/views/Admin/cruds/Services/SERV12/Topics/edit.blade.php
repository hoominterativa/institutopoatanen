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
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.serv12.edit', ['SERV12Services' => $service->id]) }}">{{ $service->title }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">Editar Tópico</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar Tópico</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#editTopic" data-bs-toggle="tab" aria-expanded="true" class="nav-link active d-flex align-items-center">
                            Tópico
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Editar tópico"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#topicGalleries" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Galeria
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro de imagens e/ou vídeos"></i>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="editTopic">
                        {!! Form::model($topic, [ 'route' => ['admin.serv12.topic.update', $topic->id], 'class' => 'parsley-validate','method' => 'PUT', 'files' => true, ]) !!}
                            @include('Admin.cruds.Services.SERV12.Topics.form')
                            {!! Form::button('Salvar', [ 'class' => 'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit', ]) !!}
                            <a href="{{route('admin.serv12.edit', ['SERV12Services' => $service->id])}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                        {!! Form::close() !!}
                    </div>
                    <div class="tab-pane" id="topicGalleries">
                        @include('Admin.cruds.Services.SERV12.TopicGalleries.index', [
                            'galleries' => $topicGalleries,
                            'topic' => $topic
                        ])
                    </div>
                </div> <!-- container -->
            </div>
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
