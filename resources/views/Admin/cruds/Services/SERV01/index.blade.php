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
                                    <li class="breadcrumb-item active">{{$configModelsMain->Services->SERV01->config->titlePanel}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">{{$configModelsMain->Services->SERV01->config->titlePanel}}</h4>
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
                                        <button id="btSubmitDelete" data-route="{{route('admin.serv01.destroySelected')}}" type="button" class="btn btn-danger btnDeleteService" style="display: none;">Deletar selecionados</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{route('admin.serv01.create')}}" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                                        <button class="btn btn-warning float-end me-2" type="button" data-bs-toggle="collapse" data-bs-target="#serviceSection" aria-expanded="false" aria-controls="collapseExample">
                                            Informações da Seção
                                        </button>
                                        <button class="btn btn-primary float-end me-2" type="button" data-bs-toggle="collapse" data-bs-target="#serviceBanner" aria-expanded="false" aria-controls="collapseExample">
                                            Banner Interno
                                        </button>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <div class="collapse bg-light p-3 mb-3" id="serviceBanner">
                                            @if ($section)
                                                {!! Form::model($section, ['route' => ['admin.serv01.section.update', $section->id], 'class'=>'parsley-examples', 'files' => true]) !!}
                                                @method('PUT')
                                            @else
                                                {!! Form::model(null, ['route' => 'admin.serv01.section.store', 'class'=>'parsley-examples', 'files' => true]) !!}
                                            @endif
                                            <div class="row">
                                                <h3 class="mb-3">Banner Interno</h3>
                                                <div class="col-12 col-lg-6">
                                                    <div class="mb-2">
                                                        {!! Form::label('title_banner', 'Título', ['class'=>'form-label']) !!}
                                                        {!! Form::text('title_banner', null, ['class'=>'form-control', 'id'=>'title_banner', 'required' => true]) !!}
                                                    </div>
                                                    <div class="mb-2">
                                                        {!! Form::label('description_banner', 'Descrição', ['class'=>'form-label']) !!}
                                                        {!! Form::textarea('description_banner', null, [
                                                            'class'=>'form-control',
                                                            'id'=>'description_banner',
                                                            'data-parsley-trigger'=>'keyup',
                                                            'data-parsley-minlength'=>'20',
                                                            'data-parsley-maxlength'=>'100',
                                                            'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                                                            'data-parsley-validation-threshold'=>'10',
                                                        ]) !!}
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <div class="mb-3">
                                                        {!! Form::label('file', 'Imagem', ['class'=>'form-label']) !!}
                                                        {!! Form::file('path_image_banner', [
                                                            'data-plugins'=>'dropify',
                                                            'data-height'=>'300',
                                                            'data-max-file-size-preview'=>'2M',
                                                            'accept'=>'image/*',
                                                            'data-default-file'=> isset($section)?$section->path_image_banner<>''?url('storage/'.$section->path_image_banner):'':'',
                                                        ]) !!}
                                                    </div>
                                                </div>
                                            </div>
                                                <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
                                                    {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0', 'type' => 'submit']) !!}
                                                </div>
                                            {!! Form::close() !!}
                                        </div>
                                        <div class="collapse bg-light p-3 mb-3" id="serviceSection">
                                            @if ($section)
                                                {!! Form::model($section, ['route' => ['admin.serv01.section.update', $section->id], 'class'=>'parsley-examples', 'files' => true]) !!}
                                                @method('PUT')
                                            @else
                                                {!! Form::model(null, ['route' => 'admin.serv01.section.store', 'class'=>'parsley-examples', 'files' => true]) !!}
                                            @endif
                                            <div class="row">
                                                <h3 class="mb-3">Informações da Seção</h3>
                                                <div class="col-12 col-lg-6">
                                                    <div class="mb-2">
                                                        {!! Form::label('title_section', 'Título', ['class'=>'form-label']) !!}
                                                        {!! Form::text('title_section', null, ['class'=>'form-control', 'id'=>'title_section', 'required' => true]) !!}
                                                    </div>
                                                    <div class="mb-2">
                                                        {!! Form::label('subtitle_section', 'Subtítulo', ['class'=>'form-label']) !!}
                                                        {!! Form::text('subtitle_section', null, ['class'=>'form-control', 'id'=>'subtitle_section']) !!}
                                                    </div>
                                                    <div class="mb-3 form-check me-3">
                                                        {!! Form::checkbox('active_section', '1', null, ['class'=>'form-check-input', 'id'=>'active_section']) !!}
                                                        {!! Form::label('active_section', 'Ativar exibição na home?', ['class'=>'form-check-label']) !!}
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <div class="mb-3">
                                                        {!! Form::label('description_section', 'Descrição', ['class'=>'form-label']) !!}
                                                        {!! Form::textarea('description_section', null, [
                                                            'class'=>'form-control',
                                                            'id'=>'description_section',
                                                            'data-parsley-trigger'=>'keyup',
                                                            'data-parsley-minlength'=>'20',
                                                            'data-parsley-maxlength'=>'100',
                                                            'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                                                            'data-parsley-validation-threshold'=>'10',
                                                        ]) !!}
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
                                                <label><input name="btnSelectAll" value="btnDeleteService" type="checkbox"></label>
                                            </th>
                                            <th></th>
                                            <th>Título/Subtítulo</th>
                                            <th>Descrição</th>
                                            <th>Status</th>
                                            <th width="90px">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody data-route="{{route('admin.serv01.sorting')}}">
                                        @foreach ($services as $service)
                                            <tr data-code="{{$service->id}}">
                                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                <td class="bs-checkbox align-middle">
                                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$service->id}}"></label>
                                                </td>
                                                <td class="align-middle avatar-group">
                                                    @if ($service->path_image_icon)
                                                        <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/'.$service->path_image_icon)}})"></div>
                                                    @endif
                                                    @if ($service->path_image)
                                                        <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/'.$service->path_image)}})"></div>
                                                    @endif
                                                </td>
                                                <td class="align-middle">{{$service->title}} <b>/</b> {{$service->subtitle}}</td>
                                                <td class="align-middle">{{substr($service->description,0,50)}}</td>
                                                <td class="align-middle d-felx">
                                                    @if ($service->active)
                                                        <span class="badge bg-success me-1">Ativo</span>
                                                    @else
                                                        <span class="badge bg-danger me-1">Inativo</span>
                                                    @endif
                                                    @if ($service->featured)
                                                        <span class="badge bg-primary text-white me-1">Destaque</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <a href="{{route('admin.serv01.edit',['SERV01Services' => $service->id])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                                        </div>
                                                        <form action="{{route('admin.serv01.destroy',['SERV01Services' => $service->id])}}" class="col-4" method="POST">
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
    @include('Admin.components.links.resourcesIndex')
@endsection
