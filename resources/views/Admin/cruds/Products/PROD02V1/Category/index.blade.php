<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <button id="btSubmitDelete" data-route="{{route('admin.prod02v1.category.destroySelected')}}" type="button" class="btn btn-danger btnDeleteCategory" style="display: none;">Deletar selecionados</button>
                    </div>
                    <div class="col-6">
                        <a href="javascript:void(0)"  data-bs-target="#modal-category-create" data-bs-toggle="modal" class="btn btn-success float-end">Adicionar Categoria <i class="mdi mdi-plus"></i></a>
                    </div>
                </div>
                <table class="table table-bordered table-sortable">
                    <thead class="table-light">
                        <tr>
                            <th width="50px"></th>
                            <th width="30px" class="bs-checkbox">
                                <label><input name="btnSelectAll" value="btnDeleteCategory" type="checkbox"></label>
                            </th>
                            <th>Imagem</th>
                            <th>Title</th>
                            <th width="100px">Status</th>
                            <th width="90px">Ações</th>
                        </tr>
                    </thead>

                    <tbody data-route="{{route('admin.prod02v1.category.sorting')}}">
                        @foreach ($categories as $category)
                            <tr data-code="{{$category->id}}">
                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                <td class="bs-checkbox align-middle">
                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$category->id}}"></label>
                                </td>
                                <td class="align-middle avatar-group">
                                    @if ($category->path_image_icon)
                                        <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/' . $category->path_image_icon)}})"></div>
                                    @endif
                                </td>
                                <td class="align-middle">{{$category->title}}</td>
                                <td class="align-middle">
                                    @if ($category->active)
                                        <span class="badge bg-success">Ativo</span>
                                    @else
                                        <span class="badge bg-danger">Inativo</span>
                                    @endif
                                    @if ($category->featured)
                                        <span class="badge bg-primary text-white">Destaque</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="javascript:void(0)" data-bs-target="#modal-category-update-{{$category->id}}" data-bs-toggle="modal" class="btn-icon mdi mdi-square-edit-outline"></a>
                                        </div>
                                        <form action="{{route('admin.prod02v1.category.destroy',['PROD02V1ProductsCategory' => $category->id])}}" class="col-4" method="POST">
                                            @method('DELETE') @csrf
                                            <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                                        </form>
                                        {{-- BEGIN MODAL CATEGORY UPDATE --}}
                                        <div id="modal-category-update-{{$category->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog" style="max-width: 1100px;">
                                                <div class="modal-content">
                                                    <div class="modal-header p-3 pt-2 pb-2">
                                                        <h4 class="page-title">Editar Categoria</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body p-3 pt-0 pb-3">
                                                        @include('Admin.cruds.Products.PROD02V1.Category.form',[
                                                            'category' => $category
                                                        ])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- END MODAL CATEGORY UPDATE --}}
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

{{-- BEGIN MODAL CATEGORY CREATE --}}
<div id="modal-category-create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="max-width: 1100px;">
        <div class="modal-content">
            <div class="modal-header p-3 pt-2 pb-2">
                <h4 class="page-title">Cadastrar Categoria</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-3 pt-0 pb-3">
                @include('Admin.cruds.Products.PROD02V1.Category.form',[
                    'category' => null
                ])
            </div>
        </div>
    </div>
</div>
{{-- END MODAL CATEGORY CREATE --}}
