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
                                    <li class="breadcrumb-item"><a href="{{route('admin.copa04.index')}}">{{ getTitleModel($configModelsMain, 'ContentPages', 'COPA04')}}</a></li>
                                    <li class="breadcrumb-item active">Editar {{ getTitleModel($configModelsMain, 'ContentPages', 'COPA04')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar {{ getTitleModel($configModelsMain, 'ContentPages', 'COPA04')}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#contentPage" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link active d-flex align-items-center">
                            {{ getTitleModel($configModelsMain, 'ContentPages', 'COPA04')}}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro do título da página e status."></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#sectionHero" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Info. Banner
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro do conteúdo principal"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#sectionVideo" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Seção Vídeo
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro do banner da página"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#sectionHighlighteds" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Seção Destaque
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Esta seção será exibida abaixo do conteúdo principal na página"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#sectionTopic" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Seção Tópico
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Aqui você pode cadastrar um ou mais tópicos"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#topicCarousel" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Seção Carossel
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Esta seção será exibida como complemento dos tópicos"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#sectionGallery" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Seção Galeria
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Esta seção será exibida no final da página."></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#additionalContents" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Seção Conteúdo adicional
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Esta seção será exibida no final da página."></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#additionalTopics" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Seção Tópico adicional
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Esta seção será exibida no final da página."></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#faq" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Seção FAQ
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Esta seção será exibida no final da página."></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#sectionProduct" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Seção Produtos
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Esta seção será exibida no final da página."></i>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="contentPage">
                        {!! Form::model($contentPage, ['route' => ['admin.copa04.update', $contentPage->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
                            @include('Admin.cruds.ContentPages.COPA04.form')
                            {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                            <a href="{{route('admin.copa04.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                        {!! Form::close() !!}
                    </div> <!-- tab-pane -->
                    <div class="tab-pane" id="sectionHero">
                        @include('Admin.cruds.ContentPages.COPA04.SectionHero.form',['contentPage' => $contentPage])
                    </div>
                    <div class="tab-pane" id="sectionVideo">
                        @include('Admin.cruds.ContentPages.COPA04.SectionVideo.index')
                    </div>
                    <div class="tab-pane" id="sectionHighlighteds">
                        @include('Admin.cruds.ContentPages.COPA04.SectionHighlighted.index')
                    </div>
                    <div class="tab-pane" id="sectionTopic">
                        @include('Admin.cruds.ContentPages.COPA04.SectionTopic.index')
                    </div>
                    <div class="tab-pane" id="topicCarousel">
                        @include('Admin.cruds.ContentPages.COPA04.TopicCarousel.index')
                    </div>
                    <div class="tab-pane" id="sectionGallery">
                        @include('Admin.cruds.ContentPages.COPA04.Gallery.index')
                    </div>
                    <div class="tab-pane" id="additionalContents">
                        @include('Admin.cruds.ContentPages.COPA04.AdditionalContent.index')
                    </div>
                    <div class="tab-pane" id="additionalTopics">
                        @include('Admin.cruds.ContentPages.COPA04.AdditionalTopics.index')
                    </div>
                    <div class="tab-pane" id="faq">
                        @include('Admin.cruds.ContentPages.COPA04.Faq.index')
                    </div>
                    <div class="tab-pane" id="sectionProduct">
                        @include('Admin.cruds.ContentPages.COPA04.SectionProducts.index')
                    </div>
                </div> <!-- tab-content -->

            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
