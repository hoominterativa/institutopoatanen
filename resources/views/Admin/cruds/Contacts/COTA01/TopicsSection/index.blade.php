<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <button id="btSubmitDelete" data-route="{{route('admin.cota01.topicSection.destroySelected')}}" type="button" class="btn btn-danger btnDeleteBlogCategory" style="display: none;">Deletar selecionados</button>
                    </div>
                    <div class="col-6">
                        <a href="javascript:void(0)"  data-bs-target="#modal-topicSection-create" data-bs-toggle="modal" class="btn btn-success float-end">Adicionar Tópicos <i class="mdi mdi-plus"></i></a>
                    </div>
                </div>
                <table class="table table-bordered table-sortable">
                    <thead class="table-light">
                        <tr>
                            <th width="50px"></th>
                            <th width="30px" class="bs-checkbox">
                                <label><input name="btnSelectAll" value="btnDeleteBlogCategory" type="checkbox"></label>
                            </th>
                            <th width="60px"></th>
                            <th>Title</th>
                            <th>description</th>
                            <th width="90px">Ações</th>
                        </tr>
                    </thead>

                    <tbody data-route="{{route('admin.cota01.topicSection.sorting')}}">
                        @foreach ($topicsSection as $topicSection)
                            <tr data-code="{{$topicSection->id}}">
                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                <td class="bs-checkbox align-middle">
                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$topicSection->id}}"></label>
                                </td>
                                <td class="align-middle">
                                    @if ($topicSection->path_image_icon)
                                        <div class="avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/'.$topicSection->path_image_icon)}})"></div>
                                    @endif
                                </td>
                                <td class="align-middle">{{$topicSection->title}}</td>
                                <td class="align-middle">{{$topicSection->description}}</td>
                                <td class="align-middle">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="javascript:void(0)" data-bs-target="#modal-topicSection-update-{{$topicSection->id}}" data-bs-toggle="modal" class="btn-icon mdi mdi-square-edit-outline"></a>
                                        </div>
                                        <form action="{{route('admin.cota01.topicSection.destroy',['COTA01ContactsTopic' => $topicSection->id])}}" class="col-4" method="POST">
                                            @method('DELETE') @csrf
                                            <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                                        </form>
                                        {{-- BEGIN MODAL CATEGORY UPDATE --}}
                                        <div id="modal-topicSection-update-{{$topicSection->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog" style="max-width: 1100px;">
                                                <div class="modal-content">
                                                    <div class="modal-header p-3 pt-2 pb-2">
                                                        <h4 class="page-title">Editar Tópico</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body p-3 pt-0 pb-3">
                                                        @include('Admin.cruds.Contacts.COTA01.TopicsSection.form',[
                                                            'topic' => $topicSection
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
<div id="modal-topicSection-create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="max-width: 1100px;">
        <div class="modal-content">
            <div class="modal-header p-3 pt-2 pb-2">
                <h4 class="page-title">Cadastrar Tópicos</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-3 pt-0 pb-3">
                @include('Admin.cruds.Contacts.COTA01.TopicsSection.form',[
                    'topic' => null
                ])
            </div>
        </div>
    </div>
</div>
{{-- END MODAL CATEGORY CREATE --}}
