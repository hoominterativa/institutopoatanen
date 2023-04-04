<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <button id="btSubmitDelete" data-route="{{ route('admin.topi102.featuredtopic.destroySelected') }}"
                            type="button" class="btn btn-danger btnDeleteTopics" style="display: none;">Deletar
                            selecionados</button>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.topi102.featuredtopic.create') }}" class="btn btn-success float-end">Adicionar novo
                            <i class="mdi mdi-plus"></i></a>
                    </div>
                </div>
                <table class="table table-bordered table-sortable">
                    <thead class="table-light">
                        <tr>
                            <th width="50px"></th>
                            <th width="30px" class="bs-checkbox">
                                <label><input name="btnSelectAll" value="btnDeleteTopics" type="checkbox"></label>
                            </th>
                            <th>Título</th>
                            <th>Quantidade</th>
                            <th width="100px">Status</th>
                            <th width="90px">Ações</th>
                        </tr>
                    </thead>

                    <tbody data-route="{{ route('admin.topi102.featuredtopic.sorting') }}">
                        @foreach ($featuredtopics as $featuredtopic)
                            <tr data-code="{{ $featuredtopic->id }}">
                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span>
                                </td>
                                <td class="bs-checkbox align-middle">
                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox"
                                            value="{{ $featuredtopic->id }}"></label>
                                </td>
                                <td class="align-middle">{{ $featuredtopic->title }}</td>
                                <td class="align-middle">{{ $featuredtopic->quantity }}</td>
                                <td class="align-middle">
                                    @switch($featuredtopic->active)
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
                                            <a href="{{ route('admin.topi102.featuredtopic.edit', ['TOPI102TopicsFeaturedTopics' => $featuredtopic->id]) }}"
                                                class="btn-icon mdi mdi-square-edit-outline"></a>
                                        </div>
                                        <form
                                            action="{{ route('admin.topi102.featuredtopic.destroy', ['TOPI102TopicsFeaturedTopics' => $featuredtopic->id]) }}"
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

                {{-- PAGINATION --}}
                <div class="mt-3 float-end">
                    {{ $featuredtopics->links() }}
                </div>
            </div>
        </div> <!-- end card-->
    </div> <!-- end col-->
</div>
