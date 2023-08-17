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
                        <a href="javascript:void(0)"  data-bs-target="#modal-imageTopic-create" data-bs-toggle="modal" class="btn btn-warning float-end me-3">Adicionar Imagem na seção <i class="mdi mdi-plus"></i></a>
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

{{-- BEGIN MODAL BANNER CREATE --}}
<div id="modal-imageTopic-create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="max-width: 1100px;">
        <div class="modal-content">
            <div class="modal-header p-3 pt-2 pb-2">
                <h4 class="page-title">Cadastrar Tópicos</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-3 pt-0 pb-3">
                {!! Form::model($contact, ['route' => ['admin.cota01.update', $contact->id], 'class'=>'parsley-validate', 'files' => true]) !!}
                    @method('PUT')
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" name="title_page" value="{{$contact->title_page}}">
                            <div class="mb-3">
                                <div class="container-image-crop">
                                    {!! Form::label('inputImage', 'Imagem', ['class'=>'form-label']) !!}
                                    <small class="ms-2">Dimensão proporcional mínima 400x300px</small>
                                    <label class="area-input-image-crop" for="inputImage">
                                        {!! Form::file('path_image_section_topic', [
                                            'id'=>'inputImage',
                                            'class'=>'inputImage',
                                            'data-min-width'=>'200', // px
                                            'data-min-height'=>'275', // px
                                            'data-box-height'=>'180', // Input height in the form
                                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                            'data-default-file'=> isset($contact)?($contact->path_image_section_topic<>''?url('storage/'.$contact->path_image_section_topic):''):'',
                                        ]) !!}
                                    </label>
                                </div><!-- END container image crop -->
                            </div>
                        </div>
                    </div>
                    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
                        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
                        {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
{{-- END MODAL BANNER CREATE --}}
