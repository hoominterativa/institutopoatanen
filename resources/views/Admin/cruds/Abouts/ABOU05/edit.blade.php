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
                                    <li class="breadcrumb-item"><a href="{{route('admin.abou05.index')}}">{{ getTitleModel($configModelsMain, 'Abouts', 'ABOU05')}}</a></li>
                                    <li class="breadcrumb-item active">Editar {{ getTitleModel($configModelsMain, 'Abouts', 'ABOU05')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar {{ getTitleModel($configModelsMain, 'Abouts', 'ABOU05')}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#about" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link active d-flex align-items-center">
                            {{ getTitleModel($configModelsMain, 'Abouts', 'ABOU05') }}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Informações do conteúdo principal"></i>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="about">
                        @include('Admin.cruds.Abouts.ABOU05.form')
                    </div>
                </div>
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
