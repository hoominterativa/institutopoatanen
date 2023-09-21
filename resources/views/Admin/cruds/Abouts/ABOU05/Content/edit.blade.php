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
                                    <li class="breadcrumb-item"><a href="{{route('admin.abou05.index')}}">{{getTitleModel($configModelsMain, 'Abouts', 'ABOU05')}}</a></li>
                                    <li class="breadcrumb-item active">Editar Conteúdo</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar Conteúdo</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#editContent" data-bs-toggle="tab" aria-expanded="true" class="nav-link active d-flex align-items-center">
                            Conteúdo
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Editar os campos do conteúdo"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#social" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Redes Sociais
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro de informações para as redes sociais"></i>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="editContent">
                        {!! Form::model($content, ['route' => ['admin.abou05.content.update', $content->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
                            @include('Admin.cruds.Abouts.ABOU05.Content.form')
                            {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                            <a href="{{route('admin.abou05.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                        {!! Form::close() !!}
                    </div>
                    <div class="tab-pane" id="social">
                        @include("Admin.cruds.Abouts.ABOU05.Social.index",[
                            'socials' => $socials,
                            'content' => $content,
                        ])
                    </div>
                </div>
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
