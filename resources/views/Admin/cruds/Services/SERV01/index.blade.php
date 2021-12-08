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
                                    <li class="breadcrumb-item active">Serviços</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Serviços</h4>
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
                                        <button id="btSubmitDelete" data-route="{{route('admin.serv01.destroySelected')}}" type="button" class="btn btn-danger" style="display: none;">Deletar selecionados</button>
                                    </div>
                                    <div class="col-9">
                                        <a href="{{route('admin.serv01.create')}}" class="btn btn-success float-end">Cadastrar Serviço <i class="mdi mdi-plus"></i></a>
                                        <button type="button" class="btn btn-secondary float-end me-2" data-bs-toggle="modal" data-bs-target="#create-services-section">Informações da Seção</button>
                                        <a href="{{route('admin.serv01.subcategory.index')}}" class="btn btn-primary float-end me-2">Lista de Subcategorias <i class="mdi mdi-plus"></i></a>
                                        <a href="{{route('admin.serv01.category.index')}}" class="btn btn-primary float-end me-2">Lista de Categorias <i class="mdi mdi-plus"></i></a>
                                    </div>
                                </div>
                                <table class="table table-bordered table-sortable">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50px"></th>
                                            <th width="30px" class="bs-checkbox">
                                                <label><input name="btSelectAll" type="checkbox"></label>
                                            </th>
                                            <th>Imagem</th>
                                            <th>Titulo</th>
                                            <th>Categoria</th>
                                            <th>Subcategoria</th>
                                            <th width="100px">Status</th>
                                            <th width="90px">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody data-route="{{route('admin.serv01.sorting')}}">
                                        @foreach ($services as $service)
                                            <tr data-code="{{$service->slug}}">
                                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                <td class="bs-checkbox align-middle">
                                                    <label><input name="btSelectItem" class="btSelectItem" type="checkbox" value="{{$service->slug}}"></label>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="avatar-bg rounded-circle avatar-sm" style="background-image: url({{url('storage/'.$service->path_image_box)}})"></div>
                                                </td>
                                                <td class="align-middle">{{$service->title}}</td>
                                                <td class="align-middle">{{$service->getCategory?$service->getCategory->name:'--'}}</td>
                                                <td class="align-middle">{{$service->getSubcategory?$service->getSubcategory->name:'--'}}</td>
                                                <td class="align-middle">
                                                    @if ($service->active == 1)
                                                        <span class="badge bg-success">Ativo</span>
                                                    @else
                                                        <span class="badge bg-danger">Inativo</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <a href="{{route('admin.serv01.edit',['SERV01Services' => $service->slug])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                                        </div>
                                                        <form action="{{route('admin.serv01.destroy',['SERV01Services' => $service->slug])}}" class="col-4" method="POST">
                                                            @method('DELETE') @csrf
                                                            <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{-- PAGINATION --}}
                                <div class="mt-3 float-end">
                                    {{$services->links()}}
                                </div>
                            </div>
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    <div id="create-services-section" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Título da Seção</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {!! Form::model($serviceSection, ['autocomplete' => 'off', 'method' => $serviceSection?'PUT':'POST', 'route' => $serviceSection?['admin.serv01section.update',$serviceSection->id]:['admin.serv01section.store'], 'class'=>'parsley-examples']) !!}
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <div class="mb-3">
                            {!! Form::label(null, 'Título', ['class'=>'form-label']) !!}
                            {!! Form::text('title', null, [
                                'class'=>'form-control',
                                'parsley-type'=>'url',
                            ]) !!}
                            </div>
                            <div class="mb-3">
                                {!! Form::label('message', 'Descrição', ['class'=>'form-label']) !!}
                                {!! Form::textarea('description', null, [
                                    'class'=>'form-control',
                                    'id'=>'message',
                                    'data-parsley-trigger'=>'keyup',
                                    'data-parsley-maxlength'=>'200',
                                    'data-parsley-maxlength-message'=>'Vamos lá! Você só pode inserir um texto com no máximo 200 caracteres.',
                                    'data-parsley-validation-threshold'=>'10',
                                    'rows'=>'5'
                                ]) !!}
                            </div>
                            <div class="form-check">
                                {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
                                {!! Form::label('active', 'Exibir?', ['class'=>'form-check-label']) !!}
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
    @include('Admin.components.links.resourcesIndex')
@endsection
