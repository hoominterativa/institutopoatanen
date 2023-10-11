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
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.cota04.index') }}">{{ getTitleModel($configModelsMain, 'Contacts', 'COTA04') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">Editar {{ getTitleModel($configModelsMain, 'Contacts', 'COTA04') }}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar {{ getTitleModel($configModelsMain, 'Contacts', 'COTA04') }}</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#infoContact" data-bs-toggle="tab" aria-expanded="true" class="nav-link active  d-flex align-items-center">
                            Campos do contato
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro das informações da página"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#section" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Seção
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Informações referentes a cada seção"></i>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="infoContact">
                        {!! Form::model($contact, [ 'route' => ['admin.cota04.update', $contact->id], 'class' => 'parsley-validate','method' => 'PUT', 'files' => true, ]) !!}
                            @include('Admin.cruds.Contacts.COTA04.form')
                            {!! Form::button('Salvar', [ 'class' => 'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit', ]) !!}
                            <a href="{{ route('admin.cota04.index') }}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                        {!! Form::close() !!}
                    </div>
                    <div class="tab-pane" id="section">
                        @include('Admin.cruds.Contacts.COTA04.Sections.index',[
                            'contact' => $contact,
                            'sections' => $sections
                        ])
                    </div>
                </div> <!-- container -->
            </div>
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
