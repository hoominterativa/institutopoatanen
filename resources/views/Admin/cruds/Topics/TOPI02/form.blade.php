<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('description', 'Descrição', ['class'=>'form-label']) !!}
                {!! Form::textarea('description', null, [
                    'class'=>'form-control',
                    'id'=>'description',
                    'data-parsley-trigger'=>'keyup',
                    'data-parsley-minlength'=>'20',
                    'data-parsley-maxlength'=>'150',
                    'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold'=>'10',
                ]) !!}
            </div>
            <div class="row">
                <div class="mb-3 col-12 col-sm-8">
                    {!! Form::label(null, 'Link', ['class'=>'form-label']) !!}
                    {!! Form::url('link', null, ['class'=>'form-control','parsley-type'=>'url']) !!}
                </div>
                <div class="mb-3 col-12 col-sm-4">
                    {!! Form::label('target_link', 'Abrir link', ['class'=>'form-label']) !!}
                    {!! Form::select('target_link', [
                        '_self' => 'Na mesma aba',
                        '_target' => 'Em nova aba',
                        '_lightbox' => 'Abrir um lightbox'
                    ], isset($topic)?$topic->target_link:'_self', ['class'=>'form-select', 'id'=>'target_link']) !!}
                </div>
            </div>
            <div class="mb-3 form-check">
                {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
                {!! Form::label('active', 'Ativar exibição', ['class'=>'form-check-label']) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    {{-- end card --}}
    <div class="col-12 col-lg-6">
        <div class="card card-body">
            <div class="mb-3">
                <div class="mb-3">
                    {!! Form::label('file', 'Ícone', ['class'=>'form-label']) !!}
                    {!! Form::file('path_image_icon', [
                        'data-plugins'=>'dropify',
                        'data-height'=>'180',
                        'data-max-file-size-preview'=>'2M',
                        'accept'=>'image/*',
                        'data-default-file'=> isset($topic)?$topic->path_image_icon<>''?url('storage/'.$topic->path_image_icon):'':'',
                    ]) !!}
                </div>
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem', ['class'=>'form-label']) !!}
                    <label class="area-input-image-crop" for="inputImage" title="Upload image file">
                        {!! Form::file('path_image', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-scale'=>'4/3',
                            'data-height'=>'180',
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($topic)?$topic->path_image<>''?url('storage/'.$topic->path_image):'':'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    {{-- end col-12 --}}
</div>
{{-- end row --}}
