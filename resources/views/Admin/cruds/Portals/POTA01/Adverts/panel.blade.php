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
                            <h4 class="page-title d-flex align-items-center"><i class="mdi mdi-sign-real-estate mdi-36px me-2 mt-1 text-muted"></i> Anúcios</h4>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="navOwlDashboard"></div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="alert alert-warning">
                    <p class="mb-0">
                        <b>IMPORTANTE: </b> Os anúncios vinculados aos artigos deveram ser cadastrados dentro dos mesmos. <a href="{{route('admin.pota01.index')}}">Clique aqui e confira.</a>
                    </p>
                </div>

                <div class="row">
                    <div class="col-md-6 col-xl-3">
                        <a nofollow href="{{route('admin.pota01.adverts.index', ['type' => 'category'])}}">
                            <div class="widget-rounded-circle card">
                                <div class="card-body bg-light">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="avatar-xl rounded-circle border-secondary border shadow m-auto mb-3">
                                                <i class="mdi mdi-newspaper mdi-36px avatar-title text-dark"></i>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="text-center">
                                                <h4 class="text-dark mt-1">Anúncios das Categoria</h4>
                                                <p class="text-muted mb-1">Administre os anúncios vinculados as categorias dos artigos</p>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->
                                </div>
                            </div> <!-- end widget-rounded-circle-->
                        </a>
                    </div> <!-- end col-->
                    <div class="col-md-6 col-xl-3">
                        <a nofollow href="{{route('admin.pota01.adverts.index', ['type' => 'home'])}}">
                            <div class="widget-rounded-circle card">
                                <div class="card-body bg-light">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="avatar-xl rounded-circle border-secondary border shadow m-auto mb-3">
                                                <i class="mdi mdi-sign-real-estate mdi-36px avatar-title text-dark"></i>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="text-center">
                                                <h4 class="text-dark mt-1">Anúncios da Home</h4>
                                                <p class="text-muted mb-1">Administre os anúncios da página principal do Portal</p>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->
                                </div>
                            </div> <!-- end widget-rounded-circle-->
                        </a>
                    </div> <!-- end col-->
                    <div class="col-md-6 col-xl-3">
                        <a nofollow href="{{route('admin.pota01.adverts.index', ['type' => 'blog'])}}">
                            <div class="widget-rounded-circle card">
                                <div class="card-body bg-light">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="avatar-xl rounded-circle border-secondary border shadow m-auto mb-3">
                                                <i class="mdi mdi-page-next-outline mdi-36px avatar-title text-dark"></i>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="text-center">
                                                <h4 class="text-dark mt-1">Anúncios das Internas dos Artigos</h4>
                                                <p class="text-muted mb-1">Anúncios gerais para as páginas internas de artigos</p>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->
                                </div>
                            </div> <!-- end widget-rounded-circle-->
                        </a>
                    </div> <!-- end col-->
                    <div class="col-md-6 col-xl-3">
                        <a nofollow href="{{route('admin.pota01.adverts.index', ['type' => 'podcast'])}}">
                            <div class="widget-rounded-circle card">
                                <div class="card-body bg-light">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="avatar-xl rounded-circle border-secondary border shadow m-auto mb-3">
                                                <i class="mdi mdi-music-note-plus mdi-36px avatar-title text-dark"></i>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="text-center">
                                                <h4 class="text-dark mt-1">Anúncios Podcast</h4>
                                                <p class="text-muted mb-1">Administre os anúncios da página de Podcasts</p>
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
        </div>
    </div>
@endsection
