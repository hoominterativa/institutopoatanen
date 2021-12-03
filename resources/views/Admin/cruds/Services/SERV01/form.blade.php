<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body">
            <div class="mb-3">
                {!! Form::label(null, 'Categoria', ['class'=>'form-label']) !!}
                {!! Form::select('category_id', $categories, null, [
                    'class'=>'form-select',
                    'id'=>'heard',
                    'required'=>'required',
                    'placeholder' => isset($service)?$service->category_id:''
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'Subcategoria', ['class'=>'form-label']) !!}
                {!! Form::select('subcategory_id', $subcategories, null, [
                    'class'=>'form-select',
                    'id'=>'heard',
                    'placeholder' => isset($service)?$service->subcategory_id:''
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'Título', ['class'=>'form-label']) !!}
                {!! Form::text('title', null, ['class'=>'form-control', 'required'=>'required']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'Descrição', ['class'=>'form-label']) !!}
                {!! Form::textarea('description', null, [
                    'class'=>'form-control',
                    'required'=>'required',
                    'data-parsley-trigger'=>'keyup',
                    'data-parsley-minlength'=>'10',
                    'data-parsley-maxlength'=>'190',
                    'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 10 caracteres.',
                    'data-parsley-validation-threshold'=>'10',
                ]) !!}
            </div>
            <div class="mb-3 form-check">
                {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
                {!! Form::label('active', 'Ativar exibição', ['class'=>'form-check-label']) !!}
            </div>
        </div> <!-- end card-body-->
    </div> <!-- end card-->
    <div class="col-12 col-lg-6">
        <div class="card card-body">
            <div class="mb-3">
                {!! Form::label('file', 'Imagem interna', ['class'=>'form-label']) !!}
                {!! Form::file('path_image_inner', [
                    'data-plugins'=>'dropify',
                    'data-height'=>'200',
                    'data-max-file-size-preview'=>'2M',
                    'accept'=>'image/*',
                    'data-default-file'=> isset($service)?$service->path_image_inner<>''?url('storage/'.$service->path_image_inner):'':'',
                ]) !!}
            </div>

            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label(null, 'Imagem Box', ['class'=>'form-label']) !!}
                    <label class="area-input-image-crop" for="inputImage" title="Upload image file">
                        {!! Form::file('path_image_box', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-mincropwidth'=>'250',
                            'data-scale'=>'8/5',
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff',
                            'data-default-file'=> isset($service)?$service->path_image_box<>''?url('storage/'.$service->path_image_box):'':'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div> <!-- end card-body-->
    </div> <!-- end card-->
    <div class="col-12">
        <div class="card card-body">
            <div class="mb-3">
                {!! Form::label('complete-editor', 'Mais informações', ['class'=>'form-label']) !!}
                {!! Form::textarea('text', null, [
                    'class'=>'form-control',
                    'id'=>'complete-editor',
                ]) !!}
            </div>
        </div> <!-- end card-body-->
    </div> <!-- end card-->
</div>
<!-- end row -->
