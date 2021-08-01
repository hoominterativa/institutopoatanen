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
                            <h4 class="page-title">Dashboard</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-md-6 col-xl-3">
                        <a nofollow href="#">
                            <div class="widget-rounded-circle card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="avatar-lg rounded-circle border-secondary border shadow m-auto mb-3">
                                                <i class="mdi mdi-image-move font-24 avatar-title text-dark"></i>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="text-center">
                                                <h4 class="text-dark mt-1">Banner</h4>
                                                <p class="text-muted mb-1">Ver Listagem</p>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->
                                </div>
                            </div> <!-- end widget-rounded-circle-->
                        </a>
                    </div> <!-- end col-->
                    <div class="col-md-6 col-xl-3">
                        <a nofollow href="#">
                            <div class="widget-rounded-circle card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="avatar-lg rounded-circle border-secondary border shadow m-auto mb-3">
                                                <i class="mdi mdi-image-move font-24 avatar-title text-dark"></i>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="text-center">
                                                <h4 class="text-dark mt-1">Topics</h4>
                                                <p class="text-muted mb-1">Ver Listagem</p>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->
                                </div>
                            </div> <!-- end widget-rounded-circle-->
                        </a>
                    </div> <!-- end col-->
                    <div class="col-md-6 col-xl-3">
                        <a nofollow href="#">
                            <div class="widget-rounded-circle card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="avatar-lg rounded-circle border-secondary border shadow m-auto mb-3">
                                                <i class="mdi mdi-image-move font-24 avatar-title text-dark"></i>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="text-center">
                                                <h4 class="text-dark mt-1">Categoria Produtos</h4>
                                                <p class="text-muted mb-1">Ver Listagem</p>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->
                                </div>
                            </div> <!-- end widget-rounded-circle-->
                        </a>
                    </div> <!-- end col-->
                    <div class="col-md-6 col-xl-3">
                        <a nofollow href="#">
                            <div class="widget-rounded-circle card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="avatar-lg rounded-circle border-secondary border shadow m-auto mb-3">
                                                <i class="mdi mdi-briefcase font-24 avatar-title text-dark"></i>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="text-center">
                                                <h4 class="text-dark mt-1">Produtos</h4>
                                                <p class="text-muted mb-1">Ver Listagem</p>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->
                                </div>
                            </div> <!-- end widget-rounded-circle-->
                        </a>
                    </div> <!-- end col-->
                </div>

            </div> <!-- container -->

        </div> <!-- content -->

    </div>

    {{-- <main id="root">
        @foreach ($sections as $section)
            {{$section}}
        @endforeach
    </main> --}}
@endsection
