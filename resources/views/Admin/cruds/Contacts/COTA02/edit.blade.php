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
                                            href="{{ route('admin.cota02.index') }}">{{ getTitleModel($configModelsMain, 'Contacts', 'COTA02') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">Editar
                                        {{ getTitleModel($configModelsMain, 'Contacts', 'COTA02') }}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar {{ getTitleModel($configModelsMain, 'Contacts', 'COTA02') }}</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#infoContact" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link active  d-flex align-items-center">
                            Campos do Formulário
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro das informações da página e dos campos do formulário"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#infoBanner" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Informações do Banner
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Aqui você pode editar as informações do banner"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#infoForm" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Informações formulário
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Aqui você pode editar as informações do formulário"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#topicSection" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Tópicos da seção
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro dos tópicos que aparecem na seção acima do formulário"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#infoTopic" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Informações da seção Tópico
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Aqui você pode editar as informações do tópico"></i>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="infoContact">
                        {!! Form::model($contact, ['route' => ['admin.cota02.update', $contact->id], 'class' => 'parsley-validate', 'method' => 'PUT','files' => true,]) !!}
                        @include('Admin.cruds.Contacts.COTA02.form')
                        {!! Form::button('Salvar', ['class' => 'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit', ]) !!}
                        <a href="{{ route('admin.cota02.index') }}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                        {!! Form::close() !!}
                    </div>
                    <div class="tab-pane" id="infoBanner">
                        {!! Form::model($contact, ['route' => ['admin.cota02.update', $contact->id], 'class' => 'parsley-validate', 'method' => 'PUT', 'files' => true,]) !!}
                        {!! Form::hidden('title_page', $contact->title_page) !!}
                        @include('Admin.cruds.Contacts.COTA02.InfoBanner.form')
                        {!! Form::close() !!}
                    </div>
                    <div class="tab-pane" id="infoForm">
                        {!! Form::model($contact, ['route' => ['admin.cota02.update', $contact->id],'class' => 'parsley-validate', 'method' => 'PUT', 'files' => true, ]) !!}
                        {!! Form::hidden('title_page', $contact->title_page) !!}
                        @include('Admin.cruds.Contacts.COTA02.InfoForm.form')
                        {!! Form::close() !!}
                    </div>
                    <div class="tab-pane" id="infoTopic">
                        {!! Form::model($contact, ['route' => ['admin.cota02.update', $contact->id], 'class' => 'parsley-validate', 'method' => 'PUT', 'files' => true,]) !!}
                        {!! Form::hidden('title_page', $contact->title_page) !!}
                        @include('Admin.cruds.Contacts.COTA02.InfoTopic.form')
                        {!! Form::close() !!}
                    </div>
                    <div class="tab-pane" id="topicSection">
                        @include('Admin.cruds.Contacts.COTA02.Topics.index', [
                            'topics' => $topics,
                            'contact' => $contact,
                        ])
                    </div>
                </div> <!-- container -->
            </div>
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
