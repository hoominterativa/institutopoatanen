<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <button id="btSubmitDelete"
                            data-route="{{ route('admin.unit03.content.destroySelected') }}" type="button" class="btn btn-danger btDeleteContents" style="display: none;">Deletar selecionados</button>
                    </div>
                    <div class="col-6">
                        <a href="javascript:void(0)" data-bs-target="#modal-content-create" data-bs-toggle="modal" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                    </div>
                </div>
                <table class="table table-bordered table-sortable">
                    <thead class="table-light">
                        <tr>
                            <th width="50px"></th>
                            <th width="30px" class="bs-checkbox">
                                <label><input name="btnSelectAll" value="btDeleteContents" type="checkbox"></label>
                            </th>
                            <th>Imagem</th>
                            <th>Título/Subtítulo</th>
                            <th>Texto</th>
                            <th>Título do botão</th>
                            <th>Link</th>
                            <th width="100px">Status</th>
                            <th width="90px">Ações</th>
                        </tr>
                    </thead>

                    <tbody data-route="{{ route('admin.unit03.content.sorting') }}">
                        @foreach ($contents as $content)
                            <tr data-code="{{ $content->id }}">
                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                <td class="bs-checkbox align-middle">
                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{ $content->id }}"></label>
                                </td>
                                <td class="align-middle avatar-group">
                                    @if ($content->path_image)
                                        <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{ asset('storage/' . $content->path_image) }})"></div>
                                    @endif
                                    @if ($content->path_image_desktop)
                                        <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{ asset('storage/' . $content->path_image_desktop) }})"></div>
                                    @endif
                                    @if ($content->path_image_mobile)
                                        <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{ asset('storage/' . $content->path_image_mobile) }})"></div>
                                    @endif
                                </td>
                                <td class="align-middle">{{$content->title}} <b>/</b>{{$content->subtitle}}</td>
                                <td class="align-middle">{!! substr($content->text, 0, 30) !!}</td>
                                <td class="align-middle">{{$content->title_button}}</td>
                                <td class="align-middle"><a href="{{ $content->link_button }}" target="_blank" class="mdi mdi-link-box-variant mdi-24px"></a></td>
                                <td class="align-middle">
                                    @if ($content->active)
                                        <span class="badge bg-success">Ativo</span>
                                    @else
                                        <span class="badge bg-danger">Inativo</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="javascript:void(0)" data-bs-target="#modal-content-update-{{ $content->id }}" data-bs-toggle="modal" class="btn-icon mdi mdi-square-edit-outline"></a>
                                        </div>
                                        <form action="{{ route('admin.unit03.content.destroy', ['UNIT03UnitsContent' => $content->id]) }}" class="col-4" method="POST">
                                            @method('DELETE') @csrf
                                            <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                                        </form>
                                        {{-- BEGIN MODAL CONTENT UPDATE --}}
                                        <div id="modal-content-update-{{ $content->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog" style="max-width: 1100px;">
                                                <div class="modal-content">
                                                    <div class="modal-header p-3 pt-2 pb-2">
                                                        <h4 class="page-title">Atualizar Conteúdo</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-3 pt-0 pb-3">
                                                        @include(
                                                            'Admin.cruds.Units.UNIT03.Content.form',
                                                            [
                                                                'content' => $content,
                                                            ]
                                                        )
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- END MODAL CONTENT UPDATE --}}
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
{{-- BEGIN MODAL CONTENT CREATE --}}
<div id="modal-content-create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="max-width: 1100px;">
        <div class="modal-content">
            <div class="modal-header p-3 pt-2 pb-2">
                <h4 class="page-title">Cadastrar Conteúdo</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-3 pt-0 pb-3">
                @include('Admin.cruds.Units.UNIT03.Content.form', [
                    'content' => null,
                ])
            </div>
        </div>
    </div>
</div>
{{-- END MODAL CONTENT CREATE --}}

