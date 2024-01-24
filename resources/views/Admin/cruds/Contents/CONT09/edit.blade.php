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
                                    <li class="breadcrumb-item"><a href="{{route('admin.cont09.index')}}">{{getTitleModel($configModelsMain, 'Contents', 'CONT09')}}</a></li>
                                    <li class="breadcrumb-item active">Editar {{getTitleModel($configModelsMain, 'Contents', 'CONT09')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar {{getTitleModel($configModelsMain, 'Contents', 'CONT09')}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#contents" data-bs-toggle="tab" aria-expanded="true" class="nav-link active d-flex align-items-center">
                            {{ getTitleModel($configModelsMain, 'Contents', 'CONT09') }}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Edição do conteúdo principal"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#topics" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Tópicos em destaque
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Estes tópicos serão exibidos na home. Exemplos: Redes sociais"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#section" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Seção adicional dos tópicos
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Informações complementares para os tópicos"></i>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="contents">
                        {!! Form::model($content, ['route' => ['admin.cont09.update', $content->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
                            @include('Admin.cruds.Contents.CONT09.form')
                            {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                            <a href="{{route('admin.cont09.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                        {!! Form::close() !!}
                    </div>
                    <div class="tab-pane" id="topics">
                        @include('Admin.cruds.Contents.CONT09.Topics.index', [
                            'topics' => $topics,
                            'content' => $content
                        ])
                    </div>
                    <div class="tab-pane" id="section">
                        @include('Admin.cruds.Contents.CONT09.Section.form')
                    </div>
                </div>
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
