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
                                    <li class="breadcrumb-item"><a href="{{route('admin.gall02.index')}}">{{getTitleModel($configModelsMain, 'Galleries', 'GALL02')}}</a></li>
                                    <li class="breadcrumb-item active">Editar {{getTitleModel($configModelsMain, 'Galleries', 'GALL02')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar {{getTitleModel($configModelsMain, 'Galleries', 'GALL02')}}</h4>
                        </div>
                    </div>
                </div>

                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#editGallery" data-bs-toggle="tab" aria-expanded="true" class="nav-link active  d-flex align-items-center">
                            {{getTitleModel($configModelsMain, 'Galleries', 'GALL02')}}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Edição do conteúdo principal"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#images" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center">
                            Imagens da galeria
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Imagens da galeria que serão exibidas no lightbox"></i>
                        </a>
                    </li>
                </ul>

                <!-- end page title -->
                <div class="tab-content">
                    <div class="tab-pane show active" id="editGallery">
                        <div class="collapse show" id="formService">
                            {!! Form::model($gallery, ['route' => ['admin.gall02.update', $gallery->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
                                @include('Admin.cruds.Galleries.GALL02.form')
                                {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                                <a href="{{route('admin.gall02.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="tab-pane" id="images">
                        @include('Admin.cruds.Galleries.GALL02.Images.index', [
                            'images' => $images,
                            'gallery' => $gallery,
                        ])
                    </div>
                </div>
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
