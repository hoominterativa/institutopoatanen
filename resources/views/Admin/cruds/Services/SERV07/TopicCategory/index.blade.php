<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <button id="btSubmitDelete"
                            data-route="{{ route('admin.serv07.topic-category.destroySelected') }}" type="button" class="btn btn-danger btnDelete" style="display: none;">Deletar selecionados</button>
                    </div>
                    <div class="col-6">
                        <a href="javascript:void(0)" data-bs-target="#modal-topic-category-create" data-bs-toggle="modal" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                    </div>
                </div>
                <table class="table table-bordered table-sortable">
                    <thead class="table-light">
                        <tr>
                            <th width="50px"></th>
                            <th width="30px" class="bs-checkbox">
                                <label><input name="btnSelectAll" value="btnDelete" type="checkbox"></label>
                            </th>
                            <th>Imagem</th>
                            <th>Título</th>
                            <th>Descrição</th>
                            <th width="100px">Status</th>
                            <th width="90px">Ações</th>
                        </tr>
                    </thead>

                    <tbody data-route="{{ route('admin.serv07.topic-category.sorting') }}">
                        @foreach ($topicsCategory as $topicCategory)
                            <tr data-code="{{ $topicCategory->id }}">
                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                <td class="bs-checkbox align-middle">
                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{ $topicCategory->id }}"></label>
                                </td>
                                <td class="align-middle avatar-group">
                                    @if ($topicCategory->path_image || $topicCategory->path_image_icon)
                                        <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{ asset('storage/' . $topicCategory->path_image) }})"></div>
                                        <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{ asset('storage/' . $topicCategory->path_image_icon) }})"></div>
                                    @endif
                                </td>
                                <td class="align-middle">{{$topicCategory->title}}</td>
                                <td class="align-middle">{!! substr($topicCategory->description, 0, 30) !!}<b>...</b></td>
                                <td class="align-middle">
                                    @if ($topicCategory->active)
                                        <span class="badge bg-success">Ativo</span>
                                    @else
                                        <span class="badge bg-danger">Inativo</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="javascript:void(0)" data-bs-target="#modal-topic-category-update-{{ $topicCategory->id }}" data-bs-toggle="modal" class="btn-icon mdi mdi-square-edit-outline"></a>
                                        </div>
                                        <form action="{{ route('admin.serv07.topic-category.destroy', ['SERV07ServicesTopicCategory' => $topicCategory->id]) }}" class="col-4" method="POST">
                                            @method('DELETE') @csrf
                                            <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                                        </form>
                                        {{-- BEGIN MODAL SECTIONCATEGORY UPDATE --}}
                                        <div id="modal-topic-category-update-{{ $topicCategory->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog" style="max-width: 1100px;">
                                                <div class="modal-content">
                                                    <div class="modal-header p-3 pt-2 pb-2">
                                                        <h4 class="page-title">Atualizar Seção</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-3 pt-0 pb-3">
                                                        @include(
                                                            'Admin.cruds.Services.SERV07.TopicCategory.form',
                                                            [
                                                                'topicCategory' => $topicCategory,
                                                            ]
                                                        )
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- END MODAL SECTIONCATEGORY UPDATE --}}
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
{{-- BEGIN MODAL SECTIONCATEGORY CREATE --}}
<div id="modal-topic-category-create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="max-width: 1100px;">
        <div class="modal-content">
            <div class="modal-header p-3 pt-2 pb-2">
                <h4 class="page-title">Cadastrar Seção da categoria</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-3 pt-0 pb-3">
                @include('Admin.cruds.Services.SERV07.TopicCategory.form', [
                    'topicCategory' => null,
                ])
            </div>
        </div>
    </div>
</div>
{{-- END MODAL SECTIONCATEGORY CREATE --}}

