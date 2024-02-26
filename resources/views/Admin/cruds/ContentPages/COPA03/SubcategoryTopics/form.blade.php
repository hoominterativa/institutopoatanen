@if (isset($subcategoryTopic))
    {!! Form::model($subcategoryTopic, ['route' => ['admin.copa03.subcategory-topics.update', $subcategoryTopic->id], 'class'=>'parsley-validate', 'files' => true]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => ['admin.copa03.subcategory-topics.store'], 'class'=>'parsley-validate', 'files' => true]) !!}
@endif
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card card-body border" id="tooltip-container">
                <div class="mb-3">
                    <div class="d-flex">
                        {!! Form::label('heard', 'Categoria', ['class'=>'form-label']) !!}
                        <i class="text-danger">*</i>
                    </div>
                    {!! Form::select('category_id', $categoriesExists, null, [
                        'class'=>'form-select',
                        'id'=>'heard',
                        'required'=>'required',
                        'placeholder' => 'Informe a categoria'
                    ]) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label('title', 'Título da Subcategoria', ['class'=>'form-label']) !!}
                    {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title', 'required'=>'required',]) !!}
                </div>
            </div>
            <div class="mb-3 form-check">
                {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                {!! Form::label('active', 'Ativar exibição?', ['class' => 'form-check-label']) !!}
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card card-body" id="tooltip-container">
                <div class="mb-3">
                    <div class="container-image-crop">
                        {!! Form::label('inputImage', 'Ícone', ['class' => 'form-label']) !!}
                        <small class="ms-2">Dimensões proporcionais mínimas
                            {{ $cropSetting->SubcategoryTopics->path_image_icon->width }}x{{ $cropSetting->SubcategoryTopics->path_image_icon->height }}px!</small>
                        <label class="area-input-image-crop" for="inputImage">
                            {!! Form::file('path_image_icon', [
                                'id' => 'inputImage',
                                'class' => 'inputImage',
                                'data-status' => $cropSetting->SubcategoryTopics->path_image_icon->activeCrop, // px
                                'data-min-width' => $cropSetting->SubcategoryTopics->path_image_icon->width, // px
                                'data-min-height' => $cropSetting->SubcategoryTopics->path_image_icon->height, // px
                                'data-box-height' => '170', // Input height in the form
                                'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                'data-default-file' => isset($subcategoryTopic)
                                    ? ($subcategoryTopic->path_image_icon != ''
                                        ? url('storage/' . $subcategoryTopic->path_image_icon)
                                        : '')
                                    : '',
                            ]) !!}
                        </label>
                    </div><!-- END container image crop -->
                </div>
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
        {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
    </div>
{!! Form::close() !!}
