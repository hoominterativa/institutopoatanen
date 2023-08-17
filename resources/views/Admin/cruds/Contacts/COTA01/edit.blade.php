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
                                    <li class="breadcrumb-item"><a href="{{route('admin.cota01.index')}}">{{getTitleModel($configModelsMain, 'Contacts', 'COTA01')}}</a></li>
                                    <li class="breadcrumb-item active">Editar {{getTitleModel($configModelsMain, 'Contacts', 'COTA01')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar {{getTitleModel($configModelsMain, 'Contacts', 'COTA01')}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#infoFormContact" data-bs-toggle="tab" aria-expanded="true" class="nav-link active  d-flex align-items-center">
                            Informações da Página
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro das informações da página e dos campos do formulário"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#banner" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Banner da página
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro do banner principal da página"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#topicsForm" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center" >
                            Tópicos do Formulário
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro dos tópicos que aparecem ao lado do formulário"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#topicsSection" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center" >
                            Tópicos da seção
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro dos tópicos que aparecem na seção abaixo do formulário"></i>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">

                    <div class="tab-pane show active" id="infoFormContact">
                        {!! Form::model($contact, ['route' => ['admin.cota01.update', $contact->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
                            @include('Admin.cruds.Contacts.COTA01.form')
                            {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                            <a href="{{route('admin.cota01.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                        {!! Form::close() !!}
                    </div>
                    {{-- END #listFormContact --}}

                    <div class="tab-pane" id="banner">
                        @include('Admin.cruds.Contacts.COTA01.Banner.form',[
                            'contact' => $contact
                        ])
                    </div>
                    {{-- END #banner --}}

                    <div class="tab-pane" id="topicsForm">
                        @include('Admin.cruds.Contacts.COTA01.TopicsForm.index',[
                            'topicsForm' => $topicsForm,
                            'contact' => $contact
                        ])
                    </div>
                    {{-- END #topicsForm --}}

                    <div class="tab-pane" id="topicsSection">
                        @include('Admin.cruds.Contacts.COTA01.TopicsSection.index',[
                            'topicsSection' => $topicsSection,
                            'contact' => $contact
                        ])
                    </div>
                    {{-- END #topicsSection --}}

                </div>
                {{-- END .tab-content --}}
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
