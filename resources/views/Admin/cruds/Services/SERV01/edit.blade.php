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
                                    <li class="breadcrumb-item"><a href="{{route('admin.serv01.index')}}">Serviços</a></li>
                                    <li class="breadcrumb-item active">Editar Serviço</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar Serviço</h4>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <a href="{{route('admin.serv01.category.create')}}" class="btn btn-primary float-start me-2">Cadastrar Categoria <i class="mdi mdi-plus"></i></a>
                        <a href="{{route('admin.serv01.subcategory.create')}}" class="btn btn-primary float-start">Cadastrar Subcategoria <i class="mdi mdi-plus"></i></a>
                    </div>
                </div>
                <!-- end page title -->
                {!! Form::model($service, ['route' => ['admin.serv01.update', $service->slug], 'class'=>'parsley-examples', 'method'=>'PUT', 'files'=>true]) !!}
                    @include('Admin.Cruds.Services.SERV01.form',['service'=>$service])
                    {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                    <a href="{{route('admin.serv01.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                {!! Form::close() !!}
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
