
<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('subtitle', 'Título', ['class'=>'form-label']) !!}
                {!! Form::text('subtitle', null, ['class'=>'form-control', 'id'=>'subtitle']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('link', 'Link', ['class'=>'form-label']) !!}
                {!! Form::text('link', null, ['class'=>'form-control', 'id'=>'link']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('heard', 'Abrir link', ['class'=>'form-label']) !!}
                {!! Form::select('options', ['_self' => 'Mesma Aba', '_blank' => 'Aba diferente'], null, [
                    'class'=>'form-select',
                    'id'=>'heard',
                ]) !!}
            </div>
            <div class="mb-3 form-check">
                {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
                {!! Form::label('active', 'Ativar exibição', ['class'=>'form-check-label']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('description', 'Descrição', ['class'=>'form-label']) !!}
                {!! Form::textarea('description', null, [
                    'class'=>'form-control',
                    'id'=>'description',
                    'data-parsley-trigger'=>'keyup',
                    'data-parsley-minlength'=>'20',
                    'data-parsley-maxlength'=>'300',
                    'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold'=>'10',
                ]) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>

    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem do Centro', ['class'=>'form-label']) !!}
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_center', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-scale'=>'3/4',
                            'data-height'=>'170',
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($content)?$content->path_image_center<>''?url('storage/'.$content->path_image_center):'':'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>

            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem da Esquerda', ['class'=>'form-label']) !!}
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_right', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-scale'=>'3/4',
                            'data-height'=>'170',
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($content)?$content->path_image_right<>''?url('storage/'.$content->path_image_right):'':'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>

            <div class="mb-3">
                {!! Form::label('file', 'Imagem Background', ['class'=>'form-label']) !!}
                {!! Form::file('path_image_background', [
                    'data-plugins'=>'dropify',
                    'data-height'=>'170',
                    'data-max-file-size-preview'=>'2M',
                    'accept'=>'image/*',
                    'data-default-file'=> isset($content)?$content->path_image_background<>''?url('storage/'.$content->path_image_background):'':'',
                ]) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    {{-- end card --}}
</div>
{{-- end row --}}
