
<div class="row mb-3">
    <div class="col-6">
        <button id="btSubmitDelete" data-route="{{route('admin.copa01.archive.destroySelected')}}" type="button" class="btn btn-danger btnDeleteContentPages" style="display: none;">Deletar selecionados</button>
    </div>
</div>
<table class="table table-bordered table-sortable">
    <thead class="table-light">
        <tr>
            <th width="50px"></th>
            <th width="30px" class="bs-checkbox">
                <label><input name="btnSelectAll" value="btnDeleteContentPages" type="checkbox"></label>
            </th>
            <th>Title</th>
            <th>Arquivo</th>
            <th width="90px">Ações</th>
        </tr>
    </thead>

    <tbody data-route="{{route('admin.copa01.archive.sorting')}}">
        @foreach ($archives as $archive)
            <tr data-code="{{$archive->id}}">
                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                <td class="bs-checkbox align-middle">
                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$archive->id}}"></label>
                </td>
                <td class="align-middle">{{$archive->title}}</td>
                <td class="align-middle"><a href="{{asset('storage/'.$archive->path_archive)}}" target="_blank" rel="noopener noreferrer"><i class="mdi mdi-cloud-download font-20"></i></a></td>
                <td class="align-middle">
                    <div class="row">
                        <div class="col-4">
                            <a href="javascript:void(0)" data-bs-target="#modal-archive-update-{{$archive->id}}" data-bs-toggle="modal" class="btn-icon mdi mdi-square-edit-outline"></a>
                        </div>
                        <form action="{{route('admin.copa01.archive.destroy',['COPA01ContentPagesSectionArchive' => $archive->id])}}" class="col-4" method="POST">
                            @method('DELETE') @csrf
                            <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                        </form>
                        {{-- BEGIN MODAL ARCHIVE UPDATE --}}
                        <div id="modal-archive-update-{{$archive->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog" style="max-width: 1100px;">
                                <div class="modal-content">
                                    <div class="modal-header p-3 pt-2 pb-2">
                                        <h4 class="page-title">Editar Arquivo</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body p-3 pt-0 pb-3">
                                        @include('Admin.cruds.ContentPages.COPA01.Archives.form',[
                                            'archive' => $archive,
                                            'section' => $section
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- END MODAL ARCHIVE UPDATE --}}
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
