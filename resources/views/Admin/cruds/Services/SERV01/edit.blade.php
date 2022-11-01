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
                                    <li class="breadcrumb-item"><a href="{{route('admin.serv01.index')}}">{{$configModelsMain->Services->SERV01->config->titlePanel}}</a></li>
                                    <li class="breadcrumb-item active">Editar {{$configModelsMain->Services->SERV01->config->titlePanel}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar {{$configModelsMain->Services->SERV01->config->titlePanel}}</h4>
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-info float-end me-3 mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#formService" aria-expanded="false" aria-controls="collapseExample">
                            Esconder formulário de serviço
                        </button>
                    </div>
                </div>
                <!-- end page title -->
                <div class="collapse show" id="formService">
                    {!! Form::model($service, ['route' => ['admin.serv01.update', $service->id], 'class'=>'parsley-validate mb-5', 'method'=>'PUT', 'files'=>true]) !!}
                        @include('Admin.Cruds.Services.SERV01.form')
                        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                        <a href="{{route('admin.serv01.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                    {!! Form::close() !!}
                </div>
                @include('Admin.cruds.Services.SERV01.Advantages.index',[
                    'configModelsMain' => $configModelsMain,
                    'service' => $service,
                    'advantages' => $advantages,
                    'advantageSection' => $advantageSection,
                ])
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
