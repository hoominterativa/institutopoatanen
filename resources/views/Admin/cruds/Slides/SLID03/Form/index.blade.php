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
                                    <li class="breadcrumb-item"><a href="{{route('admin.slid03.index')}}">{{getTitleModel($configModelsMain, 'Slides', 'SLID03')}}</a></li>
                                    <li class="breadcrumb-item active">Cadastro {{getTitleModel($configModelsMain, 'Slides', 'SLID03')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Cadastrar {{getTitleModel($configModelsMain, 'Slides', 'SLID03')}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#slide" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center active">
                            Informações do Banner
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastrar informações para o slide"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#form" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center" >
                            Informações do Formulário
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastrar informações para exibição do formulário"></i>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane show active" id="slide">
                        @include('Admin.cruds.Slides.SLID03.form')
                    </div>
                    <div class="tab-pane show active" id="form">

                    </div>
                </div>
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
