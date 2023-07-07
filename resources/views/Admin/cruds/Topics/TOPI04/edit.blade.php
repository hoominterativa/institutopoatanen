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
                                    <li class="breadcrumb-item"><a href="{{route('admin.topi04.index')}}">{{getTitleModel($configModelsMain, 'Topics', 'TOPI04')}}</a></li>
                                    <li class="breadcrumb-item active">Editar {{getTitleModel($configModelsMain, 'Topics', 'TOPI04')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar {{getTitleModel($configModelsMain, 'Topics', 'TOPI04')}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#topic" data-bs-toggle="tab" aria-expanded="true" class="nav-link active d-flex align-items-center">
                            {{ getTitleModel($configModelsMain, 'Topics', 'TOPI04') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#topicSection" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Tópicos em destaque
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="Esta seção exibira os tópicos em destaque."></i>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="topic">
                        <div class="collapse show" id="formService">
                            {!! Form::model($topic, ['route' => ['admin.topi04.update', $topic->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
                                @include('Admin.cruds.Topics.TOPI04.form')
                                {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                                <a href="{{route('admin.topi04.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="tab-pane" id="topicSection">
                        @include('Admin.cruds.Topics.TOPI04.TopicSection.index', [
                            'topic' => $topic,
                            'topicSections' => $topicSections,
                        ])
                    </div>
                </div>
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
