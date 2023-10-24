<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label('category_id', 'Categoria', ['class'=>'form-label']) !!}
                {!! Form::select('category_id', $categories, null, [
                    'required'=>'required',
                    'class'=>'form-select',
                    'id'=>'category_id',
                    'placeholder' => '--'
                ]) !!}
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                        {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title', 'required'=>'required']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label(null, 'Data de Publicação', ['class'=>'form-label']) !!}
                        {!! Form::text('publishing', null, [
                                'class'=>'form-control',
                                'required'=>'required',
                                'data-provide'=>'datepicker',
                                'data-date-autoclose'=>'true',
                                'data-date-format'=>'dd/mm/yyyy',
                                'data-date-language'=>'pt-BR',
                                'data-date-start-date'=>'0d', // Isso permite datas a partir do dia atual (0d)
                            ])!!}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                {!! Form::label('description', 'Breve Descrição', ['class'=>'form-label']) !!}
                {!! Form::textarea('description', null, [
                    'class'=>'form-control',
                    'id'=>'description',
                    'data-parsley-trigger'=>'keyup',
                    'data-parsley-maxlength'=>'800',
                    'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold'=>'10',
                ]) !!}
            </div>
            <div class="col-12">
                <div class="complete-editor__content mb-3">
                    {!! Form::label('complete-editor', 'Texto Artigo', ['class'=>'form-label']) !!}
                    <small class="ms-1"><b>Recomendamos salvar de tempo em tempo caso a matéria seja extensa</b></small>
                    {!! Form::textarea('text', null, [
                        'class'=>'form-control complete-editor',
                        'id'=>'complete-editor',
                    ]) !!}
                </div>
            </div>
        </div>
        {{-- end card-body --}}
        <div class="d-flex">
            <div class="form-check me-3">
                {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
                {!! Form::label('active', 'Ativar Exibição?', ['class'=>'form-check-label']) !!}
            </div>
            <div class="form-check me-3">
                {!! Form::checkbox('featured', '1', null, ['class'=>'form-check-input', 'id'=>'featured']) !!}
                {!! Form::label('featured', 'Destacar na Home?', ['class'=>'form-check-label']) !!}
            </div>
        </div>
    </div>
    {{-- end card --}}
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem do box', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image_box->width}}x{{$cropSetting->path_image_box->height}}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_box', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-status'=>$cropSetting->path_image_box->activeCrop, // px
                            'data-min-width'=>$cropSetting->path_image_box->width, // px
                            'data-min-height'=>$cropSetting->path_image_box->height, // px
                            'data-box-height'=>'225', // Input height in the form
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($blog)?($blog->path_image_box<>''?url('storage/'.$blog->path_image_box):''):'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem Interna', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image->width}}x{{$cropSetting->path_image->height}}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-status'=>$cropSetting->path_image->activeCrop, // px
                            'data-min-width'=>$cropSetting->path_image->width, // px
                            'data-min-height'=>$cropSetting->path_image->height, // px
                            'data-box-height'=>'225', // Input height in the form
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($blog)?($blog->path_image<>''?url('storage/'.$blog->path_image):''):'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
    </div>
</div>
{{-- end row --}}
