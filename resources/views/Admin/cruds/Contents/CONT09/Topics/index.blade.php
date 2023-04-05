<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <button id="btSubmitDelete" data-route="{{ route('admin.cont09.topic.destroySelected') }}"
                            type="button" class="btn btn-danger btnDeleteTopics" style="display: none;">Deletar
                            selecionados</button>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.cont09.topic.create') }}" class="btn btn-success float-end">Adicionar
                            novo <i class="mdi mdi-plus"></i></a>
                        <button class="btn btn-warning float-end me-2" type="button" data-bs-toggle="collapse"
                            data-bs-target="#topicSection" aria-expanded="false" aria-controls="collapseExample">
                            Informações da Seção
                        </button>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="collapse bg-light p-3 mb-3" id="topicSection">
                            @if ($section)
                                {!! Form::model($section, [
                                    'route' => ['admin.cont09.topicsection.update', $section->id],
                                    'class' => 'parsley-validate',
                                    'files' => true,
                                ]) !!}
                                @method('PUT')
                            @else
                                {!! Form::model(null, [
                                    'route' => 'admin.cont09.topicsection.store',
                                    'class' => 'parsley-validate',
                                    'files' => true,
                                ]) !!}
                            @endif
                            <div class="row">
                                <div class="col-12 ">
                                    <div class="card card-body">
                                        <div class="mb-2">
                                            {!! Form::label('title', 'Título dos tópicos', ['class' => 'form-label']) !!}
                                            {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) !!}
                                        </div>
                                        <div class="mb-2">
                                            {!! Form::label('subtitle', 'Subtítulo dos tópicos', ['class' => 'form-label']) !!}
                                            {!! Form::text('subtitle', null, ['class' => 'form-control', 'id' => 'subtitle']) !!}
                                        </div>
                                        <div class="mb-3 form-check">
                                            {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
                                            {!! Form::label('active', 'Ativar exibição', ['class'=>'form-check-label']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
                                {!! Form::button('Salvar', [
                                    'class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0',
                                    'type' => 'submit',
                                ]) !!}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div> <!-- end col-->
                </div>
                <table class="table table-bordered table-sortable">
                    <thead class="table-light">
                        <tr>
                            <th width="50px"></th>
                            <th width="30px" class="bs-checkbox">
                                <label><input name="btnSelectAll" value="btnDeleteTopics" type="checkbox"></label>
                            </th>
                            <th>Imagem</th>
                            <th>Link</th>
                            <th width="100px">Status</th>
                            <th width="90px">Ações</th>
                        </tr>
                    </thead>

                    <tbody data-route="{{ route('admin.cont09.topic.sorting') }}">
                        @foreach ($topics as $topic)
                            <tr data-code="{{ $topic->id }}">
                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span>
                                </td>
                                <td class="bs-checkbox align-middle">
                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox"
                                            value="{{ $topic->id }}"></label>
                                </td>
                                <td class="align-middle avatar-group">
                                    @if ($topic->path_image_icon)
                                        <div class="avatar-group-item avatar-bg rounded-circle avatar-sm"
                                            style="background-image: url({{ asset('storage/' . $topic->path_image_icon) }})">
                                        </div>
                                    @endif
                                </td>
                                <td class="align-middle"><a href="{{ $topic->link }}" target="_blank"
                                        class="mdi mdi-link-box-variant mdi-24px"></a></td>
                                <td class="align-middle">
                                    @switch($topic->active)
                                        @case(1)
                                            <span class="badge bg-success">Ativo</span>
                                        @break

                                        @case(0)
                                            <span class="badge bg-danger">Inativo</span>
                                        @break
                                    @endswitch
                                </td>
                                <td class="align-middle">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{ route('admin.cont09.topic.edit', ['CONT09ContentsTopic' => $topic->id]) }}"
                                                class="btn-icon mdi mdi-square-edit-outline"></a>
                                        </div>
                                        <form
                                            action="{{ route('admin.cont09.topic.destroy', ['CONT09ContentsTopic' => $topic->id]) }}"
                                            class="col-4" method="POST">
                                            @method('DELETE') @csrf
                                            <button type="button" class="btn-icon btSubmitDeleteItem"><i
                                                    class="mdi mdi-trash-can"></i></button>
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
