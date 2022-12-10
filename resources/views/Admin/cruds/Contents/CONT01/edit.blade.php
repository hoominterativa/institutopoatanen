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
                                    <li class="breadcrumb-item active">{{getTitleModel($configModelsMain, 'Content', 'CONT01')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">{{getTitleModel($configModelsMain, 'Content', 'CONT01')}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                @if ($content)
                    {!! Form::model($content, ['route' => ['admin.cont01.update', $content->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
                @else
                    {!! Form::model(null, ['route' => 'admin.cont01.store', 'class'=>'parsley-validate', 'files'=>true]) !!}
                @endif
                    @include('Admin.Cruds.Contents.CONT01.form')
                    {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                {!! Form::close() !!}
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
