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
                                    <li class="breadcrumb-item active">SMTP</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Configurar SMTP</h4>
                            <div class="alert alert-warning">
                                <p class="mb-0">As configurações de SMTP são necessárias para que os <b>leads</b> do site sejam entregues no seu e-mail, porém todos os <b>leads</b> são registrados na seção de <a href="{{route('admin.contact.index')}}"><b>OPORTUNIDADES</b></a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                {!! Form::model($settingSmtp, ['autocomplete' => 'off', 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'route' => ['admin.settingSmtp.update', $settingSmtp->id], 'class'=>'parsley-validate']) !!}
                    @include('Admin.cruds.settingSMTP.form')
                    {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                {!! Form::close() !!}
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
