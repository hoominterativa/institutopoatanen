<div id="containerTopicos">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                </div>
                <h4 class="page-title">Tópicos</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <button id="btSubmitDelete" data-route="{{ route('admin.serv04.topic.destroySelected') }}"
                                type="button" class="btn btn-danger btnDeleteTopic" style="display: none;">Deletar
                                selecionados</button>
                        </div>
                        <div class="col-6">
                            <a href="javascript:void(0)" data-bs-target="#modal-topic-create" data-bs-toggle="modal"
                                class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                        </div>
                    </div>
                    <table class="table table-bordered table-sortable">
                        <thead class="table-light">
                            <tr>
                                <th width="50px"></th>
                                <th width="30px" class="bs-checkbox">
                                    <label><input name="btnSelectAll" value="btnDeleteTopic" type="checkbox"></label>
                                </th>
                                <th>Título</th>
                                <th>Texto</th>
                                <th width="100px">Status</th>
                                <th width="90px">Ações</th>
                            </tr>
                        </thead>

                        <tbody data-route="{{ route('admin.serv04.topic.sorting') }}">
                            @foreach ($topics as $topic)
                                <tr data-code="{{ $topic->id }}">
                                    <td class="align-middle"><span
                                            class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                    <td class="bs-checkbox align-middle">
                                        <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox"
                                                value="{{ $topic->id }}"></label>
                                    </td>
                                    <td class="align-middle">{{ $topic->title }}</td>
                                    <td class="align-middle">{!! substr($topic->text, 0, 50) !!}
                                    </td>
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
                                                <a href="javascript:void(0)"
                                                    data-bs-target="#modal-topic-update-{{ $topic->id }}"
                                                    data-bs-toggle="modal"
                                                    class="btn-icon mdi mdi-square-edit-outline"></a>
                                            </div>
                                            <form
                                                action="{{ route('admin.serv04.topic.destroy', ['SERV04ServicesTopic' => $topic->id]) }}"
                                                class="col-4" method="POST">
                                                @method('DELETE') @csrf
                                                <button type="button" class="btn-icon btSubmitDeleteItem"><i
                                                        class="mdi mdi-trash-can"></i></button>
                                            </form>
                                            {{-- BEGIN MODAL TOPIC UPDATE --}}
                                            <div id="modal-topic-update-{{ $topic->id }}" class="modal fade"
                                                tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                                aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog" style="max-width: 750px;">
                                                    <div class="modal-content">
                                                        <div class="modal-header p-3 pt-2 pb-2">
                                                            <h4 class="page-title">Cadastrar Tópicos</h4>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body p-3 pt-0 pb-3">
                                                            @include(
                                                                'Admin.cruds.Services.SERV04.Topics.form',
                                                                [
                                                                    'topic' => $topic,
                                                                ]
                                                            )
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- END MODAL TOPIC UPDATE --}}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- PAGINATION --}}
                    <div class="mt-3 float-end">
                        {{ $topics->links() }}
                    </div>
                </div>
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
</div>

{{-- BEGIN MODAL TOPIC CREATE --}}
<div id="modal-topic-create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="max-width: 750px;">
        <div class="modal-content">
            <div class="modal-header p-3 pt-2 pb-2">
                <h4 class="page-title">Cadastrar Tópicos</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-3 pt-0 pb-3">
                @include('Admin.cruds.Services.SERV04.Topics.form', [
                    'topic' => null,
                ])
            </div>
        </div>
    </div>
</div>
{{-- END MODAL TOPIC CREATE --}}
