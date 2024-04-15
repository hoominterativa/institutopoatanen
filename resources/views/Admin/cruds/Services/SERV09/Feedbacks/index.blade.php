<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <button id="btSubmitDelete" data-route="{{route('admin.serv09.feedback.destroySelected')}}" type="button" class="btn btn-danger btnDeleteFeedbacks" style="display: none;">Deletar selecionados</button>
                    </div>
                    <div class="col-6">
                        <a href="javascript:void(0)"  data-bs-target="#modal-feedbacks-create" data-bs-toggle="modal" class="btn btn-success float-end">Adicionar Feedback <i class="mdi mdi-plus"></i></a>
                    </div>
                </div>
                <table class="table table-bordered table-sortable">
                    <thead class="table-light">
                        <tr>
                            <th width="50px"></th>
                            <th width="30px" class="bs-checkbox">
                                <label><input name="btnSelectAll" value="btnDeleteFeedbacks" type="checkbox"></label>
                            </th>
                            <th>Imagem</th>
                            <th>Nome</th>
                            <th>Profissão</th>
                            <th>Depoimento</th>
                            <th width="100px">Status</th>
                            <th width="90px">Ações</th>
                        </tr>
                    </thead>

                    <tbody data-route="{{route('admin.serv09.feedback.sorting')}}">
                        @foreach ($feedbacks as $feedback)
                            <tr data-code="{{$feedback->id}}">
                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                <td class="bs-checkbox align-middle">
                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$feedback->id}}"></label>
                                </td>
                                <td class="align-middle avatar-group">
                                    @if ($feedback->path_image)
                                        <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/' . $feedback->path_image)}})"></div>
                                    @endif
                                </td>
                                <td class="align-middle">{{$feedback->name}}</td>
                                <td class="align-middle">{{$feedback->profession}}</td>
                                <td class="align-middle">{!! substr($feedback->text, 0, 20)!!}<b>...</b></td>
                                <td class="align-middle">
                                    @if ($feedback->active)
                                        <span class="badge bg-success">Ativo</span>
                                    @else
                                        <span class="badge bg-danger">Inativo</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="javascript:void(0)" data-bs-target="#modal-feedbacks-update-{{$feedback->id}}" data-bs-toggle="modal" class="btn-icon mdi mdi-square-edit-outline"></a>
                                        </div>
                                        <form action="{{route('admin.serv09.feedback.destroy',['SERV09ServicesFeedback' => $feedback->id])}}" class="col-4" method="POST">
                                            @method('DELETE') @csrf
                                            <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                                        </form>
                                        {{-- BEGIN MODAL FEEDBACK UPDATE --}}
                                        <div id="modal-feedbacks-update-{{$feedback->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog" style="max-width: 1100px;">
                                                <div class="modal-content">
                                                    <div class="modal-header p-3 pt-2 pb-2">
                                                        <h4 class="page-title">Editar Tópico</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body p-3 pt-0 pb-3">
                                                        @include('Admin.cruds.Services.SERV09.Feedbacks.form',[
                                                            'feedback' => $feedback
                                                        ])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- END MODAL FEEDBACK UPDATE --}}
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

{{-- BEGIN MODAL FEEDBACK CREATE --}}
<div id="modal-feedbacks-create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="max-width: 1100px;">
        <div class="modal-content">
            <div class="modal-header p-3 pt-2 pb-2">
                <h4 class="page-title">Cadastrar Tópico</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-3 pt-0 pb-3">
                @include('Admin.cruds.Services.SERV09.Feedbacks.form',[
                    'feedback' => null
                ])
            </div>
        </div>
    </div>
</div>
{{-- END MODAL FEEDBACK CREATE --}}
