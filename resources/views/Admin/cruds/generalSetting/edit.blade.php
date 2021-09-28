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
                                    <li class="breadcrumb-item active">Configurações Gerais</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Configurações Gerais</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                {!! Form::model($generalSetting, ['autocomplete' => 'off', 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'route' => ['admin.generalSetting.update', $generalSetting->id], 'class'=>'parsley-examples']) !!}
                    @include('Admin.cruds.generalSetting.form',[
                        'generalSetting' => $generalSetting
                    ])
                    {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                {!! Form::close() !!}

                <!-- start page title -->
                <div id="rowSocial" class="row mt-5">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                            </div>
                            <h4 class="page-title">Redes Sociais</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <button id="btSubmitDelete" data-route="{{route('admin.social.destroySelected')}}" type="button" class="btn btn-danger" style="display: none;">Deletar selecionados</button>
                                    </div>
                                    <div class="col-6">
                                        <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#create-social-modal">Adicionar novo <i class="mdi mdi-plus"></i></button>
                                    </div>
                                </div>
                                <table data-toggle="table" data-page-size="5" data-pagination="false" class="table-bordered table-sortable">
                                    <thead class="table-light">
                                        <tr>
                                            <th></th>
                                            <th class="bs-checkbox">
                                                <label><input name="btSelectAll" type="checkbox"></label>
                                            </th>
                                            <th>Link</th>
                                            <th>Icone</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody data-route="{{route('admin.social.sorting')}}">
                                        @foreach ($socials as $key => $social)
                                            <tr>
                                                <td><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                <td class="bs-checkbox">
                                                    <label><input data-index="{{$key}}" name="btSelectItem" class="btSelectItem" type="checkbox" value="{{$social->id}}"></label>
                                                </td>
                                                <td><a class="breakText text-muted" href="{{$social->link}}">{{$social->link}}</a></td>
                                                <td><i class="mdi {{$social->icon}} font-22"></i></td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <a href="javascript:void(0)" class="btn-icon mdi mdi-square-edit-outline" data-bs-toggle="modal" data-bs-target="#edit-social-modal-{{$social->id}}"></a>
                                                        </div>
                                                        <form action="{{route('admin.social.destroy',['Social' => $social->id])}}" class="col-4" method="POST">
                                                            @method('DELETE') @csrf
                                                            <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                                                        </form>

                                                        {{-- MODAL EDIT SOCIAL --}}
                                                        <div id="edit-social-modal-{{$social->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Editar rede Social</h4>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    {!! Form::model($social, ['autocomplete' => 'off', 'method' => 'PUT', 'route' => ['admin.social.update', $social->id], 'class'=>'parsley-examples']) !!}
                                                                        <div class="modal-body p-4">
                                                                            <div class="mb-3">
                                                                                <div class="mb-3">
                                                                                {!! Form::label(null, 'Link', ['class'=>'form-label']) !!}
                                                                                {!! Form::url('link', null, [
                                                                                    'class'=>'form-control',
                                                                                    'required'=>'required',
                                                                                    'parsley-type'=>'url',
                                                                                ]) !!}
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    {!! Form::label(null, 'Tipo', ['class'=>'form-label']) !!}
                                                                                    {!! Form::select('icon', [
                                                                                        'mdi-facebook' => 'Facebook',
                                                                                        'mdi-facebook-messenger' => 'Facebook Messenger',
                                                                                        'mdi-youtube' => 'Youtube',
                                                                                        'mdi-youtube-gaming' => 'Youtube Gaming',
                                                                                        'mdi-instagram' => 'Instagram',
                                                                                        'mdi-linkedin' => 'Linkedin',
                                                                                    ], null, [
                                                                                        'class'=>'form-select',
                                                                                        'id'=>'heard',
                                                                                        'required'=>'required',
                                                                                        'placeholder' => '--'
                                                                                    ]) !!}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cancelar</button>
                                                                            {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                                                                        </div>
                                                                    {!! Form::close() !!}
                                                                </div>
                                                            </div>
                                                        </div><!-- /.create-social-modal -->
                                                        {{-- END MODAL EDIT SOCIAL --}}

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


    <div id="create-social-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Cadastrar Rede Social</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {!! Form::model(null, ['autocomplete' => 'off', 'route' => ['admin.social.store'], 'class'=>'parsley-examples']) !!}
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <div class="mb-3">
                            {!! Form::label(null, 'Link', ['class'=>'form-label']) !!}
                            {!! Form::url('link', null, [
                                'class'=>'form-control',
                                'required'=>'required',
                                'parsley-type'=>'url',
                            ]) !!}
                            </div>
                            <div class="mb-3">
                                {!! Form::label(null, 'Tipo', ['class'=>'form-label']) !!}
                                {!! Form::select('icon', [
                                    'mdi-facebook' => 'Facebook',
                                    'mdi-facebook-messenger' => 'Facebook Messenger',
                                    'mdi-youtube' => 'Youtube',
                                    'mdi-youtube-gaming' => 'Youtube Gaming',
                                    'mdi-instagram' => 'Instagram',
                                    'mdi-linkedin' => 'Linkedin',
                                ], null, [
                                    'class'=>'form-select',
                                    'id'=>'heard',
                                    'required'=>'required',
                                    'placeholder' => '--'
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cancelar</button>
                        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div><!-- /.create-social-modal -->

    <style>
        .breakText{
            white-space: nowrap;
            max-width: 38em;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
        }
    </style>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
