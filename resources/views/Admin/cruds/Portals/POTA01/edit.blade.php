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
                                    <li class="breadcrumb-item"><a href="{{route('admin.pota01.index')}}">{{getTitleModel($configModelsMain, 'Portals', 'POTA01')}}</a></li>
                                    <li class="breadcrumb-item active">Editar {{getTitleModel($configModelsMain, 'Portals', 'POTA01')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar {{getTitleModel($configModelsMain, 'Portals', 'POTA01')}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <ul class="mb-0 nav nav-tabs">
                    <li class="nav-item">
                        <a href="#editArticle" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">Editar</a>
                    </li>
                    <li class="nav-item">
                        <a href="#listArticleAdverts" data-bs-toggle="tab" aria-expanded="true" class="nav-link">Cadastrar Anúncios</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active show" id="editArticle">
                        {!! Form::model($portal, ['route' => ['admin.pota01.update', $portal->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
                            @include('Admin.cruds.Portals.POTA01.form')
                            {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                            <a href="{{route('admin.pota01.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                        {!! Form::close() !!}
                    </div>
                    <div class="tab-pane" id="listArticleAdverts">
                        @include('Admin.cruds.Portals.POTA01.AdvertsBlog.index',[
                            'adverts' => $adverts,
                            'portal' => $portal,
                        ])
                    </div>
                </div>
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
