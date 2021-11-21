
<div class="row col-12">
    <div class="card col-12 col-lg-6">
        <div class="card-body">
            <div class="mb-3">
                {!! Form::label(null, 'Título', ['class'=>'form-label']) !!}
                {!! Form::text('title', null, ['class'=>'form-control', 'required'=>'required']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('message', 'Descrição', ['class'=>'form-label']) !!}
                {!! Form::textarea('description', null, [
                    'class'=>'form-control',
                    'id'=>'message',
                    'data-parsley-trigger'=>'keyup',
                    'data-parsley-maxlength'=>'200',
                    'data-parsley-maxlength-message'=>'Vamos lá! Você só pode inserir um texto com no máximo 200 caracteres.',
                    'data-parsley-validation-threshold'=>'10',
                    'rows'=>'5'
                ]) !!}
            </div>
            <div class="form-check">
                {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
                {!! Form::label('active', 'Exibir?', ['class'=>'form-check-label']) !!}
            </div>
        </div> <!-- end card-body-->
    </div> <!-- end card-->
    <div class="card col-12 col-lg-6">
        <div class="card-body">
            <div class="mb-3">
                <div class="container-image-crop">
                    <label class="area-input-image-crop" for="inputImage" title="Upload image file">
                        {!! Form::file('path_image', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-mincropwidth'=>'80',
                            'data-scale'=>'1/1',
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff',
                            'data-default-file'=> isset($topic)?$topic->path_image<>''?url('storage/'.$topic->path_image):'':'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div> <!-- end card-body-->
    </div> <!-- end card-->
</div>
<!-- end row -->
