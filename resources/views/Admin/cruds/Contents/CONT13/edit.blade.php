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
                                    <li class="breadcrumb-item"><a href="{{route('admin.cont13.index')}}">{{getTitleModel($configModelsMain, 'Contents', 'CONT13')}}</a></li>
                                    <li class="breadcrumb-item active">Editar {{getTitleModel($configModelsMain, 'Contents', 'CONT13')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar {{getTitleModel($configModelsMain, 'Contents', 'CONT13')}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#editContents" data-bs-toggle="tab" aria-expanded="true" class="nav-link active d-flex align-items-center">
                            {{getTitleModel($configModelsMain, 'Contents', 'CONT13')}}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Edição do conteúdo principal"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#galleries" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center" >
                            Galeria
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro de imagens"></i>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="editContents">
                        {!! Form::model($content, ['route' => ['admin.cont13.update', $content->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
                            @include('Admin.cruds.Contents.CONT13.form')
                            {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                            <a href="{{route('admin.cont13.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                        {!! Form::close() !!}
                    </div>
                    <div class="tab-pane" id="galleries">
                        @include('Admin.cruds.Contents.CONT13.Gallery.index',[
                            'galleries' => $galleries,
                            '$content' => $content
                        ])
                    </div>
                </div>
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
