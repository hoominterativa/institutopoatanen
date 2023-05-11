<div class="tab-pane" id="infoForm">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="d-flex align-items-center mb-1">
                    {!! Form::label('title_form', 'Título', ['class' => 'form-label mb-0']) !!}
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Título que é exibido no formulário"></i>
                </div>
                {!! Form::text('title_form', null, ['class' => 'form-control', 'id' => 'title_form']) !!}
            </div>
            <div class="mb-3">
                <div class="d-flex align-items-center mb-1">
                    {!! Form::label('description_form', 'Descrição', ['class' => 'form-label mb-0']) !!}
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Informação que é exibida na descrição do formulário"></i>
                </div>
                {!! Form::textarea('description_form', null, [
                    'class' => 'form-control',
                    'id' => 'message',
                    'data-parsley-trigger' => 'keyup',
                    'rows' => '6',
                    'data-parsley-minlength' => '20',
                    'data-parsley-maxlength' => '300',
                    'data-parsley-minlength-message' => 'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold' => '10',
                ]) !!}
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem Desktop', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->InfoForm->path_image_form_desktop->width }}x{{ $cropSetting->InfoForm->path_image_form_desktop->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_form_desktop', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->InfoForm->path_image_form_desktop->activeCrop, // px
                            'data-min-width' => $cropSetting->InfoForm->path_image_form_desktop->width, // px
                            'data-min-height' => $cropSetting->InfoForm->path_image_form_desktop->height, // px
                            'data-box-height' => '300', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($contact)
                                ? ($contact->path_image_form_desktop != ''
                                    ? url('storage/' . $contact->path_image_form_desktop)
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
                        {{ $cropSetting->InfoForm->path_image_form_mobile->width }}x{{ $cropSetting->InfoForm->path_image_form_mobile->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_form_mobile', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->InfoForm->path_image_form_mobile->activeCrop, // px
                            'data-min-width' => $cropSetting->InfoForm->path_image_form_mobile->width, // px
                            'data-min-height' => $cropSetting->InfoForm->path_image_form_mobile->height, // px
                            'data-box-height' => '300', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($contact)
                                ? ($contact->path_image_form_mobile != ''
                                    ? url('storage/' . $contact->path_image_form_mobile)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="mb-3">
                {!! Form::label('colorpicker-default', 'Cor de fundo', ['class' => 'form-label']) !!}
                {!! Form::text('background_color_form', null, [
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
