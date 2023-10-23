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
                {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title', 'required'=>'required']) !!}
            </div>
            <div class="mb-3">
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
            <div class="mb-3">
                {!! Form::label('description', 'Breve Descrição', ['class'=>'form-label']) !!}
                {!! Form::textarea('description', null, [
                    'class'=>'form-control',
                    'id'=>'description',
                    'data-parsley-trigger'=>'keyup',
                    'data-parsley-maxlength'=>'900',
                    'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold'=>'10',
                ]) !!}
            </div>
            <div class="complete-editor__content mb-3">
                {!! Form::label('complete-editor', 'Texto Artigo', ['class'=>'form-label']) !!}
                <small class="ms-1"><b>Recomendamos salvar de tempo em tempo caso a matéria seja extensa</b></small>
                {!! Form::textarea('text', null, [
                    'class'=>'form-control complete-editor',
                    'id'=>'complete-editor',
                ]) !!}
            </div>
            <div class="d-flex">
                <div class="form-check me-3">
                    {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
                    {!! Form::label('active', 'Ativar Exibição?', ['class'=>'form-check-label']) !!}
                </div>
                <div class="form-check me-3">
                    {!! Form::checkbox('featured_home', '1', null, ['class'=>'form-check-input', 'id'=>'featured_home']) !!}
                    {!! Form::label('featured_home', 'Destacar na Home?', ['class'=>'form-check-label']) !!}
                </div>
                <div class="form-check me-3">
                    {!! Form::checkbox('featured_page', '1', null, ['class'=>'form-check-input', 'id'=>'featured_page']) !!}
                    {!! Form::label('featured_page', 'Destacar na Página?', ['class'=>'form-check-label']) !!}
                </div>
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    {{-- end card --}}
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Ícone do box', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image_icon->width}}x{{$cropSetting->path_image_icon->height}}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_icon', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-status'=>$cropSetting->path_image_icon->activeCrop, // px
                            'data-min-width'=>$cropSetting->path_image_icon->width, // px
                            'data-min-height'=>$cropSetting->path_image_icon->height, // px
                            'data-box-height'=>'225', // Input height in the form
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($blog)?($blog->path_image_icon<>''?url('storage/'.$blog->path_image_icon):''):'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image_thumbnail->width}}x{{$cropSetting->path_image_thumbnail->height}}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_thumbnail', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-status'=>$cropSetting->path_image_thumbnail->activeCrop, // px
                            'data-min-width'=>$cropSetting->path_image_thumbnail->width, // px
                            'data-min-height'=>$cropSetting->path_image_thumbnail->height, // px
                            'data-box-height'=>'225', // Input height in the form
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($blog)?($blog->path_image_thumbnail<>''?url('storage/'.$blog->path_image_thumbnail):''):'',
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
