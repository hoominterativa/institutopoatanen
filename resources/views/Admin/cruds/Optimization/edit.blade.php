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
                                    <li class="breadcrumb-item"><a href="{{route('admin.optimization.index')}}">Informações de SEO</a></li>
                                    <li class="breadcrumb-item active">Editar  Informações de SEO</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar Informações de SEO</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                {!! Form::model($optimization, ['route' => ['admin.optimization.update', $optimization->id], 'method' => 'PUT', 'class'=>'parsley-examples']) !!}
                    @include('Admin.cruds.Optimization.form')
                    {!! Form::submit('Salvar', ['class'=>'btn btn-primary float-end me-3']) !!}
                    <a class="btn btn-secondary float-end me-1" href="{{route('admin.optimization.index')}}">Voltar</a>
                {!! Form::close() !!}
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
