<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <button id="btSubmitDelete" data-route="" type="button" class="btn btn-danger btnDeleteTopic" style="display: none;">Deletar selecionados</button>
                    </div>
                    <div class="col-6">
                        <a href="ss" class="btn btn-success float-end">Adicionar <i class="mdi mdi-plus"></i></a>
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
                            <th>Título</th>
                            <th>Link</th>
                            <th width="100px">Status</th>
                            <th width="90px">Ações</th>
                        </tr>
                    </thead>
                    
                    <tbody data-route="">
                        {{--  
                        @foreach ($topics as $topic)
                            <tr data-code="{{$topic->id}}">
                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                <td class="bs-checkbox align-middle">
                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$topic->id}}"></label>
                                </td>
                                <td class="align-middle avatar-group">
                                    @if ($topic->path_image_box)
                                        <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/' . $topic->path_image_box)}})"></div>
                                    @endif
                                </td>
                                <td class="align-middle">{{$topic->title}} <b>/</b> {{$topic->subtitle}}</td>
                                <td class="align-middle">{!! substr($topic->description,0,25) !!}</td>
                                <td class="align-middle">
                                    @if ($topic->active)
                                        <span class="badge bg-success">Ativo</span>
                                    @else
                                        <span class="badge bg-danger">Inativo</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{route('admin.copa02.topic.edit',['COPA02ContentPagesTopic' => $topic->id])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                        </div>
                                        <form action="{{route('admin.copa02.topic.destroy',['COPA02ContentPagesTopic' => $topic->id])}}" class="col-4" method="POST">
                                            @method('DELETE') @csrf
                                            <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach--}}
                    </tbody>
                </table>
            </div>
        </div> <!-- end card-->
    </div> <!-- end col-->
</div>
