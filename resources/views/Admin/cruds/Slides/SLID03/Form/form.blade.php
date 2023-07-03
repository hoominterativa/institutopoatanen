@if ($form)
    {!! Form::model($form, ['route' => ['admin.slid03.infoForm.update', $form->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
@else
    {!! Form::model(null, ['route' => 'admin.slid03.infoForm.store', 'class'=>'parsley-validate', 'files'=>true]) !!}
@endif
    <div class="row col-12">
        <div class="col-12">
            <div class="card card-body" id="tooltip-container">
                <div class="row">
                    <div class="mb-3 col-12 col-lg-6">
                        <div class="d-flex align-items-center mb-1">
                            {!! Form::label('compliance_id', 'Termos do formulário', ['class'=>'form-label mb-0']) !!}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Escolha qual compliance será exigido de aceite no formulário. Caso não aparecça nenhuma opção abaixo você deverá cadastrar na área de Conpliance."></i>
                        </div>
                        {!! Form::select('compliance_id', $compliances, null, [
                            'class'=>'form-select',
                            'id'=>'compliance_id',
                            'required'=>'required',
                            'placeholder' => '--'
                        ]) !!}
                    </div>
                    <div class="mb-3 col-12 col-lg-6">
                        <div class="d-flex align-items-center mb-1">
                            {!! Form::label('email_form', 'E-mail para recebimento dos Leads', ['class'=>'form-label mb-0']) !!}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Insira um email destinatário para o recebimentos dos leads deste formulário"></i>
                        </div>
                        {!! Form::email('email_form', null, [
                            'class'=>'form-control',
                            'required'=>'required',
                            'parsley-type'=>'email',
                        ]) !!}
                    </div>
                </div>
            </div>
            {{-- end card-body --}}
        </div>
        <div class="col-12 col-lg-6">
            <div class="card card-body" id="tooltip-container">
                <div class="mb-3">
                    <div class="d-flex align-items-center mb-1">
                        {!! Form::label('title', 'Título na Isca', ['class'=>'form-label mb-0']) !!}
                        <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon"
                            data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="Será exibido no formulário isca do banner"></i>
                    </div>
                    {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title']) !!}
                </div>
                <div class="mb-3">
                    <div class="d-flex align-items-center mb-1">
                        {!! Form::label('title_lightbox', 'Título Lightbox', ['class'=>'form-label mb-0']) !!}
                        <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon"
                            data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="Será exibido no formulário do lightbox"></i>
                    </div>
                    {!! Form::text('title_lightbox', null, ['class'=>'form-control', 'id'=>'title_lightbox']) !!}
                </div>
                <div class="mb-3">
                    <div class="d-flex align-items-center mb-1">
                        {!! Form::label('description_lightbox', 'Descrição Lightbox', ['class'=>'form-label mb-0']) !!}
                        <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon"
                            data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="Texto que é exibido no lightbox"></i>
                    </div>
                    {!! Form::textarea('description_lightbox', null, [
                        'class'=>'form-control',
                        'id'=>'message',
                        'data-parsley-trigger'=>'keyup',
                        'rows'=>'6',
                        'data-parsley-minlength'=>'20',
                        'data-parsley-maxlength'=>'600',
                        'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                        'data-parsley-validation-threshold'=>'10',
                    ]) !!}
                </div>
            </div>
            {{-- end card-body --}}
        </div>
        {{-- end col-lg-6 --}}
        <div class="col-12 col-lg-6">
            <div class="card card-body" id="tooltip-container">
                <div class="mb-3">
                    <div class="container-image-crop">
                        {!! Form::label('inputImage', 'Imagem Ligthbox', ['class'=>'form-label']) !!}
                        <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->Form->path_image_lightbox->width}}x{{$cropSetting->Form->path_image_lightbox->height}}px!</small>
                        <label class="area-input-image-crop" for="inputImage">
                            {!! Form::file('path_image_lightbox', [
                                'id'=>'inputImage',
                                'class'=>'inputImage',
                                'data-status'=>$cropSetting->Form->path_image_lightbox->activeCrop, // px
                                'data-min-width'=>$cropSetting->Form->path_image_lightbox->width, // px
                                'data-min-height'=>$cropSetting->Form->path_image_lightbox->height, // px
                                'data-box-height'=>'250', // Input height in the form
                                'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                'data-default-file'=> isset($form)?($form->path_image_lightbox<>''?url('storage/'.$form->path_image_lightbox):''):'',
                            ]) !!}
                        </label>
                    </div><!-- END container image crop -->
                </div>
                <div class="mb-3 form-check">
                    {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
                    {!! Form::label('active', 'Ativar exbição do formulário', ['class'=>'form-check-label']) !!}
                </div>
            </div>
            {{-- end card-body --}}
        </div>
        {{-- end col-lg-6 --}}
    </div>
    {{-- end row --}}
    {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
{!! Form::close() !!}
