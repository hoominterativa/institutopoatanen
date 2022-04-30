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
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">UBold</a></li>
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                    <li class="breadcrumb-item active">Opportunities</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Opportunities</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->


                <div class="row">
                    <div class="col-12 order-xl-1 order-2">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="row justify-content-between">
                                    <div class="col-auto">
                                        <form class="d-flex flex-wrap align-items-center">
                                            <label for="inputPassword2" class="visually-hidden">Search</label>
                                            <div class="me-3">
                                                <input type="search" class="form-control my-1 my-md-0" id="inputPassword2" placeholder="Search...">
                                            </div>
                                            <label for="status-select" class="me-2">Sort By</label>
                                            <div class="me-sm-3">
                                                <select class="form-select my-1 my-md-0" id="status-select">
                                                    <option selected="">All</option>
                                                    <option value="1">Hot</option>
                                                    <option value="2">Cold</option>
                                                    <option value="3">In Progress</option>
                                                    <option value="4">Lost</option>
                                                    <option value="5">Won</option>
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-md-end mt-3 mt-md-0">
                                            <button type="button" class="btn btn-success waves-effect waves-light me-1"><i class="mdi mdi-cog"></i></button>
                                            <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#custom-modal"><i class="mdi mdi-plus-circle me-1"></i> Add New</button>
                                        </div>
                                    </div><!-- end col-->
                                </div> <!-- end row -->
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                        @foreach ($contactLeads as $contactLead)
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-sm-4">
                                            <div class="d-flex align-items-start">
                                                <div class="w-100">
                                                    @foreach (json_decode($contactLead->json) as $key => $informations)
                                                        @if ($informations->type <> 'email' && $informations->type <> 'phone' && $informations->type <> 'cellphone' && $informations->type <> 'checkbox')
                                                            <p class="mb-1"><b>{{$key}}:</b> {{$informations->value}}</p>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            @foreach (json_decode($contactLead->json) as $key => $informations)
                                                @switch($informations->type)
                                                    @case('email')
                                                        <p class="mb-1 mt-3 mt-sm-0"><a href="mailto:{{$informations->value}}"><i class="mdi mdi-email me-1"></i> {{$informations->value}}</a></p>
                                                    @break
                                                    @case('phone')
                                                        <p class="mb-1"><a href="tel:{{$informations->value}}"><i class="mdi mdi-phone me-1"></i> {{$informations->value}}</a></p>
                                                    @break
                                                    @case('cellphone')
                                                        <p class="mb-0"><a href="tel:{{$informations->value}}"><i class="mdi mdi-cellphone me-1"></i> {{$informations->value}}</a></p>
                                                    @break
                                                @endswitch
                                            @endforeach
                                        </div>
                                        <div class="col-sm-3">
                                            @foreach (json_decode($contactLead->json) as $key => $informations)
                                                @switch($informations->type)
                                                    @case('checkbox')
                                                        <h5 class="mb-1">{{$key}}</h5>
                                                        <ul>
                                                            @foreach ($informations->value as $item)
                                                                <li><p class="mb-0">{{$item}}</p></li>
                                                            @endforeach
                                                        </ul>
                                                    @break
                                                @endswitch
                                            @endforeach
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="text-center mt-3 mt-sm-0">
                                                <div class="badge font-14 bg-soft-info text-info p-1">Hot</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="text-sm-end">
                                                <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                                <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                                            </div>
                                        </div> <!-- end col-->
                                    </div> <!-- end row -->
                                </div>
                            </div> <!-- end card-->
                        @endforeach

                    </div> <!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- container -->

        </div> <!-- content -->

        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <script>document.write(new Date().getFullYear())</script> &copy; UBold theme by <a href="">Coderthemes</a>
                    </div>
                    <div class="col-md-6">
                        <div class="text-md-end footer-links d-none d-sm-block">
                            <a href="javascript:void(0);">About Us</a>
                            <a href="javascript:void(0);">Help</a>
                            <a href="javascript:void(0);">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->

    </div>
    @include('Admin.components.links.resourcesIndex')
@endsection
