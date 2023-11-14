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
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('admin.port04.index') }}">{{ getTitleModel($configModelsMain, 'Portfolios', 'PORT04') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">Editar
                                        {{ getTitleModel($configModelsMain, 'Portfolios', 'PORT04') }}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar {{ getTitleModel($configModelsMain, 'Portfolios', 'PORT04') }}
                            </h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#editPortfolios" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link active d-flex align-items-center">
                            {{ getTitleModel($configModelsMain, 'Portfolios', 'PORT04') }}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Edição do conteúdo principal"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#bannerInner" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Banner da página interna
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cada portfólio terá seu banner interno"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#contentInner" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Conteúdo da página interna
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cada portfólio terá uma seção conteúdo, que será apresentado abaixo do banner interno"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#additionalTopics" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Tópicos adicionais
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro de tópicos adicionais"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#topics" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Tópicos
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro dos tópicos"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#gallery" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Galeria
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro de uma ou mais imagens"></i>
                        </a>
                    </li>

                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="editPortfolios">
                        {!! Form::model($portfolio, [
                            'route' => ['admin.port04.update', $portfolio->id],
                            'class' => 'parsley-validate',
                            'method' => 'PUT',
                            'files' => true,
                        ]) !!}
                        {!! Form::hidden('active_banner', $portfolio->active_banner) !!}
                        {!! Form::hidden('active_content', $portfolio->active_content) !!}

                        @include('Admin.cruds.Portfolios.PORT04.form')
                        {!! Form::button('Salvar', [
                            'class' => 'btn btn-primary waves-effect waves-light float-end me-3 width-lg',
                            'type' => 'submit',
                        ]) !!}
                        <a href="{{ route('admin.port04.index') }}"
                            class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                        {!! Form::close() !!}
                    </div>
                    <div class="tab-pane" id="bannerInner">
                        @include('Admin.cruds.Portfolios.PORT04.BannerInner.form')
                    </div>
                    <div class="tab-pane" id="contentInner">
                        @include('Admin.cruds.Portfolios.PORT04.ContentInner.form')
                    </div>
                    <div class="tab-pane" id="additionalTopics">
                        @include('Admin.cruds.Portfolios.PORT04.AdditionalTopics.index', [
                            'additionalTopics' => $additionalTopics,
                            'portfolio' => $portfolio,
                        ])
                    </div>
                    <div class="tab-pane" id="topics">
                        @include('Admin.cruds.Portfolios.PORT04.Topics.index', [
                            'topics' => $topics,
                            'portfolio' => $portfolio,
                        ])
                    </div>
                    <div class="tab-pane" id="gallery">
                        @include('Admin.cruds.Portfolios.PORT04.Gallery.index', [
                            'galleries' => $galleries,
                            'portfolio' => $portfolio,
                        ])
                    </div>

                </div>
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
