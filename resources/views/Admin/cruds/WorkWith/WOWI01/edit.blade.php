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
                                    <li class="breadcrumb-item"><a href="{{route('admin.wowi01.index')}}">{{getTitleModel($configModelsMain, 'WorkWith', 'WOWI01')}}</a></li>
                                    <li class="breadcrumb-item active">Editar {{getTitleModel($configModelsMain, 'WorkWith', 'WOWI01')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar {{getTitleModel($configModelsMain, 'WorkWith', 'WOWI01')}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#bannerPage" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                            Banner da Página
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Informações do Banner que aparecem acima dos tópicos"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#infoPage" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                            Informações da Página
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro de todas as informações da página."></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#topicsSection" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                            Informações da seção de Tópicos
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Informações de textos que aparecem na seção dos tópicos"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#topics" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                            Tópicos
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Informações que aparecem abaixo dos tópicos"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#sectionContent" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                            Seção de Conteúdo
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Informações que aparecem abaixo dos tópicos"></i>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane" id="bannerPage">
                        @include('Admin.cruds.WorkWith.WOWI01.Banner.form',[
                            'workWith' => $workWith
                        ])
                    </div>

                    <div class="tab-pane active show" id="infoPage">
                        {!! Form::model($workWith, ['route' => ['admin.wowi01.update', $workWith->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
                            @include('Admin.Cruds.WorkWith.WOWI01.form')
                            {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                            <a href="{{route('admin.wowi01.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                        {!! Form::close() !!}
                    </div>

                    <div class="tab-pane" id="topicsSection">
                        @include('Admin.cruds.WorkWith.WOWI01.TopicsSection.form',[
                            'workWith' => $workWith,
                            'topicSection' => $topicSection
                        ])
                    </div>

                    <div class="tab-pane" id="topics">
                        @include('Admin.cruds.WorkWith.WOWI01.Topics.index',[
                            'workWith' => $workWith,
                            'topics' => $topics
                        ])
                    </div>

                    <div class="tab-pane" id="sectionContent">
                        @include('Admin.cruds.WorkWith.WOWI01.SectionContent.form',[
                            'workWith' => $workWith
                        ])
                    </div>
                </div>
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
