<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <button id="btSubmitDelete" data-route="{{route('admin.pota01.adverts.destroySelected')}}" type="button" class="btn btn-danger btnDeleteBlogCategory" style="display: none;">Deletar selecionados</button>
                    </div>
                    <div class="col-6">
                        <a href="javascript:void(0)"  data-bs-target="#modal-advert-create" data-bs-toggle="modal" class="btn btn-success float-end">Adicionar Anúncio <i class="mdi mdi-plus"></i></a>
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
                                    <span class="badge bg-warning">Final da Página</span>
                                </td>
                                <td class="align-middle">
                                    @if ($advert->active)
                                        <span class="badge bg-success">Ativo</span>
                                    @else
                                        <span class="badge bg-danger">Inativo</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="javascript:void(0)" data-bs-target="#modal-advert-update-{{$advert->id}}" data-bs-toggle="modal" class="btn-icon mdi mdi-square-edit-outline"></a>
                                        </div>
                                        <form action="{{route('admin.pota01.adverts.destroy',['POTA01PortalsAdverts' => $advert->id])}}" class="col-4" method="POST">
                                            @method('DELETE') @csrf
                                            <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                                        </form>
                                    </div>
                                    {{-- BEGIN MODAL CATEGORY UPDATE --}}
                                    <div id="modal-advert-update-{{$advert->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog" style="max-width: 1100px;">
                                            <div class="modal-content">
                                                <div class="modal-header p-3 pt-2 pb-2">
                                                    <h4 class="page-title">Editar Anúncio</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body p-3 pt-0 pb-3">
                                                    @include('Admin.cruds.Portals.POTA01.AdvertsBlog.form',[
                                                        'advert' => $advert,
                                                        'portal' => $portal,
                                                    ])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- END MODAL CATEGORY UPDATE --}}
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

{{-- BEGIN MODAL ADVERT CREATE --}}
<div id="modal-advert-create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="max-width: 1100px;">
        <div class="modal-content">
            <div class="modal-header p-3 pt-2 pb-2">
                <h4 class="page-title">Cadastrar Anúncio</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-3 pt-0 pb-3">
                @include('Admin.cruds.Portals.POTA01.AdvertsBlog.form',[
                    'portal' => $portal,
                    'advert' => null,
                ])
            </div>
        </div>
    </div>
</div>
{{-- END MODAL CATEGORY CREATE --}}
