<div class="tab-pane" id="infoTopic">
    <div class="col-12 ">
        <div class="card card-body" id="tooltip-container">
            <h4 class="mb-3">Informações do Tópico</h4>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem Desktop', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->InfoTopic->path_image_topic_desktop->width }}x{{ $cropSetting->InfoTopic->path_image_topic_desktop->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_topic_desktop', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->InfoTopic->path_image_topic_desktop->activeCrop, // px
                            'data-min-width' => $cropSetting->InfoTopic->path_image_topic_desktop->width, // px
                            'data-min-height' => $cropSetting->InfoTopic->path_image_topic_desktop->height, // px
                            'data-box-height' => '300', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($contact)
                                ? ($contact->path_image_topic_desktop != ''
                                    ? url('storage/' . $contact->path_image_topic_desktop)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem Mobile', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->InfoTopic->path_image_topic_mobile->width }}x{{ $cropSetting->InfoTopic->path_image_topic_mobile->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_topic_mobile', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->InfoTopic->path_image_topic_mobile->activeCrop, // px
                            'data-min-width' => $cropSetting->InfoTopic->path_image_topic_mobile->width, // px
                            'data-min-height' => $cropSetting->InfoTopic->path_image_topic_mobile->height, // px
                            'data-box-height' => '300', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($contact)
                                ? ($contact->path_image_topic_mobile != ''
                                    ? url('storage/' . $contact->path_image_topic_mobile)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="mb-3">
                {!! Form::label('colorpicker-default', 'Cor de fundo', ['class' => 'form-label']) !!}
                {!! Form::text('background_color_topic', null, [
                    'class' => 'form-control colorpicker-default',
                    'id' => 'colorpicker-default',
                ]) !!}
            </div>
        </div>
        <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
            {!! Form::button('Salvar', [
                'class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0',
                'type' => 'submit',
            ]) !!}
        </div>
        {{-- end card-body --}}
    </div>
</div>
