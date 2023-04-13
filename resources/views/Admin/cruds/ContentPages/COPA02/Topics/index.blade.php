<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <button id="btSubmitDelete" data-route="{{route('admin.copa02.topic.destroySelected')}}" type="button" class="btn btn-danger btnDeleteTopic" style="display: none;">Deletar selecionados</button>
                    </div>
                    <div class="col-6">
                        <a href="{{route('admin.copa02.topic.create')}}" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                        <button class="btn btn-warning float-end me-2" type="button" data-bs-toggle="collapse" data-bs-target="#sectionTopic" aria-expanded="false" aria-controls="collapseExample"> Informações adicionais </button>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="collapse bg-light p-3 mb-3" id="sectionTopic">
                            @if ($sectionTopic)
                                {!! Form::model($sectionTopic, [
                                    'route' => ['admin.copa02.section.topic.update', $sectionTopic->id],
                                    'class' => 'parsley-validate',
                                    'files' => true,
                                ]) !!}
                                @method('PUT')
                            @else
                                {!! Form::model(null, [
                                    'route' => 'admin.copa02.section.topic.store',
                                    'class' => 'parsley-validate',
                                    'files' => true,
                                ]) !!}
                            @endif
                            <div class="row col-12">
                                <div class="col-12 col-lg-6">
                                        <div class="card card-body" id="tooltip-container">
                                            <div class="mb-2">
                                                {!! Form::label('title', 'Título da seção', ['class' => 'form-label']) !!}
                                                {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) !!}
                                            </div>
                                            <div class="mb-2">
                                                {!! Form::label('subtitle', 'Subtítulo da seção', ['class' => 'form-label']) !!}
                                                {!! Form::text('subtitle', null, ['class' => 'form-control', 'id' => 'subtitle']) !!}
                                            </div>
                                            <div class="mb-3">
                                                {!! Form::label('description', 'Descrição', ['class'=>'form-label']) !!}
                                                {!! Form::textarea('description', null, [
                                                    'class'=>'form-control',
                                                    'id'=>'description',
                                                    'data-parsley-trigger'=>'keyup',
                                                    'data-parsley-minlength'=>'20',
                                                    'data-parsley-maxlength'=>'800',
                                                    'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                                                    'data-parsley-validation-threshold'=>'10',
                                                ]) !!}
                                            </div>
                                            <div class="mb-3 form-check">
                                                {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                                                {!! Form::label('active', 'Ativar exibição', ['class' => 'form-check-label']) !!}
                                            </div>
                                        </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="card card-body" id="tooltip-container">
                                        <div class="mb-3">
                                            <div class="container-image-crop">
                                                {!! Form::label('inputImage', 'Background Desktop', ['class' => 'form-label']) !!}
                                                <small class="ms-2">Dimensões proporcionais mínimas
                                                    {{ $cropSetting->SectionTopic->path_image_desktop->width }}x{{ $cropSetting->SectionTopic->path_image_desktop->height }}px!</small>
                                                <label class="area-input-image-crop" for="inputImage">
                                                    {!! Form::file('path_image_desktop', [
                                                        'id' => 'inputImage',
                                                        'class' => 'inputImage',
                                                        'data-status' => $cropSetting->SectionTopic->path_image_desktop->activeCrop, // px
                                                        'data-min-width' => $cropSetting->SectionTopic->path_image_desktop->width, // px
                                                        'data-min-height' => $cropSetting->SectionTopic->path_image_desktop->height, // px
                                                        'data-box-height' => '170', // Input height in the form
                                                        'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                                        'data-default-file' => isset($sectionTopic)
                                                            ? ($sectionTopic->path_image_desktop != ''
                                                                ? url('storage/' . $sectionTopic->path_image_desktop)
                                                                : '')
                                                            : '',
                                                    ]) !!}
                                                </label>
                                            </div><!-- END container image crop -->
                                        </div>
                                        <div class="mb-3">
                                            <div class="container-image-crop">
                                                {!! Form::label('inputImage', 'Background Mobile', ['class' => 'form-label']) !!}
                                                <small class="ms-2">Dimensões proporcionais mínimas
                                                    {{ $cropSetting->SectionTopic->path_image_mobile->width }}x{{ $cropSetting->SectionTopic->path_image_mobile->height }}px!</small>
                                                <label class="area-input-image-crop" for="inputImage">
                                                    {!! Form::file('path_image_mobile', [
                                                        'id' => 'inputImage',
                                                        'class' => 'inputImage',
                                                        'data-status' => $cropSetting->SectionTopic->path_image_mobile->activeCrop, // px
                                                        'data-min-width' => $cropSetting->SectionTopic->path_image_mobile->width, // px
                                                        'data-min-height' => $cropSetting->SectionTopic->path_image_mobile->height, // px
                                                        'data-box-height' => '170', // Input height in the form
                                                        'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                                        'data-default-file' => isset($sectionTopic)
                                                            ? ($sectionTopic->path_image_mobile != ''
                                                                ? url('storage/' . $sectionTopic->path_image_mobile)
                                                                : '')
                                                            : '',
                                                    ]) !!}
                                                </label>
                                            </div><!-- END container image crop -->
                                        </div>
                                        <div class="mb-3 border px-2 py-3">
                                            {!! Form::label('background_color', 'Cor do background', ['class' => 'form-label']) !!}
                                            {!! Form::text('background_color', null, [
                                                'class' => 'form-control colorpicker-default',
                                                'id' => 'background_color',
                                            ]) !!}
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
                                <label><input name="btnSelectAll" value="btnDeleteTopic" type="checkbox"></label>
                            </th>
                            <th>Imagem</th>
                            <th>Título/Subtítulo</th>
                            <th>Descrição</th>
                            <th width="100px">Status</th>
                            <th width="90px">Ações</th>
                        </tr>
                    </thead>

                    <tbody data-route="{{route('admin.copa02.topic.sorting')}}">
                        @foreach ($topics as $topic)
                            <tr data-code="{{$topic->id}}">
                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                <td class="bs-checkbox align-middle">
                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$topic->id}}"></label>
                                </td>
                                <td class="align-middle avatar-group">
                                    @if ($topic->path_image_box)
                                        <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/' . $topic->path_image_box)}})"></div>
                                    @endif
                                </td>
                                <td class="align-middle">{{$topic->title}} <b>/</b> {{$topic->subtitle}}</td>
                                <td class="align-middle">{!! substr($topic->description,0,50) !!}</td>
                                <td class="align-middle">
                                    @if ($topic->active)
                                        <span class="badge bg-success">Ativo</span>
                                    @else
                                        <span class="badge bg-danger">Inativo</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{route('admin.copa02.topic.edit',['COPA02ContentPagesTopic' => $topic->id])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                        </div>
                                        <form action="{{route('admin.copa02.topic.destroy',['COPA02ContentPagesTopic' => $topic->id])}}" class="col-4" method="POST">
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
