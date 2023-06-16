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
                                    <li class="breadcrumb-item"><a href="{{route('admin.unit03.index')}}">{{getTitleModel($configModelsMain, 'Units', 'UNIT03')}}</a></li>
                                    <li class="breadcrumb-item active">Editar {{getTitleModel($configModelsMain, 'Units', 'UNIT03')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar {{getTitleModel($configModelsMain, 'Units', 'UNIT03')}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#editUnit" data-bs-toggle="tab" aria-expanded="true" class="nav-link active  d-flex align-items-center">
                            {{ getTitleModel($configModelsMain, 'Units', 'UNIT03') }}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Edição do conteúdo principal"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#bannerShow" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Banner Interno
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro do banner para a página interna"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#topics" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Tópicos
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro de tópicos"></i>
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
                    <li class="nav-item">
                        <a href="#content" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Conteúdo
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastrar conteúdos"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#gallery" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Galeria
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastrar galeria"></i>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="editUnit">
                        <div class="collapse show" id="formService">
                            {!! Form::model($unit, ['route' => ['admin.unit03.update', $unit->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
                                @include('Admin.cruds.Units.UNIT03.form')
                                {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                                <a href="{{route('admin.unit03.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="tab-pane" id="bannerShow">
                        @include('Admin.cruds.Units.UNIT03.BannerShow.form', [
                            'unit' => $unit,
                            'bannerShow' => $bannerShow,
                        ])
                    </div>
                    <div class="tab-pane" id="topics">
                        @include('Admin.cruds.Units.UNIT03.Topic.index', [
                            'unit' => $unit,
                            'topics' => $topics,
                        ])
                    </div>
                    <div class="tab-pane" id="socials">
                        @include('Admin.cruds.Units.UNIT03.Social.index', [
                            'unit' => $unit,
                            'socials' => $socials,
                        ])
                    </div>
                    <div class="tab-pane" id="content">
                        @include('Admin.cruds.Units.UNIT03.Content.index', [
                            'unit' => $unit,
                            'contents' => $contents,
                        ])
                    </div>
                    <div class="tab-pane" id="gallery">
                        @include('Admin.cruds.Units.UNIT03.Gallery.index', [
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
