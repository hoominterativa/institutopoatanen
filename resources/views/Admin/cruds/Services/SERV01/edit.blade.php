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
                                    <li class="breadcrumb-item"><a href="{{route('admin.serv01.index')}}">{{getTitleModel($configModelsMain, 'Services', 'SERV01')}}</a></li>
                                    <li class="breadcrumb-item active">Editar {{getTitleModel($configModelsMain, 'Services', 'SERV01')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar {{getTitleModel($configModelsMain, 'Services', 'SERV01')}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#editService" data-bs-toggle="tab" aria-expanded="true" class="nav-link active  d-flex align-items-center">
                            Editar Solução
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#advantages" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Vantagens
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Tópicos que aparecem abaixo do texto de soluções"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#protfolios" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center" >
                            Portifólios
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Galerias que aparecem abaixo dos tópicos"></i>
                        </a>
                    </li>
                </ul>

               <div class="tab-content">
                    <div class="tab-pane show active" id="editService">
                        {!! Form::model($service, ['route' => ['admin.serv01.update', $service->id], 'class'=>'parsley-validate mb-5', 'method'=>'PUT', 'files'=>true]) !!}
                            @include('Admin.Cruds.Services.SERV01.form')
                            {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                            <a href="{{route('admin.serv01.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                        {!! Form::close() !!}
                    </div>
                    <div class="tab-pane" id="advantages">
                        @include('Admin.cruds.Services.SERV01.Advantages.index',[
                            'service' => $service,
                            'advantages' => $advantages,
                            'advantageSection' => $advantageSection,
                        ])
                    </div>
                    <div class="tab-pane" id="protfolios">
                        @include('Admin.cruds.Services.SERV01.Portfolios.index',[
                            'service' => $service,
                            'portfolios' => $portfolios,
                            'portfolioSection' => $portfolioSection,
                        ])
                    </div>
                </div>
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
