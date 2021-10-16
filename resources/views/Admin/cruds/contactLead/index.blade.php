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
                                    <li class="breadcrumb-item active">Contatos Leads</li>
                                </ol>
                            </div>
                            <h4 class="page-title mb-0">Contatos Leads</h4>
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
                                            @if (isset($contactForm->name))
                                                <th>{{$contactForm->name->title}}</th>
                                            @endif
                                            @if (isset($contactForm->email))
                                                <th>{{$contactForm->email->title}}</th>
                                            @endif
                                            @if (isset($contactForm->phone))
                                                <th>{{$contactForm->phone->title}}</th>
                                            @endif
                                            @if (isset($contactForm->cellphone))
                                                <th>{{$contactForm->cellphone->title}}</th>
                                            @endif
                                            @if (isset($contactForm->subject))
                                                <th>{{$contactForm->subject->title}}</th>
                                            @endif
                                            @if (isset($contactForm->met_us))
                                                <th>{{$contactForm->met_us->title}}</th>
                                            @endif
                                            <th width="150px">Enviado em</th>
                                            <th width="70px">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($contactLeads as $contactLead)
                                            <tr>
                                                @if (isset($contactForm->name))
                                                    <td>{{$contactLead->name}}</td>
                                                @endif
                                                @if (isset($contactForm->email))
                                                    <td>{{$contactLead->email}}</td>
                                                @endif
                                                @if (isset($contactForm->phone))
                                                    <td>{{$contactLead->phone}}</td>
                                                @endif
                                                @if (isset($contactForm->cellphone))
                                                    <td>{{$contactLead->cellphone}}</td>
                                                @endif
                                                @if (isset($contactForm->subject))
                                                    <td>{{$contactLead->subject}}</td>
                                                @endif
                                                @if (isset($contactForm->met_us))
                                                    <td>{{$contactLead->met_us}}</td>
                                                @endif
                                                <td>{{Carbon\Carbon::parse($contactLead->created_at)->format('d/m/Y H:s')}}</td>
                                                <td class="text-center">
                                                    <a href="" class="btn-icon mdi mdi-eye" data-bs-toggle="modal" data-bs-target="#create-social-modal"></a>

                                                    <div id="create-social-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Detalhes do lead</h4>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="text-start modal-body p-4">
                                                                    <div class="mb-3">
                                                                        @if (isset($contactForm->name))
                                                                            <div class="mb-3">
                                                                                <label class="form-label">{{$contactForm->name->title}}</label>
                                                                                <p class="form-control">{{$contactLead->name}}</p>
                                                                            </div>
                                                                        @endif
                                                                        @if (isset($contactForm->email))
                                                                            <div class="mb-3">
                                                                                <label class="form-label">{{$contactForm->email->title}}</label>
                                                                                <p class="form-control">{{$contactLead->email}}</p>
                                                                            </div>
                                                                        @endif
                                                                        @if (isset($contactForm->phone))
                                                                            <div class="mb-3">
                                                                                <label class="form-label">{{$contactForm->phone->title}}</label>
                                                                                <p class="form-control">{{$contactLead->phone}}</p>
                                                                            </div>
                                                                        @endif
                                                                        @if (isset($contactForm->cellphone))
                                                                            <div class="mb-3">
                                                                                <label class="form-label">{{$contactForm->cellphone->title}}</label>
                                                                                <p class="form-control">{{$contactLead->cellphone}}</p>
                                                                            </div>
                                                                        @endif
                                                                        @if (isset($contactForm->subject))
                                                                            <div class="mb-3">
                                                                                <label class="form-label">{{$contactForm->subject->title}}</label>
                                                                                <p class="form-control">{{$contactLead->subject}}</p>
                                                                            </div>
                                                                        @endif
                                                                        @if (isset($contactForm->met_us))
                                                                            <div class="mb-3">
                                                                                <label class="form-label">{{$contactForm->met_us->title}}</label>
                                                                                <p class="form-control">{{$contactLead->met_us}}</p>
                                                                            </div>
                                                                        @endif
                                                                        @if (isset($contactForm->description))
                                                                            <div class="mb-3">
                                                                                <label class="form-label">{{$contactForm->description->title}}</label>
                                                                                <p class="form-control">{{$contactLead->description}}</p>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div><!-- /.create-social-modal -->
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
