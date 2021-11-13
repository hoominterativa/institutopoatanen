
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
                {!! Form::label(null, 'Icone', ['class'=>'form-label']) !!}
                {!! Form::file('path_image', [
                    'data-plugins'=>'dropify',
                    'data-height'=>'230',
                    'data-max-file-size-preview'=>'2M',
                    'accept'=>'image/*',
                    'data-default-file'=> isset($topic)?$topic->path_image<>''?url('storage/'.$topic->path_image):'':'',
                ]) !!}
            </div>
        </div> <!-- end card-body-->
    </div> <!-- end card-->
</div>
<!-- end row -->
