<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <button id="btSubmitDelete" data-route="{{route('admin.abou05.content.destroySelected')}}" type="button" class="btn btn-danger btnDeleteContent" style="display: none;">Deletar selecionados</button>
                    </div>
                    <div class="col-6">
                        <a href="{{route('admin.abou05.content.create')}}" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                    </div>
                </div>
                <table class="table table-bordered table-sortable">
                    <thead class="table-light">
                        <tr>
                            <th width="50px"></th>
                            <th width="30px" class="bs-checkbox">
                                <label><input name="btnSelectAll" value="btnDeleteContent" type="checkbox"></label>
                            </th>
                            <th>Imagem</th>
                            <th>Título/Subtítulo</th>
                            <th>Texto</th>
                            <th>Título/Subtítulo "Lightbox"</th>
                            <th>Texto "Lightbox"</th>
                            <th width="100px">Status</th>
                            <th width="90px">Ações</th>
                        </tr>
                    </thead>

                    <tbody data-route="{{route('admin.abou05.content.sorting')}}">
                        @foreach ($contents as $content)
                            <tr data-code="{{$content->id}}">
                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                <td class="bs-checkbox align-middle">
                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$content->id}}"></label>
                                </td>
                                <td class="align-middle avatar-group">
                                    @if ($content->path_image || $content->path_image_inner)
                                        <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/' . $content->path_image)}})"></div>
                                        <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/' . $content->path_image_inner)}})"></div>
                                    @endif
                                </td>
                                <td class="align-middle">{{$content->title}} <b>/</b>{{$content->subtitle}}</td>
                                <td class="align-middle">{!! substr($content->text, 0, 25) !!}<b>...</b></td>
                                <td class="align-middle">{{$content->title_inner}} <b>/</b>{{$content->subtitle_inner}}</td>
                                <td class="align-middle">{!! substr($content->text_inner, 0, 25) !!}<b>...</b></td>
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
                                            <a href="{{route('admin.abou05.content.edit',['ABOU05AboutsContent' => $content->id])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                        </div>
                                        <form action="{{route('admin.abou05.content.destroy',['ABOU05AboutsContent' => $content->id])}}" class="col-4" method="POST">
                                            @method('DELETE') @csrf
                                            <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
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

