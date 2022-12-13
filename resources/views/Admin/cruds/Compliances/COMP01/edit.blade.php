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
                                    <li class="breadcrumb-item"><a href="{{route('admin.comp01.index')}}">Compliances</a></li>
                                    <li class="breadcrumb-item active">Editar Compliance</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar Compliance</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#infoPage" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                            Informações da Página
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Informações como título e banner da página"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#sectionsPage" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                            Seções da Página
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Conteúdo que será exibido como seções na págima"></i>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane show active" id="infoPage">
                        {!! Form::model($compliance, ['route' => ['admin.comp01.update', $compliance->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
                            @include('Admin.Cruds.Compliances.COMP01.form')
                            {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                            <a href="{{route('admin.comp01.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                        {!! Form::close() !!}
                    </div>
                    {{-- END #infoPage --}}
                    <div class="tab-pane" id="sectionsPage">
                        @include('Admin.cruds.Compliances.COMP01.Sections.index',[
                            'compliance' => $compliance,
                            'sections' => $sections
                        ])
                    </div>
                    {{-- END #listArchives --}}
                </div>
                {{-- END .tab-content --}}
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
