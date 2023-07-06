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
                                    <li class="breadcrumb-item"><a href="{{route('admin.abou01.index')}}">{{getTitleModel($configModelsMain, 'Abouts', 'ABOU01')}}</a></li>
                                    <li class="breadcrumb-item active">{{getTitleModel($configModelsMain, 'Abouts', 'ABOU01')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Página {{getTitleModel($configModelsMain, 'Abouts', 'ABOU01')}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <ul class="mb-3 nav nav-tabs">
                    <li class="nav-item">
                        <a href="#formAbout" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">Informações da Página</a>
                    </li>
                    <li class="nav-item">
                        <a href="#formAboutSection" data-bs-toggle="tab" aria-expanded="true" class="nav-link">Informações para Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#formBannerAbout" data-bs-toggle="tab" aria-expanded="false" class="nav-link">Banner</a>
                    </li>
                    <li class="nav-item">
                        <a href="#formSectionInnerAbout" data-bs-toggle="tab" aria-expanded="false" class="nav-link">Seção Página</a>
                    </li>
                    <li class="nav-item">
                        <a href="#formSectionTopics" data-bs-toggle="tab" aria-expanded="false" class="nav-link">Seção Tópicos</a>
                    </li>
                    <li class="nav-item">
                        <a href="#aboutTopicsList" data-bs-toggle="tab" aria-expanded="false" class="nav-link">Tópicos</a>
                    </li>
                </ul>
                <div class="tab-content">
                    @include('Admin.cruds.Abouts.ABOU01.form')
                    <div class="tab-pane" id="aboutTopicsList">
                        @if ($about)
                            @include('Admin.cruds.Abouts.ABOU01.Topics.index',[
                                'about' => $about,
                                'topics' => $about->topics
                            ])
                        @endif
                    </div>
                </div>
            </div> <!-- container -->

        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
