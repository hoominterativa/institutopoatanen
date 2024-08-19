<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <button id="btSubmitDelete" data-route="{{ route('admin.bran02.marcas.destroySelected') }}" type="button" class="btn btn-danger btnDeleteTopic"
                            style="display: none;">Deletar selecionados</button>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.bran02.marcas.create') }}"
                            class="btn btn-success float-end">Adicionar <i class="mdi mdi-plus"></i></a>
                    </div>

                </div>
                <table class="table table-bordered table-sortable">
                    <thead class="table-light">
                        <tr>
                            <th width="50px"></th>
                            <th width="30px" class="bs-checkbox">
                                <label><input name="btnSelectAll" value="btnDeleteTopic" type="checkbox"></label>
                            </th>
                            <th>Imagems</th>
                            <th>Link</th>
                            <th width="100px">Destaque</th>
                            <th width="100px">Status</th>
                            <th width="90px">Ações</th>
                        </tr>
                    </thead>
                    <tbody data-route="{{ route('admin.bran02.marcas.sorting') }}">
                        @foreach ($bran02marcas as $produtos)
                            <tr data-code="{{ $produtos->id }}">
                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span>
                                </td>
                                <td class="bs-checkbox align-middle">
                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox"
                                            value="{{ $produtos->id }}"></label>
                                </td>
                                <td class="align-middle avatar-group">
                                    @if ($produtos->path_image)
                                        <div class="avatar-group-item avatar-bg rounded-circle avatar-sm"
                                            style="background-image: url({{ asset('storage/' . $produtos->path_image) }})">
                                        </div>
                                    @endif
                                </td>
                                <td class="align-middle"><a href="{{ $produtos->button_link }}">{{ $produtos->button_link }}</a></td>
                                <td class="align-middle">
                                    @if ($produtos->highlighted)
                                        <span class="badge bg-success">Destacado</span>
                                    @else
                                        <span class="badge bg-danger">Normal</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @if ($produtos->active)
                                        <span class="badge bg-success">Ativo</span>
                                    @else
                                        <span class="badge bg-danger">Inativo</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{ route('admin.bran02.marcas.edit', ['BRAN02BrandsMarcas' => $produtos->id]) }}"
                                                class="btn-icon mdi mdi-square-edit-outline"></a>
                                        </div>
                                        <form
                                            action="{{ route('admin.bran02.marcas.destroy', ['BRAN02BrandsMarcas' => $produtos->id]) }}"
                                            class="col-4" method="POST">
                                            @method('DELETE') @csrf
                                            <button type="button" class="btn-icon btSubmitDeleteItem"><i
                                                    class="mdi mdi-trash-can"></i></button>
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
