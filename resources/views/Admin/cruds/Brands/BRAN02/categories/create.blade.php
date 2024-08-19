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
                                            href="{{ route('admin.bran02.index') }}">{{ getTitleModel($configModelsMain, 'Brands', 'BRAN02') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">Cadastro Categorias</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Cadastro Categorias</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                {!! Form::model(null, [
                    'route' => 'admin.bran02.categories.store',
                    'class' => 'parsley-validate',
                    'files' => true,
                ]) !!}
                @include('Admin.cruds.Brands.BRAN02.categories.form')
                {!! Form::button('Cadastrar', [
                    'class' => 'btn btn-primary waves-effect waves-light float-end me-3 width-lg',
                    'type' => 'submit',
                ]) !!}
                <!-- end page title -->
                <a href="{{ route('admin.bran02.index') . '?tab=#category' }}"
                    class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                {!! Form::close() !!}
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
