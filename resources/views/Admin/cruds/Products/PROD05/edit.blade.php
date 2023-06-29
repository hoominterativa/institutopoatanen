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
                                    <li class="breadcrumb-item"><a href="{{route('admin.prod05.index')}}">{{ getTitleModel($configModelsMain, 'Products', 'PROD05')}}</a></li>
                                    <li class="breadcrumb-item active">Editar {{ getTitleModel($configModelsMain, 'Products', 'PROD05')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar {{ getTitleModel($configModelsMain, 'Products', 'PROD05')}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#product" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center active">
                            {{getTitleModel($configModelsMain, 'Products', 'PROD05')}}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Editar produto"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#bannerProduct" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Banner
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Este banner será exibido na página desse produto"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#galleryType" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Cores da Galeria
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Gerencie as cores das galerias"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#gallery" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Galeria com opções
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Categoriaze as imagens do produto"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#gallerySection" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Galeria de imagens
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastre imagens soltas para o produto"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#topicCategory" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center" >
                            Categorias Tópicos
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Categorias paras os Tópicos com Informações complementares"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#topics" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center" >
                            Tópicos
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Informações complementares para o produto"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#topicSection" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center" >
                            Seção de Tópicos
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Informações para a seção de tópicos"></i>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="product">
                        {!! Form::model($product, ['route' => ['admin.prod05.update', $product->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
                            @include('Admin.cruds.Products.PROD05.form')
                            {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                            <a href="{{route('admin.prod05.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                        {!! Form::close() !!}
                    </div>
                    {{-- END .tab-pane --}}
                    <div class="tab-pane" id="bannerProduct">
                        @include('Admin.cruds.Products.PROD05.BannerProduct.form',[
                            'product' => $product
                        ])
                    </div>
                    {{-- END .tab-pane --}}
                    <div class="tab-pane" id="galleryType">
                        @include('Admin.cruds.Products.PROD05.GalleryType.index',[
                            'galleryTypes' => $galleryTypes,
                            'product' => $product
                        ])
                    </div>
                    {{-- END .tab-pane --}}
                    <div class="tab-pane" id="gallery">
                        @include('Admin.cruds.Products.PROD05.Gallery.index',[
                            'galleryTypes' => $galleryTypes,
                            'product' => $product
                        ])
                    </div>
                    {{-- END .tab-pane --}}
                    <div class="tab-pane" id="gallerySection">
                        @include('Admin.cruds.Products.PROD05.GallerySection.index',[
                            'galleriesSection' => $galleriesSection,
                            'product' => $product
                        ])
                    </div>
                    {{-- END .tab-pane --}}
                    <div class="tab-pane" id="topicCategory">
                        @include('Admin.cruds.Products.PROD05.TopicCategory.index',[
                            'topicCategories' => $topicCategories,
                            'product' => $product
                        ])
                    </div>
                    {{-- END .tab-pane --}}
                    <div class="tab-pane" id="topics">
                        @include('Admin.cruds.Products.PROD05.Topic.index',[
                            'topicCategories' => $topicCategories,
                            'topics' => $topics,
                            'product' => $product
                        ])
                    </div>
                    {{-- END .tab-pane --}}
                    <div class="tab-pane" id="topicSection">
                        @include('Admin.cruds.Products.PROD05.TopicSection.form',[
                            'product' => $product
                        ])
                    </div>
                    {{-- END .tab-pane --}}
                </div>
                {{-- END .tab-content --}}
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
