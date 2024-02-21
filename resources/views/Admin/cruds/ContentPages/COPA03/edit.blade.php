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
                                    <li class="breadcrumb-item"><a href="{{route('admin.copa03.index')}}">{{ getTitleModel($configModelsMain, 'ContentPages', 'COPA03')}}</a></li>
                                    <li class="breadcrumb-item active">Editar {{ getTitleModel($configModelsMain, 'ContentPages', 'COPA03')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar {{ getTitleModel($configModelsMain, 'ContentPages', 'COPA03')}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#editContentPage" data-bs-toggle="tab" aria-expanded="true" class="nav-link active d-flex align-items-center">
                            {{getTitleModel($configModelsMain, 'ContentPages', 'COPA03')}}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Edição do conteúdo principal"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#categories" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Categorias
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Aqui você pode cadastrar uma ou mais categorias"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#subcategoryTopics" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Subcategorias dos tópicos
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Aqui você pode cadastrar uma ou mais subcategorias para os tópicos"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#subcategoryVideos" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Subcategorias dos vídeos
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Aqui você pode cadastrar uma ou mais subcategorias para os vídeos"></i>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="editContentPage">
                        {!! Form::model($contentPage, ['route' => ['admin.copa03.update', $contentPage->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
                            @include('Admin.cruds.ContentPages.COPA03.form')
                            {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                            <a href="{{route('admin.copa03.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                        {!! Form::close() !!}
                    </div>
                    <div class="tab-pane" id="categories">
                        @include('Admin.cruds.ContentPages.COPA03.Category.index', [
                            'categories' => $categories,
                            'contentPage' => $contentPage
                        ])
                    </div>
                    <div class="tab-pane" id="subcategoryTopics">
                        @include('Admin.cruds.ContentPages.COPA03.SubcategoryTopics.index', [
                            'categoriesExists' => $categoriesExists,
                            'subcategoryTopics' => $subcategoryTopics
                        ])
                    </div>
                    <div class="tab-pane" id="subcategoryVideos">
                        @include('Admin.cruds.ContentPages.COPA03.SubcategoryVideos.index', [
                            'categoriesExists' => $categoriesExists,
                            'subcategoryVideos' => $subcategoryVideos
                        ])
                    </div>
                </div>
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
