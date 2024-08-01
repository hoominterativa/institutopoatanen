<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="row">
                <div class="mb-3 col-6">
                    {!! Form::label('validationCustom01', 'Título', ['class'=>'form-label']) !!}
                    {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'validationCustom01', 'placeholder'=>'Título', 'required'=>'required']) !!}
                </div>
                <div class="mb-3 col-6">
                    {!! Form::label('validationCustom01', 'Subtitulo', ['class'=>'form-label']) !!}
                    {!! Form::text('subtitle', null, ['class'=>'form-control', 'id'=>'validationCustom01', 'placeholder'=>'Subtitulo', 'required'=>'required']) !!}
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-6">
                    {!! Form::label('validationCustom01', 'Valor', ['class'=>'form-label']) !!}
                    {!! Form::text('value', null, ['class'=>'form-control', 'id'=>'validationCustom01', 'placeholder'=>'Valor', 'required'=>'required']) !!}
                </div>
                <div class="mb-3 col-6">
                    {!! Form::label('validationCustom01', 'Promoção', ['class'=>'form-label']) !!}
                    {!! Form::text('promotion', null, ['class'=>'form-control', 'id'=>'validationCustom01', 'placeholder'=>'Promoção', 'required'=>'required']) !!}
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-4">
                    {!! Form::label('validationCustom01', 'Título do botão', ['class'=>'form-label']) !!}
                    {!! Form::text('button_text', null, ['class'=>'form-control', 'id'=>'validationCustom01', 'placeholder'=>'Título do botão', 'required'=>'required']) !!}
                </div>
                <div class="mb-3 col-8">
                    {!! Form::label('validationCustom01', 'Link', ['class'=>'form-label']) !!}
                    {!! Form::text('button_link', null, ['class'=>'form-control', 'id'=>'validationCustom01', 'placeholder'=>'Link', 'required'=>'required']) !!}
                </div>
            </div>
            <div class="basic-editor__content mb-3 col-12">
                {!! Form::label('basic-editor', 'Texto', ['class'=>'form-label']) !!}
                {!! Form::textarea('value_text', null, [
                    'class'=>'form-control basic-editor',
                    'id'=>'basic-editor',
                ]) !!}
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image->width}}x{{$cropSetting->path_image->height}}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-status'=>$cropSetting->path_image->activeCrop, // px
                            'data-min-width'=>$cropSetting->path_image->width, // px
                            'data-min-height'=>$cropSetting->path_image->height, // px
                            'data-box-height'=>'225', // Input height in the form
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff',
                            'data-default-file'=> isset($Products)?($Products->path_image<>''?url('storage/'.$Products->path_image):''):'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                {!! Form::label('active', 'Ativo?', ['class' => 'form-check-label']) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
</div>
{{-- end row --}}

