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
                                    <li class="breadcrumb-item"><a href="{{route('admin.port01.index')}}">{{$configModelsMain->Portfolios->PORT01->config->titlePanel}}</a></li>
                                    <li class="breadcrumb-item active">Cadastro {{$configModelsMain->Portfolios->PORT01->config->titlePanel}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Cadastro {{$configModelsMain->Portfolios->PORT01->config->titlePanel}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                {!! Form::model(null, ['route' => 'admin.port01.store', 'class'=>'parsley-validate', 'files'=>true]) !!}
                    <div class="w-100 d-table mb-3">
                        {!! Form::button('Cadastrar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                        <a href="{{route('admin.port01.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                    </div>
                    @include('Admin.Cruds.Portfolios.PORT01.form')
                    <div class="w-100 d-table">
                        {!! Form::button('Cadastrar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                        <a href="{{route('admin.port01.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                    </div>
                {!! Form::close() !!}
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
