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
                                    <li class="breadcrumb-item"><a href="{{route('admin.abou01.index')}}">{{$configModelsMain->Abouts->ABOU01->config->titlePanel}}</a></li>
                                    <li class="breadcrumb-item active">{{$configModelsMain->Abouts->ABOU01->config->titlePanel}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Página {{$configModelsMain->Abouts->ABOU01->config->titlePanel}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                @if ($about)
                    {!! Form::model($about, ['route' => ['admin.abou01.update', $about->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
                @else
                    {!! Form::model(null, ['route' => 'admin.abou01.store', 'class'=>'parsley-validate', 'files'=>true]) !!}
                @endif
                    @include('Admin.Cruds.Abouts.ABOU01.form')
                    {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                    <a href="{{route('admin.dashboard')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                {!! Form::close() !!}
            </div> <!-- container -->
            @if ($about)
                @include('Admin.cruds.Abouts.ABOU01.Topics.index',[
                    'about' => $about,
                    'topics' => $about->topics
                ])
            @endif

        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
