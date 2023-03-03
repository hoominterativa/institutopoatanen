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
                                    <li class="breadcrumb-item"><a href="{{route('admin.slid02.topic.index')}}"> {{getTitleModel($configModelsMain, 'Slides', 'SLID02')}} </a></li>
                                    <li class="breadcrumb-item active">Cadastro {{getTitleModel($configModelsMain, 'Slides', 'SLID02')}} </li>
                                </ol>
                            </div>
                            <h4 class="page-title">Cadastro {{getTitleModel($configModelsMain, 'Slides', 'SLID02')}} </h4>
                        </div>
                    </div>
                </div>
                <div class="alert alert-warning">
                    <p class="mb-0"><b>Atenção:</b> Preencha os campos de informações do Desktop e Mobile.</p>
                </div>
                <!-- end page title -->
                {!! Form::model(null, ['route' => 'admin.slid02.topic.store', 'class'=>'parsley-validate', 'files'=>true]) !!}
                    @include('Admin.Cruds.Slides.SLID02.Topics.form')
                    {!! Form::button('Cadastrar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                    <a href="{{route('admin.slid02.topic.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                {!! Form::close() !!}
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
