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
                                            href="{{ route('admin.blog03.index') }}">{{ getTitleModel($configModelsMain, 'Blogs', 'BLOG03') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">Editar
                                        {{ getTitleModel($configModelsMain, 'Blogs', 'BLOG03') }}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar {{ getTitleModel($configModelsMain, 'Blogs', 'BLOG03') }}</h4>
                        </div>
                    </div>
                </div>
                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#about" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link active d-flex align-items-center">
                            Home
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Informações do conteúdo principal"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#gallery" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Galeria
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Esta seção será apresentada na home, junto com os galeria em destaque"></i>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="about">
                        <!-- end page title -->
                        {!! Form::model($blog, [
                            'route' => ['admin.blog03.update', $blog->id],
                            'class' => 'parsley-validate',
                            'method' => 'PUT',
                            'files' => true,
                        ]) !!}
                        @include('Admin.cruds.Blogs.BLOG03.form')
                        {!! Form::button('Salvar', [
                            'class' => 'btn btn-primary waves-effect waves-light float-end me-3 width-lg',
                            'type' => 'submit',
                        ]) !!}
                        <a href="{{ route('admin.blog03.index') }}"
                            class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                        {!! Form::close() !!}
                    </div> <!-- end tab-pane -->
                        <div class="tab-pane" id="gallery">
                            @include('Admin.cruds.Blogs.BLOG03.Galleries.index',
                            ['galleries' => $blog->galleries])
                        </div>
                    </div>
                </div> <!-- container -->
            </div> <!-- content -->
        </div>
        @include('Admin.components.links.resourcesCreateEdit')
    @endsection
