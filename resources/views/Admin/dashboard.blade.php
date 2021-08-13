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
                    @foreach ($modelsMain as $model)
                        <div class="col-md-6 col-xl-3">
                            <a nofollow href="{{route(Str::lower($model->Code).'.index')}}">
                                <div class="widget-rounded-circle card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="avatar-lg rounded-circle border-secondary border shadow m-auto mb-3">
                                                    <i class="{{$model->config->iconPanel<>''?$model->config->iconPanel:'mdi-cancel'}} font-24 avatar-title text-dark"></i>
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
                    @endforeach
                </div>

            </div> <!-- container -->

        </div> <!-- content -->

    </div>
    @include('Admin.components.links.resourcesIndex')
@endsection
