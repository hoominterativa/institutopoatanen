<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <button id="btSubmitDelete" data-route="{{route('admin.copa04.additionalContentImages.destroySelected')}}" type="button" class="btn btn-danger btnDeleteContentPages" style="display: none;">Deletar selecionados</button>
                    </div>
                    <div class="col-6">
                        <a href="{{route('admin.copa04.additionalContentImages.create')}}" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                    </div>
                </div>
                <table class="table table-bordered table-sortable">
                    <thead class="table-light">
                        <tr>
                            <th width="50px"></th>
                            <th width="30px" class="bs-checkbox">
                                {{-- INSERIR UMA CLASSE ÙNICA NO "#btSubmitDelete" E NO VALUE DO INPUT ABAIXO --}}
                                <label><input name="btnSelectAll" value="btnDeleteContentPages" type="checkbox"></label>
                            </th>
                            <th>Título</th>
                            <th>subtitulo</th>
                            <th width="100px">Status</th>
                            <th width="90px">Ações</th>
                        </tr>
                    </thead>
                        <tbody data-route="{{route('admin.copa04.additionalContentImages.sorting')}}">
                            @foreach($AdditionalContentImages as $additionalContentImage)
                                <tr data-code="{{$additionalContentImage->id}}">
                                    <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                    <td class="bs-checkbox align-middle">
                                        <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$additionalContentImage->id}}"></label>
                                    </td>
                                    <td class="align-middle">{{$additionalContentImage->title}}</td>
                                    <td class="align-middle">{{$additionalContentImage->subtitle}}</td>
                                    <td class="align-middle">
                                        @switch($additionalContentImage->active)
                                            @case(1)
                                                <span class="badge bg-success">Ativo</span>
                                                @break
                                            @case(0)
                                                <span class="badge bg-danger">Inativo</span>
                                                @break
                                            @default                                                            
                                        @endswitch
                                    </td>
                                    <td class="align-middle">
                                        <div class="row">
                                            <div class="col-4">
                                                <a href="{{route('admin.copa04.additionalContentImages.edit',['AdditionalContentImages' => $additionalContentImage->id])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                            </div>
                                            <form action="{{route('admin.copa04.additionalContentImages.destroy',['AdditionalContentImages' => $additionalContentImage->id])}}" class="col-4" method="POST">
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
<!-- end row -->

