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
                                    <li class="breadcrumb-item"><a href="{{route('admin.slid01.index')}}">Banners</a></li>
                                    <li class="breadcrumb-item active">Editar {{getTitleModel($configModelsMain, 'Slides', 'SLID01')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar {{getTitleModel($configModelsMain, 'Slides', 'SLID01')}}</h4>
                        </div>
                    </div>
                </div>
                <div class="alert alert-warning">
                    <p class="mb-0"><b>Atenção:</b> Não recomendamos colocar os textos na imagem do banner, isso pode influenciar negativamente o SEO do seu site. Utlize nossa ferramenta de cadastro para configurar o título, subtítulo e botão do seu banner.</p>
                </div>
                <!-- end page title -->
                {!! Form::model($slide, ['route' => ['admin.slid01.update', $slide->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
                    @include('Admin.cruds.Slides.SLID01.form')
                    {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                    <a href="{{route('admin.slid01.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                {!! Form::close() !!}
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
