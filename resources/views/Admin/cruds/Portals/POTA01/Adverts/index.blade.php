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
                                    <li class="breadcrumb-item"><a href="{{route('admin.pota01.adverts.index')}}">Anúncios</a></li>
                                    <li class="breadcrumb-item active">{{$titlePage}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">{{$titlePage}}</h4>
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
                                        <button id="btSubmitDelete" data-route="{{route('admin.pota01.adverts.destroySelected')}}" type="button" class="btnDeletePodcast btn btn-danger" style="display: none;">Deletar selecionados</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{route('admin.pota01.adverts.create', ['type' => $type])}}" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
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
                                            @if ($type=='category')
                                                <th>Categoria</th>
                                            @endif
                                            <th>Período de Exibição</th>
                                            <th>Link</th>
                                            <th>Adsense?</th>
                                            <th>Posição</th>
                                            <th width="90px">Status</th>
                                            <th width="90px">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody data-route="{{route('admin.pota01.adverts.sorting')}}">
                                        @foreach ($adverts as $advert)
                                            <tr data-code="{{$advert->id}}">
                                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                <td class="bs-checkbox align-middle">
                                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$advert->id}}"></label>
                                                </td>
                                                <td class="align-middle">
                                                    @if ($advert->path_image)
                                                        <div class="avatar-group">
                                                            <a href="{{asset('storage/'.$advert->path_image)}}" data-fancybox>
                                                                <div class="avatar-group-item avatar-bg rounded-circle avatar-sm mb-0" style="background-image: url({{asset('storage/'.$advert->path_image)}})"></div>
                                                            </a>
                                                        </div>
                                                    @endif
                                                </td>
                                                @if ($type=='category')
                                                    <td class="align-middle">{{$advert->category->title}}</td>
                                                @endif
                                                <td class="align-middle">
                                                    De {{Carbon\Carbon::parse($advert->date_start)->format('d/m/Y H:i')}}
                                                    à {{Carbon\Carbon::parse($advert->date_end)->format('d/m/Y H:i')}}
                                                </td>
                                                <td class="align-middle">
                                                    @if ($advert->link)
                                                        <a href="{{$advert->link}}" class="mdi mdi-link-variant" target="_blank"></a>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    @if ($advert->adsense)
                                                        <span class="badge bg-warning text-white">Usando Google Adsense</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    @switch($advert->position)
                                                        @case('homeBottomPodcast')
                                                            <span class="badge bg-warning">Abaixo do Padcast</span>
                                                        @break
                                                        @case('bottomLatestNews')
                                                            <span class="badge bg-warning">Abaixo das Últimas Notícias</span>
                                                        @break
                                                        @case('category')
                                                        @case('categoryInnerEndPage')
                                                            <span class="badge bg-warning">Final da Página</span>
                                                        @break
                                                        @case('categoryInnerBeginPage')
                                                            <span class="badge bg-warning">Início da Página</span>
                                                        @break
                                                        @case('podcastBeforeArticle')
                                                            <span class="badge bg-warning">Antes dos Artigos</span>
                                                        @break
                                                        @case('podcastAfterArticle')
                                                            <span class="badge bg-warning">Depois dos Artigos</span>
                                                        @break
                                                        @default
                                                            <span class="badge bg-danger">Sem posicionamento</span>
                                                    @endswitch
                                                </td>
                                                <td class="align-middle">
                                                    @if ($advert->active)
                                                        <span class="badge bg-success">Ativo</span>
                                                    @else
                                                        <span class="badge bg-danger">Inativo</span>
                                                    @endif
                                                    @if ($advert->featured_home)
                                                        <span class="badge bg-primary text-white">Destaque</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <a href="{{route('admin.pota01.adverts.edit',['POTA01PortalsAdverts' => $advert->id, 'type' => $type])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                                        </div>
                                                        <form action="{{route('admin.pota01.adverts.destroy',['POTA01PortalsAdverts' => $advert->id])}}" class="col-4" method="POST">
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
