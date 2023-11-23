<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="d-flex align-items-center mb-1">
                    {!! Form::label('title_page', 'Título da Página', ['class'=>'form-label mb-0']) !!}
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Título que é exibido no menu do site"></i>
                </div>
                {!! Form::text('title_page', null, ['class'=>'form-control', 'id'=>'title_page', 'required'=>true]) !!}
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title_banner', 'Título Banner', ['class' => 'form-label']) !!}
                        {!! Form::text('title_banner', null, ['class' => 'form-control', 'required'=>'required', 'id' => 'title_banner']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('subtitle_banner', 'Subtítulo Banner', ['class' => 'form-label']) !!}
                        {!! Form::text('subtitle_banner', null, ['class' => 'form-control', 'id' => 'subtitle_banner']) !!}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                {!! Form::label('background_color_banner', 'Cor do background banner', ['class'=>'form-label']) !!}
                <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Caso não exista imagem de background no banner."></i>
                {!! Form::text('background_color_banner', null, [
                    'class'=>'form-control colorpicker-default',
                    'id'=>'colorpicker-default',
                ])!!}
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title_content', 'Título Conteúdo', ['class' => 'form-label']) !!}
                        {!! Form::text('title_content', null, ['class' => 'form-control', 'id' => 'title_content']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('subtitle_content', 'Subtítulo Conteúdo', ['class' => 'form-label']) !!}
                        {!! Form::text('subtitle_content', null, ['class' => 'form-control', 'id' => 'subtitle_content']) !!}
                    </div>
                </div>
            </div>
            <div class="normal-editor__content mb-3">
                {!! Form::label('description_content', 'Drescrição do conteúdo', ['class' => 'form-label']) !!}
                {!! Form::textarea('description_content', null, [
                    'class' => 'form-control normal-editor',
                    'data-height' => 500,
                    'id' => 'description_content',
                ]) !!}
            </div>
            <div class="mb-3">
                <div class="d-flex align-items-center mb-1">
                    {!! Form::label('compliance_id', 'Termos do formulário', ['class' => 'form-label mb-0']) !!}
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Escolha qual compliance será exigido de aceite no formulário. Caso não aparecça nenhuma opção abaixo você deverá cadastrar na área de Compliance."></i>
                </div>
                {!! Form::select('compliance_id', $compliances, null, [
                    'class' => 'form-select',
                    'id' => 'compliance_id',
                    'required' => 'required',
                    'placeholder' => '--',
                ]) !!}
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title_compliance', 'Título seção compliance', ['class' => 'form-label']) !!}
                        {!! Form::text('title_compliance', null, ['class' => 'form-control', 'id' => 'title_compliance']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('subtitle_compliance', 'Subtítulo seção compliance', ['class' => 'form-label']) !!}
                        {!! Form::text('subtitle_compliance', null, ['class' => 'form-control', 'id' => 'subtitle_compliance']) !!}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center mb-1">
                            {!! Form::label('email_form', 'E-mail recebimento dos Leads', ['class' => 'form-label mb-0']) !!}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Insira um email destinatário para o recebimentos dos leads deste formulário"></i>
                        </div>
                        {!! Form::email('email_form', null, [
                            'class' => 'form-control',
                            'required' => 'required',
                            'parsley-type' => 'email',
                        ]) !!}
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center mb-1">
                            {!! Form::label('title_button_form', 'Nome do botão no formulário', ['class' => 'form-label mb-0']) !!}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Nome que aparecerá no botão do formulário"></i>
                        </div>
                        {!! Form::text('title_button_form', null, [
                            'class' => 'form-control',
                            'id' => 'title_button_form',
                            'required' => true,
                        ]) !!}
                    </div>
                </div>
            </div>
            <div class="d-flex">
                <div class="mb-3 form-check me-3">
                    {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                    {!! Form::label('active', 'Ativar exibição?', ['class' => 'form-check-label']) !!}
                </div>
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Background desktop do banner', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->path_image_banner_desktop->width }}x{{ $cropSetting->path_image_banner_desktop->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_banner_desktop', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image_banner_desktop->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image_banner_desktop->width, // px
                            'data-min-height' => $cropSetting->path_image_banner_desktop->height, // px
                            'data-box-height' => '180', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($contact)
                                ? ($contact->path_image_banner_desktop != ''
                                    ? url('storage/' . $contact->path_image_banner_desktop)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Background mobile do banner', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->path_image_banner_mobile->width }}x{{ $cropSetting->path_image_banner_mobile->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_banner_mobile', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image_banner_mobile->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image_banner_mobile->width, // px
                            'data-min-height' => $cropSetting->path_image_banner_mobile->height, // px
                            'data-box-height' => '180', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($contact)
                                ? ($contact->path_image_banner_mobile != ''
                                    ? url('storage/' . $contact->path_image_banner_mobile)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem do conteúdo', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->path_image_content->width }}x{{ $cropSetting->path_image_content->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_content', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image_content->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image_content->width, // px
                            'data-min-height' => $cropSetting->path_image_content->height, // px
                            'data-box-height' => '180', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($contact)
                                ? ($contact->path_image_content != ''
                                    ? url('storage/' . $contact->path_image_content)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
    </div>
</div>
{{-- end row --}}
