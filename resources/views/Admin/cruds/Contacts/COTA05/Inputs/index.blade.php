<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <button id="btSubmitDelete" data-route="{{route('admin.cota05.destroySelected')}}" type="button" class="btn btn-danger btnDeleteInputs" style="display: none;">Deletar selecionados</button>
                    </div>
                </div>
                <table class="table table-bordered table-sortable">
                    <thead class="table-light">
                        <tr>
                            <th width="50px"></th>
                            <th width="30px" class="bs-checkbox">
                                <label><input name="btnSelectAll" value="btnDeleteInputs" type="checkbox"></label>
                            </th>
                            <th>Página</th>
                            <th>Informações</th>
                            <th width="90px">Ações</th>
                        </tr>
                    </thead>

                    <tbody data-route="{{route('admin.cota05.sorting')}}">
                        @foreach ($inputs as $input)
                            <tr data-code="{{$input->id}}">
                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                <td class="bs-checkbox align-middle">
                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$input->id}}"></label>
                                </td>
                                <td class="align-middle">{{$input->target_lead}}</td>
                                <td class="align-middle">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Chave</th>
                                                <th>Valor</th>
                                                <th>Arquivo de Solicitação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($input->json as $key => $value)
                                                <tr>
                                                    <td>{{$key}}</td>
                                                    <td>{{$value['value']}}</td>
                                                    <td>{{$value['requestFile']}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                                {{-- <td class="align-middle">
                                    <div class="row">
                                        <form action="{{route('admin.cota05.destroy',['COTA05Contacts' => $input->id])}}" class="col-4" method="POST">
                                            @method('DELETE') @csrf
                                            <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                                        </form>
                                    </div>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> <!-- end card-->
    </div> <!-- end col-->
</div>
<!-- end row -->

