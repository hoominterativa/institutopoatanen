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
                                    <li class="breadcrumb-item"><a href="{{route('admin.generalSetting.index')}}">Configurações Gerais</a></li>
                                    <li class="breadcrumb-item active">Formulários</li>
                                </ol>
                            </div>
                            <h4 class="page-title mb-0">Formulários</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-3">
                                        <button id="btSubmitDelete" data-route="{{route('admin.contactForm.destroySelected')}}" type="button" class="btn btn-danger" style="display: none;">Deletar selecionados</button>
                                    </div>
                                    <div class="col-9">
                                        <a href="{{route('admin.contactForm.create')}}" class="btn btn-success float-end">Cadastrar Formulário <i class="mdi mdi-plus"></i></a>
                                    </div>
                                </div>
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="30px" class="bs-checkbox">
                                                <label><input name="btSelectAll" type="checkbox"></label>
                                            </th>
                                            <th width="150px">E-mail Destinatário</th>
                                            <th width="150px">Título</th>
                                            <th width="150px">Página</th>
                                            <th width="150px">Posição</th>
                                            <th width="150px">Modelo</th>
                                            <th width="70px">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($contactForms as $contactForm)
                                            <tr>
                                                <td class="bs-checkbox align-middle">
                                                    <label><input name="btSelectItem" class="btSelectItem" type="checkbox" value="{{$contactForm->id}}"></label>
                                                </td>
                                                <td>{{$contactForm->email}}</td>
                                                <td>{{$contactForm->section_title}}</td>
                                                <td>{{$contactForm->page}}</td>
                                                <td>
                                                    @switch($contactForm->position)
                                                        @case('after') Depois da Sessão @break
                                                        @case('before') Antes da Sessão @break
                                                    @endswitch
                                                </td>
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
