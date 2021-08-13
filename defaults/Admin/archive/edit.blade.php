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
                                    <li class="breadcrumb-item"><a href="{{route('code.index')}}">Name</a></li>
                                    <li class="breadcrumb-item active">Editar Name</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar Name</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                {!! Form::model(null, ['route' => 'code.update', 'class'=>'parsley-examples']) !!}
                    @include('Admin.Module.CODE.form')
                    {!! Form::submit('Salvar', ['class'=>'btn btn-primary float-end me-3']) !!}
                {!! Form::close() !!}
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
