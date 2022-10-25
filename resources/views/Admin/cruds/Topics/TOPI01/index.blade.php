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
                                    <li class="breadcrumb-item active">{{$configModelsMain->Topics->TOPI01->config->titlePanel}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">{{$configModelsMain->Topics->TOPI01->config->titlePanel}}</h4>
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
                                        <button id="btSubmitDelete" data-route="{{route('admin.topi01.destroySelected')}}" type="button" class="btn btn-danger" style="display: none;">Deletar selecionados</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{route('admin.topi01.create')}}" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                                        <button class="btn btn-warning float-end me-2" type="button" data-bs-toggle="collapse" data-bs-target="#topicSection" aria-expanded="false" aria-controls="collapseExample">
                                            Informações da Seção
                                        </button>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <div class="collapse bg-light p-3 mb-3" id="topicSection">
                                            @if ($section)
                                                {!! Form::model($section, ['route' => ['admin.topi01.section.update', $section->id], 'class'=>'parsley-examples', 'files' => true]) !!}
                                                @method('PUT')
                                            @else
                                                {!! Form::model(null, ['route' => 'admin.topi01.section.store', 'class'=>'parsley-examples', 'files' => true]) !!}
                                            @endif
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-2">
                                                        {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                                                        {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title', 'required' => true]) !!}
                                                    </div>
                                                    <div class="mb-2">
                                                        {!! Form::label('subtitle', 'Subtítulo', ['class'=>'form-label']) !!}
                                                        {!! Form::text('subtitle', null, ['class'=>'form-control', 'id'=>'subtitle', 'required' => true]) !!}
                                                    </div>
                                                    <div class="mb-2">
                                                        {!! Form::label('description', 'Descrição', ['class'=>'form-label']) !!}
                                                        {!! Form::textarea('description', null, [
                                                            'class'=>'form-control basic-editor',
                                                            'id'=>'description',
                                                        ]) !!}
                                                    </div>
                                                    <div class="mb-3 form-check me-3">
                                                        {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'activeSection']) !!}
                                                        {!! Form::label('activeSection', 'Ativar exibição na home?', ['class'=>'form-check-label']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                                <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
                                                    {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0', 'type' => 'submit']) !!}
                                                </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div> <!-- end col-->
                                </div>
                                <table class="table table-bordered table-sortable">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50px"></th>
                                            <th width="30px" class="bs-checkbox">
                                                <label><input name="btSelectAll" type="checkbox"></label>
                                            </th>
                                            <th width="90px"></th>
                                            <th>Título</th>
                                            <th width="100px">Status</th>
                                            <th width="90px">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody data-route="{{route('admin.topi01.sorting')}}">
                                        @foreach ($topics as $topic)
                                            <tr data-code="{{$topic->id}}">
                                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                <td class="bs-checkbox align-middle">
                                                    <label><input name="btSelectItem" class="btSelectItem" type="checkbox" value="{{$topic->id}}"></label>
                                                </td>
                                                <td class="align-middle avatar-group text-center">
                                                    <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/'.$topic->path_image)}})"></div>
                                                    <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/'.$topic->path_image_icon)}})"></div>
                                                </td>
                                                <td class="align-middle">{{$topic->title}}</td>
                                                <td class="align-middle">
                                                    @if ($topic->active)
                                                        <span class="badge bg-success">Ativo</span>
                                                    @else
                                                        <span class="badge bg-danger">Inativo</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <a href="{{route('admin.topi01.edit',['TOPI01Topics' => $topic->id])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                                        </div>
                                                        <form action="{{route('admin.topi01.destroy',['TOPI01Topics' => $topic->id])}}" class="col-4" method="POST">
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
    @include('Admin.components.links.resourcesIndex')
@endsection
