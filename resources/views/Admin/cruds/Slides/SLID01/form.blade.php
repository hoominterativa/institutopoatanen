<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body">
            <div class="mb-3">
                {!! Form::label(null, 'Título', ['class'=>'form-label']) !!}
                {!! Form::text('title', null, ['class'=>'form-control']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'Subtítulo', ['class'=>'form-label']) !!}
                {!! Form::text('subtitle', null, ['class'=>'form-control']) !!}
            </div>
            <div class="mb-3"  id="tooltip-container">
                 <div class="d-flex align-items-center mb-1">
                    {!! Form::label(null, 'Mascara', ['class'=>'form-label']) !!}
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Insere uma mascara em frente a imagem principal do banner"></i>
                </div>
                {!! Form::text('blade', null, [
                        'class'=>'form-control',
                        'id'=>'colorpicker-default',
                    ])!!}
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'Título Botão', ['class'=>'form-label']) !!}
                {!! Form::text('button_title', null, ['class'=>'form-control']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'Link', ['class'=>'form-label']) !!}
                {!! Form::url('button_link', null, [
                    'class'=>'form-control',
                    'parsley-type'=>'url',
                    'placeholder'=>'Ex.: https://google.com'
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'Posição do Conteúdo', ['class'=>'form-label']) !!}
                {!! Form::select('content_position', ['flex-row' => 'Esquerdo', 'flex-row-reverse' => 'Direito'], null, [
                    'class'=>'form-select'
                ]) !!}
            </div>
            <div class="mb-3 form-check">
                {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
                {!! Form::label('active', 'Ativo?', ['class'=>'form-check-label']) !!}
            </div>
        </div> <!-- end card-body-->
    </div> <!-- end card-->
    <div class="col-12 col-lg-6">
        <div class="card card-body">
            <div class="mb-3">
                {!! Form::label(null, 'Descrição', ['class'=>'form-label']) !!}
                {!! Form::textarea('description', null, [
                    'class'=>'form-control',
                    'data-parsley-trigger'=>'keyup',
                    'data-parsley-maxlength'=>'250',
                    'rows'=>5
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'Imagem Background', ['class'=>'form-label']) !!}
                {!! Form::file('path_image_background', [
                    'data-plugins'=>'dropify',
                    'data-height'=>'180',
                    'data-max-file-size-preview'=>'2M',
                    'accept'=>'image/*',
                    'data-default-file'=> isset($slide)?$slide->path_image_background<>''?url('storage/'.$slide->path_image_background):'':'',
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'Imagem PNG', ['class'=>'form-label']) !!}
                {!! Form::file('path_image_png', [
                    'data-plugins'=>'dropify',
                    'data-height'=>'180',
                    'data-max-file-size-preview'=>'2M',
                    'accept'=>'image/*',
                    'data-default-file'=> isset($slide)?$slide->path_image_png<>''?url('storage/'.$slide->path_image_png):'':'',
                ]) !!}
            </div>
        </div> <!-- end card-body-->
    </div> <!-- end card-->
</div>
<!-- end row -->
