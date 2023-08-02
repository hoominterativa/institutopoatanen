<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <button id="btSubmitDelete"
                            data-route="{{ route('admin.serv07.section-category.destroySelected') }}" type="button" class="btn btn-danger btnDelete" style="display: none;">Deletar selecionados</button>
                    </div>
                    <div class="col-6">
                        <a href="javascript:void(0)" data-bs-target="#modal-section-category-create" data-bs-toggle="modal" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
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
                            <th>Título/Subtítle</th>
                            <th>Descrição</th>
                            <th>Título botão</th>
                            <th>Link botão</th>
                            <th width="100px">Status</th>
                            <th width="90px">Ações</th>
                        </tr>
                    </thead>

                    <tbody data-route="{{ route('admin.serv07.section-category.sorting') }}">
                        @foreach ($sectionsCategory as $sectionCategory)
                            <tr data-code="{{ $sectionCategory->id }}">
                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                <td class="bs-checkbox align-middle">
                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{ $sectionCategory->id }}"></label>
                                </td>
                                <td class="align-middle avatar-group">
                                    @if ($sectionCategory->path_image)
                                        <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{ asset('storage/' . $sectionCategory->path_image) }})"></div>
                                    @endif
                                </td>
                                <td class="align-middle">{{$sectionCategory->title}} <b>/</b> {{$sectionCategory->subtitle}}</td>
                                <td class="align-middle">{!! substr($sectionCategory->description, 0, 30) !!}<b>...</b></td>
                                <td class="align-middle">{{$sectionCategory->title_button}}</td>
                                <td class="align-middle"><a href="{{$sectionCategory->link_button}}" target="_blank" class="mdi mdi-link-box-variant mdi-24px"></a></td>
                                <td class="align-middle">
                                    @if ($sectionCategory->active)
                                        <span class="badge bg-success">Ativo</span>
                                    @else
                                        <span class="badge bg-danger">Inativo</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="javascript:void(0)" data-bs-target="#modal-section-category-update-{{ $sectionCategory->id }}" data-bs-toggle="modal" class="btn-icon mdi mdi-square-edit-outline"></a>
                                        </div>
                                        <form action="{{ route('admin.serv07.section-category.destroy', ['SERV05ServicesSectionCategory' => $sectionCategory->id]) }}" class="col-4" method="POST">
                                            @method('DELETE') @csrf
                                            <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                                        </form>
                                        {{-- BEGIN MODAL SECTIONCATEGORY UPDATE --}}
                                        <div id="modal-section-category-update-{{ $sectionCategory->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog" style="max-width: 1100px;">
                                                <div class="modal-content">
                                                    <div class="modal-header p-3 pt-2 pb-2">
                                                        <h4 class="page-title">Atualizar Seção</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-3 pt-0 pb-3">
                                                        @include(
                                                            'Admin.cruds.Services.SERV07.SectionCategory.form',
                                                            [
                                                                'sectionCategory' => $sectionCategory,
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
<div id="modal-section-category-create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="max-width: 1100px;">
        <div class="modal-content">
            <div class="modal-header p-3 pt-2 pb-2">
                <h4 class="page-title">Cadastrar Seção da categoria</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-3 pt-0 pb-3">
                @include('Admin.cruds.Services.SERV07.SectionCategory.form', [
                    'sectionCategory' => null,
                ])
            </div>
        </div>
    </div>
</div>
{{-- END MODAL SECTIONCATEGORY CREATE --}}

