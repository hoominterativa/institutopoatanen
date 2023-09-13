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
                                    <li class="breadcrumb-item active">{{getTitleModel($configModelsMain, 'Services', 'SERV08')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">{{getTitleModel($configModelsMain, 'Services', 'SERV08')}}</h4>
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
                                        <button id="btSubmitDelete" data-route="{{route('admin.serv08.destroySelected')}}" type="button" class="btn btn-danger btnDeleteServices" style="display: none;">Deletar selecionados</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{route('admin.serv08.create')}}" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                                    </div>
                                </div>
                                <table class="table table-bordered table-sortable">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50px"></th>
                                            <th width="30px" class="bs-checkbox">
                                                <label><input name="btnSelectAll" value="btnDeleteServices" type="checkbox"></label>
                                            </th>
                                            <th>Imagem</th>
                                            <th>Categoria</th>
                                            <th>Título/Subtítulo</th>
                                            <th>Descrição</th>
                                            <th>Texto</th>
                                            <th>Título do preço</th>
                                            <th>Preço</th>
                                            <th>Título do botão</th>
                                            <th>Título do destaque</th>
                                            <th>Cor do destaque</th>
                                            <th width="100px">Status</th>
                                            <th width="90px">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody data-route="{{route('admin.serv08.sorting')}}">
                                        @foreach ($services as $service)
                                            <tr data-code="{{$service->id}}">
                                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                <td class="bs-checkbox align-middle">
                                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$service->id}}"></label>
                                                </td>
                                                <td class="align-middle avatar-group">
                                                    @if ($service->path_image)
                                                        <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/' . $service->path_image)}})"></div>
                                                    @endif
                                                </td>
                                                <td class="align-middle">{{$service->categories->title}}</td>
                                                <td class="align-middle">{{$service->title}} <b>/</b>{{$service->subtitle}}</td>
                                                <td class="align-middle">{!! substr($service->description, 0, 20) !!}<b>...</b></td>
                                                <td class="align-middle">{!! substr($service->text, 0, 20) !!}<b>...</b></td>
                                                <td class="align-middle">{{$service->title_price}}</td>
                                                <td class="align-middle"><b>R$</b> {{$service->price}}</td>
                                                <td class="align-middle">{{$service->title_featured_service}}</td>
                                                <td class="align-middle">
                                                    <span class="badge" style="background-color: {{$service->color_featured_service}}">{{$service->color_featured_service}}</span>
                                                </td>
                                                <td class="align-middle">
                                                    @if ($service->active)
                                                        <span class="badge bg-success">Ativo</span>
                                                    @else
                                                        <span class="badge bg-danger">Inativo</span>
                                                    @endif
                                                    @if ($service->featured)
                                                        <span class="badge bg-primary text-white">Destaque Home</span>
                                                    @endif
                                                    @if ($service->featured_service)
                                                    <span class="badge bg-primary text-white">Serviço em destaque</span>
                                                @endif
                                                </td>
                                                <td class="align-middle">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <a href="{{route('admin.serv08.edit',['SERV08Services' => $service->id])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                                        </div>
                                                        <form action="{{route('admin.serv08.destroy',['SERV08Services' => $service->id])}}" class="col-4" method="POST">
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
