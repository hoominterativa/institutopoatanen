<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="d-flex">
                    {!! Form::label('heard', 'Categoria', ['class'=>'form-label']) !!}
                    <i class="text-danger">*</i>
                </div>
                {!! Form::select('category_id', $categories, null, [
                    'class'=>'form-select',
                    'id'=>'heard',
                    'required'=>'required',
                    'placeholder' => 'Informe a categoria do serviço'
                ]) !!}
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title', 'Título', ['class' => 'form-label']) !!}
                        {!! Form::text('title', null, ['class' => 'form-control', 'required'=>'required', 'id' => 'title']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('subtitle', 'Subtítulo', ['class' => 'form-label']) !!}
                        {!! Form::text('subtitle', null, ['class' => 'form-control', 'id' => 'subtitle']) !!}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title_price', 'Título do preço', ['class' => 'form-label']) !!}
                        {!! Form::text('title_price', null, ['class' => 'form-control', 'id' => 'title_price']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label(null, 'Preço R$', ['class'=>'form-label']) !!}
                        {!! Form::text('price', null, [
                            'class'=>'form-control',
                            'data-toggle'=>'input-mask',
                            'data-mask-format'=>'#.##0,00',
                            'data-reverse'=>'true',
                            'placeholder'=> '87,25'
                        ]) !!}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                {!! Form::label('description', 'Breve Descrição', ['class' => 'form-label']) !!}
                {!! Form::textarea('description', null, [
                    'class' => 'form-control',
                    'id' => 'description',
                    'rows' => 5,
                    'data-parsley-trigger' => 'keyup',
                    'data-parsley-minlength' => '20',
                    'data-parsley-maxlength' => '600',
                    'data-parsley-minlength-message' => 'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold' => '10',
                ]) !!}
            </div>
            <div class="normal-editor__content mb-3">
                {!! Form::label('text', 'Texto', ['class' => 'form-label']) !!}
                {!! Form::textarea('text', null, [
                    'class' => 'form-control normal-editor',
                    'data-height' => 500,
                    'id' => 'text',
                ]) !!}
            </div>
            <div class="card card-body border" id="tooltip-container">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-sm-6">
                            {!! Form::label('title_featured', 'Título do destaque', ['class' => 'form-label']) !!}
                            {!! Form::text('title_featured', null, ['class' => 'form-control', 'placeholder'=> 'Promoção', 'id' => 'title_featured']) !!}
                        </div>
                        <div class="col-sm-6">
                            {!! Form::label('color', 'Cor do destaque', ['class'=>'form-label']) !!}
                            {!! Form::text('color', '#e5e502', [
                                'class'=>'form-control colorpicker-default',
                                'id'=>'colorpicker-default',
                            ])!!}
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="mb-3 form-check me-3">
                        {!! Form::checkbox('featured_service', '1', null, ['class' => 'form-check-input', 'id' => 'featured_service']) !!}
                        {!! Form::label('featured_service', 'Destacar o serviço ?', ['class' => 'form-check-label']) !!}
                    </div>
                </div>
            </div>
            <div class="d-flex">
                <div class="mb-3 form-check me-3">
                    {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                    {!! Form::label('active', 'Ativar exibição ?', ['class' => 'form-check-label']) !!}
                </div>
                <div class="mb-3 form-check me-3">
                    {!! Form::checkbox('featured', '1', null, ['class' => 'form-check-input', 'id' => 'featured']) !!}
                    {!! Form::label('featured', 'Destacar na home ?', ['class' => 'form-check-label']) !!}
                </div>
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem do box', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->path_image->width }}x{{ $cropSetting->path_image->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image->width, // px
                            'data-min-height' => $cropSetting->path_image->height, // px
                            'data-box-height' => '180', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($service)
                                ? ($service->path_image != ''
                                    ? url('storage/' . $service->path_image)
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
