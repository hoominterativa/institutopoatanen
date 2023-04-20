@if (isset($topicSection))
    {!! Form::model($topicSection, ['route' => ['admin.topi04.topic.section.update', $topicSection->id], 'class'=>'parsley-validate', 'files' => true]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => ['admin.topi04.topic.section.store'], 'class'=>'parsley-validate', 'files' => true]) !!}
    <input type="hidden" name="topic_id" value="{{ $topic->id }}">
@endif
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card card-body border" id="tooltip-container">
                <div class="mb-3">
                    {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                    {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title']) !!}
                </div>
                <div class="d-flex">
                    <div class="mb-3 form-check me-3">
                        {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                        {!! Form::label('active', 'Ativar exibição', ['class' => 'form-check-label']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card card-body border" id="tooltip-container">
                <div class="mb-3">
                    <div class="container-image-crop">
                        {!! Form::label('inputImage', 'Ícone', ['class' => 'form-label']) !!}
                        <small class="ms-2">Dimensões proporcionais mínimas
                            {{ $cropSetting->TopicSection->path_image_icon->width }}x{{ $cropSetting->TopicSection->path_image_icon->height }}px!</small>
                        <label class="area-input-image-crop" for="inputImage">
                            {!! Form::file('path_image_icon', [
                                'id' => 'inputImage',
                                'class' => 'inputImage',
                                'data-status' => $cropSetting->TopicSection->path_image_icon->activeCrop, // px
                                'data-min-width' => $cropSetting->TopicSection->path_image_icon->width, // px
                                'data-min-height' => $cropSetting->TopicSection->path_image_icon->height, // px
                                'data-box-height' => '225', // Input height in the form
                                'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                'data-default-file' => isset($topicSection)
                                    ? ($topicSection->path_image_icon != ''
                                        ? url('storage/' . $topicSection->path_image_icon)
                                        : '')
                                    : '',
                            ]) !!}
                        </label>
                    </div><!-- END container image crop -->
                </div>
                <div class="mb-3">
                    <div class="container-image-crop">
                        {!! Form::label('inputImage', 'Imagem do box', ['class' => 'form-label']) !!}
                        <small class="ms-2">Dimensões proporcionais mínimas
                            {{ $cropSetting->TopicSection->path_image_box->width }}x{{ $cropSetting->TopicSection->path_image_box->height }}px!</small>
                        <label class="area-input-image-crop" for="inputImage">
                            {!! Form::file('path_image_box', [
                                'id' => 'inputImage',
                                'class' => 'inputImage',
                                'data-status' => $cropSetting->TopicSection->path_image_box->activeCrop, // px
                                'data-min-width' => $cropSetting->TopicSection->path_image_box->width, // px
                                'data-min-height' => $cropSetting->TopicSection->path_image_box->height, // px
                                'data-box-height' => '225', // Input height in the form
                                'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                'data-default-file' => isset($topicSection)
                                    ? ($topicSection->path_image_box != ''
                                        ? url('storage/' . $topicSection->path_image_box)
                                        : '')
                                    : '',
                            ]) !!}
                        </label>
                    </div><!-- END container image crop -->
                </div>
            </div>
            {{-- end card-body --}}
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
        {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
    </div>
{!! Form::close() !!}
