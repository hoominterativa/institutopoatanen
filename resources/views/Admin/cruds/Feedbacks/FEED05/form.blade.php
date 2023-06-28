<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label('name', 'Nome', ['class' => 'form-label']) !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('testimony', 'Depoimento', ['class' => 'form-label']) !!}
                {!! Form::textarea('testimony', null, [
                    'class' => 'form-control',
                    'id' => 'testimony',
                    'required' => 'required',
                    'data-parsley-trigger' => 'keyup',
                    'data-parsley-minlength' => '20',
                    'data-parsley-maxlength' => '800',
                    'data-parsley-minlength-message' => 'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold' => '10',
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('classification', 'Classificação', ['class'=>'form-label']) !!}
                {!! Form::select('classification', ['1' => '1 estrela', '2' => '2 estrelas', '3' => '3 estrelas', '4' => '4 estrelas', '5' => '5 estrelas'], null, [
                    'class'=>'form-select',
                    'id'=>'classification',
                    'required'=>'required',
                    'placeholder' => 'Insira a classificação...'
                ]) !!}
            </div>

        </div>
        <div class="mb-3 form-check">
            {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
            {!! Form::label('active', 'Ativar exibição', ['class' => 'form-check-label']) !!}
        </div>
        {{-- end card-body --}}
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Foto', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->path_image->width }}x{{ $cropSetting->path_image->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image->width, // px
                            'data-min-height' => $cropSetting->path_image->height, // px
                            'data-box-height' => '170', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($feedback)
                                ? ($feedback->path_image != ''
                                    ? url('storage/' . $feedback->path_image)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
    </div>
    {{-- end card --}}
</div>
{{-- end row --}}

