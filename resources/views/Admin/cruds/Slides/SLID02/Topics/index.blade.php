<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <button id="btSubmitDelete" data-route="{{ route('admin.slid02.topic.destroySelected') }}"
                            type="button" class="btn btn-danger" style="display: none;">Deletar selecionados</button>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.slid02.topic.create') }}" class="btn btn-success float-end">Adicionar
                            novo <i class="mdi mdi-plus"></i></a>
                    </div>
                </div>
                <table class="table table-bordered table-sortable">
                    <thead class="table-light">
                        <tr>
                            <th width="50px"></th>
                            <th width="30px" class="bs-checkbox">
                                <label><input name="btnSelectAll" value="" type="checkbox"></label>
                            </th>
                            <th>Imagem</th>
                            <th>Link</th>
                            <th width="100px">Status</th>
                            <th width="90px">Ações</th>
                        </tr>
                    </thead>

                    <tbody data-route="{{ route('admin.slid02.topic.sorting') }}">
                        @foreach ($topics as $topic)
                            <tr data-code="{{ $topic->id }}">
                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span>
                                </td>
                                <td class="bs-checkbox align-middle">
                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox"
                                            value="{{ $topic->id }}"></label>
                                </td>
                                <td class="align-middle avatar-group">
                                    <div class="avatar-group-item avatar-bg rounded-circle avatar-sm"
                                        style="background-image: url({{ asset('Admin/assets/' . $topic->path_image_icon) }})">
                                    </div>
                                </td>
                                <td class="align-middle">{{ $topic->link }}</td>
                                <td class="align-middle">
                                    @switch($topic->active)
                                        @case(1)
                                            <span class="badge bg-success">Ativo</span>
                                        @break

                                        @case(0)
                                            <span class="badge bg-danger">Inativo</span>
                                        @break
                                    @endswitch
                                </td>
                                <td class="align-middle">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{ route('admin.slid02.topic.edit', ['SLID02SlidesTopic' => $topic->id]) }}"
                                                class="btn-icon mdi mdi-square-edit-outline"></a>
                                        </div>
                                        <form
                                            action="{{ route('admin.slid02.topic.destroy', ['SLID02SlidesTopic' => $topic->id]) }}"
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
<!-- end row -->
