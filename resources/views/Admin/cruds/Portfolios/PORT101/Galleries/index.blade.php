<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <button id="btSubmitDelete"
                            data-route="{{ route('admin.port101.gallery.destroySelected') }}" type="button"
                            class="btn btn-danger btDeleteGalleries" style="display: none;">Deletar
                            selecionados</button>
                    </div>
                    <div class="col-6">
                        <a href="javascript:void(0)" data-bs-target="#modal-gallery-create" data-bs-toggle="modal"
                            class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                    </div>
                </div>
                <table class="table table-bordered table-sortable">
                    <thead class="table-light">
                        <tr>
                            <th width="50px"></th>
                            <th width="30px" class="bs-checkbox">
                                <label><input name="btnSelectAll" value="btDeleteGalleries" type="checkbox"></label>
                            </th>
                            <th>Imagem</th>
                            <th>Link do vídeo</th>
                            <th width="90px">Ações</th>
                        </tr>
                    </thead>

                    <tbody data-route="{{ route('admin.port101.gallery.sorting') }}">
                        @foreach ($galleries as $gallery)
                            <tr data-code="{{ $gallery->id }}">
                                <td class="align-middle"><span
                                        class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                <td class="bs-checkbox align-middle">
                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox"
                                            value="{{ $gallery->id }}"></label>
                                </td>
                                <td class="align-middle avatar-group">
                                    @if ($gallery->path_image)
                                        <div class="avatar-group-item avatar-bg rounded-circle avatar-sm"
                                            style="background-image: url({{ asset('storage/' . $gallery->path_image) }})">
                                        </div>
                                    @endif
                                </td>
                                <td class="align-middle">{{ $gallery->link_video }}</td>
                                <td class="align-middle">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="javascript:void(0)"
                                                data-bs-target="#modal-gallery-update-{{ $gallery->id }}"
                                                data-bs-toggle="modal"
                                                class="btn-icon mdi mdi-square-edit-outline"></a>
                                        </div>
                                        <form
                                            action="{{ route('admin.port101.gallery.destroy', ['PORT101PortfoliosGallery' => $gallery->id]) }}"
                                            class="col-4" method="POST">
                                            @method('DELETE') @csrf
                                            <button type="button" class="btn-icon btSubmitDeleteItem"><i
                                                    class="mdi mdi-trash-can"></i></button>
                                        </form>
                                        {{-- BEGIN MODAL GALLERY UPDATE --}}
                                        <div id="modal-gallery-update-{{ $gallery->id }}" class="modal fade"
                                            tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                            aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog" style="max-width: 1100px;">
                                                <div class="modal-content">
                                                    <div class="modal-header p-3 pt-2 pb-2">
                                                        <h4 class="page-title">Atualizar fotos</h4>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body p-3 pt-0 pb-3">
                                                        @include(
                                                            'Admin.cruds.Portfolios.PORT101.Galleries.form',
                                                            [
                                                                'gallery' => $gallery,
                                                            ]
                                                        )
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- END MODAL GALLERY UPDATE --}}
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
{{-- BEGIN MODAL GALLERY CREATE --}}
<div id="modal-gallery-create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="max-width: 1100px;">
        <div class="modal-content">
            <div class="modal-header p-3 pt-2 pb-2">
                <h4 class="page-title">Cadastrar Fotos</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-3 pt-0 pb-3">
                @include('Admin.cruds.Portfolios.PORT101.Galleries.form', [
                    'gallery' => null,
                ])
            </div>
        </div>
    </div>
</div>
{{-- END MODAL GALLERY CREATE --}}
