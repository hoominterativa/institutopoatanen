@extends('Admin.core.admin')
@section('content')
    <style>
        .card{
            transition: ease all 0.4s;
        }
        .card:hover{
            box-shadow: 3px 3px 12px rgb(0 0 0 / 14%);
            transform: scale(1.01);
            transition: ease all 0.4s;
        }
    </style>
    <div class="content-page">
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="page-title-box">
                            <h4 class="page-title d-flex align-items-center"><i class="mdi mdi-view-dashboard-outline mdi-36px me-2 mt-1 text-muted"></i> Dashboard</h4>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="navOwlDashboard"></div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="mt-2 mb-3 position-relative">
                    <div class="owl-carousel-dashboard">
                        @foreach ($modelsMain as $module => $models)
                            @foreach ($models as $code => $model)
                                @if ($model->ViewListPanel)
                                    <div class="col-auto">
                                        <a nofollow href="{{route('admin.'.Str::lower($code).'.index')}}">
                                            <div class="widget-rounded-circle card mb-0">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="avatar-xl rounded-circle border-secondary border shadow m-auto mb-3">
                                                                <i class="{{$model->config->iconPanel<>''?$model->config->iconPanel:'mdi-cancel'}} mdi mdi-36px avatar-title text-dark"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="text-center">
                                                                <h4 class="text-dark mt-1">{{$model->config->titlePanel}}</h4>
                                                                <p class="text-muted mb-1">Ver Listagem</p>
                                                            </div>
                                                        </div>
                                                    </div> <!-- end row-->
                                                </div>
                                            </div> <!-- end widget-rounded-circle-->
                                        </a>
                                    </div> <!-- end col-->
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                </div>
                <div class="card card-body card--custom" >
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title d-flex align-items-center mb-2" style="line-height: 47px;">
                                    <i class="mdi mdi-filter-plus mdi-36px me-2 mt-1 text-muted"></i>
                                    Funil
                                </h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-md-6 col-xl-3">
                            <a nofollow href="{{route('admin.contact.index')}}">
                                <div class="widget-rounded-circle card">
                                    <div class="card-body bg-light">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="avatar-xl rounded-circle border-secondary border shadow m-auto mb-3">
                                                    <i class="mdi mdi-handshake-outline mdi-36px avatar-title text-dark"></i>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="text-center">
                                                    <h4 class="text-dark mt-1">Oportunidades</h4>
                                                    <p class="text-muted mb-1">Leads do formulário de contato</p>
                                                </div>
                                            </div>
                                        </div> <!-- end row-->
                                    </div>
                                </div> <!-- end widget-rounded-circle-->
                            </a>
                        </div> <!-- end col-->
                        <div class="col-md-6 col-xl-3">
                            <a nofollow href="{{route('admin.contactForm.index')}}">
                                <div class="widget-rounded-circle card">
                                    <div class="card-body bg-light">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="avatar-xl rounded-circle border-secondary border shadow m-auto mb-3">
                                                    <i class="mdi mdi-content-paste mdi-36px avatar-title text-dark"></i>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="text-center">
                                                    <h4 class="text-dark mt-1">Formulários</h4>
                                                    <p class="text-muted mb-1">Crie formulários personalizados</p>
                                                </div>
                                            </div>
                                        </div> <!-- end row-->
                                    </div>
                                </div> <!-- end widget-rounded-circle-->
                            </a>
                        </div> <!-- end col-->
                    </div>
                    {{-- END .row --}}
                </div>

                <style>
                    .card.card-body.card--custom:hover{
                        transform: scale(1) !important;
                    }
                </style>

                <div class="card card-body card--custom" >
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title d-flex align-items-center mb-2" style="line-height: 47px;">
                                    <i class="mdi mdi-application-cog mdi-36px me-2 mt-1 text-muted"></i>
                                    Configurações
                                </h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-md-6 col-xl-3">
                            <a nofollow href="{{route('admin.header.index')}}">
                                <div class="widget-rounded-circle card">
                                    <div class="card-body bg-light">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="avatar-xl rounded-circle border-secondary border shadow m-auto mb-3">
                                                    <i class="mdi mdi-microsoft-xbox-controller-menu mdi-36px avatar-title text-dark"></i>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="text-center">
                                                    <h4 class="text-dark mt-1">Configurações do Menu</h4>
                                                    <p class="text-muted mb-1">Configure o menu do site.</p>
                                                </div>
                                            </div>
                                        </div> <!-- end row-->
                                    </div>
                                </div> <!-- end widget-rounded-circle-->
                            </a>
                        </div> <!-- end col-->

                        <div class="col-md-6 col-xl-3">
                            <a nofollow href="{{route('admin.optimization.index')}}">
                                <div class="widget-rounded-circle card">
                                    <div class="card-body bg-light">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="avatar-xl rounded-circle border-secondary border shadow m-auto mb-3">
                                                    <i class="mdi mdi-google-analytics mdi-36px avatar-title text-dark"></i>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="text-center">
                                                    <h4 class="text-dark mt-1">SEO</h4>
                                                    <p class="text-muted mb-1">Otimize seu site aqui.</p>
                                                </div>
                                            </div>
                                        </div> <!-- end row-->
                                    </div>
                                </div> <!-- end widget-rounded-circle-->
                            </a>
                        </div> <!-- end col-->

                        <div class="col-md-6 col-xl-3">
                            <a nofollow href="{{route('admin.generalSetting.index')}}">
                                <div class="widget-rounded-circle card">
                                    <div class="card-body bg-light">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="avatar-xl rounded-circle border-secondary border shadow m-auto mb-3">
                                                    <i class="mdi mdi-hammer-wrench mdi-36px avatar-title text-dark"></i>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="text-center">
                                                    <h4 class="text-dark mt-1">Gerais</h4>
                                                    <p class="text-muted mb-1">Configure seu site aqui</p>
                                                </div>
                                            </div>
                                        </div> <!-- end row-->
                                    </div>
                                </div> <!-- end widget-rounded-circle-->
                            </a>
                        </div> <!-- end col-->
                        <div class="col-md-6 col-xl-3">
                            <a nofollow href="{{route('admin.settingSmtp.index')}}">
                                <div class="widget-rounded-circle card">
                                    <div class="card-body bg-light">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="avatar-xl rounded-circle border-secondary border shadow m-auto mb-3">
                                                    <i class="mdi mdi-email-edit mdi-36px avatar-title text-dark"></i>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="text-center">
                                                    <h4 class="text-dark mt-1">SMTP</h4>
                                                    <p class="text-muted mb-1">Configure o envio de e-mails</p>
                                                </div>
                                            </div>
                                        </div> <!-- end row-->
                                    </div>
                                </div> <!-- end widget-rounded-circle-->
                            </a>
                        </div> <!-- end col-->
                        <div class="col-md-6 col-xl-3">
                            <a nofollow href="{{route('admin.social.index')}}">
                                <div class="widget-rounded-circle card">
                                    <div class="card-body bg-light">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="avatar-xl rounded-circle border-secondary border shadow m-auto mb-3">
                                                    <i class="mdi mdi-graph-outline mdi-36px avatar-title text-dark"></i>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="text-center">
                                                    <h4 class="text-dark mt-1">Redes Sociais</h4>
                                                    <p class="text-muted mb-1">Cadastre suas redes sociais</p>
                                                </div>
                                            </div>
                                        </div> <!-- end row-->
                                    </div>
                                </div> <!-- end widget-rounded-circle-->
                            </a>
                        </div> <!-- end col-->
                        @if ($complianceModel)
                            <div class="col-md-6 col-xl-3">
                                <a nofollow href="{{route('admin.'.$complianceModel.'.index')}}">
                                    <div class="widget-rounded-circle card">
                                        <div class="card-body bg-light">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="avatar-xl rounded-circle border-secondary border shadow m-auto mb-3">
                                                        <i class="mdi mdi-notebook-check mdi-36px avatar-title text-dark"></i>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="text-center">
                                                        <h4 class="text-dark mt-1">Compliances <span class="text-danger">*</span></h4>
                                                        <p class="text-muted mb-1">Área jurídica para o site</p>
                                                    </div>
                                                </div>
                                            </div> <!-- end row-->
                                        </div>
                                    </div> <!-- end widget-rounded-circle-->
                                </a>
                            </div> <!-- end col-->
                        @endif
                        <div class="col-md-6 col-xl-3">
                            <a nofollow href="{{route('admin.user.index')}}">
                                <div class="widget-rounded-circle card">
                                    <div class="card-body bg-light">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="avatar-xl rounded-circle border-secondary border shadow m-auto mb-3">
                                                    <i class="mdi mdi-account mdi-36px avatar-title text-dark"></i>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="text-center">
                                                    <h4 class="text-dark mt-1">Usuários</h4>
                                                    <p class="text-muted mb-1">Ver Listagem</p>
                                                </div>
                                            </div>
                                        </div> <!-- end row-->
                                    </div>
                                </div> <!-- end widget-rounded-circle-->
                            </a>
                        </div> <!-- end col-->
                    </div>
                </div>
                {{-- END .card --}}


            </div> <!-- container -->

        </div> <!-- content -->

    </div>
    @include('Admin.components.links.resourcesDashboard')
@endsection
