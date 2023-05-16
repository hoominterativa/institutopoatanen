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
                                    <li class="breadcrumb-item active">Podcasts</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Podcasts</h4>
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
                                        <button id="btSubmitDelete" data-route="{{route('admin.pota01.podcast.destroySelected')}}" type="button" class="btnDeletePodcast btn btn-danger" style="display: none;">Deletar selecionados</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{route('admin.pota01.podcast.create')}}" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                                    </div>
                                </div>
                                <table class="table table-bordered table-sortable">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50px"></th>
                                            <th width="30px" class="bs-checkbox">
                                                <label><input name="btnSelectAll" value="btnDeletePodcast" type="checkbox"></label>
                                            </th>
                                            <th width="50px">Imagem</th>
                                            <th>Título</th>
                                            <th>Duração</th>
                                            <th>Publicado em:</th>
                                            <th width="200px">Status</th>
                                            <th width="90px">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody data-route="{{route('admin.pota01.podcast.sorting')}}">
                                        @foreach ($podcasts as $podcast)
                                            <tr data-code="{{$podcast->id}}">
                                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                <td class="bs-checkbox align-middle">
                                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$podcast->id}}"></label>
                                                </td>
                                                <td class="align-middle">
                                                    @if ($podcast->path_image_thumbnail)
                                                        <div class="avatar-group">
                                                            <div class="avatar-group-item avatar-bg rounded-circle avatar-sm mb-0" style="background-image: url({{asset('storage/'.$podcast->path_image_thumbnail)}})"></div>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="align-middle">{{$podcast->title}}</td>
                                                <td class="align-middle">{{$podcast->duration}}min</td>
                                                <td class="align-middle">{{dateFormat($podcast->publising, 'd', 'M', 'Y', '')}}</td>
                                                <td class="align-middle">
                                                    @if ($podcast->active)
                                                        <span class="badge bg-success">Ativo</span>
                                                    @else
                                                        <span class="badge bg-danger">Inativo</span>
                                                    @endif
                                                    @if ($podcast->featured_home)
                                                        <span class="badge bg-primary text-white">Destaque</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <a href="{{route('admin.pota01.podcast.edit',['POTA01PortalsPodcast' => $podcast->id])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                                        </div>
                                                        <form action="{{route('admin.pota01.podcast.destroy',['POTA01PortalsPodcast' => $podcast->id])}}" class="col-4" method="POST">
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
                                    {{$podcasts->links()}}
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
