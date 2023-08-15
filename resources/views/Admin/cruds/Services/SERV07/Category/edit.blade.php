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
                                    <li class="breadcrumb-item"><a href="{{route('admin.serv07.index')}}">{{getTitleModel($configModelsMain, 'Services', 'SERV07')}}</a></li>
                                    <li class="breadcrumb-item active">Editar Categoria</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar Categoria</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#editCategory" data-bs-toggle="tab" aria-expanded="true" class="nav-link active d-flex align-items-center">
                            Categorias
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Editar os campos da categoria"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#sectionCategory" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Seções da categoria
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro de informações para as seções da categoria"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#video" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Galeria de vídeos da categoria
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro de galeria de vídeos"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#galleryCategory" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Galeria de imagens da categoria
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro de galeria de imagens."></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#topicCategory" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Tópicos da categoria
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro da seção Tópicos da categoria."></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#infoCategory" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Informações adicionais
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro de informações complementares que serão mostradas em seções específicas."></i>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="editCategory">
                        {!! Form::model($category, ['route' => ['admin.serv07.category.update', $category->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
                            @include('Admin.cruds.Services.SERV07.Category.form')
                            {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                            <a href="{{route('admin.serv07.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                        {!! Form::close() !!}
                    </div>
                    <div class="tab-pane" id="sectionCategory">
                        @include("Admin.cruds.Services.SERV07.SectionCategory.index",[
                            'sectionsCategory' => $sectionsCategory,
                            'category' => $category
                        ])
                    </div>
                    <div class="tab-pane" id="video">
                        @include("Admin.cruds.Services.SERV07.VideoCategory.index",[
                            'videos' => $videos,
                            'category' => $category
                        ])
                    </div>
                    <div class="tab-pane" id="galleryCategory">
                        @include("Admin.cruds.Services.SERV07.GalleryCategory.index",[
                            'galleriesCategory' => $galleriesCategory,
                            'category' => $category
                        ])
                    </div>
                    <div class="tab-pane" id="topicCategory">
                        @include("Admin.cruds.Services.SERV07.TopicCategory.index",[
                            'topicsCategory' => $topicsCategory,
                            'category' => $category
                        ])
                    </div>
                    <div class="tab-pane" id="infoCategory">
                        @include("Admin.cruds.Services.SERV07.InformationCategory.form")
                    </div>
                </div>
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
