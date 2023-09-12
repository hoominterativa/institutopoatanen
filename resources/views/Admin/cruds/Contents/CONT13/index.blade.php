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
                                    <li class="breadcrumb-item active">{{getTitleModel($configModelsMain, 'Contents', 'CONT13')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">{{getTitleModel($configModelsMain, 'Contents', 'CONT13')}}</h4>
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
                                        <button id="btSubmitDelete" data-route="{{route('admin.cont13.destroySelected')}}" type="button" class="btn btn-danger btnDeleteContents" style="display: none;">Deletar selecionados</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{route('admin.cont13.create')}}" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                                    </div>
                                </div>
                                <table class="table table-bordered table-sortable">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50px"></th>
                                            <th width="30px" class="bs-checkbox">
                                                <label><input name="btnSelectAll" value="btnDeleteContents" type="checkbox"></label>
                                            </th>
                                            <th>Imagem</th>
                                            <th>Categoria</th>
                                            <th>Título/Subtítulo</th>
                                            <th>Descrição</th>
                                            <th>Título do preço</th>
                                            <th>Preço</th>
                                            <th>Título do botão</th>
                                            <th>Link do botão</th>
                                            <th>Título do destaque</th>
                                            <th>Cor do destaque</th>
                                            <th width="100px">Status</th>
                                            <th width="90px">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody data-route="{{route('admin.cont13.sorting')}}">
                                        @foreach ($contents as $content)
                                            <tr data-code="{{$content->id}}">
                                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                <td class="bs-checkbox align-middle">
                                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$content->id}}"></label>
                                                </td>
                                                <td class="align-middle avatar-group">
                                                    @if ($content->path_image)
                                                        <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/' . $content->path_image)}})"></div>
                                                    @endif
                                                </td>
                                                <td class="align-middle">{{$content->category->title}}</td>
                                                <td class="align-middle">{{$content->title}} <b>/</b>{{$content->subtitle}}</td>
                                                <td class="align-middle">{!! substr($content->description, 0, 30) !!}<b>...</b></td>
                                                <td class="align-middle">{{$content->title_price}}</td>
                                                <td class="align-middle">R$ {{$content->price}}</td>
                                                <td class="align-middle">{{$content->title_button}}</td>
                                                <td class="align-middle"><a href="{{$content->link_button}}" target="_blank" class="mdi mdi-link-box-variant mdi-24px"></a></td>
                                                <td class="align-middle">{{$content->title_featured}}</td>
                                                <span class="badge" style="background-color: {{$content->color__featured}}">{{$content->color__featured}}</span>
                                                <td class="align-middle">
                                                    @if ($content->active)
                                                        <span class="badge bg-success">Ativo</span>
                                                    @else
                                                        <span class="badge bg-danger">Inativo</span>
                                                    @endif
                                                    @if ($content->featured)
                                                        <span class="badge bg-primary text-white">Destaque</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <a href="{{route('admin.cont13.edit',['CONT13Contents' => $content->id])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                                        </div>
                                                        <form action="{{route('admin.cont13.destroy',['CONT13Contents' => $content->id])}}" class="col-4" method="POST">
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
                                    {{$contents->links()}}
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
