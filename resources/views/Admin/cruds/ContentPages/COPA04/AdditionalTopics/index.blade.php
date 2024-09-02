<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <button id="btSubmitDelete" data-route="{{route('admin.copa04.additionalTopics.destroySelected')}}" type="button" class="btn btn-danger btnDeleteContentPages" style="display: none;">Deletar selecionados</button>
                    </div>
                    <div class="col-6">
                        <a href="javascript:void(0)"  data-bs-target="#modal-additionalTopics-create" data-bs-toggle="modal" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                        <div id="modal-additionalTopics-create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog" style="max-width: 900px;">
                                <div class="modal-content">
                                    <div class="modal-header p-3 pt-2 pb-2">
                                        <h4 class="page-title">Cadastrar Tópico adicional</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                        
                                    <div class="modal-body p-3 pt-0 pb-3">
                                        {!! Form::model(null, ['route' => 'admin.copa04.additionalTopics.store', 'class'=>'parsley-validate', 'files'=>true]) !!}
                                            @include('Admin.cruds.ContentPages.COPA04.AdditionalTopics.form', ['contentPage' => $contentPage])

                                            {!! Form::button('Cadastrar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                                            <a href="{{route('admin.copa04.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                                        {!! Form::close() !!}                                        
                                    </div>
                                </div>
                            </div>
                        </div>
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
                            <th width="100px">Status</th>
                            <th width="90px">Ações</th>
                        </tr>
                    </thead>
                    <tbody data-route="{{route('admin.copa04.additionalTopics.sorting')}}">
                        @foreach($additionalTopics as $topic)
                            <tr data-code="{{$topic->id}}">
                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                <td class="bs-checkbox align-middle">
                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$topic->id}}"></label>
                                </td>
                                <td class="align-middle">{{$topic->title}}</td>
                                <td class="align-middle">
                                    @switch($topic->active)
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
                                            <a href="javascript:void(0)"  data-bs-target="#modal-additionalTopics-edit" data-bs-toggle="modal"> <i class="btn-icon mdi mdi-square-edit-outline"></i></a>
                                            <div id="modal-additionalTopics-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog" style="max-width: 900px;">
                                                    <div class="modal-content">
                                                        <div class="modal-header p-3 pt-2 pb-2">
                                                            <h4 class="page-title">Cadastrar Tópico adicional</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                            
                                                        <div class="modal-body p-3 pt-0 pb-3">
                                                            {!! Form::model($topic, ['route' => ['admin.copa04.additionalTopics.update', $topic->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
                                                                @include('Admin.cruds.ContentPages.COPA04.AdditionalTopics.form')
                                                                {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                                                                <a href="{{route('admin.copa04.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                                                            {!! Form::close() !!}                                     
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="{{route('admin.copa04.additionalTopics.destroy',['AdditionalTopics' => $topic->id])}}" class="col-4" method="POST">
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

