<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <button id="btSubmitDelete" data-route="{{route('admin.serv07.gallery-service.destroySelected')}}" type="button" class="btn btn-danger btnDeleteGalleryService" style="display: none;">Deletar selecionados</button>
                    </div>
                    <div class="col-6">
                        <a href="javascript:void(0)"  data-bs-target="#modal-gallery-service-create" data-bs-toggle="modal" class="btn btn-success float-end">Adicionar Imagens <i class="mdi mdi-plus"></i></a>
                    </div>
                </div>
                <table class="table table-bordered table-sortable">
                    <thead class="table-light">
                        <tr>
                            <th width="50px"></th>
                            <th width="30px" class="bs-checkbox">
                                <label><input name="btnSelectAll" value="btnDeleteGalleryService" type="checkbox"></label>
                            </th>
                            <th width="60px">Imagem</th>
                            <th width="90px">Ações</th>
                        </tr>
                    </thead>

                    <tbody data-route="{{route('admin.serv07.gallery-service.sorting')}}">
                        @foreach ($galleriesService as $galleryService)
                            <tr data-code="{{$galleryService->id}}">
                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                <td class="bs-checkbox align-middle">
                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$galleryService->id}}"></label>
                                </td>
                                <td class="align-middle avatar-group">
                                    @if ($galleryService->path_image)
                                        <a href="{{asset('storage/' . $galleryService->path_image)}}" data-fancybox="gallery">
                                            <div class="avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/' . $galleryService->path_image)}})"></div>
                                        </a>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <form action="{{route('admin.serv07.gallery-service.destroy',['SERV07ServicesGalleryService' => $galleryService->id])}}" method="POST">
                                        @method('DELETE') @csrf
                                        <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                                    </form>
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

{{-- BEGIN MODAL GALLERYSERVICE CREATE --}}
<div id="modal-gallery-service-create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="max-width: 1100px;">
        <div class="modal-content">
            <div class="modal-header p-3 pt-2 pb-2">
                <h4 class="page-title">Cadastrar Imagens</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-3 pt-0 pb-3">
                @include('Admin.cruds.Services.SERV07.GalleryService.form')
            </div>
        </div>
    </div>
</div>
{{-- END MODAL GALLERYSERVICE CREATE --}}
