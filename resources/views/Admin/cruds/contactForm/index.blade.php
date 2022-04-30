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
                                    <li class="breadcrumb-item active">Formulários de Leads</li>
                                </ol>
                            </div>
                            <h4 class="page-title mb-0">Formulários de Leads</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3"></div>
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="150px">E-mail Destinatário</th>
                                            <th width="150px">Página</th>
                                            <th width="150px">Após sessão</th>
                                            <th width="150px">Modelo</th>
                                            <th width="70px">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($contactForms as $contactForm)
                                            <tr>
                                                <td>{{$contactForm->email}}</td>
                                                <td>{{$contactForm->page}}</td>
                                                <td>{{$contactForm->after_session}}</td>
                                                <td>{{$contactForm->model}}</td>
                                                <td class="align-middle">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <a href="{{route('admin.contactForm.edit',['ContactForm' => $contactForm->id])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                                        </div>
                                                        <form action="{{route('admin.contactForm.destroy',['ContactForm' => $contactForm->id])}}" class="col-4" method="POST">
                                                            @method('DELETE') @csrf
                                                            <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>

    <style>
        .breakText{
            white-space: nowrap;
            max-width: 25em;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
        }
    </style>
    @include('Admin.components.links.resourcesIndex')
@endsection
