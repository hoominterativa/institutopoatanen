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
                                            href="{{ route('admin.port101.index') }}">{{ getTitleModel($configModelsMain, 'Portfolios', 'PORT101') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">Editar
                                        {{ getTitleModel($configModelsMain, 'Portfolios', 'PORT101') }}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar {{ getTitleModel($configModelsMain, 'Portfolios', 'PORT101') }}
                            </h4>
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-info float-end me-3 mb-3" type="button" data-bs-toggle="collapse"
                            data-bs-target="#formService" aria-expanded="false" aria-controls="collapseExample">
                            Esconder/Exibir formulário
                        </button>
                        <a href="#containerGalleries" class="btn btn-warning float-end me-3 mb-3"> Galeria de fotos </a>
                    </div>
                </div>
                <!-- end page title -->
                <div class="collapse show" id="formService">
                    {!! Form::model($portfolio, [
                        'route' => ['admin.port101.update', $portfolio->id],
                        'class' => 'parsley-validate',
                        'method' => 'PUT',
                        'files' => true,
                    ]) !!}
                    @include('Admin.Cruds.Portfolios.PORT101.form')
                    {!! Form::button('Salvar', [
                        'class' => 'btn btn-primary waves-effect waves-light float-end me-3 width-lg',
                        'type' => 'submit',
                    ]) !!}
                    <a href="{{ route('admin.port101.index') }}"
                        class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                    {!! Form::close() !!}
                </div>
            </div> <!-- container -->
            @include('Admin.cruds.Portfolios.PORT101.Galleries.index', [
                'portfolio' => $portfolio,
                'galleries' => $galleries,
            ])
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
