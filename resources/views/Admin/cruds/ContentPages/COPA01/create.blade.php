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
                                    <li class="breadcrumb-item"><a href="{{route('admin.copa01.index')}}">{{getTitleModel($configModelsMain, 'ContentPages', 'COPA01')}}</a></li>
                                    <li class="breadcrumb-item active">Cadastro {{getTitleModel($configModelsMain, 'ContentPages', 'COPA01')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Cadastro {{getTitleModel($configModelsMain, 'ContentPages', 'COPA01')}}</h4>
                            <p class="mb-4">Mais opções de cadastros serão exibidos após salvar as informações abaixo</p>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                {!! Form::model(null, ['route' => 'admin.copa01.store', 'class'=>'parsley-validate', 'files'=>true]) !!}
                    @include('Admin.cruds.ContentPages.COPA01.form')
                    {!! Form::button('Cadastrar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                    <a href="{{route('admin.copa01.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                {!! Form::close() !!}
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
