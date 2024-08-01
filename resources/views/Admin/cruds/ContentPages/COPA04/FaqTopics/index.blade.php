<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <button id="btSubmitDelete" data-route="{{route('admin.copa04.faqTopics.destroySelected')}}" type="button" class="btn btn-danger btnDeleteContentPages" style="display: none;">Deletar selecionados</button>
                    </div>
                    <div class="col-6">
                        <a href="{{route('admin.copa04.faqTopics.create')}}" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                    </div>
                </div>
                <table class="table table-bordered table-sortable">
                    <thead class="table-light">
                        <tr>
                            <th>Título</th>
                            <th width="100px">Status</th>
                            <th width="90px">Ações</th>
                        </tr>
                    </thead>
                    @foreach($faqs as $faq)
                        <tbody>
                            <tr>
                                <td class="align-middle">{{$faq->title}}</td>
                                <td class="align-middle">
                                    @switch($faq->active)
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
                                            <a href="{{route('admin.copa04.faqTopics.edit',['COPA04ContentPagesFaqTopics' => $faq->id])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                        </div>
                                        <form action="{{route('admin.copa04.faqTopics.destroy',['COPA04ContentPagesFaqTopics' => $faq->id])}}" class="col-4" method="POST">
                                            @method('DELETE') @csrf
                                            <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    @endforeach
                </table>
            </div>
        </div> <!-- end card-->
    </div> <!-- end col-->
</div>  
<!-- end row -->

