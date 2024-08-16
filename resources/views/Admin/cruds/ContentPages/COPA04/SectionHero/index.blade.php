
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <button id="btSubmitDelete" data-route="{{route('admin.copa04.sectionHero.destroySelected')}}" type="button" class="btn btn-danger btnDeleteContentPages" style="display: none;">Deletar selecionados</button>
                    </div>
                    <div class="col-6">
                        @if (!$sectionHero)
                            <a href="{{route('admin.copa04.sectionHero.create')}}" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                        @endif
                    </div>
                </div>
                <table class="table table-bordered table-sortable">
                    <thead class="table-light">
                        <tr>
                            <th>Título</th>
                            <th>Imagem</th>
                            <th width="100px">Status</th>
                            <th width="90px">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if ($sectionHero)
                            <tr>
                                <td class="align-middle">{{$sectionHero->title}}</td>
                                <td class="align-middle avatar-group">
                                    <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/'.$sectionHero->path_image)}})"></div>
                                </td>
                                <td class="align-middle">
                                    @switch($sectionHero->active)
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
                                            <a href="{{route('admin.copa04.sectionHero.edit',['COPA04ContentPagesSectionHero' => $sectionHero->id])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                        </div>
                                        <form action="{{route('admin.copa04.sectionHero.destroy',['COPA04ContentPagesSectionHero' => $sectionHero->id])}}" class="col-4" method="POST">
                                            @method('DELETE') @csrf
                                            <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div> <!-- end card-->
    </div> <!-- end col-->
</div>
<!-- end row -->
